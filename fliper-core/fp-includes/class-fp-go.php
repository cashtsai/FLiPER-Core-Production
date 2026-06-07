<?php
/**
 * FLiPER GO routes and rendering.
 *
 * Source of truth for /6go, /6go/<code>, /today, article six-code badges,
 * and author social links. This file was moved from the production
 * fliper-go.php mu-plugin into FLiPER Core so public page layout stays
 * versioned with the core site runtime.
 *
 * 六碼機制（全站通用）：
 *   由文章查碼：code = str_pad(post_id, 6, "0")   （post_id 超過 6 位則為原數字）
 *   由碼查文：  post_id = intval(去前導零)，需為已發佈 post/page 才轉址
 */

if (!defined('ABSPATH')) { exit; }

/* =========================================================
 *  可調整參數
 * ========================================================= */
if (!defined('FLIPER_GO_SITE')) {
    define('FLIPER_GO_SITE', 'https://flipermag.com');
}
if (!defined('FLIPER_GO_IG')) {
    define('FLIPER_GO_IG', 'https://www.instagram.com/fliper_mag/');
}
if (!defined('FLIPER_GO_BRAND')) {
    define('FLIPER_GO_BRAND', 'FLiPER');
}
if (!defined('FLIPER_GO_BLUE')) {
    define('FLIPER_GO_BLUE', '#1F7BA1'); // 本站 meta 藍（IBM Plex Mono 配色）
}
if (!defined('FLIPER_GO_CODE_LEN')) {
    define('FLIPER_GO_CODE_LEN', 6);
}

/* =========================================================
 *  六碼機制（全站通用，以 post_id 為基礎）
 * ========================================================= */

/** 由文章 → 六碼（post_id 補零到六位；>6 位則回傳原數字） */
function fliper_go_code_for_post($post_id) {
    $post_id = (int) $post_id;
    if ($post_id <= 0) { return ''; }
    return str_pad((string) $post_id, FLIPER_GO_CODE_LEN, '0', STR_PAD_LEFT);
}

/** 由六碼 → post_id（查無/非公開內容回 0） */
function fliper_go_lookup($code) {
    $digits = preg_replace('/\D/', '', (string) $code);
    if ($digits === '') { return 0; }
    $pid = (int) $digits;            // 去前導零
    if ($pid <= 0) { return 0; }
    $post = get_post($pid);
    if (!$post) { return 0; }
    if ($post->post_status !== 'publish') { return 0; }
    if (!in_array($post->post_type, array('post', 'page'), true)) { return 0; }
    return $pid;
}

/** 設定「當日好文」並回傳其六碼。供每日腳本呼叫。
 *  $note：當日編輯推薦短語（EDITOR'S NOTE）。給非空字串則寫入
 *  option `fed_today_note`；給空字串/不給則清除舊短語（避免新文章
 *  掛到前一天的短語），/today 會 fallback 顯示文章標題。 */
function fliper_go_set_today($post_id, $note = '') {
    $post_id = (int) $post_id;
    update_option('fliper_go_today', $post_id, false);
    $note = trim((string) $note);
    if ($note !== '') {
        update_option('fed_today_note', $note, false);
    } else {
        delete_option('fed_today_note');
    }
    return fliper_go_code_for_post($post_id);
}

function fliper_go_request_path() {
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
    return trim(urldecode((string) $path), '/'); // e.g. "6go", "6go/377274", "today"
}

function fliper_go_handle_request() {
    if (is_admin()) { return ''; }

    $path = fliper_go_request_path();

    // /today —— 當日好文落地頁（延後渲染）
    if ($path === 'today') {
        return 'today';
    }

    // /6go —— 六碼輸入頁（支援 /6go/?code=123456 後援）
    if ($path === '6go') {
        if (isset($_GET['code']) && $_GET['code'] !== '') {
            $pid = fliper_go_lookup($_GET['code']);
            if ($pid > 0) { wp_redirect(get_permalink($pid), 302); exit; }
            return 'input_err';
        }
        return 'input';
    }

    // /6go/123456 —— 六碼直達
    if (preg_match('#^6go/([0-9]{1,9})$#', $path, $m)) {
        $pid = fliper_go_lookup($m[1]);
        if ($pid > 0) { wp_redirect(get_permalink($pid), 302); exit; }
        return 'input_err'; // 查無此碼 → 友善提示
    }

    // 舊路徑 /go、/go/123456 —— 301 永久轉到 /6go 對應路徑（不斷鏈）
    if ($path === 'go') {
        $qs = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] !== '' ? '?' . $_SERVER['QUERY_STRING'] : '';
        wp_redirect(home_url('/6go' . $qs), 301);
        exit;
    }
    if (preg_match('#^go/([0-9]{1,9})$#', $path, $m)) {
        wp_redirect(home_url('/6go/' . $m[1]), 301);
        exit;
    }

    return '';
}

