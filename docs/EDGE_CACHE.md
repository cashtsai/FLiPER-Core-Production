# CloudFront 邊緣快取：現況評估與待辦

> 2026-08-11 調查。**源站頁面快取已上線**（WP-Optimize，首頁 0.13s → 0.010s）；
> 這份是關於**再往前一層**、在 CloudFront 邊緣快取的評估。尚未執行。

## 為什麼現在 CloudFront 一直是 Miss

實測 `https://flipermag.com/` 與文章頁，源站回應長這樣：

```
HTTP/1.1 200 OK
Set-Cookie: _fbp=<每位訪客都不同>; Max-Age=7776000; domain=flipermag.com; SameSite=Lax
（沒有任何 Cache-Control 標頭）
```

兩個問題：

1. **完全沒有 `Cache-Control`** —— 源站沒告訴 CloudFront 這頁可以放多久。
2. **每個回應都帶 `Set-Cookie: _fbp=`，而且每位訪客的值都不同。**
   如果 distribution 的 cache policy 把 cookie 納入 cache key，**每位訪客就是一個獨立的
   cache key，命中率永遠是 0** —— 這最能解釋「一直 Miss」。

> ⚠️ 第 2 點是推論。distribution 的 cache policy 我沒有 AWS 權限可以看，
> 要進 Console 確認 cache key 是否包含 cookies。

## `_fbp` 是誰種的、能不能改成前端種

**是誰**：`official-facebook-pixel` 5.2.2 的 `FacebookParamBuilder::server_setup()`
（`facebook-for-wordpress.php:86`，每個頁面請求都跑），用 PHP `setcookie()` 種 `_fbp`/`_fbc`，
目的是餵給 Conversions API (CAPI) 做歸因。

**評估結論：可以安全改成前端種，理由三點**

1. **前端 Pixel 本來就會自己種 `_fbp`。** 實測線上頁面確實載入 `fbevents.js` 並執行
   `fbq('init', ...)`；`_fbp` 原本就是 Pixel JS 的標準行為，伺服器端那次是「加強版」。
2. **這站的 CAPI 實際上送不出東西。** `facebook_capi_integration_status=1`，
   但 **`facebook_pixel_id` 未設定、access token 不存在** —— 沒有憑證就發不了伺服器端事件，
   所以伺服器端 `_fbp` 目前並沒有在發揮它的用途。
3. **有外掛官方認可的開關**（見下）。

**唯一的代價**：Safari ITP 對 JS 種的 cookie 有較嚴格的存活期限制，
廣告歸因的長尾會稍微變差。以這站目前沒有實際在跑 CAPI 的狀態，影響很小。

### 抑制方式（外掛官方 filter，不必改外掛原始碼）

`FacebookSignalState::is_held()` 是 `apply_filters('facebook_signals_held', ...)`。
回傳 `true` 時，`server_setup()` 會走 held 分支、**完全不呼叫 `setcookie()`**：

```php
// mu-plugin，例如 wp-content/mu-plugins/fliper-no-server-fbp.php
add_filter( 'facebook_signals_held', '__return_true' );
```

> ⚠️ **上線前要先確認副作用**：`is_held()` 同時會讓 CAPI 事件進入「排隊等釋放」的流程
> （`class-releasesignalsajax.php`）。在沒有 CAPI 憑證的現況下應該是無害的，
> 但**要在 staging 或低流量時段先測**，確認沒有多出非預期的 AJAX 請求。

---

## 執行順序（建議一次做完，中間的狀態沒有意義）

單獨做任何一步都**不會有效果**，所以別拆開做：

### 步驟 1：關掉伺服器端 `_fbp`
加上上面的 mu-plugin，然後驗證：

```bash
curl -sI https://flipermag.com/ | grep -i set-cookie     # 應該不再有 _fbp
curl -s  https://flipermag.com/ | grep -c fbevents.js    # 應該仍然是 1（Pixel 還活著）
```

### 步驟 2：讓源站送 `Cache-Control`
只對**未登入**訪客送，登入者一律 `no-cache`。可用 mu-plugin 掛 `send_headers`：

```php
add_action( 'send_headers', function () {
    if ( is_user_logged_in() || is_admin() || is_preview() ) {
        return; // 登入者/後台/預覽永遠不要被任何一層快取
    }
    if ( is_singular() || is_home() || is_archive() ) {
        header( 'Cache-Control: public, max-age=600, s-maxage=600' );
    }
} );
```

> 先從短 TTL（600 秒）開始，確認發文後更新正常再考慮拉長。

### 步驟 3：CloudFront cache policy
Console → CloudFront → distribution `d451bae1acb7710ccd6bc25839f90056` → Behaviors → Edit：

- Cache policy：建一個自訂 policy
  - **Cookies: None**（← 關鍵。有這個 `_fbp` 才不會把 cache key 打散）
  - Headers: None（或只留 `Host`）
  - Query strings: None（或只留你實際會用到的）
  - Min TTL 0 / Default TTL 600 / Max TTL 3600
- 保留一條**繞過快取**的 behavior，優先權排在前面：
  - `/wp-admin/*`、`/wp-login.php`、`/wp-json/*`、`/account/*`、`/article-manager/*`、`/apply-writer/*`
  - 這些用 `CachingDisabled` policy

### 步驟 4：驗證

```bash
curl -sI https://flipermag.com/ | grep -i x-cache   # 連打兩次，第二次要看到 Hit
```

- **一定要測**：登入後看到的是自己的登入狀態（不是別人的快取頁）
- **一定要測**：發一篇文章，確認首頁在 TTL 內會更新（源站 WP-Optimize 會清源站快取，
  但 **CloudFront 那層不會自動清** —— 需要的話得手動 invalidation，或接受最長 TTL 的延遲）

## 一個要先想清楚的取捨

CloudFront 那層**不會**因為你發文就自動清快取。所以：

- TTL 設短（10 分鐘）→ 新文章最多晚 10 分鐘出現，但邊緣快取效益打折
- TTL 設長（1 小時以上）→ 效益大，但發文後要**手動 invalidation** 才會即時更新

如果要「發文即時更新 + 長 TTL」，得在發佈流程裡加一步呼叫 CloudFront invalidation API
（需要一組有 `cloudfront:CreateInvalidation` 權限的 IAM 憑證）。這可以接到現有的
FED 自動發佈流程裡。

## 現況提醒

源站頁面快取已經把 2 vCPU 的負載問題解決掉了（load 從 50 降到 0.3）。
邊緣快取是**錦上添花**，不是救火 —— 可以從容規劃，不必急著上。
