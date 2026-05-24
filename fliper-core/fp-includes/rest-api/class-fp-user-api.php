<?php
/**
 * FLiPER User Route (using wp-rest-api plugin)
 * 
 * Version: 1.0.0
 * Author: Rasiel-FLiPER
 * Author URI: https://github.com/rasielchang
 */

/**
 * FLiPER User Route (using wp-rest-api plugin)
 *
 * @author      Rasiel-FLiPER
 * @package     FLiPER
 * @version     1.0.0
 */
class FLiPER_User_Route extends WP_REST_Controller {

    /**
     * Register the routes for the objects of the controller.
     *
     */
    public function register_routes() {

        $version = '2';
        $namespace = 'api/v' . $version;
        $base = 'users';
        // register_rest_route( $namespace, '/' . $base, array(
        //     array(
        //         'methods'         => WP_REST_Server::READABLE,
        //         'callback'        => array( $this, 'get_items' ),
        //         'permission_callback' => array( $this, 'get_items_permissions_check' ),
        //         'args'            => array()
        //     )
        // ) );

        register_rest_route( $namespace, '/' . $base . '/(?P<id>[\d]+)', array(
            array(
                'methods'         => WP_REST_Server::READABLE,
                'callback'        => array( $this, 'get_item' ),
                'permission_callback' => array( $this, 'get_item_permissions_check' ),
                'args' => array()
            ),
            array(
                'methods'         => WP_REST_Server::EDITABLE,
                'callback'        => array( $this, 'update_item' ),
                'permission_callback' => array( $this, 'update_item_permissions_check' ),
                'args'            => array()
            )
        ) );

        register_rest_route( $namespace, '/' . $base . '/(?P<id>[\d]+)/avatar', array(
            'methods'         => WP_REST_Server::EDITABLE,
            'callback'        => array( $this, 'upload_avatar' ),
            'permission_callback' => array( $this, 'update_item_permissions_check' ),
            'args'            => array()
        ) );

        register_rest_route( $namespace, '/' . $base . '/(?P<id>[\d]+)/cover', array(
            'methods'         => WP_REST_Server::EDITABLE,
            'callback'        => array( $this, 'upload_cover' ),
            'permission_callback' => array( $this, 'update_item_permissions_check' ),
            'args'            => array()
        ) );

        register_rest_route( $namespace, '/' . $base . '/current', array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => array( $this, 'current' ),
            'permission_callback' => array( $this, 'get_items_permissions_check' ),
            'args' => array()
        ) );

        register_rest_route( $namespace, '/' . $base . '/current/change-password', array(
            'methods' => WP_REST_Server::EDITABLE,
            'callback' => array( $this, 'change_password' ),
            'permission_callback' => array( $this, 'update_item_permissions_check' ),
            'args' => array()
        ) );