/* =========================================================
 *  路由（URI 為準）：
 *  - 轉址（302 六碼直達、301 舊 /go）立即執行
 *  - 頁面渲染僅設旗標，延後到 template_redirect 以便
 *    get_header()/get_footer() 在主題環境完整載入後輸出
 * ========================================================= */
function fliper_go_parse_request($wp) {
    $view = fliper_go_handle_request();
    if ($view !== '') {
        $GLOBALS['fliper_go_view'] = $view;
    }
}
add_action('parse_request', 'fliper_go_parse_request', -1000);

/* 渲染：template_redirect 優先權 0，搶在 redirect_canonical(10) 之前
   （/today 與舊文 slug=today 同名，不先攔會被 canonical 301 導走） */
function fliper_go_template_redirect() {
    $view = $GLOBALS['fliper_go_view'] ?? fliper_go_handle_request();
    if (!$view) { return; }

    global $wp_query;
    $wp_query->is_404 = false;          // /6go 無對應查詢，避免主題 header 以 404 樣式渲染
    status_header(200);
    if (!defined('DONOTCACHEPAGE')) { define('DONOTCACHEPAGE', true); }
    nocache_headers();

    // 頁面標題與 SEO（noindex，避免 Yoast 用舊文資料）
    $title = ($view === 'today') ? FLIPER_GO_BRAND . ' — 今日好文' : FLIPER_GO_BRAND . ' GO — 輸入六碼';
    add_filter('pre_get_document_title', function () use ($title) { return $title; }, 99);
    add_filter('wpseo_robots', function () { return 'noindex,follow'; }, 99);

    if ($view === 'today') {
        fliper_go_render_today();
    } else {
        fliper_go_render_input($view === 'input_err');
    }
    exit;
}
add_action('template_redirect', 'fliper_go_template_redirect', -1000);

/* =========================================================
 *  文章頁（single）meta 六碼標籤
 *  由主題 single.php 的 meta 區呼叫 fliper_go_post_code_html()；
 *  移除本 mu-plugin 時函式不存在，主題端有 function_exists 防護，
 *  標籤自動消失、不會出錯。樣式由下方 wp_head 注入（不動主題 CSS）。
 * ========================================================= */
function fliper_go_post_code_html($post_id) {
    $code = fliper_go_code_for_post($post_id);
    if ($code === '') { return ''; }
    return '<a class="fliper-go-postcode" href="' . esc_url(home_url('/6go/' . $code)) . '" title="FLiPER GO 六碼：於 flipermag.com/6go 輸入此碼即可直達本文">#' . esc_html($code) . '</a>';
}

/* =========================================================
 *  文章頁作者社群連結（single.php 作者名下方呼叫）
 *  資料：user meta `fliper_social_*`，並尊重 `fliper_public_social_*`
 *  公開開關（旗標存在且為否 → 不顯示）。只渲染有值的欄位。
 *  icon 一律單色線條（stroke）極簡風，點擊開新分頁。
 * ========================================================= */
