<?php
/**
 * FLiPER Article Route (using wp-rest-api plugin)
 * 
 * Version: 1.0.0
 * Author: Rasiel-FLiPER
 * Author URI: https://github.com/rasielchang
 */

/**
 * FLiPER Article Route (using wp-rest-api plugin)
 *
 * @author      Rasiel-FLiPER
 * @package     FLiPER
 * @version     1.0.0
 */
class FLiPER_Article_Route extends WP_REST_Controller {

    /**
     * A reference to an instance of this class.
     */
    private static $instance;

    /**
     * Returns an instance of this class.
     */
    public static function get_instance() {
        if ( null == self::$instance ) {
            self::$instance = new FLiPER_Article_Route();
        }
 
        return self::$instance;
    }

    /**
     * Register the routes for the objects of the controller.
     *
     */
    public function register_routes() {

        $version = '2';
        $namespace = 'api/v' . $version;
        $base = 'articles';
        register_rest_route( $namespace, '/' . $base, array(
            array(
                'methods'         => WP_REST_Server::READABLE,
                'callback'        => array( $this, 'get_items' ),
                'permission_callback' => array( $this, 'get_items_permissions_check' ),
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

        register_rest_route( $namespace, '/' . $base . '/(?P<id>[\d]+)/favorite-users', array(
            array(
                'methods'         => WP_REST_Server::READABLE,
                'callback'        => array( $this, 'get_favorite_users' ),
                'permission_callback' => array( $this, 'get_item_permissions_check' ),
                'args'            => array()
            )
        ) );

        register_rest_route( $namespace, '/' . $base . '/(?P<id>[\d]+)/comments', array(
            array(
                'methods'         => WP_REST_Server::READABLE,
                'callback'        => array( $this, 'get_comments' ),
                'permission_callback' => array( $this, 'get_item_permissions_check' ),
                'args'            => array()
            )
        ) );

        register_rest_route( $namespace, '/' . $base . '/explore', array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => array( $this, 'get_explore_items'),
            'permission_callback' => array( $this, 'get_items_permissions_check' ),
            'args' => array()
        ) );

        // register_rest_route( $namespace, '/' . $base . '/schema', array(
        //     'methods'         => WP_REST_Server::READABLE,
        //     'callback'        => array( $this, 'get_public_item_schema' ),
        // ) );

    }

    /**
     * Get a collection of items
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function get_items( $request ) {
        $default[ 'count' ] = 10;
        $default[ 'offset' ] = 0;
        $default[ 'cat' ] = '';
        $default[ 'tag' ] = '';
        $default[ 's' ] = '';

        //get parameters from request
        $params = $request->get_params();
        $offset = is_numeric( $params[ 'offset' ] ) ? $params[ 'offset' ] : $default[ 'offset' ];
        if ( 0 > $offset ) $offset = $default[ 'offset' ];
        $count = is_numeric( $params[ 'count' ] ) ? $params[ 'count' ] : $default[ 'count' ];
        if ( 1 > $count || 100 < $count ) $count = $default[ 'count' ];
        $cat = is_numeric( $params[ 'category' ] ) ? $params[ 'category' ] : $default[ 'cat' ];
        $tag = is_numeric( $params[ 'tag' ] ) ? $params[ 'tag' ] : $default[ 'tag' ];
        $s = $params[ 'search' ] ? $params[ 'search' ] : $default[ 's' ];

        $option = array( 'ad_20160731' => isset( $params[ 'ad_20160731' ] ) );
        $ret = $this->get_articles( $offset, $count, $cat, $tag, $s, $option );

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
        $item = get_post( $params[ 'id' ] );

        //return a response or error based on some conditional
        if ( '' != $item ) {
            $data = $this->prepare_item_for_response( $item, $request );
            return new WP_REST_Response( $data, 200 );
        }else{
            return new WP_Error( ERROR_ARTICLE_NOT_FOUND, __( '找不到文章', 'fliper' ) );
        }

    }

    /**
     * 取得文章的收藏使用者
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function get_favorite_users( $request ) {
        $default[ 'count' ] = 10;
        $default[ 'offset' ] = 0;
        $params = $request->get_params();
        $offset = is_numeric( $params[ 'offset' ] ) ? $params[ 'offset' ] : $default[ 'offset' ];
        if ( 0 > $offset ) $offset = $default[ 'offset' ];
        $count = is_numeric( $params[ 'count' ] ) ? $params[ 'count' ] : $default[ 'count' ];
        if ( 1 > $count || 100 < $count ) $count = $default[ 'count' ];

        $item = get_post( $params[ 'id' ] );
        if ( '' == $item )
            return new WP_Error( ERROR_ARTICLE_NOT_FOUND, __( '找不到文章', 'fliper' ) );
        
        $user_ids = FP_Favorite::get_favorite_user_ids( $params[ 'id' ], 'post', $offset, $count );
        $list = array();
        foreach ( $user_ids as $id )
            array_push( $list, FLiPER_User_Route::prepare_user_for_response( $id ) );

        $ret = array(
            'offset' => $offset + count( $user_ids ),
            'count' => count( $user_ids ),
            'list' => $list
        );

        return new WP_REST_Response( $ret, 200 );
    }

    /**
     * 取得文章的留言
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function get_comments( $request ) {
        $default[ 'direction' ] = 'before';
        $default[ 'date' ] = '';
        $default[ 'position' ] = '';
        $params = $request->get_params();
        $post_id = $params[ 'id' ];
        $direction = in_array( $params[ 'direction' ], array( 'before', 'after' ) ) ? $params[ 'direction' ] : $default[ 'direction' ];
        $date = date_create( $params[ 'date' ] ) ? $params[ 'date' ] : $default[ 'date' ];
        $position = isset( $params[ 'position' ] ) ? $params[ 'position' ] : $default[ 'position' ];

        if( $date ) {
            $args = array( 
                'post_id' => $params[ 'id' ], 
                'orderby' => array( 'comment_date', 'comment_ID' ), 
                'date_query' => array( $direction => $date )
            ); 
            if ( 'after' === $direction ) {
                $args[ 'order' ] = 'ASC';
            }
            $comments = get_comments( $args );
        } else if ( $position ) {
            global $wpdb;
            if ( 'before' === $direction ) {
                $comments = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM wp_comments WHERE comment_post_ID = %d AND comment_approved = %s AND comment_ID < %d ORDER BY comment_ID DESC LIMIT 10',
                    $params[ 'id' ],
                    '1',
                    $position
                ) );
            } else if ( 'after' === $direction ) {
                $comments = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM wp_comments WHERE comment_post_ID = %d AND comment_approved = %s AND comment_ID > %d ORDER BY comment_ID ASC LIMIT 10',
                    $params[ 'id' ],
                    '1',
                    $position
                ) );
            }
        } else {
            $comments = get_comments( array( 'post_id' => $params[ 'id' ], 'number' => 10 ) );
        }
        
        $list = array();
        foreach ( $comments as $comment ) {
            array_push( $list, FLiPER_Comment_Route::prepare_comment_for_response( $comment ) );
        }

        $ret = array(
            'total_count' => intval( wp_count_comments( $post_id )->approved ),
            'count' => count( $list ),
            'list' => $list
        );

        return new WP_REST_Response( $ret, 200 );
    }

    /**
     * Get a collection of items, using WordPress Popular Posts plugin to get post.
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function get_explore_items( $request ) {

        $default[ 'count' ] = 10;
        $default[ 'offset' ] = 0;

        //get parameters from request
        $params = $request->get_params();
        $offset = is_numeric( $params[ 'offset' ] ) ? $params[ 'offset' ] : $default[ 'offset' ];
        if ( 0 > $offset ) $offset = $default[ 'offset' ];
        $count = is_numeric( $params[ 'count' ] ) ? $params[ 'count' ] : $default[ 'count' ];
        if ( 1 > $count || 100 < $count ) $count = $default[ 'count' ];

        // Use WordPress Popular Posts function to get popular post ids
        wpp_get_mostpopular_post( 'pid="40212,40993,37982,39646,32475,64998,60583"&post_type="post"&order_by="views"&range="daily"&limit="100"' );
        global $wpp_popular_post_ids;

        $query = new WP_Query( array( 'post__in' => $wpp_popular_post_ids, 'posts_per_page' => $count, 'offset' => $offset ) );
        $data = array();
        while( $query->have_posts() ) {
            $query->the_post();
            $itemdata = $this->prepare_item_for_response( $query->post, $request );
            // $data[] = $this->prepare_response_for_collection( $itemdata );
            $data[] = $itemdata;
        }
        $ret = array(
            'offset' => $offset + $query->post_count,
            'count' => $query->post_count,
            'list' => $data
        );

        wp_reset_postdata();
        
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
            return new WP_Error( ERROR_USER_NOT_LOGIN, __( '請先登入', 'fliper' ), array( 'status' => 401 ) );

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
     * Prepare the item for the REST response
     *
     * @param mixed $item WordPress representation of the item.
     * @param WP_REST_Request $request Request object.
     * @return mixed
     */
    public function prepare_item_for_response( $item, $request ) {

        return FLiPER_Article_Route::prepare_article_for_response( $item );
        
    }

    /**
     * 將 WordPress Post 資料封裝成 API Artilce 格式
     *
     * @param mixed $post 將要被封裝的 post
     * @return mixed
     */
    static public function prepare_article_for_response( $local_post ) {
        global $current_user_id;
        global $post;
        $post = $local_post;
        setup_postdata( $post ); 

        $num_words = 80;
        $more = ' ......';

        $ret = array();

        $ret[ 'id' ] = $post->ID;
        $ret[ 'title' ] = get_the_title( $post->ID );
        $ret[ 'url' ] = get_the_permalink( $post->ID );
        $ret[ 'excerpt' ] = wp_trim_words( strip_shortcodes( $post->post_content ), $num_words, $more );
        $ret[ 'cover' ] = array();
        $thumbnail_id = get_post_thumbnail_id( $post->ID );
        $image = wp_get_attachment_image_src( $thumbnail_id, 'full' );
        if ( $image ) 
            $ret[ 'cover' ][ 'o' ] = array( 'width' => $image[ 1 ], 'height' => $image[ 2 ], 'source' => $image[ 0 ] );
        $sizes = array(
            array( 160, 96, 'xs' ),
            array( 320, 192, 's' ),
            array( 640, 384, 'm' ),
            array( 750, 450, 'l' ),
            array( 1080, 648, 'xl' ),
            array( 720, 458, 'list_articles_thumb_2x' )
        );
        foreach ( $sizes as $size ) {
            $image = wp_get_attachment_image_src( $thumbnail_id, $size );
            if ( $image && $size[ 0 ] == $image[ 1 ] && $size[ 1 ] == $image[ 2 ] )
                $ret[ 'cover' ][ $size[ 2 ] ] = array( 'width' => $image[ 1 ], 'height' => $image[ 2 ], 'source' => $image[ 0 ] );
        }

        $ret[ 'date' ] = get_post_time( 'Y/m/d', false, $post->ID );
        $ret['_date'] = date( 'M', get_the_time( 'U', $post->ID ) ) . get_the_date( '.d.Y', $post->ID );
        $ret[ 'favorites' ] = array(
            'total_count' => intval( FP_Favorite::get_favorite_users_count( $post->ID, 'post' ) ),
            'has_favorite' => FP_Favorite::has_favorite( $current_user_id, $post->ID, 'post' )
        );
        $ret[ 'shares' ] = array(
            'facebook' => FLiPER_get_facebook_share_count( $post->ID )
        );
        $ret[ 'comments' ] = array(
            'total_count' => intval( wp_count_comments( $post->ID )->approved )
        );
        $ret[ 'author' ] = FLiPER_User_Route::prepare_user_for_response( $post->post_author );

        // Remove youtube shortcode, using special parser in app
        remove_shortcode( 'youtube' );

        // Remove vimeo shortcode, using special parser in app
        remove_shortcode( 'vimeo' );

        // Extract content from post
        $ret[ 'content' ] = get_the_content();
        $ret[ 'content' ] = apply_filters( 'the_content', $ret[ 'content' ] );
        // $ret[ 'content' ] = str_replace( ']]>', ']]&gt;', $ret[ 'content' ] );

        // Handle Instagram source issue
        $ret[ 'content' ] = str_replace( 'src="//instagram.com/', 'src="http://instagram.com/', $ret[ 'content' ] );

        // Wrap a div container around content
        $ret[ 'content' ] = '<div id="app-main">' . $ret[ 'content' ] . '</div>';

        $cssBlockquote = 'blockquote { font-size:16px;color: #111;font-weight: bold;margin: 40px 0;}
            blockquote:before { content: "“";font-family: arial;font-size: 34px;float: left;}
            blockquote:after { content: "”";font-family: arial;font-size: 34px;float: right;margin-top: -37px;}
            blockquote p { padding: 0 16px;}';
        $cssMain = '#app-main {word-wrap: break-word;}';
        $cssImg = '#app-main img {max-width:100%;height:auto;}';
        $cssP = 'p { display: block;margin-bottom: 15px; font-size:18px; line-height:1.6;}';
        $cssA = 'a {color:#3b22d6;font-weight:bold; text-decoration:none;}';
        $cssC = '.wp-caption, .gallery-caption {margin-bottom: 20px;max-width: 100%;text-align: center;}';
        $cssVimeo = '.vvqbox {display: block;max-width: 100%;visibility: visible !important;margin: 10px auto;}';
        $cssIframe = 'iframe {max-width: 100%;height:auto;}';
        $cssLyrics = '.lyrics {font-size:0.9em;border-top:1px solid #e8e8e8;border-bottom:1px solid #e8e8e8;border-top:1px solid #e8e8e8;padding:1em 0;margin-bottom:1.5em;}
            .lyrics dd, .lyrics dt {margin-left:0px;padding-left:0px;margin-bottom:1em;}
            .lyrics dd {background: #eee;}';
        $cssClearfix = '.clearfix:after {content: ".";height: 0px;visibility: hidden;display: block;clear: both;}';
        $css = '<style>' . 
           $cssBlockquote .
           $cssMain .
           $cssImg .
           $cssP .
           $cssA .
           $cssC .
           $cssVimeo .
           $cssIframe .
           $cssLyrics .
           $cssClearfix .
           '</style>';
        
        // Wrap html, head tag around content
        $ret[ 'content' ] = '<!DOCTYPE html>
            <html xmlns="http://www.w3.org/1999/xhtml" lang="zh-TW">
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />' . $css . '</head><body>' . $ret[ 'content' ] . '</body></html>';
        $main_category_id = get_field( 'main_category', $post->ID );
        $main_category = get_category( $main_category_id );
        $ret['main_category'] = array(
            'id' => $main_category_id,
            'name' => ( $main_category && ! is_wp_error( $main_category ) ) ? $main_category->name : '',
            'url' => ( $main_category && ! is_wp_error( $main_category ) ) ? get_category_link( $main_category_id ) : '',
            'full_name' => fp_get_category_name( $main_category_id ),
        );
        $ret[ 'categories' ] = array();
        $categories = get_the_category( $post->ID );
        foreach ( $categories as $cat ) {
            array_push( $ret[ 'categories' ], array( 'id' => $cat->term_id, 'name' => $cat->name, 'slug' => $cat->slug ) );
        }
        $ret[ 'tags' ] = array();
        $tags = get_the_tags( $post->ID );
        if ( is_array( $tags ) ) {
            foreach ( $tags as $tag ) {
                array_push( $ret[ 'tags' ], array( 'id' => $tag->term_id, 'name' => $tag->name, 'slug' => $tag->slug ) );
            }
        }

        return $ret;
    }

    /**
     * 抓取文章列表
     *
     * @param int $offset 
     * @param int $count
     * @param int $cat 文章分類 ID
     * @param str $s 搜尋字串
     * @return array 抓出來的文章
     */
    public function get_articles( $offset = 0, $count = 10, $cat = 0, $tag = 0, $s = '', $option = array() ) {
        // 取得檔期內廣告文章，此文章封面需使用影片
        // 新增變數，以利廣告讀取
        $ad_20160731 = isset( $option[ 'ad_20160731' ] ) && $option[ 'ad_20160731' ];
        if ( $ad_20160731 ) {
            $ad_index = 3;
            $ad_post_id = get_option( 'fliper_app_ad_post_id' );
            $ad_video_url = get_option( 'fliper_app_ad_video_url' );
            $ad_post = get_post( $ad_post_id );    
        }

        $query = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => $count, 'offset' => $offset, 'cat' => $cat, 'tag_id' => $tag, 's' => $s ) );
        $data = array();
        $request = null;
        $index = 1;
        while( $query->have_posts() ) {
            // 若 AD 文章存在且到該顯示的篇數，則顯示 AD
            if ( $ad_20160731 ) {
                if ( 0 === $offset && $index === $ad_index && '' != $ad_post ) {
                    $ad = $this->prepare_item_for_response( $ad_post, $request );

                    // 加入文章封面影片連結
                    $ad[ 'cover_video_url' ] = $ad_video_url;
                    $data[] = $ad;            
                }
            }

            $query->the_post();
            $itemdata = $this->prepare_item_for_response( $query->post, $request );
            // $data[] = $this->prepare_response_for_collection( $itemdata );
            $data[] = $itemdata;
            $index += 1;
        }
        $ret = array(
            'offset' => $offset + $query->post_count,
            'count' => $query->post_count,
            'list' => $data
        );

        wp_reset_postdata();

        return $ret;
    }

}
