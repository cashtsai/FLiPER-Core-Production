<?php
/**
 * FLiPER Rest API (using wp-rest-api plugin)
 * 
 * Version: 1.0.0
 * Author: Rasiel-FLiPER
 * Author URI: https://github.com/rasielchang
 */

// 通用
define( 'ERROR_USER_NOT_LOGIN', -5 ); // 使用者未登入
define( 'ERROR_PERMISSION_DENIED', -10 ); // 使用者沒有權限進行當前操作
define( 'ERROR_WRONG_PASSWORD', -15 ); // 密碼錯誤

// 使用者
define( 'ERROR_USER_NOT_FOUND', -20 ); // 找不到使用者
define( 'ERROR_USER_EMPTY_DISPLAY_NAME', -21 ); // 使用者名稱為空白
define( 'ERROR_USER_UPDATE_FAIL', -22 ); // 更新使用者資料失敗
define( 'ERROR_USER_EMPTY_AVATAR', -23 ); // 使用者大頭照圖片為空白
define( 'ERROR_USER_UPLOAD_AVATAR_FAIL', -24 ); // 使用者大頭照格式或大小不正確
define( 'ERROR_USER_DESCRIPTION_FAIL', -25 ); // 使用者個人資料格式不正確（超過200字）

// 修改密碼
define( 'ERROR_CHANGE_PASSWORD_OLD_PASS_EMPTY', -30 ); // 修改密碼時舊密碼為空
define( 'ERROR_CHANGE_PASSWORD_NEW_PASS_MISMATCH', -31 ); // 修改密碼時新密碼第一次輸入與第二次不同
define( 'ERROR_CHANGE_PASSWORD_PASS_FORMAT', -32 ); // 修改密碼時新密碼格式錯誤

// 愛好或取消愛好
define( 'ERROR_FOLLOW_SELF', -100 ); // 使用者與登入使用者相同
define( 'ERROR_FOLLOW_DATABASE_ERROR', -101 ); // 因不明原因而無法新增資料庫內容

// 收藏文章或取消收藏文章
define( 'ERROR_FAVORITE_ARTICLE', -200 ); // 因不明原因而無法新增、修改或刪除資料庫內容

// 註冊
define( 'ERROR_SIGN_UP_USER_LOGIN_FORMAT', -1000 ); // 帳號格式不正確，僅能輸入英文字母（不分大小寫）、數字、底線與英文句點
define( 'ERROR_SIGN_UP_EMAIL_FORMAT', -1001 ); // 帳號電子郵件信箱格式不正確
define( 'ERROR_SIGN_UP_PASSWORD_EMPTY', -1002 ); // 未輸入密碼
define( 'ERROR_SIGN_UP_USER_LOGIN', -1003 ); // 帳號已經有人使用
define( 'ERROR_SIGN_UP_EMAIL', -1004 ); // 電子郵件信箱已經有人使用
            
// 登入
define( 'ERROR_LOGIN', -1100 ); // 帳號或密碼錯誤

// Facebook 登入
define( 'ERROR_FACEBOOK_CONNECT_ACCESS_TOKEN_EMPTY', -1200 ); // 未帶 access_token
define( 'ERROR_FACEBOOK_CONNECT_EMAIL_EMPTY', -1201 ); // 無法從 Facebook 得到使用者 Email
define( 'ERROR_FACEBOOK_CONNECT_CANNOT_CREATE_USER', -1202 ); // 無法新增 FLiPER 帳號

// 忘記密碼
define( 'ERROR_FORGOT_PASSWORD', -1300 ); // 未輸入正確帳號或電子郵件信箱
define( 'ERROR_FORGOT_PASSWORD_KEY', -1301 ); // 伺服器無法正確產生修改密碼的 key
define( 'ERROR_FORGOT_PASSWORD_SEND_MAIL', -1302 ); // 伺服器無法寄出修改密碼的 Email

// 文章
define( 'ERROR_ARTICLE_NOT_FOUND', -2000 ); // 找不到文章

// 通知
define( 'ERROR_NOTIFICATION_READ_ALL', -3000 ); // 無法修改通知資料庫

// 留言
define( 'ERROR_COMMENT_POST_ID', -4000 ); // 留言文章 id 錯誤
define( 'ERROR_COMMENT_CONTENT_EMPTY', -4001 ); // 留言內容為空
define( 'ERROR_COMMENT_CANT_CREATE', -4002 ); // 因不明原因而無法新增留言
define( 'ERROR_COMMENT_NOT_APPROVED', -4003 ); // 新增的留言被系統判斷為垃圾留言

// 集資專案
define( 'ERROR_CROWDFUNDING_PROJECT_NOT_FOUND', -5000 );

// 商品
define( 'ERROR_PRODUCT_NOT_FOUND', -6000 );

// 載入相關檔案
require_once( 'class-fp-infrastructure-api.php' );
require_once( 'class-fp-article-api.php' );
require_once( 'class-fp-user-api.php' );
require_once( 'class-fp-comment-api.php' );
require_once( 'class-fp-web-api.php' );
require_once( 'class-fp-crowdfunding-project-api.php' );
require_once( 'class-fp-product-api.php' );

// 將 API router 掛上 WordPress Hook
$fliper_infrastructure_route = new FLiPER_Infrastructure_Route();
add_action( 'rest_api_init', array( $fliper_infrastructure_route, 'register_routes' ) );

add_action( 'rest_api_init', array( FLiPER_Article_Route::get_instance(), 'register_routes' ) );

$fliper_user_route = new FLiPER_User_Route();
add_action( 'rest_api_init', array( $fliper_user_route, 'register_routes' ) );

$fliper_comment_route = new FLiPER_Comment_Route();
add_action( 'rest_api_init', array( $fliper_comment_route, 'register_routes' ) );

$fliper_web_route = new FLiPER_Web_Route();
add_action( 'rest_api_init', array( $fliper_web_route, 'register_routes' ) );

$fliper_crowdfunding_project_route = new FLiPER_Crowdfunding_Project_Route();
add_action( 'rest_api_init', array( $fliper_crowdfunding_project_route, 'register_routes' ) );

$fliper_product_route = new FLiPER_Product_Route();
add_action( 'rest_api_init', array( $fliper_product_route, 'register_routes' ) );