function fliper_go_author_social_html($user_id) {
    $user_id = (int) $user_id;
    if ($user_id <= 0) { return ''; }

    // 平台 → [URL 模板（非 http 值時使用；null=必須是完整網址才渲染）, stroke SVG]
    $platforms = array(
        'instagram' => array('https://www.instagram.com/%s/', '<svg viewBox="0 0 24 24"><rect x="3.5" y="3.5" width="17" height="17" rx="4.5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r="0.5" fill="currentColor" stroke="none"/></svg>'),
        'threads'   => array('https://www.threads.net/@%s', '<svg viewBox="0 0 24 24"><path d="M19.2 8.4C18.6 5 16 3 12 3 7.3 3 4.5 6 4.5 12s2.8 9 7.5 9c4.1 0 6.8-2.4 6.8-5.4 0-2.7-2-4.4-5.2-4.4-1.9 0-3.6 1-3.6 2.7 0 1.5 1.3 2.4 3 2.4 2 0 3.4-1.4 3.6-4.2.1-1.7-.3-3.6-2.6-4.3"/></svg>'),
        'facebook'  => array('https://www.facebook.com/%s', '<svg viewBox="0 0 24 24"><path d="M15.5 4.5h-1.8c-2 0-3.2 1.3-3.2 3.3V10H8.5v3h2v7.5"/><path d="M10.5 13h4.5"/></svg>'),
        'tiktok'    => array('https://www.tiktok.com/@%s', '<svg viewBox="0 0 24 24"><path d="M14 4v9.6a3.8 3.8 0 1 1-3.8-3.8"/><path d="M14 4c.5 2.6 2.3 4.3 5 4.5"/></svg>'),
        'line'      => array('https://line.me/R/ti/p/%s', '<svg viewBox="0 0 24 24"><path d="M12 4.5c-4.7 0-8.5 2.9-8.5 6.6 0 3.3 2.9 6 6.8 6.5l-.4 2.7c-.1.4.4.7.7.4l3.4-2.3c3.8-.5 6.5-3.2 6.5-6.5 0-3.7-3.8-6.6-8.5-6.6z"/><path d="M8.2 9.8v3.4M11 9.8v3.4M13.8 9.8v3.4h2.2M16.5 9.8v3.4"/></svg>'),
        'wechat'    => array(null, '<svg viewBox="0 0 24 24"><path d="M9.5 4.5C6 4.5 3.5 6.7 3.5 9.4c0 1.6.9 3 2.3 3.9l-.5 2.1 2.2-1.1c.6.2 1.3.3 2 .3"/><path d="M14.7 8.5c3.2 0 5.8 2 5.8 4.6 0 1.4-.8 2.7-2 3.5l.4 1.9-2-1c-.6.2-1.4.3-2.2.3-3.2 0-5.8-2-5.8-4.7s2.6-4.6 5.8-4.6z"/></svg>'),
        'website'   => array(null, '<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="8.5"/><path d="M3.5 12h17"/><path d="M12 3.5c2.7 2.3 4 5.1 4 8.5s-1.3 6.2-4 8.5c-2.7-2.3-4-5.1-4-8.5s1.3-6.2 4-8.5z"/></svg>'),
    );

    $out = '';
    foreach ($platforms as $key => $def) {
        $val = trim((string) get_user_meta($user_id, 'fliper_social_' . $key, true));
        if ($val === '') { continue; }
        $pub = get_user_meta($user_id, 'fliper_public_social_' . $key, true);
        if ($pub !== '' && !$pub) { continue; }   // 有公開旗標且關閉 → 不顯示
        if (preg_match('#^https?://#i', $val)) {
            $url = $val;
        } elseif ($def[0] !== null) {
            $url = sprintf($def[0], rawurlencode(ltrim($val, '@')));
        } else {
            continue;   // 無法組網址（如 WeChat ID）→ 不渲染
        }
        $out .= '<a href="' . esc_url($url) . '" target="_blank" rel="noopener" aria-label="' . esc_attr($key) . '">' . $def[1] . '</a>';
    }

    // 部落格欄位（user meta `blog`，本站作者有填 Medium 等）
    $blog = trim((string) get_user_meta($user_id, 'blog', true));
    if ($blog !== '' && preg_match('#^https?://#i', $blog)) {
        $out .= '<a href="' . esc_url($blog) . '" target="_blank" rel="noopener" aria-label="blog"><svg viewBox="0 0 24 24"><path d="M16.8 4.3 19.7 7.2 8.4 18.5l-4 1.1 1.1-4z"/><path d="M14.6 6.5l2.9 2.9"/></svg></a>';
    }

    if ($out === '') { return ''; }
    return '<div class="fliper-go-author-social">' . $out . '</div>';
}

