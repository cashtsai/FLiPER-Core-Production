# AWS 代操需求單｜flipermag.com

**提出日期**：2026/10/09
**AWS 帳戶**：597088011828
**區域**：ap-northeast-1（Tokyo）
**CloudFront Distribution**：`d451bae1acb7710ccd6bc25839f90056`（網域 flipermag.com）
**窗口**：為善彰之股份有限公司／cash@flipermag.com

本單共兩項，彼此獨立，可分開排程。**第一項為資安處置，建議優先執行。**

---

## 第一項｜停用並刪除 2026 年 7 月入侵事件中外洩的 IAM 存取金鑰

### 背景

本站於 2026/07/20 遭植入後門（`aa.php`），攻擊者讀取 `wp-config.php` 內以明文儲存的 AWS 存取金鑰，並於 07/23 在 us-west-2 與 us-east-1 啟動 **159 台 GPU 執行個體**，產生 **USD 5,133** 非授權費用（已另案向 AWS 申訴）。

後門已清除、網站已完成金鑰輪替，但**外洩金鑰的複本仍在攻擊者手中**，僅在 IAM 停用才會真正失效。

### 作業內容

#### 1-1. 刪除外洩金鑰（必做）

IAM → Users → 逐一檢視使用者的 Security credentials，找出 **Access key ID 結尾為 `DU2WQA`** 的金鑰：

1. 先檢視該金鑰的 **Last used**（最後使用時間與服務）
   - **若顯示 2026/08/15 之後仍有活動** → 請**先暫停作業**並告知我方，可能有未知系統正在使用，需先釐清
   - 若顯示 08/15 之後無活動 → 繼續下一步
2. **Deactivate**（停用）
3. 觀察 24 小時，確認無異常後 **Delete**（刪除）

#### 1-2. 清查更早期的舊金鑰（必做）

同帳戶中若存在另一組曾用於 S3 媒體上傳的舊金鑰（我方 `wp-config.php` 內原有 `DBI_AWS_ACCESS_KEY_ID` 設定，已於 10/07 移除明文），請一併 Deactivate → Delete。

#### 1-3. 清查未知的 IAM 主體（必做）

請列出本帳戶所有 **IAM Users / Roles / Access Keys**，特別標示：

- 2026 年 7 月之後建立者
- 具有 EC2 相關權限者
- 無法對應到已知用途者

攻擊者常於入侵後建立持久化後門，此項為確認是否已完全清除。**清單請提供給我方核對。**

### ⚠️ 絕對不可刪除

**Access key ID 結尾 `DN5HCP`**（IAM 使用者 **`wp-s3-media`**）為網站現行使用中的金鑰，負責媒體上傳至 S3 bucket `flipermag`。**刪除將導致網站無法上傳圖片。**

我方已實測確認此金鑰權限正確收斂：呼叫 EC2 `DescribeInstances` 回應 `UnauthorizedOperation`、`ListBuckets` 遭拒、僅能存取 `flipermag` bucket。

### 驗收方式

1. 提供 1-3 的 IAM 清查清單
2. 刪除後，我方將驗證網站媒體上傳功能正常（約需 5 分鐘）

---

## 第二項｜CloudFront 快取政策設定（效能）

### 背景

目前 distribution 幾乎未發揮快取效果（實測首頁回應標頭為 `x-cache: Miss from cloudfront`），所有流量均回源至 EC2。該主機僅 2 vCPU，且近期觀測到**爬蟲佔總請求約 40%**（AhrefsBot、bingbot、tphotobot、KeenableBot、meta-externalagent 等），其中單一檔案 `/post-sitemap7.xml` 在 14 分鐘內被請求 232 次。

**源站側設定我方已全部完成**：
- 已停止伺服器端寫入 `_fbp` cookie（原本每個回應都帶訪客專屬 `Set-Cookie`，導致無法快取）
- 匿名請求已回傳 `Cache-Control: public, max-age=600, s-maxage=600`
- 登入者與敏感路徑已回傳 `Cache-Control: private, no-store`

僅剩 CloudFront 端需調整。

### 作業內容

#### 2-1. 建立 Cache Policy

CloudFront → Policies → Cache → Create cache policy

| 設定項 | 值 |
|---|---|
| Name | `flipermag-anon-html` |
| Minimum TTL | `0` |
| Default TTL | `600` |
| Maximum TTL | `3600` |
| Headers | **None** |
| **Cookies** | **None**（關鍵設定） |
| Query strings | None |
| Compression | Gzip、Brotli 皆啟用 |

> **Cookies 必須設為 None**。若將 cookie 納入 cache key，每位訪客的 cookie 值不同，會造成每次請求都是獨立 cache key，命中率永遠為零。

#### 2-2. 套用至 Default behavior

Distribution `d451bae1acb7710ccd6bc25839f90056` → Behaviors → Default (`*`) → Edit → Cache policy 選擇 `flipermag-anon-html` → Save

#### 2-3. 建立繞過快取的 behaviors（重要）

以下路徑**必須不快取**，請各建立一條 behavior，Cache policy 一律選用 AWS 受管的 **`CachingDisabled`**，Origin 與 Default 相同，**Precedence 需排在 Default 之前**：

```
/wp-admin/*
/wp-login.php
/wp-json/*
/wp-cron.php
/account/*
/article-manager/*
/apply-writer/*
```

> 這些路徑涉及後台操作、使用者登入狀態與 App 的 API 呼叫，若被快取將造成嚴重問題（例如使用者看到他人的登入狀態）。

### 驗收方式

設定生效後（約 5–10 分鐘），請執行：

```bash
curl -sI https://flipermag.com/ | grep -i x-cache   # 連續執行兩次
```

第二次應顯示 **`X-Cache: Hit from cloudfront`**。

另請確認：
- 登入後台後，顯示的是自己的登入狀態（非他人快取內容）
- `curl -sI https://flipermag.com/wp-json/wp/v2/posts?per_page=1` 不應出現 `Hit from cloudfront`

### 已知影響（我方已知悉，無需處理）

文章發布後，首頁最長可能有 **10 分鐘**延遲才顯示新內容（Default TTL 600 秒）。我方日常發布為每日 07:45 定時，此延遲可接受，暫不需設定自動 invalidation。

---

## 補充說明

- 第一項與第二項無相依性，可分開排程
- 兩項作業期間若需我方配合（例如暫停發文、提供測試帳號），請直接聯繫
- 完成後請告知，我方將於當日完成驗收

以上，麻煩協助處理，謝謝。
