<?php
/**
 * FLiPER Infrastructure API (using wp-rest-api plugin)
 * 
 * Version: 1.0.0
 * Author: Rasiel-FLiPER
 * Author URI: https://github.com/rasielchang
 */

/**
 * FLiPER Infrastructure API Route (using wp-rest-api plugin)
 *
 * @author      Rasiel-FLiPER
 * @package     FLiPER
 * @version     1.0.0
 */
class FLiPER_Infrastructure_Route extends WP_REST_Controller {

    /**
     * Register the routes for the objects of the controller.
     *
     */
    public function register_routes() {

        $version = '2';
        $namespace = 'api/v' . $version;
        register_rest_route( $namespace, '/sign-up', array(
            'methods'         => WP_REST_Server::CREATABLE,
            'callback'        => array( $this, 'sign_up' ),
            'permission_callback' => '__return_true',
            'args'            => array()
        ) );

        register_rest_route( $namespace, '/login', array(
            'methods'         => WP_REST_Server::CREATABLE,
            'callback'        => array( $this, 'login' ),
            'permission_callback' => '__return_true',
            'args'            => array()
        ) );

        register_rest_route( $namespace, '/logout', array(
            'methods'         => WP_REST_Server::READABLE,
            'callback'        => array( $this, 'logout' ),
            'permission_callback' => '__return_true',
            'args'            => array()
        ) );

        register_rest_route( $namespace, '/forgot_password', array(
            'methods'         => WP_REST_Server::CREATABLE,
            'callback'        => array( $this, 'forgot_password' ),
            'permission_callback' => '__return_true',
            'args'            => array()
        ) );

        register_rest_route( $namespace, '/facebook-connect', array(
            'methods'         => WP_REST_Server::CREATABLE,
            'callback'        => array( $this, 'facebook_connect' ),
            'permission_callback' => '__return_true',
            'args'            => array()
        ) );

        register_rest_route( $namespace, '/update-social-share-count', array(
            'methods'         => WP_REST_Server::READABLE,
            'callback'        => array( $this, 'update_social_share_count' ),
            'permission_callback' => '__return_true',
            'args'            => array()
        ) );

        register_rest_route( $namespace, '/home', array(
            'methods'         => WP_REST_Server::READABLE,
            'callback'        => array( $this, 'home' ),
            'permission_callback' => array( $this, 'get_permissions_check' ),
            'args'            => array()
        ) );

    }