add_action('wp_head', function () {
    if (!is_single()) { return; }
    echo '<style id="fliper-go-single">
    /* 六碼標籤：手機（基準）獨立一行，置於日期下方（order 排在 actions 後換行） */
    .full-article .meta .fliper-go-postcode{display:block;order:10;flex-basis:100%;
      margin-top:6px;line-height:20px;
      font-family:"IBM Plex Mono","Roboto Slab",monospace;font-size:13px;
      letter-spacing:1.5px;color:#999999;text-decoration:none}
    .full-article .meta .fliper-go-postcode:hover{color:#1f7ba1}
    /* 分享/收藏 icon 放大（sprite 圖以 transform 縮放，視覺與點擊區同步加大） */
    .full-article .meta .actions{align-items:center}
    .full-article .meta .actions .iconset{transform:scale(1.4);transform-origin:center}
    .full-article .meta .actions .bookmark{margin-right:16px}
    @media screen and (min-width:1100px){
      /* 桌面：六碼接在日期後同一行 */
      .full-article .meta .fliper-go-postcode{display:inline-block;order:0;flex-basis:auto;
        margin:0 0 0 14px;line-height:32px;font-size:13px}
      .full-article .meta .actions .iconset{transform:scale(1.35)}
      .full-article .meta .actions .bookmark{margin-right:18px}
    }
    /* 作者社群連結（作者名下、簡介上）：單色 stroke icon，最深層 */
    .full-article .author-wrap .author-meta{flex-wrap:wrap}   /* 主題為 flex nowrap，允許換行讓社群列落到名字下方 */
    .full-article .author-wrap .fliper-go-author-social{display:flex;gap:14px;margin:8px 0 4px;flex-basis:100%}
    .full-article .author-wrap .fliper-go-author-social a{display:inline-flex;align-items:center;justify-content:center;
      width:30px;height:30px;color:#2e2e2e}
    .full-article .author-wrap .fliper-go-author-social a:hover{color:#1f7ba1}
    .full-article .author-wrap .fliper-go-author-social svg{width:20px;height:20px;stroke:currentColor;fill:none;
      stroke-width:1.6;stroke-linecap:round;stroke-linejoin:round}
    /* 作者簡介文字調深一級（原 #8c8c8c），層次：icon #2e2e2e > 簡介 #6e6e6e */
    .full-article .author-wrap .description{color:#6e6e6e}
    </style>';
});

/* =========================================================
 *  視覺：內容區沿用 FLiPER 編輯風（Noto Serif TC、IBM Plex Mono、
 *  #1F7BA1、細線），外層交給主題 header/footer。
 *  樣式以 #fliper-go-app 作用域 + fg- 前綴，避免與主題互相干擾。
 * ========================================================= */
function fliper_go_styles() {
    $blue = FLIPER_GO_BLUE;
    return '<style>
    #fliper-go-app{--fg-ink:#1a1a1a;--fg-blue:' . $blue . ';--fg-sub:#767676;--fg-line:#e6e6e6;
      --fg-mono:"IBM Plex Mono","Roboto Slab",monospace;
      --fg-serif:"Noto Serif TC","Noto Serif",serif;
      --fg-sans:"Noto Sans TC","PingFang TC","Microsoft JhengHei",sans-serif;
      font-family:var(--fg-sans);color:var(--fg-ink);line-height:1.7;
      max-width:480px;margin:0 auto;padding:34px 22px 56px;box-sizing:border-box;}
    #fliper-go-app *{box-sizing:border-box;margin:0;padding:0}
    #fliper-go-app .fg-sechead{display:flex;align-items:center;gap:14px;margin:0 0 22px;
      font-family:"Roboto Slab","Noto Sans TC",serif;font-size:13px;letter-spacing:3px;color:var(--fg-ink)}
    #fliper-go-app .fg-sechead::before,#fliper-go-app .fg-sechead::after{content:"";flex:1;height:1px;background:var(--fg-ink)}
    #fliper-go-app .fg-btn{display:block;width:100%;text-align:center;background:var(--fg-ink);color:#fff;border:none;
      padding:15px;border-radius:0;font-family:var(--fg-sans);font-size:15px;font-weight:500;letter-spacing:3px;
      text-decoration:none;cursor:pointer;line-height:1.5}
    #fliper-go-app .fg-btn:active{opacity:.85}
    #fliper-go-app .fg-btn:hover{color:#fff;text-decoration:none}
    #fliper-go-app .fg-btn.fg-ghost{background:#fff;color:var(--fg-ink);border:1px solid var(--fg-ink);font-weight:400}
    #fliper-go-app .fg-btn.fg-ghost:hover{color:var(--fg-ink)}
    #fliper-go-app .fg-card{border:1px solid var(--fg-line)}
    #fliper-go-app .fg-cover{width:100%;aspect-ratio:16/9;object-fit:cover;display:block;background:#f3f3f3}
    #fliper-go-app .fg-pad{padding:20px}
    #fliper-go-app .fg-kicker{font-family:var(--fg-mono);font-size:11px;letter-spacing:2px;color:var(--fg-blue);
      text-transform:uppercase;margin-bottom:10px}
    #fliper-go-app .fg-title{font-family:var(--fg-serif);font-size:21px;font-weight:700;line-height:1.55;margin-bottom:10px}
    #fliper-go-app .fg-masthead{margin:0 0 22px;text-align:center}
    #fliper-go-app .fg-masthead h4{font-family:"Roboto Slab","Noto Sans TC",serif;font-size:12px;font-weight:700;letter-spacing:1.2px;color:#1a1a1a;line-height:1.5}
    #fliper-go-app .fg-masthead h3{font-family:"Roboto Slab","Noto Sans TC",serif;font-size:20px;font-weight:700;letter-spacing:2px;color:#1a1a1a;line-height:1.4;margin:1px 0}
    #fliper-go-app .fg-masthead h5{font-family:"Roboto Slab","Noto Sans TC",serif;font-size:10px;font-weight:700;letter-spacing:.25px;color:#8c8c8c;line-height:1.5}
    #fliper-go-app .fg-notelbl{font-family:var(--fg-mono);font-size:11px;letter-spacing:2px;color:var(--fg-blue);margin:2px 0 8px}
    #fliper-go-app .fg-note{font-family:var(--fg-serif);font-size:19px;font-weight:500;line-height:1.8;margin-bottom:12px}
    #fliper-go-app .fg-meta{font-family:var(--fg-mono);font-size:12px;color:var(--fg-sub);margin-bottom:18px}
    #fliper-go-app .fg-lead{font-size:14px;color:var(--fg-sub);margin:0 0 22px}
    #fliper-go-app .fg-codebox{margin:4px 0 16px}
    #fliper-go-app .fg-codebox input{width:100%;font-family:var(--fg-mono);font-size:26px;letter-spacing:10px;text-align:center;
      padding:14px 10px;border:1px solid var(--fg-ink);border-radius:0;font-weight:500;background:#fff;color:var(--fg-ink)}
    #fliper-go-app .fg-codebox input:focus{outline:none;border-color:var(--fg-blue)}
    #fliper-go-app .fg-err{font-family:var(--fg-mono);font-size:13px;color:#b03a2e;border:1px solid #e8c9c4;
      padding:12px 14px;margin-bottom:16px}
    #fliper-go-app .fg-err a{color:#b03a2e;font-weight:600}
    #fliper-go-app .fg-fortune{margin:22px 0 0;border-top:1px solid var(--fg-ink);padding:18px 12px 6px;text-align:center}
    #fliper-go-app .fg-minor{text-align:center;margin-top:12px;font-family:var(--fg-mono);font-size:11px;letter-spacing:1px}
    #fliper-go-app .fg-minor a{color:var(--fg-sub);text-decoration:underline;text-underline-offset:3px}
    #fliper-go-app .fg-flbl{font-family:var(--fg-mono);font-size:11px;letter-spacing:2px;color:var(--fg-sub);margin-bottom:2px}
    #fliper-go-app .fg-fgz{font-family:var(--fg-mono);font-size:11px;letter-spacing:1.5px;color:var(--fg-blue);margin-bottom:14px}
    #fliper-go-app .fg-f3{display:flex;justify-content:center;gap:8px;margin-bottom:10px}
    #fliper-go-app .fg-fi{flex:1;max-width:130px;padding:12px 6px 10px}
    #fliper-go-app .fg-fi svg{display:block;margin:0 auto 6px;width:18px;height:18px;stroke:var(--fg-ink);fill:none;stroke-width:1.5;stroke-linecap:round;stroke-linejoin:round}
    #fliper-go-app .fg-fl{display:block;font-family:var(--fg-mono);font-size:10px;letter-spacing:1.5px;color:var(--fg-sub);margin-bottom:3px}
    #fliper-go-app .fg-fv{font-family:var(--fg-serif);font-size:17px;font-weight:700;color:var(--fg-ink)}
    #fliper-go-app .fg-fyj{display:flex;align-items:flex-start;gap:10px;text-align:left;padding:10px 14px;margin:8px 0 0}
    #fliper-go-app .fg-fyj svg{flex:none;width:16px;height:16px;margin-top:3px;stroke:var(--fg-ink);fill:none;stroke-width:1.5;stroke-linecap:round;stroke-linejoin:round}
    #fliper-go-app .fg-ftag{flex:none;font-family:var(--fg-mono);font-size:11px;letter-spacing:1px;color:var(--fg-ink);border:1px solid #c9c9c9;padding:1px 7px;margin-top:1px}
    #fliper-go-app .fg-fyj .fg-ftxt{font-family:var(--fg-serif);font-size:13.5px;line-height:1.7;color:var(--fg-ink)}
    #fliper-go-app .fg-todaycode{margin:22px 0 14px;border-top:1px solid var(--fg-ink);border-bottom:1px solid var(--fg-ink);
      padding:18px 0;text-align:center}
    #fliper-go-app .fg-todaycode .fg-lbl{font-family:var(--fg-mono);font-size:11px;letter-spacing:2px;color:var(--fg-sub);margin-bottom:6px}
    #fliper-go-app .fg-todaycode .fg-num{font-family:var(--fg-mono);font-size:36px;font-weight:600;letter-spacing:12px;color:var(--fg-blue);text-indent:12px}
    #fliper-go-app h1.fg-big{font-family:var(--fg-serif);font-size:23px;font-weight:700;margin-bottom:8px}
    #fliper-go-app .fg-gap{height:12px}
    </style>';
}