        register_rest_route( $namespace, '/' . $base . '/follow', array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => array( $this, 'follow' ),
            'permission_callback' => array( $this, 'update_item_permissions_check' ),
            'args' => array()
        ) );

        register_rest_route( $namespace, '/' . $base . '/unfollow', array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => array( $this, 'unfollow' ),
            'permission_callback' => array( $this, 'update_item_permissions_check' ),
            'args' => array()
        ) );

        register_rest_route( $namespace, '/' . $base . '/favorite/article', array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => array( $this, 'favorite_article' ),
            'permission_callback' => array( $this, 'update_item_permissions_check' ),
            'args' => array()
        ) );

        register_rest_route( $namespace, '/' . $base . '/unfavorite/article', array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => array( $this, 'unfavorite_article' ),
            'permission_callback' => array( $this, 'update_item_permissions_check' ),
            'args' => array()
        ) );

        register_rest_route( $namespace, '/' . $base . '/notifications', array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => array( $this, 'get_notifications' ),
            'permission_callback' => array( $this, 'get_item_permissions_check' ),
            'args' => array()
        ) );

        register_rest_route( $namespace, '/' . $base . '/notifications/read', array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => array( $this, 'read_all_notifications' ),
            'permission_callback' => array( $this, 'update_item_permissions_check' ),
            'args' => array()
        ) );

        register_rest_route( $namespace, '/' . $base . '/explore', array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => array( $this, 'get_explore_items'),
            'permission_callback' => array( $this, 'get_items_permissions_check' ),
            'args' => array()
        ) );

    }

    /**
     * Get a collection of items
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function get_items( $request ) {
        $params = $request->get_params();
        global $current_user_id;
        $offset = 0;
        if ( is_numeric( $params[ 'offset' ] ) && 0 < $params[ 'offset' ] ) $offset = $params[ 'offset' ];
        $count = 10;
        if ( is_numeric( $params[ 'count' ] ) && ( 0 < $params[ 'count' ] && 100 >= $params[ 'count' ] ) ) $count = $params[ 'count' ];
        
        global $wpdb;
        $args = array(
            'orderby' => 'display_name',
            'number' => $count, 
            'offset' => $offset
        );

        if ( is_string( $params[ 'role' ] ) ) {
            $role = explode( ',', $params[ 'role' ] );
            if ( 1 === count( $role ) ) {
                $args[ 'role' ] = $role;
            } elseif ( 1 < count( $role ) ) {
                $meta_query = array( 'relation' => 'OR' );
                foreach( $role as $r ) {
                    array_push( $meta_query, array(
                        'key' => $wpdb->prefix . 'capabilities',
                        'value' => $r,
                        'compare' => 'like'
                    ) );
                }
                $args[ 'meta_query' ] = $meta_query;
            }
        }

        $wp_user_query = new WP_User_Query( $args );
        $authors = $wp_user_query->get_results();
        $list = array();
        foreach ( $authors as $author ) {
            array_push( $list, $this->prepare_item_for_response( $author->ID, $request ) );
        }
        $ret = array(
            'offset' => $offset + count( $authors ),
            'count' => count( $authors ),
            'list' => $list
        );
        
        return new WP_REST_Response( $ret, 200 );
    }

    /**
     * Get one item from the collection
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function get_item( $request ) {

        //get parameters from request
        $params = $request->get_params();
        $user = new WP_User( $params[ 'id' ] );

        //return a response or error based on some conditional
        if ( $user->exists() ) {
            $data = $this->prepare_item_for_response( $user->ID, $request );
            return new WP_REST_Response( $data, 200 );
        } else {
            return new WP_Error( ERROR_USER_NOT_FOUND, __( '找不到使用者', 'fliper' ) );
        }

    }


    /**
     * 更新使用者資料
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Request
     */
    public function update_item( $request ) {

        $params = $request->get_params();
        if ( get_current_user_id() != $params[ 'id' ] )
            return new WP_Error( ERROR_PERMISSION_DENIED, __( '權限不足', 'fliper' ) );

        $user = new WP_User( $params[ 'id' ] );

        if ( ! $user->exists() )
            return new WP_Error( ERROR_USER_NOT_FOUND, __( '找不到使用者', 'fliper' ) );

        if ( '' == $params[ 'display_name' ] )
            return new WP_Error( ERROR_USER_EMPTY_DISPLAY_NAME, __( '請輸入名稱', 'fliper' ) );

        $description = $params[ 'description' ];
        if ( mb_strlen( $description ) > 200 )
            return new WP_Error( ERROR_USER_DESCRIPTION_FAIL, __( '個人介紹超過200個字', 'fliper' ) );
        
        $user_data = $this->prepare_item_for_database( $request );

        $r = wp_update_user( $user_data );
        if ( is_wp_error( $r ) )
            return new WP_Error( ERROR_USER_UPDATE_FAIL, __( '更新失敗，請聯繫服務人員', 'fliper' ), $r );
        
        return new WP_REST_Response( $this::prepare_user_for_response( $user_data->ID ) , 200 );

    }

    /**
     * 上傳使用者的大頭照
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function upload_avatar( $request ) {
        $params = $request->get_params();
        if ( get_current_user_id() != $params[ 'id' ] )
            return new WP_Error( ERROR_PERMISSION_DENIED, __( '權限不足', 'fliper' ) );

        $user = new WP_User( $params[ 'id' ] );

        if ( ! $user->exists() )
            return new WP_Error( ERROR_USER_NOT_FOUND, __( '找不到使用者', 'fliper' ) );

        $file_params = $request->get_file_params();
        if ( '' == $file_params[ 'avatar' ] && $params['update_status'] != 'desktop' )
            return new WP_Error( ERROR_USER_EMPTY_AVATAR, __( '請提供大頭照圖片', 'fliper' ) );
        
        if ( isset( $params['update_status'] ) &&  $params['update_status'] == 'desktop' ){
            // 桌面版使用，檔案上傳藉由media uploader，再由此處更新指定檔案資訊
            global $wp_user_avatar; 
            global $blog_id;
            global $wpdb;
            // var_dump($blog_id);
            
            // Remove old attachment postmeta
            delete_metadata( 'user', null, '_wp_attachment_wp_user_avatar', $params['id'], true );

            // Create new attachment postmeta
            update_post_meta( $params['img_id'], '_wp_attachment_wp_user_avatar', $params['id'] );

            // Update usermeta
            update_user_meta( $params['id'], $wpdb->get_blog_prefix($blog_id).'user_avatar', $params['img_id'] );
        } else {
            /* 使用 WP User Avatar 的內部程式，外掛更新後有可能會不能使用 */
            // Hack 權限判斷，讓所以使用者都被 WP User Avatar 當作沒有辦法存取 WP Media 的使用者
            function wpua_is_author_or_above_always_true() {
                return false;
            }
            add_filter( 'wpua_is_author_or_above', 'wpua_is_author_or_above_always_true' );        
            global $wp_user_avatar;
            $_POST[ 'submit' ] = 1; // Hack for ajax call
            $_FILES[ 'wpua-file' ] = $file_params[ 'avatar' ]; // 使用者上傳的大頭照資料
            $errors = new WP_Error();
            $wp_user_avatar->wpua_upload_errors( $errors, true, $user );
            if ( $errors->get_error_codes() )
                return new WP_Error( ERROR_USER_UPLOAD_AVATAR_FAIL, __( '請使用正確格式的大頭照，僅接受 jpg 或 png圖檔，檔案大小不能超過 20M', 'fliper' ) );

            $wp_user_avatar->wpua_action_process_option_update( $params[ 'id' ] );
            remove_filter( 'wpua_is_author_or_above', 'wpua_is_author_or_above_always_true' );
        }
        return new WP_REST_Response( array(
            't' => get_wp_user_avatar_src( $user->ID, array( 300, 300 ) ),
            'o' => get_wp_user_avatar_src( $user->ID, 'full' )
        ), 200 );
    }

    /**
     * 上傳使用者的背景圖片
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function upload_cover( $request ) {
        $params = $request->get_params();
        if ( get_current_user_id() != $params[ 'id' ] )
            return new WP_Error( ERROR_PERMISSION_DENIED, __( '權限不足', 'fliper' ) );

        $user = new WP_User( $params[ 'id' ] );

        if ( ! $user->exists() )
            return new WP_Error( ERROR_USER_NOT_FOUND, __( '找不到使用者', 'fliper' ) );

        fp_save_profile_cover_url( $params['id'], $params['cover_url'] );
        return new WP_REST_Response( array( 'message' => __( '上傳成功！', 'fliper' ) ), 200 );
    }

    /**
     * 取得已登入的使用者資料
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function current( $request ) {

        $item = new WP_User( get_current_user_id() );

        if ( '' != $item ) {
            $data = $this->prepare_item_for_response( $item->ID, $request );
            return new WP_REST_Response( $data, 200 );
        } else {
            return new WP_Error( ERROR_USER_NOT_FOUND, __( '找不到使用者', 'fliper' ) );
        }

    }

    /**
     * 修改已登入使用者的密碼
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function change_password( $request ) {
        $params = $request->get_params();
        $user = new WP_User( get_current_user_id() );

        if ( '' == $params[ 'old_pass' ] )
            return new WP_Error( ERROR_CHANGE_PASSWORD_OLD_PASS_EMPTY, __( '請輸入目前的密碼', 'fliper' ) );

        if ( ! wp_check_password( $params[ 'old_pass' ], $user->data->user_pass, $user->ID ) )
            return new WP_Error( ERROR_WRONG_PASSWORD, __( '目前的密碼不正確', 'fliper' ) );

        if ( $params[ 'new_pass' ] != $params[ 'new_pass_2' ] )
            return new WP_Error( ERROR_CHANGE_PASSWORD_NEW_PASS_MISMATCH, __( '新密碼兩次輸入的不相同', 'fliper' ) );


        $r1 = '/[a-z]/i';
        $r2 = '/[0-9]/';
        if ( preg_match_all( $r1, $params[ 'new_pass' ], $matches ) < 1 )
            return new WP_Error( ERROR_CHANGE_PASSWORD_PASS_FORMAT, __( '新密碼的格式不正確，密碼長度至少 8 個字，並且需包含至少一個英文字母與一個數字', 'fliper' ) );

        if ( preg_match_all( $r2, $params[ 'new_pass' ], $matches ) < 1 )
            return new WP_Error( ERROR_CHANGE_PASSWORD_PASS_FORMAT, __( '新密碼的格式不正確，密碼長度至少 8 個字，並且需包含至少一個英文字母與一個數字', 'fliper' ) );

        if ( strlen( $params[ 'new_pass' ] ) < 8 )
            return new WP_Error( ERROR_CHANGE_PASSWORD_PASS_FORMAT, __( '新密碼的格式不正確，密碼長度至少 8 個字，並且需包含至少一個英文字母與一個數字', 'fliper' ) );

        wp_set_password( $params[ 'new_pass' ], $user->ID );
        
        return new WP_REST_Response( array( 'message' => __( '更新密碼成功，請使用新密碼重新登入', 'fliper' ) ), 200 );
    }

    /**
     * 愛好使用者
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function follow( $request ) {

        $params = $request->get_params();
        global $current_user_id;
        $user = new WP_User( $params[ 'id' ] );

        if ( ! $user->exists() ) 
            return new WP_Error( ERROR_USER_NOT_FOUND, __( '找不到使用者', 'fliper' ) );

        if ( $params[ 'id' ] == $current_user_id ) 
            return new WP_Error( ERROR_FOLLOW_SELF, __( '愛好使用者與登入使用者相同', 'fliper' ) );

        if ( self::wpsa_subscribe_author_follow( $current_user_id, $params[ 'id' ] ) == false )
            return new WP_Error( ERROR_FOLLOW_DATABASE_ERROR, __( '無法新增資料庫內容', 'fliper' ) );

        return new WP_REST_Response( array( 'message' => '愛好成功' ), 200 );

    }

    /**
     * 取消愛好使用者
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function unfollow( $request ) {

        $params = $request->get_params();
        global $current_user_id;
        $user = new WP_User( $params[ 'id' ] );

        if ( ! $user->exists() ) 
            return new WP_Error( ERROR_USER_NOT_FOUND, __( '找不到使用者', 'fliper' ) );

        if ( $params[ 'id' ] == $current_user_id ) 
            return new WP_Error( ERROR_FOLLOW_SELF, __( '取消愛好使用者與登入使用者相同', 'fliper' ) );

        if ( self::wpsa_subscribe_author_unfollow( $current_user_id, $params[ 'id' ] ) == false )
            return new WP_Error( ERROR_FOLLOW_DATABASE_ERROR, __( '無法刪除資料庫內容', 'fliper' ) );

        return new WP_REST_Response( array( 'message' => '取消愛好成功' ), 200 );

    }

    /**
     * 收藏文章
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function favorite_article( $request ) {

        $params = $request->get_params();
        global $current_user_id;

        if ( ! is_string( get_post_status( $params[ 'id' ] ) ) ) 
            return new WP_Error( ERROR_ARTICLE_NOT_FOUND, __( '找不到文章', 'fliper' ) );

        if ( false === FP_Favorite::add_favorite( $current_user_id, $params[ 'id' ], 'post' ) )
            return new WP_Error( ERROR_FAVORITE_ARTICLE, __( '無法新增資料庫內容', 'fliper' ) );

        return new WP_REST_Response( array( 'message' => '收藏文章成功' ), 200 );

    }

    /**
     * 取消收藏文章
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function unfavorite_article( $request ) {

        $params = $request->get_params();
        global $current_user_id;
        

        if ( ! is_string( get_post_status( $params[ 'id' ] ) ) ) 
            return new WP_Error( ERROR_ARTICLE_NOT_FOUND, __( '找不到文章', 'fliper' ) );

        if ( false === FP_Favorite::delete_favorite( $current_user_id, $params[ 'id' ], 'post' ) )
            return new WP_Error( ERROR_FAVORITE_ARTICLE, __( '無法刪除資料庫內容', 'fliper' ) );

        return new WP_REST_Response( array( 'message' => '取消收藏文章成功' ), 200 );

    }

    /**
     * 取得使用者的通知
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function get_notifications( $request ) {
        $params = $request->get_params();
        global $current_user_id;
        $offset = 0;
        if ( is_numeric( $params[ 'offset' ] ) && 0 < $params[ 'offset' ] ) $offset = $params[ 'offset' ];
        $count = 10;
        if ( is_numeric( $params[ 'count' ] ) && ( 0 < $params[ 'count' ] && 100 >= $params[ 'count' ] ) ) $count = $params[ 'count' ];

        $ret = self::prepare_user_for_response( $current_user_id );
        
        $notifications = FP_Notification::get_notifications( $current_user_id, $offset, $count );
        $list = array();
        foreach ( $notifications as $notification ) {
            $time = strtotime( $notification->notification_date );
            $time = date( 'Y/m/d H:i:s', $time );
            $n = array(
                'id' => $notification->ID,
                'user_id' => $notification->user_id,
                'action' => $notification->action,
                'date' =>  $time
            );
            switch ( $notification->action ) {
                case 'following_publish_post':
                    $post = get_post( $notification->object_id );
                    $n[ 'article' ] = FLiPER_Article_Route::prepare_article_for_response( $post );
                    break;
                case 'user_follow':
                    $n[ 'user' ] = self::prepare_user_for_response( $notification->object_id );
                    break;
                case 'favorite_post':
                    $n[ 'user' ] = self::prepare_user_for_response( $notification->object_id );
                    $data = json_decode( $notification->data );
                    $post = get_post( $data->post_id );
                    $n[ 'article' ] = FLiPER_Article_Route::prepare_article_for_response( $post );
                    break;
                case 'comment_post':
                    $n[ 'user' ] = self::prepare_user_for_response( $notification->object_id );
                    $data = json_decode( $notification->data );
                    $post = get_post( $data->post_id );
                    $n[ 'article' ] = FLiPER_Article_Route::prepare_article_for_response( $post );
                    $n[ 'user_count' ] = $data->user_count;
                    break;
                case 'apply_writer_accept':
                    $n[ 'message' ] = '你的作者申請已通過，馬上前往後台發佈內容吧！';
                    $n[ 'url' ] = admin_url();
                    break;
                case 'apply_writer_reject':
                    $n[ 'message' ] = '你的作者申請未通過。';
                    $n[ 'url' ] = site_url( '/apply-writer' );
                    break;
            }
            array_push( $list, $n );
        }

        $ret[ 'notifications' ][ 'new_total_count' ] = FP_Notification::get_new_notifications_count( $current_user_id );
        $ret[ 'notifications' ][ 'offset' ] = $offset + count( $notifications );
        $ret[ 'notifications' ][ 'count' ] = count( $notifications );
        $ret[ 'notifications' ][ 'list' ] = $list;
        return new WP_REST_Response( $ret, 200 );
    }

    /**
     * 使用者讀取過通知，將未讀取的通知數改成 0
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function read_all_notifications( $request ) {
        $params = $request->get_params();
        global $current_user_id;

        if ( false === FP_Notification::read_all_notifications( $current_user_id ) )
            return new WP_Error( ERROR_NOTIFICATION_READ_ALL, __( '伺服器發生錯誤，請稍候再試', 'fliper' ) );

        return new WP_REST_Response( array( 'message' => '修改通知數成功' ), 200 );
    }

    /**
     * Get a collection of items.
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function get_explore_items( $request ) {
        $params = $request->get_params();
        global $wpdb;
        global $current_user_id;
        $offset = 0;
        if ( is_numeric( $params[ 'offset' ] ) && 0 < $params[ 'offset' ] ) $offset = $params[ 'offset' ];
        $count = 10;
        if ( is_numeric( $params[ 'count' ] ) && ( 0 < $params[ 'count' ] && 100 >= $params[ 'count' ] ) ) $count = $params[ 'count' ];
        $search = $params[ 'search' ] ? $params[ 'search' ] : '';

        $sql_role =  " AND ( 
            ( wp_usermeta.meta_key = 'wp_capabilities' AND CAST(wp_usermeta.meta_value AS CHAR) LIKE '%\"writer%' ) 
            )";
        if ( '' != $search ) {
            $sql_search = " AND ( wp_users.user_login LIKE '%%%s%%' OR wp_users.display_name LIKE '%%%s%%' )";
            $sql_search = $wpdb->prepare( $sql_search, $search, $search );
            $sql = 'SELECT SQL_CALC_FOUND_ROWS A.* FROM (SELECT DISTINCT wp_users.ID FROM wp_users INNER JOIN wp_usermeta ON ( wp_users.ID = wp_usermeta.user_id ) WHERE 1=1';
            $sql_limit = $wpdb->prepare( ' ) AS A ORDER BY ID DESC LIMIT %d, %d', $offset, $count );
            $sql = $sql . $sql_role . $sql_search . $sql_limit;
        } else {
            $sql = 'SELECT SQL_CALC_FOUND_ROWS A.*, COUNT(subscriber_id) AS follower_count FROM (SELECT DISTINCT wp_users.ID FROM wp_users INNER JOIN wp_usermeta ON ( wp_users.ID = wp_usermeta.user_id ) WHERE 1=1';
            $sql_limit = $wpdb->prepare( ' ) AS A LEFT JOIN wp_wpsa_subscribe_author ON A.ID = wp_wpsa_subscribe_author.author_id GROUP BY A.ID ORDER BY follower_count DESC LIMIT %d, %d', $offset, $count );
            $sql = $sql . $sql_role . $sql_limit;
        }

        $users = $wpdb->get_results( $sql );
        $list = array();
        foreach ( $users as $user ) {
            array_push( $list, $this->prepare_item_for_response( $user->ID, $request ) );
        }
        $ret = array(
            'offset' => $offset + count( $users ),
            'count' => count( $users ),
            'list' => $list
        );
        
        return new WP_REST_Response( $ret, 200 );
    }

    /**
     * Check if a given request has access to get items
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|bool
     */
    public function get_items_permissions_check( $request ) {
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

    /**
     * Check if a given request has access to get a specific item
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|bool
     */
    public function get_item_permissions_check( $request ) {
        return $this->get_items_permissions_check( $request );
    }

    /**
     * Check if a given request has access to update a specific item
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|bool
     */
    public function update_item_permissions_check( $request ) {

        $user_id = get_current_user_id();
        if ( $user_id == 0 )
            return new WP_Error( ERROR_USER_NOT_LOGIN, __( '請先登入', 'fliper' ) );

        global $current_user_id;
        $current_user_id = $user_id;
        return true;

    }

    /**
     * Prepare the item for create or update operation
     *
     * @param WP_REST_Request $request Request object
     * @return WP_Error|object $prepared_item
     */
    protected function prepare_item_for_database( $request ) {

        $params = $request->get_params();
        $user = new WP_User( get_current_user_id() );
        $user->display_name = $params[ 'display_name' ];
        $user->nickname = $params[ 'display_name' ];
        $user->user_url = $params[ 'website' ];
        $params[ 'description' ] = preg_replace( "/\r|\n/", "", $params[ 'description' ] );
        $user->__set( 'description', $params[ 'description' ] );
        $user->__set( 'facebook', $params[ 'facebook' ] );
        $user->__set( 'instagram', $params[ 'instagram' ] );
        
        return $user;

    }

    /**
     * Prepare the item for the REST response
     *
     * @param mixed $item WordPress representation of the item.
     * @param WP_REST_Request $request Request object.
     * @return mixed
     */
    public function prepare_item_for_response( $item, $request ) {

        //get parameters from request
        $params = $request->get_params();

        $opt = array();
        if ( isset( $params[ 'extra' ] ) ) $opt[ 'extra' ] = $params[ 'extra' ];
        if ( is_numeric( $params[ 'offset' ] ) && 0 < $params[ 'offset' ] ) $opt[ 'offset' ] = $params[ 'offset' ];
        if ( is_numeric( $params[ 'count' ] ) && ( 0 < $params[ 'count' ] && 100 >= $params[ 'count' ] ) ) $opt[ 'count' ] = $params[ 'count' ];

        return FLiPER_User_Route::prepare_user_for_response( $item, $opt );
        
    }

    /**
     * 將 WordPress User 資料封裝成 API User 格式
     *
     * @param int $user_id 將要被封裝的 user id
     * @param mixed $opt 依照此變數內容決定使否需要加載資料
     * @return mixed
     */
    static public function prepare_user_for_response( $user_id, $opt = array() ) {
        
        global $current_user_id;

        $ret = array();
        $default_opt = array(
            'extra' => '',
            'count' => 10,
            'offset' => 0
        );
        $opt = array_merge( $default_opt, $opt );

        $ret[ 'id' ] = $user_id;
        $ret[ 'username' ] = get_the_author_meta( 'user_login', $user_id );
        $ret[ 'display_name' ] = get_the_author_meta( 'display_name', $user_id );
        $ret[ 'avatar' ] = array(
            't' => get_wp_user_avatar_src( $user_id, array( 300, 300 ) ),
            'o' => get_wp_user_avatar_src( $user_id, 'full' )
        );
        $ret[ 'url' ] = site_url( '/author/' . get_the_author_meta( 'user_nicename', $user_id ) );
        $ret[ 'description' ] = get_the_author_meta( 'description', $user_id );
        if ( fp_is_reader( $user_id ) ) {
            $ret[ 'role' ] = 'reader';
        } else if ( ! user_can( $user_id, 'publish_posts' ) ) {
            $ret[ 'role' ] = 'author';
        } else {
            $ret[ 'role' ] = 'author'; // 使用者有 WordPress 作者（或更高）的權限，但目前 FLiPER 並無真對這些權限有特別的使用者形態，因此一律回傳為作者
        }
        $ret[ 'website' ] = get_the_author_meta( 'url', $user_id  );
        $ret[ 'facebook' ] = get_the_author_meta( 'facebook', $user_id  );
        $ret[ 'instagram' ] = get_the_author_meta( 'instagram', $user_id  );
        $ret[ 'has_certified' ] = false;
        $ret[ 'articles' ] = array(
            'total_count' => intval( count_user_posts( $user_id ) )
        );
        $ret[ 'favorites' ] = array(
            'total_count' => intval( FP_Favorite::get_favorites_count( $user_id ) )
        );
        $ret[ 'followers' ] = array(
            'total_count' => intval( self::wpsa_subscribe_author_get_follower_count( $user_id ) ),
            'has_followed' => self::wpsa_subscribe_author_has_followed( $current_user_id, $user_id )
        );
        $ret[ 'followings' ] = array(
            'total_count' => intval( self::wpsa_subscribe_author_get_following_count( $user_id ) )
        );
        $ret[ 'topics' ] = array(
            'total_count' => intval( FP_Comment::get_topics_count( $user_id ) )
        );
        $ret[ 'comments' ] = array(
            'total_count' => 0
        ); // TODO

        if ( 'articles' == $opt[ 'extra' ] ) {
            $query = new WP_Query( array(
                'author' => $user_id,
                'posts_per_page' => $opt[ 'count' ],
                'offset' => $opt[ 'offset' ]
            ) );
            $articles = array();
            while( $query->have_posts() ) {
                $query->the_post();
                $article = FLiPER_Article_Route::prepare_article_for_response( $query->post );
                $articles[] = $article;
            }
            $ret[ 'articles' ][ 'offset' ] = $opt[ 'offset' ] + $query->post_count;
            $ret[ 'articles' ][ 'count' ] = $query->post_count;
            $ret[ 'articles' ][ 'list' ] = $articles;
            wp_reset_query();
        } else if ( 'favorites' == $opt[ 'extra' ] ) {
            $ret[ 'favorites' ][ 'offset' ] = $opt[ 'offset' ] + 0;
            $ret[ 'favorites' ][ 'count' ] = 0;
            $ret[ 'favorites' ][ 'list' ] = array();

            $post_ids = FP_Favorite::get_favorite_post_ids( $user_id, $opt[ 'offset' ], $opt[ 'count' ] );
            if ( ! empty( $post_ids ) ) {
                $query = new WP_Query( array( 
                    'post__in' => $post_ids, 
                    'orderby' => 'post__in',
                    'posts_per_page' => $opt[ 'count' ],
                ) );
                $articles = array();
                while( $query->have_posts() ) {
                    $query->the_post();
                    $article = FLiPER_Article_Route::prepare_article_for_response( $query->post );
                    $articles[] = $article;
                }
                $ret[ 'favorites' ][ 'offset' ] = $opt[ 'offset' ] + $query->post_count;
                $ret[ 'favorites' ][ 'count' ] = $query->post_count;
                $ret[ 'favorites' ][ 'list' ] = $articles;
                wp_reset_query();
            }
        } else if ( 'followings' == $opt[ 'extra' ] ) {
            $following_ids = self::wpsa_subscribe_author_get_following_ids( $user_id, $opt[ 'offset' ], $opt[ 'count' ] );
            $followings = [];
            foreach ( $following_ids as $id ) {
                $followings[] = self::prepare_user_for_response( $id );
            }
            $ret[ 'followings' ][ 'offset' ] = $opt[ 'offset' ] + count( $following_ids );
            $ret[ 'followings' ][ 'count' ] = count( $following_ids );
            $ret[ 'followings' ][ 'list' ] = $followings;
        } else if ( 'followers' == $opt[ 'extra' ] ) {
            $follower_ids = self::wpsa_subscribe_author_get_follower_ids( $user_id, $opt[ 'offset' ], $opt[ 'count' ] );
            $followers = [];
            foreach ( $follower_ids as $id ) {
                $followers[] = self::prepare_user_for_response( $id );
            }
            $ret[ 'followers' ][ 'offset' ] = $opt[ 'offset' ] + count( $follower_ids );
            $ret[ 'followers' ][ 'count' ] = count( $follower_ids );
            $ret[ 'followers' ][ 'list' ] = $followers;
        } else if ( 'topics' == $opt[ 'extra' ] ) {
            $topics = FP_Comment::get_topics( $user_id, $opt[ 'offset' ], $opt[ 'count' ] );
            $t = [];
            foreach ( $topics as $topic ) {
                $t[] = FLiPER_Comment_Route::prepare_topic_for_response( $topic );
            }
            $ret[ 'topics' ][ 'offset' ] = $opt[ 'offset' ] + count( $topics );
            $ret[ 'topics' ][ 'count' ] = count( $topics );
            $ret[ 'topics' ][ 'list' ] = $t;
        }

        return $ret;
    }

    /**
     * Get the query params for collections
     *
     * @return array
     */
    public function get_collection_params() {
        return array(
            'page'                   => array(
                'description'        => 'Current page of the collection.',
                'type'               => 'integer',
                'default'            => 1,
                'sanitize_callback'  => 'absint',
            ),
            'per_page'               => array(
                'description'        => 'Maximum number of items to be returned in result set.',
                'type'               => 'integer',
                'default'            => 10,
                'sanitize_callback'  => 'absint',
            ),
            'search'                 => array(
                'description'        => 'Limit results to those matching a string.',
                'type'               => 'string',
                'sanitize_callback'  => 'sanitize_text_field',
            ),
        );
    }

    /**
     * 取得目標使用者的愛好中的使用者數量，此功能使用 wpsa_subscribe_author 外掛
     *
     * @param int $user_id 目標使用者 id
     * @return int $count 愛好中的使用者數量
     */
    static function wpsa_subscribe_author_get_following_count( $user_id ) {

        global $wpdb;
        $table_name = $wpdb->prefix . "wpsa_subscribe_author";
        $count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $table_name WHERE subscriber_id = %d AND status = %s", 
            $user_id, 
            'active'
        ) );

        return $count;

    }

    /**
     * 取得目標使用者的愛好中的使用者 id，此功能使用 wpsa_subscribe_author 外掛
     *
     * @param int $user_id 目標使用者 id
     * @param int $offset 
     * @param int $count
     * @return array $following_ids 愛好中的使用者 id
     */
    static function wpsa_subscribe_author_get_following_ids( $user_id, $offset, $count ) {

        global $wpdb;
        $table_name = $wpdb->prefix . "wpsa_subscribe_author";
        $subscribers = $wpdb->get_results( $wpdb->prepare( "SELECT author_id FROM $table_name WHERE subscriber_id = %d AND status = %s ORDER BY updated_at DESC LIMIT %d, %d", 
            $user_id, 
            'active',
            $offset,
            $count
        ) );

        $following_ids = [];
        foreach ( $subscribers as $subscriber ) {
            $following_ids[] = $subscriber->author_id;
        }

        return $following_ids;

    }

    /**
     * 愛好使用者，此功能使用 wpsa_subscribe_author 外掛
     *
     * @param int $user_id 發起愛好的使用者 id
     * @param int $author_id 將要被愛好的使用者 id
     * @return bool 愛好成功回傳 true，失敗回傳 false
     */
    static function wpsa_subscribe_author_follow( $user_id, $author_id ) {
        if ( ! class_exists( 'Wpsa_Model' ) )
            return;

        if ( self::wpsa_subscribe_author_has_followed( $user_id, $author_id ) ) 
            return true;

        $wpsa_model = new Wpsa_Model();
        $wpsa_model->subscribeAuthor( $author_id, $user_id );
        
        return true;
    }

    /**
     * 取消愛好使用者，此功能使用 wpsa_subscribe_author 外掛
     *
     * @param int $user_id 發起愛好的使用者 id
     * @param int $author_id 將要被愛好的使用者 id
     * @return bool 愛好成功回傳 true，失敗回傳 false
     */
    static function wpsa_subscribe_author_unfollow( $user_id, $author_id ) {

        if ( ! self::wpsa_subscribe_author_has_followed( $user_id, $author_id ) ) return true;

        global $wpdb;
        $table_name = $wpdb->prefix . 'wpsa_subscribe_author';
        $deleted_row = $wpdb->delete( $table_name,
            array(
                'author_id' => $author_id,
                'subscriber_id' => $user_id
            ),
            array(
                '%d',
                '%d'
            )
        );
        if ( $deleted_row == false ) return false;
        else return true;
        
    }

    /**
     * 檢查使用者是否愛好另一個使用者，此功能使用 wpsa_subscribe_author 外掛
     *
     * @param int $user_id 愛好的使用者 id
     * @param int $author_id 被愛好的使用者 id
     * @return bool 正在愛好回傳 true，否則回傳 false
     */
    static function wpsa_subscribe_author_has_followed( $user_id, $author_id ) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'wpsa_subscribe_author';
        $has_followed = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $table_name WHERE author_id = %d AND subscriber_id = %d",
            $author_id,
            $user_id
        ) );
        if ( intval( $has_followed ) > 0 ) return true;
        else return false;

    }

    /**
     * 取得愛好目標使用者的使用者數量，此功能使用 wpsa_subscribe_author 外掛
     *
     * @param int $user_id 目標使用者 id
     * @return count $count 愛好目標使用者的使用者數量
     */
    static function wpsa_subscribe_author_get_follower_count( $user_id ) {

        global $wpdb;
        $table_name = $wpdb->prefix . "wpsa_subscribe_author";
        $count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $table_name WHERE author_id = %d AND status = %s", 
            $user_id, 
            'active'
        ) );

        return $count;

    }

    /**
     * 取得愛好目標使用者的使用者 id，此功能使用 wpsa_subscribe_author 外掛
     *
     * @param int $user_id 目標使用者 id
     * @param int $offset 
     * @param int $count 
     * @return array $follower_ids 愛好目標使用者的使用者 id
     */
    static function wpsa_subscribe_author_get_follower_ids( $user_id, $offset, $count ) {

        global $wpdb;
        $table_name = $wpdb->prefix . "wpsa_subscribe_author";
        $subscribers = $wpdb->get_results( $wpdb->prepare( "SELECT subscriber_id FROM $table_name WHERE author_id = %d AND status = %s ORDER BY updated_at DESC LIMIT %d, %d", 
            $user_id, 
            'active',
            $offset,
            $count
        ) );

        $follower_ids = [];
        foreach ( $subscribers as $subscriber ) {
            $follower_ids[] = $subscriber->subscriber_id;
        }

        return $follower_ids;

    }

}
