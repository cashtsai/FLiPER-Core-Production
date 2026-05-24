<?php
/**
 * FLiPER Comment Route (using wp-rest-api plugin)
 * 
 * Version: 1.0.0
 * Author: Rasiel-FLiPER
 * Author URI: https://github.com/rasielchang
 */

/**
 * FLiPER Comment Route (using wp-rest-api plugin)
 *
 * @author      Rasiel-FLiPER
 * @package     FLiPER
 * @version     1.0.0
 */
class FLiPER_Comment_Route extends WP_REST_Controller {

    /**
     * Register the routes for the objects of the controller.
     *
     */
    public function register_routes() {

        $version = '2';
        $namespace = 'api/v' . $version;
        $base = 'comments';
        register_rest_route( $namespace, '/' . $base, array(
            array(
                'methods'         => WP_REST_Server::CREATABLE,
                'callback'        => array( $this, 'create_item' ),
                'permission_callback' => array( $this, 'create_item_permissions_check' ),
                'args'            => array()
            )
        ) );

        register_rest_route( $namespace, '/' . $base . '/(?P<id>[\d]+)', array(
            array(
                'methods'         => WP_REST_Server::READABLE,
                'callback'        => array( $this, 'get_item' ),
                'permission_callback' => array( $this, 'get_item_permissions_check' ),
                'args'            => array()
            )
        ) );

        register_rest_route( $namespace, '/topics/explore', array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => array( $this, 'get_explore_topics'),
            'permission_callback' => array( $this, 'get_items_permissions_check' ),
            'args' => array()
        ) );

    }

    public function create_item( $request ) {
        //get parameters from request
        $params = $request->get_params();
        global $current_user_id;

        if ( ! is_numeric( $params[ 'post_id' ] ) || 0 >= $params[ 'post_id' ] ) {
            return new WP_Error( ERROR_COMMENT_POST_ID, __( '留言文章錯誤', 'fliper' ) );
        }

        if ( '' == $params[ 'content' ] ) {
            return new WP_Error( ERROR_COMMENT_CONTENT_EMPTY, __( '請輸入留言內容', 'fliper' ) );
        }

        $comment_parent = 0;
        if ( array_key_exists( 'parent', $params ) ) {
            $comment_parent = $params['parent'];
        }

        $user = get_userdata( $current_user_id );
        $comment_id = wp_new_comment( array(
            'comment_post_ID' => $params[ 'post_id' ],
            'comment_author' => '', 
            'comment_author_email' => '',
            'comment_author_url' => '',
            'comment_content' => $params[ 'content' ],
            'comment_parent' => $comment_parent, 
            'user_id' => $current_user_id
        ) );

        if ( ! $comment_id ) {
            return new WP_Error( ERROR_COMMENT_CANT_CREATE, __( '伺服器發生錯誤，請稍候再試', 'fliper' ) );
        }

        $comment = get_comment( $comment_id );
        if ( '1' != $comment->comment_approved ) {
            return new WP_Error( ERROR_COMMENT_NOT_APPROVED, __( '由於你的留言可能包含不當內容，因此將不會顯示。若這是一個錯誤，請聯繫 service@flipermag.com。', 'fliper' ) );
        }

        return $this->prepare_item_for_response( $comment, $request );
    }

    /**
     * Get one item from the collection
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    // public function get_item( $request ) {
    //     //get parameters from request
    //     $params = $request->get_params();
    //     $item = get_post( $params[ 'id' ] );

    //     //return a response or error based on some conditional
    //     if ( '' != $item ) {
    //         $data = $this->prepare_item_for_response( $item, $request );
    //         return new WP_REST_Response( $data, 200 );
    //     }else{
    //         return new WP_Error( ERROR_ARTICLE_NOT_FOUND, __( '找不到文章', 'fliper' ) );
    //     }

    // }

    /**
     * Get a collection of topics, using WordPress Popular Posts plugin to get post.
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function get_explore_topics( $request ) {
        $default[ 'count' ] = 10;
        $default[ 'offset' ] = 0;

        //get parameters from request
        $params = $request->get_params();
        $offset = is_numeric( $params[ 'offset' ] ) ? $params[ 'offset' ] : $default[ 'offset' ];
        if ( 0 > $offset ) $offset = $default[ 'offset' ];
        $count = is_numeric( $params[ 'count' ] ) ? $params[ 'count' ] : $default[ 'count' ];
        if ( 1 > $count || 100 < $count ) $count = $default[ 'count' ];
        $search = $params[ 'search' ] ? $params[ 'search' ] : '';

        if ( $search ) {
            $topics = FP_Comment::search_topics( $search, $offset, $count );
        } else {
            $topics = FP_Comment::explore_topics( $offset, $count );
        }

        $data = array();
        foreach ( $topics as $topic ) {
            array_push( $data, $this->prepare_topic_for_response( $topic ) );
        }

        $ret = array(
            'offset' => $offset + count( $topics ),
            'count' => count( $topics ),
            'list' => $data
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
     * Check if a given request has access to create item
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|bool
     */
    public function create_item_permissions_check( $request ) {
        $user_id = get_current_user_id();
        if ( $user_id == 0 )
            return new WP_Error( ERROR_USER_NOT_LOGIN, __( '請先登入', 'fliper' ) );

        global $current_user_id;
        $current_user_id = $user_id;
        
        return true;
    }

    /**
     * Prepare the item for the REST response
     *
     * @param mixed $item WordPress representation of the item.
     * @param WP_REST_Request $request Request object.
     * @return mixed
     */
    public function prepare_item_for_response( $item, $request ) {
        return FLiPER_Comment_Route::prepare_comment_for_response( $item );
    }

    /**
     * 將 WordPress Comment 資料封裝成 API Comment 格式
     *
     * @param mixed $comment 將要被封裝的 comment
     * @return mixed
     */
    static public function prepare_comment_for_response( $comment ) {
        global $current_user_id;
        $ret = array();

        $ret[ 'id' ] = $comment->comment_ID;
        $ret[ 'post_id' ] = $comment->comment_post_ID;
        $ret[ 'content' ] = $comment->comment_content;
        $ret[ 'date' ] = date_format( date_create( $comment->comment_date ), 'Y/m/d H:i:s' );
        $ret[ 'author' ] = FLiPER_User_Route::prepare_user_for_response( $comment->user_id );

        return $ret;
    }

    /**
     * 將 WordPress Comment 資料封裝成 API Topic 格式
     *
     * @param mixed $comment 將要被封裝的 comment
     * @return mixed
     */
    static public function prepare_topic_for_response( $comment ) {
        global $current_user_id;
        $post = get_post( $comment->comment_post_ID );
        $ret = array();

        $ret[ 'id' ] = $comment->comment_ID;
        $ret[ 'content' ] = $comment->comment_content;
        $ret[ 'date' ] = date_format( date_create( $comment->comment_date ), 'Y/m/d H:i:s' );
        $ret[ 'author' ] = FLiPER_User_Route::prepare_user_for_response( $comment->user_id );
        $ret[ 'article' ] = FLiPER_Article_Route::prepare_article_for_response( $post );
        $ret[ 'has_new' ] = FP_Notification::topic_has_new_comment( $current_user_id, $comment->comment_post_ID );
        if ( $current_user_id > 0 ) {
            $ret[ 'has_new' ] = FP_Notification::topic_has_new_comment( $current_user_id, $comment->comment_post_ID );
        }

        return $ret;
    }

}