/* =========================================================
 *  畫面一：/6go 六碼輸入頁（含查無此碼提示）
 * ========================================================= */
function fliper_go_render_input($error) {
    $today_pid = (int) get_option('fliper_go_today', 0);
    $today_code = '';
    if ($today_pid > 0 && get_post_status($today_pid) === 'publish') {
        $today_code = fliper_go_code_for_post($today_pid);
    }

    get_header();
    echo fliper_go_styles();
    echo '<div id="fliper-go-app">';
    echo '<div class="fg-sechead">FLiPER GO</div>';
    echo '<h1 class="fg-big">輸入六碼，前往文章</h1>';
    echo '<p class="fg-lead">在限動上看到的六碼數字，貼在這裡即可直達該篇文章。FLiPER 每篇文章都有專屬六碼。</p>';
    if ($error) {
        echo '<div class="fg-err">查無此六碼，請確認後再試一次，或看看 <a href="/today">今日好文</a>。</div>';
    }
    echo '<form class="fg-codebox" onsubmit="return fgGo(event)">';
    echo '<input id="fgcode" inputmode="numeric" pattern="[0-9]*" maxlength="9" placeholder="000000" autocomplete="off">';
    echo '</form>';
    echo '<button class="fg-btn" onclick="fgGo(event)">前往文章</button>';
    echo '<div class="fg-gap"></div>';
    if ($today_code !== '') {
        echo '<div class="fg-todaycode"><div class="fg-lbl">TODAY\'S CODE ｜ 今日通關密碼</div><div class="fg-num">' . esc_html($today_code) . '</div></div>';
        echo '<a class="fg-btn fg-ghost" href="/today">今日好文</a>';
        echo '<div class="fg-gap"></div>';
        echo '<a class="fg-btn" href="' . esc_url(FLIPER_GO_SITE) . '">看更多 FLiPER 文章 →</a>';
    } else {
        echo '<a class="fg-btn fg-ghost" href="/today">先看看今日好文</a>';
    }
    echo '<noscript><p style="margin-top:14px;font-size:13px;color:#767676">若無法使用，請直接於網址列輸入 ' . esc_html(FLIPER_GO_SITE) . '/6go/你的六碼</p></noscript>';
    echo '<script>
    function fgGo(e){e.preventDefault();var v=(document.getElementById("fgcode").value||"").replace(/\D/g,"");
    if(v.length<1){return false;} window.location.href="/6go/"+v; return false;}
    </script>';
    echo '</div>';
    get_footer();
}