    /**
     * Sign up on FLiPER
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function sign_up( $request ) {

        //get parameters from request
        $params = $request->get_params();
        $valid = validate_username( $params[ 'user_login' ] );
        if ( ! $valid )
            return new WP_Error( ERROR_SIGN_UP_USER_LOGIN_FORMAT, __( '帳號格式不正確，僅能輸入英文字母（不分大小寫）、數字、底線與英文句點', 'fliper' ) );

        if ( filter_var( $params[ 'email' ], FILTER_VALIDATE_EMAIL ) === false )
            return new WP_Error( ERROR_SIGN_UP_EMAIL_FORMAT, __( '電子郵件信箱格式不正確', 'fliper' ) );
        
        if ( $params[ 'password' ] == '' )
            return new WP_Error( ERROR_SIGN_UP_PASSWORD_EMPTY, __( '請輸入密碼', 'fliper' ) );
            
        $user_id = username_exists( $params[ 'user_login' ] );
        if ( $user_id )
            return new WP_Error( ERROR_SIGN_UP_USER_LOGIN, __( '帳號已經有人使用', 'fliper' ) );
            
        if ( email_exists( $params[ 'email' ] ) ) {
            return new WP_Error( ERROR_SIGN_UP_EMAIL, __( '電子郵件信箱已經有人使用', 'fliper' ) );
        } else {
            $user_id = wp_create_user( $params[ 'user_login' ], $params[ 'password' ], $params[ 'email' ] );
            $creds[ 'user_login' ] = $params[ 'user_login' ];
            $creds[ 'user_password' ] = $params[ 'password' ];
            $creds[ 'remember' ] = true;
            $user = wp_signon( $creds, true );
            $ret = FLiPER_User_Route::prepare_user_for_response( $user->ID );
            return new WP_REST_Response( $ret, 200 );
        }
        
    }

    /**
     * Login to FLiPER
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function login( $request ) {

        //get parameters from request
        $params = $request->get_params();

        $u = get_user_by( 'login', $params[ 'user_login' ] );
        if ( ! $u && strpos( $params[ 'user_login' ], '@' ) ) {
            $u = get_user_by( 'email', $params[ 'user_login' ] );
            $creds[ 'user_login' ] = $u->user_login;
        } else {
            $creds[ 'user_login' ] = $params[ 'user_login' ];
        }

        $creds[ 'user_password' ] = $params[ 'password' ];
        $creds[ 'remember' ] = true;
        $user = wp_signon( $creds, true );
        if ( is_wp_error( $user ) ) {
            return new WP_Error( ERROR_LOGIN, __( '帳號或密碼錯誤', 'fliper' ) );
        } else {
            $ret = FLiPER_User_Route::prepare_user_for_response( $user->ID );
            return new WP_REST_Response( $ret, 200 );
        }
        
    }

    /**
     * Logout from FLiPER
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function logout( $request ) {
        wp_logout();
        $ret = array(
            'message' => '登出成功'
        );
        return new WP_REST_Response( $ret, 200 );
    }

    /**
     * Forgot password on FLiPER
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function forgot_password( $request ) {

        //get parameters from request
        $params = $request->get_params();
        $user_data = '';

        // 底下程式碼大部分是從 wp-login.php 複製過來的
        if ( strpos( $params[ 'user_login' ], '@' ) ) {
            $user_data = get_user_by( 'email', trim( $params[ 'user_login' ] ) );
        } else {
            $user_data = get_user_by( 'login', trim( $params[ 'user_login' ] ) );
        }
        if ( ! $user_data )
            return new WP_Error( ERROR_FORGOT_PASSWORD, __( '請輸入正確的帳號或電子郵件信箱', 'fliper' ) );

        // Redefining user_login ensures we return the right case in the email.
        $user_login = $user_data->user_login;
        $user_email = $user_data->user_email;
        $key = get_password_reset_key( $user_data );

        if ( is_wp_error( $key ) )
            return new WP_Error( ERROR_FORGOT_PASSWORD_KEY, __( '伺服器發生錯誤，請稍後再試', 'fliper' ) );

        $message = __('Someone has requested a password reset for the following account:') . "\r\n\r\n";
        $message .= network_home_url( '/' ) . "\r\n\r\n";
        $message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
        $message .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
        $message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
        $reset_url = network_site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' );
        $message .= $reset_url . "\r\n";

        if ( is_multisite() )
                $blogname = $GLOBALS['current_site']->site_name;
        else
            /*
             * The blogname option is escaped with esc_html on the way into the database
             * in sanitize_option we want to reverse this for the plain text arena of emails.
             */
            $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

        $title = sprintf( __('[%s] Password Reset'), $blogname );

        /**
         * Filter the subject of the password reset email.
         *
         * @since 2.8.0
         * @since 4.4.0 Added the `$user_login` and `$user_data` parameters.
         *
         * @param string  $title      Default email title.
         * @param string  $user_login The username for the user.
         * @param WP_User $user_data  WP_User object.
         */
        $title = apply_filters( 'retrieve_password_title', $title, $user_login, $user_data );

        /**
         * Filter the message body of the password reset mail.
         *
         * @since 2.8.0
         * @since 4.1.0 Added `$user_login` and `$user_data` parameters.
         *
         * @param string  $message    Default mail message.
         * @param string  $key        The activation key.
         * @param string  $user_login The username for the user.
         * @param WP_User $user_data  WP_User object.
         */
        $message = apply_filters( 'retrieve_password_message', $message, $key, $user_login, $user_data );

        if ( $message && ! wp_mail( $user_email, wp_specialchars_decode( $title ), $message ) )
            return new WP_Error( ERROR_FORGOT_PASSWORD_SEND_MAIL, __( '伺服器發生錯誤，請稍後再試', 'fliper' ) );

