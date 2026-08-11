# CloudFront WAF：wp-login 防護待辦

> 建立於 2026-08-11 事故之後。目前**尚未執行**，這份文件是給你有空時照著補的流程。

## 為什麼還要做這個

2026-08-11 主站被 wp-login 暴力破解打掛（2.5 天 79,656 次 `POST /wp-login.php`，尖峰把 2 vCPU 的機器 load 打到 50、回 504）。

事故當天已經在**伺服器端**補好防護，站也穩住了：

- `mod_remoteip` 還原 CloudFront 背後的真實 IP（否則日誌只看得到 edge IP）
- Apache 層封鎖已知攻擊來源（**iptables 沒用**：TCP 對端永遠是 CloudFront，真實 IP 只在 `X-Forwarded-For`）
- `wp-login-autoban.sh` 每 5 分鐘自動關水桶（10 分鐘內 ≥30 次登入 POST）

但這些都是**請求已經打到源站之後**才擋。攻擊流量仍然會：

1. 佔用 CloudFront 到源站的連線
2. 每個請求都要 Apache 起 PHP 才知道要不要擋
3. 攻擊規模再大一級（多 IP 輪替、低頻慢打）時，自動封鎖會追不上

**在 CloudFront 邊緣擋掉才是治本**，而且 WAF 的 CAPTCHA 動作正好就是你想要的「點我不是機器人」。

## 現況資訊

| 項目 | 值 |
|------|-----|
| Distribution | `d451bae1acb7710ccd6bc25839f90056.cloudfront.net` |
| 網域 | `flipermag.com` |
| 源站 | EC2 Tokyo `13.112.197.66`（Tailscale: `fliper-aws` `100.87.74.24`） |
| 源站規格 | 2 vCPU / 7.6G — **這是關鍵限制，扛不住洪水** |
| WAF 範圍 | CloudFront 用的 WAF 必須建在 **us-east-1 (N. Virginia)**，Global scope |

已知攻擊來源（可直接放進 IP set 當黑名單起點）：

```
93.152.221.213    TechTies Inc. (DE/SC)  — 主攻，輪換假 UA
129.121.103.155   Oso Grande (US)
173.236.254.75    DreamHost (US)
97.74.87.194      GoDaddy (US)
95.216.13.46      Hetzner (FI)
```

---

## 流程

### 步驟 1：建立 Web ACL

AWS Console → **WAF & Shield** → Web ACLs → **右上角區域切到 Global (CloudFront)** → Create web ACL

- Name: `flipermag-waf`
- Resource type: **CloudFront distributions**
- Add AWS resources → 勾選 `d451bae1acb7710ccd6bc25839f90056`
- Default action: **Allow**

> ⚠️ 區域一定要是 **Global (CloudFront)**，選到別的 region 會看不到 distribution。

### 步驟 2：wp-login 限速 + CAPTCHA（核心規則）

Add rules → **Add my own rules** → Rule builder

- Name: `wp-login-ratelimit`
- Type: **Rate-based rule**
- Rate limit: **100**（每 5 分鐘、每 IP。正常人登入不會超過個位數）
- Aggregate on: **Source IP**（若前面還有別層代理才需要改用 Forwarded IP）
- **Scope down statement** → 勾 `Enable`：
  - Inspect: **URI path**
  - Match type: **Starts with string**
  - String: `/wp-login.php`
- Action: **CAPTCHA**（← 這就是「我不是機器人」）
  - Immunity time: `300` 秒（過關後 5 分鐘內不再問）

**為什麼用 CAPTCHA 不用 Block**：萬一你或作者群自己觸發限速，還能靠點一下通過，不會被硬鎖在外面。

### 步驟 3：已知惡意 IP 直接封

先建 IP set：WAF → **IP sets** → Create（一樣要 Global）

- Name: `flipermag-blocklist`
- Region: Global (CloudFront)
- IP version: IPv4
- 貼上（注意要加 `/32`）：
  ```
  93.152.221.213/32
  129.121.103.155/32
  173.236.254.75/32
  97.74.87.194/32
  95.216.13.46/32
  ```

回到 web ACL → Add rule：

- Name: `known-bad-ips`
- Type: Rule builder → Inspect: **Originates from an IP address in** → 選 `flipermag-blocklist`
- Action: **Block**
- **Priority 排在 `wp-login-ratelimit` 之前**

### 步驟 4：擋帳號枚舉與 xmlrpc

Add rule → Rule builder，用 **OR** 串起這幾個條件：

| Inspect | Match | Value |
|---|---|---|
| URI path | Starts with | `/wp-json/wp/v2/users` |
| URI path | Starts with | `/xmlrpc.php` |
| URI path | Contains | `/wp-login.php/` |

- Action: **Block**

> ⚠️ **先確認 app 有沒有用到 `/wp-json/wp/v2/users`**。手機 app 的留言走 `wp/v2`、會員同步走 legacy `api/v2`、內容走 `/app/v1`。若不確定，這條先設 **Count** 觀察幾天，確認沒誤傷再改 Block。

### 步驟 5：套用託管規則組（可選但建議）

Add rules → **Add managed rule groups** → AWS managed rule groups：

- `AWSManagedRulesAmazonIpReputationList` — 已知惡意 IP
- `AWSManagedRulesCommonRuleSet` — 通用防護
  - ⚠️ 這組可能誤擋後台的正常操作（尤其貼長文/HTML）。**先全設 Count**，觀察 1 週再逐條轉 Block。

### 步驟 6：開日誌

Web ACL → **Logging and metrics** → Enable → 輸出到 CloudWatch Logs（`aws-waf-logs-flipermag`）

沒有日誌就看不出規則有沒有誤擋，這步別跳過。

### 步驟 7：驗證

1. **自己登入一次** → 應該正常，不該跳 CAPTCHA
2. 快速重整 `/wp-login.php` 超過 100 次 → 應該跳出 CAPTCHA
3. WAF Console → **Sampled requests** 看規則有沒有在動
4. 觀察源站 load：`ssh fliper-aws` 後 `uptime`

---

## 順便值得做的（同樣在 CloudFront，效益很大）

事故當天量到首頁是 **`x-cache: Miss from cloudfront`** —— 等於 CloudFront 幾乎沒在幫你擋流量，每個訪客都打到那台 2 vCPU 的機器。

如果把「未登入訪客的文章頁」做成邊緣快取，源站負載會直接掉一個量級，這比任何封鎖都有效：

- Cache policy：忽略除了 `wordpress_logged_in_*` 以外的 cookie
- 已登入者（帶 `wordpress_logged_in_` cookie）直接 bypass 快取
- TTL 從短的開始試（例如 5 分鐘），確認發文後更新正常再拉長

這件事影響面比較大（可能踩到留言、會員狀態、預覽），建議獨立一次處理，不要跟 WAF 混在一起上。

---

## 完成後可以回收的東西

WAF 穩定運作一段時間後，源站的這些防護可以視情況簡化（但**建議留著當第二道防線**）：

- `/opt/bitnami/apache2/conf/vhosts/02_blocklist.conf` — 手動黑名單
- `/opt/bitnami/apache2/conf/vhosts/03_autoban.conf` — 自動黑名單
- cron `*/5 /opt/bitnami/scripts/wp-login-autoban.sh`

`01_remoteip.conf`（真實 IP 還原）**不要動** —— 沒有它，日誌會退回只看得到 CloudFront edge IP。