/* =========================================================
 *  每日運勢區塊（TODAY'S FORTUNE｜本日運勢）
 *  資料：WP option `fed_today_fortune`（JSON，含今+明兩天，
 *  由每日腳本以離線 lunar 演算法庫產生），依 Asia/Taipei 當日
 *  日期取用 → 跨日自動切換；查無當日資料則整塊隱藏。
 * ========================================================= */
function fliper_go_render_fortune() {
    $all = json_decode((string) get_option('fed_today_fortune', ''), true);
    $key = date('Y-m-d', current_time('timestamp'));
    if (!is_array($all) || empty($all[$key]) || !is_array($all[$key])) { return; }
    $f = $all[$key];

    // 細線 stroke SVG icons（極簡編輯感）
    $ic_color  = '<svg viewBox="0 0 24 24"><path d="M12 3.5c3.2 3.9 5.5 6.8 5.5 9.7a5.5 5.5 0 1 1-11 0c0-2.9 2.3-5.8 5.5-9.7z"/></svg>';
    $ic_num    = '<svg viewBox="0 0 24 24"><path d="M9 4 7.5 20M16.5 4 15 20M5 9h15M4 15h15"/></svg>';
    $ic_dir    = '<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="8.5"/><path d="m15 9-2 5-4 2 2-5z"/></svg>';
    $ic_yi     = '<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="8.5"/><path d="m8.5 12.2 2.4 2.4 4.6-5"/></svg>';
    $ic_ji     = '<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="8.5"/><path d="M6.5 17.5l11-11"/></svg>';

    // 低飽和底色：幸運色 tile 呼應當日色系，其餘米/藍灰/灰綠
    $tints = array('綠色' => '#F3F7F1', '紅色' => '#FAF3F1', '黃色' => '#FAF7EC', '白色' => '#F5F5F2', '藍色' => '#F0F4F7');
    $tint_color = isset($tints[$f['color'] ?? '']) ? $tints[$f['color']] : '#F5F5F2';

    echo '<div class="fg-fortune">';
    echo '<div class="fg-flbl">TODAY\'S FORTUNE｜本日運勢</div>';
    echo '<div class="fg-fgz">' . esc_html(($f['ganzhi'] ?? '') . (!empty($f['wuxing']) ? ' · ' . $f['wuxing'] : '')) . '</div>';

    echo '<div class="fg-f3">';
    echo '<div class="fg-fi" style="background:' . esc_attr($tint_color) . '">' . $ic_color . '<span class="fg-fl">幸運色</span><span class="fg-fv">' . esc_html($f['color'] ?? '—') . '</span></div>';
    echo '<div class="fg-fi" style="background:#F7F5F0">' . $ic_num . '<span class="fg-fl">幸運數字</span><span class="fg-fv">' . esc_html((string) ($f['number'] ?? '—')) . '</span></div>';
    echo '<div class="fg-fi" style="background:#F0F4F6">' . $ic_dir . '<span class="fg-fl">幸運方位</span><span class="fg-fv">' . esc_html($f['direction'] ?? '—') . '</span></div>';
    echo '</div>';

    if (!empty($f['yi']) && is_array($f['yi'])) {
        echo '<div class="fg-fyj" style="background:#F2F6F0">' . $ic_yi . '<span class="fg-ftag">宜</span><span class="fg-ftxt">' . esc_html(implode('、', $f['yi'])) . '</span></div>';
    }
    if (!empty($f['ji']) && is_array($f['ji'])) {
        echo '<div class="fg-fyj" style="background:#F8F2F1">' . $ic_ji . '<span class="fg-ftag">忌</span><span class="fg-ftxt">' . esc_html(implode('、', $f['ji'])) . '</span></div>';
    }
    echo '</div>';
}