        $ret = array(
            'message' => '請至您註冊的電子郵件信箱收信，依照信件內的步驟取回密碼'
        );
        return new WP_REST_Response( $ret, 200 );
    }

    /**
     * Use Facebook account to sign in or sign up FLiPER
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function facebook_connect( $request ) {

        //get parameters from request
        $params = $request->get_params();
        if ( $params[ 'access_token' ] == '' )
            return new WP_Error( ERROR_FACEBOOK_CONNECT_ACCESS_TOKEN_EMPTY, __( '缺少 access_token', 'fliper' ) );
            
        $fields = 'id,name,first_name,last_name,email';
        $enable_ssl = true;
        $url = 'https://graph.facebook.com/me/?fields=' . $fields . '&access_token=' . $params[ 'access_token' ];
    
        //  Initiate curl
        $ch = curl_init();

        // Enable SSL verification
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, $enable_ssl );

        // Will return the response, if false it print the response
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

        // Set the url
        curl_setopt( $ch, CURLOPT_URL, $url );

        // Execute
        $result = curl_exec( $ch );

        // Closing
        curl_close( $ch );

        $result = json_decode( $result, true );

        if ( ! isset( $result[ 'email' ] ) )
            return new WP_Error( ERROR_FACEBOOK_CONNECT_EMAIL_EMPTY, __( '與 Facebook 連結時無法取得你的 Email 帳號資訊，有可能是因為 Email 帳號遺失、無效或尚未認證的原因造成。請你使用 Email 進行申請以註冊成為會員。', 'fliper' ) );
            
        if ( email_exists( $result[ 'email' ] ) ) {
            $user = get_user_by( 'email', $result[ 'email' ] );
            $user_id = $user->ID;
            $user_name = $user->user_login;
            $message = '使用 Facebook 帳號登入成功';
        } else {
            //$user_name = strtolower($result['first_name'].'.'.$result['last_name']);
            $user_name = explode( '@', $result[ 'email' ] )[ 0 ];
            $raw_user_name = $user_name;
            $i = 0;
            while( username_exists( $user_name ) ) {             
                $i++;
                $user_name = $raw_user_name . $i;
            }
                
            $random_password = wp_generate_password( $length = 12, $include_standard_special_chars = false );
            $userdata = array(
                'user_login'    => $user_name,
                'user_email'    => $result[ 'email' ],
                'user_pass'  => $random_password,
                'display_name'  => $result[ 'name' ],
                'first_name'  => $result[ 'first_name' ],
                'last_name'  => $result[ 'last_name' ]
            );

            $user_id = wp_insert_user( $userdata );
            if ( ! $user_id )
                return new WP_Error( ERROR_FACEBOOK_CONNECT_CANNOT_CREATE_USER, __( '伺服器發生錯誤，請稍後再試', 'fliper' ) );

            $message = '使用 Facebook 帳號註冊成功';
        }

        // 產生 Cookie
        wp_set_auth_cookie( $user_id, true );

        $ret = array(
            'message' => $message,
            'user' => FLiPER_User_Route::prepare_user_for_response( $user_id )
        );
        return new WP_REST_Response( $ret, 200 );
    }

    /**
     * 更新頁面分享數量
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function update_social_share_count( $request ) {
        //get parameters from request
        $params = $request->get_params();
        $post_id = url_to_postid( $params[ 'url' ] );

        $count = 0;
        if ( 0 != $post_id ) {
            $count = FLiPER_crawl_facebook_share_count( $post_id );
        }

        $ret = array(
            'count' => $count
        );
        
        return new WP_REST_Response( $ret, 200 );
    }

    /**
     * APP 顯示首頁所需的資料回傳
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function home( $request ) {
        //get parameters from request
        $params = $request->get_params();
        $width = is_numeric( $params['w'] ) ? $params['w'] : 320;
        $height = is_numeric( $params['h'] ) ? $params['h'] : 480;

        $option = array( 'ad_20160731' => isset( $params[ 'ad_20160731' ] ) );
        $articles = FLiPER_Article_Route::get_instance()->get_articles( 0, 10, 0, 0,'', $option );

        $today_special = null;
        if ( FLiPER::get_instance()->is_app_today_special_open() ) {
            $today_special = array(
                'type' => 'image',
                'thumbnail' => FLiPER::get_instance()->get_app_today_special_thumbnail_src(),
                'original' => FLiPER::get_instance()->get_app_today_special_original_src(),
                'link' => FLiPER::get_instance()->get_app_today_special_link(),
                'title' => FLiPER::get_instance()->get_app_today_special_title()
            );
        }

        $ret = array(
            'today_special' => $today_special,
            'articles' => $articles
        );
        
        return new WP_REST_Response( $ret, 200 );
    }

    /**
     * Check if a given request has access to get
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|bool
     */
    public function get_permissions_check( $request ) {
        $params = $request->get_params();

        if ( fliper_legacy_api_token_matches( isset( $params[ 'access_token' ] ) ? $params[ 'access_token' ] : '' ) ) {
            global $current_user_id;
            $current_user_id = 0;
            return true;
        }

        $user_id = get_current_user_id();
        if ( $user_id == 0 )
            return new WP_Error( ERROR_USER_NOT_LOGIN, __( '請先登入', 'fliper' ) );

        global $current_user_id;
        $current_user_id = $user_id;
        
        return true;
    }

}
