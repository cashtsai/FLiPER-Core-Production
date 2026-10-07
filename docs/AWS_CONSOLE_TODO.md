# AWS Console 待辦(需要帳號管理權限,約 30 分鐘一次做完)

> 2026-10-07 整理。伺服器端能自動化的安全工作都已完成
>（金鑰最小權限已驗證、機密已輪替、完整性掃描每小時）。
> 以下是只能在 AWS Console / 以管理權限執行的五件事,依優先序排列。

帳號:597088011828｜區域:ap-northeast-1 (Tokyo)｜主機 instance:private `172.31.5.168`（public 13.112.197.66）

---

## 1. Budget 費用警報（5 分鐘,最優先）

7 月盜刷燒了三週才被發現。設警報後幾小時內就會知道。

Console → **Billing and Cost Management → Budgets → Create budget**
- Use a template → **Daily cost budget**（沒有的話選 Customize, Period=Daily）
- Amount: **USD 20**（正常日費 ~$5,留 4 倍餘裕）
- Email recipients: cash@flipermag.com
- 再建一個 **Monthly: USD 250** 當第二道網

## 2. 撤銷舊金鑰（3 分鐘）

IAM → Users：
- 找擁有 **`AKIA…DU2WQA`**（舊的 offload media 金鑰）的使用者 → Security credentials → 該 access key → **Deactivate → Delete**
- 順便確認 **wp-s3-media** 使用者只有一把 active key（`AKIA…DN5HCP`）
- 檢查有沒有**不認得的 IAM user / role / access key**（7 月入侵者可能留的後門）——有就刪

> 另外有一把更舊的 `DBI_AWS_*` 金鑰（已從 wp-config 刪除明文），
> 如果 IAM 裡還看得到對應的 key，一併 Deactivate → Delete。

## 3. CloudFront cache policy（10 分鐘）— 邊緣快取的最後一步

源站側已全部就緒（_fbp 伺服器 cookie 已停、匿名回應已帶
`Cache-Control: public, max-age=600`、登入/敏感路徑 `private, no-store`）。
只差 CloudFront 把 cookie 移出 cache key：

CloudFront → Distribution `d451bae1acb7710ccd6bc25839f90056` → Behaviors → Default → Edit
- Cache policy → **Create policy**：
  - Name: `flipermag-anon-html`
  - TTL: Min 0 / Default 600 / Max 3600
  - Headers: None｜**Cookies: None**｜Query strings: None
- 另建（或沿用 managed **CachingDisabled**）給這些路徑新增 behaviors，優先序在 Default 之前：
  `/wp-admin/*`、`/wp-login.php`、`/wp-json/*`、`/wp-cron.php`、`/account/*`、`/article-manager/*`、`/apply-writer/*`
- 存檔後驗證：連打兩次 `curl -sI https://flipermag.com/ | grep -i x-cache`，第二次應見 **Hit from cloudfront**
- ⚠️ 上線後**務必登入一次後台確認看到的是自己的登入狀態**；發文後記得 CloudFront 不會自動失效，最長 10 分鐘延遲（TTL 600）

## 4. WAF + CAPTCHA（15 分鐘）

完整步驟見 `docs/WAF_LOGIN_PROTECTION.md`（distribution id、黑名單 IP、
逐步設定都寫好了）。重點：**區域要切 Global (CloudFront)** 才看得到 distribution。

## 5. IAM instance role（10 分鐘）— 伺服器徹底不存 AWS 金鑰

目前 wp-config 裡還有 `wp-s3-media` 的金鑰（已驗證最小權限，風險可控）。
終極型態是 instance role，金鑰完全消失：

1. IAM → Roles → **Create role** → Trusted entity: **EC2**
   - Policy: 建 inline policy（和現在 wp-s3-media 相同）：
     ```json
     { "Version": "2012-10-17", "Statement": [{
       "Effect": "Allow",
       "Action": ["s3:PutObject","s3:GetObject","s3:DeleteObject","s3:ListBucket"],
       "Resource": ["arn:aws:s3:::flipermag","arn:aws:s3:::flipermag/*"] }] }
     ```
   - Role name: `flipermag-web-s3`
2. EC2 → 選主機 instance → Actions → Security → **Modify IAM role** → 掛上 `flipermag-web-s3`（不用重開機）
3. **做完告訴 Claude**，伺服器端我來改：WP Offload Media 切到
   `use-server-roles: true` → 驗證上傳 → 從 wp-config 移除 `AS3CF_SETTINGS` 金鑰 → 最後回 IAM 刪掉 wp-s3-media 使用者

---

完成任何一項都可以跟 Claude 說一聲做後續驗證。1 和 2 最急，3 做完邊緣快取立即生效。