/* =========================================================
 *  畫面二：/today 當日好文落地頁
 * ========================================================= */
function fliper_go_render_today() {
    $pid = (int) get_option('fliper_go_today', 0);

    get_header();
    echo fliper_go_styles();
    echo '<div id="fliper-go-app">';
    // 首頁同款 masthead 日期區塊（動態取當天）
    $ts = current_time('timestamp'); // WP 時區、英文格式（與首頁一致）
    echo '<div class="fg-masthead"><h4>' . esc_html(date('Y l', $ts)) . '</h4><h3>' . esc_html(date('F d', $ts)) . '</h3><h5>Let Wonders Enrich Our Life</h5></div>';
    echo '<div class="fg-sechead">TODAY\'S PICK</div>';

    if ($pid <= 0 || get_post_status($pid) !== 'publish') {
        echo '<h1 class="fg-big">今日好文準備中</h1>';
        echo '<p class="fg-lead">內容稍後更新，先逛逛官網吧。</p>';
        echo '<a class="fg-btn" href="' . esc_url(FLIPER_GO_SITE) . '">前往 ' . esc_html(FLIPER_GO_BRAND) . '</a>';
        echo '</div>';
        get_footer();
        return;
    }

    $title  = get_the_title($pid);
    $url    = get_permalink($pid);
    $author = get_the_author_meta('display_name', get_post_field('post_author', $pid));
    $cats   = get_the_category($pid);
    $column = (!empty($cats)) ? $cats[0]->name : '';
    $cover  = get_the_post_thumbnail_url($pid, 'large');
    $code   = fliper_go_code_for_post($pid);
    $date   = date('M.d.Y', strtotime(get_post_field('post_date', $pid)));

    echo '<div class="fg-card">';
    if ($cover) {
        echo '<img class="fg-cover" src="' . esc_url($cover) . '" alt="' . esc_attr($title) . '">';
    }
    echo '<div class="fg-pad">';
    // 編輯推薦短語（EDITOR'S NOTE）：讀 option fed_today_note，無則 fallback 文章標題
    $note = trim((string) get_option('fed_today_note', ''));
    echo '<div class="fg-notelbl">EDITOR\'S NOTE｜編輯室</div>';
    echo '<div class="fg-note">' . esc_html($note !== '' ? $note : $title) . '</div>';
    if ($author) { echo '<div class="fg-meta">文｜' . esc_html($author) . '</div>'; }
    echo '<a class="fg-btn" href="' . esc_url($url) . '">閱讀全文</a>';
    echo '</div></div>';

    fliper_go_render_fortune();

    if ($code) {
        echo '<div class="fg-todaycode"><div class="fg-lbl">TODAY\'S CODE ｜ 今日通關密碼</div><div class="fg-num">' . esc_html($code) . '</div></div>';
    }
    // 分享今日好文（Web Share API，fallback 複製連結）
    echo '<button class="fg-btn fg-ghost" id="fgshare" onclick="fgShare(this)">分享今日好文</button>';
    echo '<div class="fg-gap"></div>';
    // 主 CTA：導回 FLiPER 首頁
    echo '<a class="fg-btn" href="' . esc_url(FLIPER_GO_SITE) . '">看更多 FLiPER 文章 →</a>';
    echo '<div class="fg-minor"><a href="/6go">或輸入六碼前往其他文章</a></div>';
    echo '<script>
    function fgShare(btn){
      var url = "' . esc_url(FLIPER_GO_SITE) . '/today";
      var title = ' . wp_json_encode('FLiPER 今日好文：' . $title) . ';
      if (navigator.share) {
        navigator.share({title: title, text: title, url: url}).catch(function(){});
        return;
      }
      function done(ok){
        var t = btn.textContent;
        btn.textContent = ok ? "連結已複製 ✓" : "請手動複製：flipermag.com/today";
        setTimeout(function(){ btn.textContent = t; }, 2200);
      }
      if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(url).then(function(){done(true);}, function(){done(false);});
      } else {
        var i = document.createElement("input"); i.value = url; document.body.appendChild(i);
        i.select(); var ok = false; try { ok = document.execCommand("copy"); } catch(e){}
        document.body.removeChild(i); done(ok);
      }
    }
    </script>';
    echo '</div>';
    get_footer();
}
