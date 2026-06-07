<?php
/**
 * Plugin Name: FLiPER Core
 * Plugin URI: https://flipermag.com
 * Description: Core runtime plugin for FLiPER. Keeps the live site APIs, user flows, favorites, notifications, and shared helpers.
 * Version: 0.1.5
 * Author: Cash of FLiPER
 * Author URI: https://github.com/cashtsai
 */

require_once( 'lib/Pusher.php' );
require_once( dirname( __FILE__ ) . '/fp-includes/class-fp-go.php' );

function fliper_legacy_api_token() {
    return defined( 'FLIPER_LEGACY_API_TOKEN' ) ? (string) FLIPER_LEGACY_API_TOKEN : '';
}

function fliper_legacy_api_token_matches( $token ) {
    $expected = fliper_legacy_api_token();
    return '' !== $expected && is_string( $token ) && hash_equals( $expected, $token );
}

function fliper_facebook_app_id() {
    return defined( 'FLIPER_FB_APP_ID' ) ? (string) FLIPER_FB_APP_ID : '404071816353493';
}

function fliper_facebook_app_token() {
    if ( defined( 'FLIPER_FB_APP_TOKEN' ) ) {
        return (string) FLIPER_FB_APP_TOKEN;
    }

    if ( defined( 'FLIPER_FB_APP_ID' ) && defined( 'FLIPER_FB_APP_SECRET' ) ) {
        return FLIPER_FB_APP_ID . '|' . FLIPER_FB_APP_SECRET;
    }

    return '';
}

class FLIPER_Null_Pusher {
    public function trigger() {
        return true;
    }

    public function notify() {
        return true;
    }
}

$fp_pusher_key = defined( 'PUSHER_APP_KEY' ) ? PUSHER_APP_KEY : '';
$fp_pusher_secret = defined( 'PUSHER_APP_SECRET' ) ? PUSHER_APP_SECRET : '';
$fp_pusher_id = defined( 'PUSHER_APP_ID' ) ? PUSHER_APP_ID : '';
$fp_pusher_cluster = defined( 'PUSHER_APP_CLUSTER' ) ? PUSHER_APP_CLUSTER : '';

if ( '' !== $fp_pusher_key && '' !== $fp_pusher_secret && '' !== $fp_pusher_id ) {
    $GLOBALS[ 'pusher' ] = new Pusher( $fp_pusher_key, $fp_pusher_secret, $fp_pusher_id, array(
        'cluster' => $fp_pusher_cluster
    ) );
} else {
    $GLOBALS[ 'pusher' ] = new FLIPER_Null_Pusher();
}

global $area;
$area = 'tw';
if ( isset( $_GET['area'] ) && 'international' === $_GET['area'] ) {
    $area = 'international';
}

class FLiPER {

    /**
     * A Unique Identifier
     */
    protected $plugin_slug;

    /**
     * The array of templates that this plugin tracks.
     */
    protected $templates;

    /**
     * A reference to an instance of this class.
     */
    private static $instance;

    /**
     * Returns an instance of this class.
     */
    public static function get_instance() {
        // 載入其他內部程式
        require_once( dirname( __FILE__ ) . '/fp-includes/class-fp-favorites.php' );
        require_once( dirname( __FILE__ ) . '/fp-includes/class-fp-comments.php' );
        require_once( dirname( __FILE__ ) . '/fp-includes/class-fp-admin.php' );
        require_once( dirname( __FILE__ ) . '/fp-includes/class-fp-contact-form.php' );
        require_once( dirname( __FILE__ ) . '/fp-includes/class-fp-rest-meta.php' );
        require_once( dirname( __FILE__ ) . '/fp-includes/cors.php' );
        require_once( dirname( __FILE__ ) . '/fp-includes/rest-api/class-fp-rest-api.php' );
        require_once( dirname( __FILE__ ) . '/fp-includes/class-fp-json-api.php' );

        if ( null == self::$instance ) {
            self::$instance = new FLiPER();
        }

        if ( class_exists( 'FP_REST_Meta' ) ) {
            FP_REST_Meta::init();
        }

        if ( class_exists( 'FP_Contact_Form' ) ) {
            FP_Contact_Form::init();
        }
 
        return self::$instance;
    }

    /**
     * Initializes the plugin by setting filters and administration functions.
     */
    private function __construct() {
        require_once( dirname( __FILE__ ) . '/fp-includes/class-fp-notifications.php' );

        $this->templates = array();

        // Register function install on activated plugin action
        register_activation_hook( __FILE__, array( $this, 'install' ) );

        add_action( 'init', array( __CLASS__, 'register_post_types' ), 6 );
        add_action( 'init', array( $this, 'custom_login_page' ) );
        add_action( 'init', array( $this, 'fp_notifications_hook' ) );
        add_action( 'init', array( $this, 'crawl_fb_share_count' ) );
        add_action( 'init', array( $this, 'register_issue_nonhierarchical_taxonomy' ) );
        add_action( 'admin_menu', array( $this, 'custom_wp_admin' ) );
        add_action( 'admin_menu', array( $this, 'add_menu_page' ) );
        add_filter( 'registration_redirect', array( $this, 'registration_redirect' ) );
    }

    public function install() {
        // Register post types first make flush rewrite rules work.
        FLiPER::register_post_types();

        // Create database
        FLiPER::create_database();

        // Make custom post type rewrite rule worked.
        flush_rules();
    }

    public static function create_database() {
        global $wpdb;
    
        $table_name = $wpdb->prefix . "votes";
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
            `vote_id` bigint(20) NOT NULL AUTO_INCREMENT,
            `user_id` bigint(20) NOT NULL,
            `post_id` bigint(20) NOT NULL,
            `vote_datetime` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            `event_id` bigint(20) NOT NULL,
            `event_item_id` bigint(20) NOT NULL,
            PRIMARY KEY (vote_id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($sql);
    }

    /**
     * Register core post types
     */
    public static function register_post_types() {
/*        if ( ! post_type_exists('fliper_event') ) {
            $permalinks = 'event';

            register_post_type( 'fliper_event', array(
                'labels' => array(
                    'name'                  => __( '活動', 'fliper' ),
                    'singular_name'         => __( '活動', 'fliper' ),
                    'menu_name'             => _x( '活動', 'Admin menu name', 'fliper' ),
                    'add_new'               => __( '新增', 'fliper' ),
                    'add_new_item'          => __( '新增活動', 'fliper' ),
                    'edit'                  => __( '編輯', 'fliper' ),
                    'edit_item'             => __( '編輯活動', 'fliper' ),
                    'new_item'              => __( '新增活動', 'fliper' ),
                    'view'                  => __( '查看活動', 'fliper' ),
                    'view_item'             => __( '活動', 'fliper' ),
                    'search_items'          => __( '搜尋活動', 'fliper' ),
                    'not_found'             => __( '無相關的活動', 'fliper' ),
                    'not_found_in_trash'    => __( '垃圾桶中無相關的活動', 'fliper' ),
                ),
                'description'           => __( '活動 - 完整顯示活動資訊', 'fliper' ),
                'public'                => true,
                'show_ui'               => true,
                'capability_type'       => 'page',
                'map_meta_cap'          => true,
                'publicly_queryable'    => true,
                'exclude_from_search'   => false,
                'hierarchical'          => false, // Hierarchical causes memory issues - WP loads all records!
                'rewrite'               => $permalinks ? array( 'slug' => untrailingslashit( $permalinks ), 'with_front' => false, 'feeds' => true ) : false,
                'query_var'             => true,
                'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'custom-fields', 'page-attributes' ),
                'has_archive'           => true,
                'show_in_nav_menus'     => true
            ) );
        }*/

      /*  if ( ! post_type_exists('fliper_video') ) {
            $permalinks = 'video';

            register_post_type( 'fliper_video', array(
                'labels' => array(
                    'name'                  => __( '影片', 'fliper' ),
                    'singular_name'         => __( '影片', 'fliper' ),
                    'menu_name'             => _x( '影片', 'Admin menu name', 'fliper' ),
                    'add_new'               => __( '新增', 'fliper' ),
                    'add_new_item'          => __( '新增影片', 'fliper' ),
                    'edit'                  => __( '編輯', 'fliper' ),
                    'edit_item'             => __( '編輯影片', 'fliper' ),
                    'new_item'              => __( '新增影片', 'fliper' ),
                    'view'                  => __( '查看影片', 'fliper' ),
                    'view_item'             => __( '影片', 'fliper' ),
                    'search_items'          => __( '搜尋影片', 'fliper' ),
                    'not_found'             => __( '無相關的影片', 'fliper' ),
                    'not_found_in_trash'    => __( '垃圾桶中無相關的影片', 'fliper' ),
                ),
                'description'           => __( '影片 - 完整顯示影片資訊', 'fliper' ),
                'public'                => true,
                'show_ui'               => true,
                'capability_type'       => 'page',
                'map_meta_cap'          => true,
                'publicly_queryable'    => true,
                'exclude_from_search'   => false,
                'hierarchical'          => false, // Hierarchical causes memory issues - WP loads all records!
                'rewrite'               => $permalinks ? array( 'slug' => untrailingslashit( $permalinks ), 'with_front' => false, 'feeds' => true ) : false,
                'query_var'             => true,
                'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'custom-fields', 'page-attributes' ),
                'has_archive'           => true,
                'show_in_nav_menus'     => true
            ) );
        } */
/*
        if ( ! post_type_exists('fliper_artwork') ) {
            $permalinks = 'artwork';

            register_post_type( 'fliper_artwork', array(
                'labels' => array(
                    'name'                  => __( '作品', 'fliper' ),
                    'singular_name'         => __( '作品', 'fliper' ),
                    'add_new'               => __( '新增', 'fliper' ),
                    'add_new_item'          => __( '新增作品', 'fliper' ),
                    'edit_item'             => __( '編輯作品', 'fliper' ),
                    'new_item'              => __( '新增作品', 'fliper' ),
                    'view_item'             => __( '作品', 'fliper' ),
                    'view_items'            => __( '查看作品', 'fliper' ),
                    'search_items'          => __( '搜尋作品', 'fliper' ),
                    'not_found'             => __( '無相關的作品', 'fliper' ),
                    'not_found_in_trash'    => __( '垃圾桶中無相關的作品', 'fliper' ),
                    'all_items'             => __( '所有作品', 'fliper' ),
                    'featured_image'        => __( '作品封面', 'fliper' ),
                    'set_featured_image'    => __( '設定作品封面', 'fliper' ),
                    'remove_featured_image' => __( '移除作品封面', 'fliper' ),
                    'menu_name'             => _x( '作品', 'Admin menu name', 'fliper' ),
                ),
                'description'           => __( '作品 - 完整顯示作品資訊', 'fliper' ),
                'public'                => true,
                'show_ui'               => true,
                'capability_type'       => 'post',
                'map_meta_cap'          => true,
                'publicly_queryable'    => true,
                'exclude_from_search'   => false,
                'hierarchical'          => false, // Hierarchical causes memory issues - WP loads all records!
                'rewrite'               => $permalinks ? array( 'slug' => untrailingslashit( $permalinks ), 'with_front' => false, 'feeds' => true ) : false,
                'capability_type'       => array( 'fliper_artwork', 'fliper_artworks' ),
                'map_meta_cap' => true,
                'query_var'             => true,
                'supports'              => array( 'title', 'author', 'excerpt', 'thumbnail', 'comments', 'custom-fields' ),
                'has_archive'           => true,
                'show_in_nav_menus'     => true
            ) );
        }
*/
  /*      $labels = array(
            'name' => _x( '作品分類', 'taxonomy general name' ),
            'singular_name' => _x( '作品分類', 'taxonomy singular name' ),
            'search_items' =>  __( '搜尋作品分類' ),
            'popular_items' => __( '熱門作品分類' ),
            'all_items' => __( '所有作品分類' ),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => __( '編輯作品分類' ), 
            'update_item' => __( '更新作品分類' ),
            'add_new_item' => __( '新增作品分類' ),
            'new_item_name' => __( '新作品分類名稱' ),
            'separate_items_with_commas' => __( '使用逗號 , 分隔作品分類' ),
            'add_or_remove_items' => __( '新增或移除作品分類' ),
            'choose_from_most_used' => __( '選擇最常使用的作品分類' ),
            'menu_name' => __( '作品分類' ),
        ); 
 
        register_taxonomy( 'artwork_category', 'fliper_artwork', array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var' => true,
            'rewrite' => array( 'slug' => 'artwork-category' ),
        ) ); */

     /*   $labels = array(
            'name' => _x( '作品組織', 'taxonomy general name' ),
            'singular_name' => _x( '作品組織', 'taxonomy singular name' ),
            'search_items' =>  __( '搜尋作品組織' ),
            'popular_items' => __( '熱門作品組織' ),
            'all_items' => __( '所有作品組織' ),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => __( '編輯作品組織' ), 
            'update_item' => __( '更新作品組織' ),
            'add_new_item' => __( '新增作品組織' ),
            'new_item_name' => __( '新作品組織名稱' ),
            'separate_items_with_commas' => __( '使用逗號 , 分隔作品組織' ),
            'add_or_remove_items' => __( '新增或移除作品組織' ),
            'choose_from_most_used' => __( '選擇最常使用的作品組織' ),
            'menu_name' => __( '作品組織' ),
        ); 
 
        register_taxonomy( 'artwork_org', 'fliper_artwork', array(
            'hierarchical' => false,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var' => true,
            'rewrite' => array( 'slug' => 'artwork-org' ),
            'capabilities' => array(
                'manage_terms' => 'edit_fliper_artworks',
            ),
        ) ); */

     /*   $labels = array(
            'name' => _x( '作品組織部門', 'taxonomy general name' ),
            'singular_name' => _x( '作品組織部門', 'taxonomy singular name' ),
            'search_items' =>  __( '搜尋作品組織部門' ),
            'popular_items' => __( '熱門作品組織部門' ),
            'all_items' => __( '所有作品組織部門' ),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => __( '編輯作品組織部門' ), 
            'update_item' => __( '更新作品組織部門' ),
            'add_new_item' => __( '新增作品組織部門' ),
            'new_item_name' => __( '新作品組織部門名稱' ),
            'separate_items_with_commas' => __( '使用逗號 , 分隔作品組織部門' ),
            'add_or_remove_items' => __( '新增或移除作品組織部門' ),
            'choose_from_most_used' => __( '選擇最常使用的作品組織部門' ),
            'menu_name' => __( '作品組織部門' ),
        ); 
 
        register_taxonomy( 'artwork_org_dept', 'fliper_artwork', array(
            'hierarchical' => false,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var' => true,
            'rewrite' => array( 'slug' => 'artwork-org-dept' ),
            'capabilities' => array(
                'manage_terms' => 'edit_fliper_artworks',
            ),
        ) ); */

     /*   $labels = array(
            'name' => _x( '作品相關活動', 'taxonomy general name' ),
            'singular_name' => _x( '作品相關活動', 'taxonomy singular name' ),
            'search_items' =>  __( '搜尋作品相關活動' ),
            'popular_items' => __( '熱門作品相關活動' ),
            'all_items' => __( '所有作品相關活動' ),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => __( '編輯作品相關活動' ), 
            'update_item' => __( '更新作品相關活動' ),
            'add_new_item' => __( '新增作品相關活動' ),
            'new_item_name' => __( '新作品相關活動名稱' ),
            'separate_items_with_commas' => __( '使用逗號 , 分隔作品相關活動' ),
            'add_or_remove_items' => __( '新增或移除作品相關活動' ),
            'choose_from_most_used' => __( '選擇最常使用的作品相關活動' ),
            'menu_name' => __( '作品相關活動' ),
        ); 
 
        register_taxonomy( 'artwork_related_event', 'fliper_artwork', array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var' => true,
            'rewrite' => array( 'slug' => 'artwork-related-event' ),
        ) ); */
    }

    // public function url_rewrites( $wp_rules ) {
    //     $rules = array(
    //         'login/?$' => 'wp-login.php',
    //     );

    //     return array_merge( $rules, $wp_rules );
    // }

    public function registration_redirect( $registration_redirect ) {
        $redirect_to = site_url();
        if ( isset( $_GET[ 'redirect_to' ] ) )
            $redirect_to = $_GET[ 'redirect_to' ];
        return $redirect_to;
    }

    public function add_menu_page() {
        add_menu_page( 'FLiPER', 'FLiPER', 'manage_options', 'fliper', array( $this, 'show_menu_page' ) );
    }

    public function show_menu_page() {
        if ( ! current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }

        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

            if ( isset( $_POST['delete_homepage_news_cache'] ) && 'yes' == $_POST['delete_homepage_news_cache'] ) {
                delete_option( 'homepage_post_sequence_' . date("Ymd") );

                // 產生新的首頁版型
                get_homepage_new_article_cache();
            } else {
                // 廣告
                update_option( 'fliper_homepage_ad_banner_link', $_POST['homepage_ad_banner_link'] );
                update_option( 'fliper_homepage_ad_banner_img', $_POST['homepage_ad_banner_img'] );
                update_option( 'fliper_homepage_ad_banner_img_mobile', $_POST['homepage_ad_banner_img_mobile'] );

                update_option( 'fliper_post_bottom_ad_banner_link', $_POST['post_bottom_ad_banner_link'] );
                update_option( 'fliper_post_bottom_ad_banner_img', $_POST['post_bottom_ad_banner_img'] );
                update_option( 'fliper_post_bottom_ad_banner_img_mobile', $_POST['post_bottom_ad_banner_img_mobile'] );

                // 其他
                update_option( 'fliper_author_manual_link', $_POST['author_manual_link'] );
            }
        }

        ?>

        <div class="wrap">
            <h2>FLiPER 設定</h2>
            <form action="" method="post">
                <div class="wrap"><h3>2020 首頁設定</h3></div>
                <div class="wrap">
                    <input type="hidden" name="delete_homepage_news_cache" value="yes" />
                    <input class="button-primary" type="submit" name="submit" value="<?php _e( '重置今日首頁版型', 'fliper' ); ?>" />
                </div>
            </form>
            <form action="" method="post">
                <div class="wrap"><h3>廣告設定</h3></div>
                <div class="wrap">
                    <label>首頁第一篇文章下方 Banner 連結</label>
                    <input name="homepage_ad_banner_link" type="text" size="128" value="<?php echo get_option( 'fliper_homepage_ad_banner_link' ); ?>" />
                </div>
                <div class="wrap">
                    <label>首頁第一篇文章下方 Banner 圖片網址</label>
                    <input name="homepage_ad_banner_img" type="text" size="128" value="<?php echo get_option( 'fliper_homepage_ad_banner_img' ); ?>" />
                </div>
                <div class="wrap">
                    <label>首頁第一篇文章下方 Banner 手機版圖片網址</label>
                    <input name="homepage_ad_banner_img_mobile" type="text" size="128" value="<?php echo get_option( 'fliper_homepage_ad_banner_img_mobile' ); ?>" />
                </div>
                <div class="wrap">
                    <label>文章頁面文末 Banner 連結</label>
                    <input name="post_bottom_ad_banner_link" type="text" size="128" value="<?php echo get_option( 'fliper_post_bottom_ad_banner_link' ); ?>" />
                </div>
                <div class="wrap">
                    <label>文章頁面文末 Banner 圖片網址</label>
                    <input name="post_bottom_ad_banner_img" type="text" size="128" value="<?php echo get_option( 'fliper_post_bottom_ad_banner_img' ); ?>" />
                </div>
                <div class="wrap">
                    <label>文章頁面文末 Banner 手機版圖片網址</label>
                    <input name="post_bottom_ad_banner_img_mobile" type="text" size="128" value="<?php echo get_option( 'fliper_post_bottom_ad_banner_img_mobile' ); ?>" />
                </div>
                <br /><br />
                <div class="wrap"><h3>其他</h3></div>
                <div class="wrap">
                    <label>專欄作家規範下載連結：</label>
                    <input name="author_manual_link" type="text" size="64" value="<?php echo $this->get_author_manual_link(); ?>" />
                </div>
                <br /><br />
                <div class="wrap">
                    <input class="button-primary" type="submit" name="submit" value="<?php _e( '儲存', 'fliper' ); ?>" />
                </div>
            </form>
        </div>

        <?php
        
    }

    public function custom_login_page() {
        add_filter( 'login_headerurl', function() {
            return site_url();
        } );
        add_filter( 'login_headertext', function() {
            return get_bloginfo( 'name' );
        } );
        add_filter( 'login_body_class', function( $classes ) {
            array_push( $classes, 'fliper' );
            return $classes;
        } );
        // add_filter( 'login_message', function( $message ) {
        //     return '<h2 class="subtitle">Discover the Creative World</h2>' . $message;
        // } );
        // add_action( 'login_enqueue_scripts', function() {
        //     global $area;
        //     if ( 'international' === $area ) {
        //         wp_enqueue_script( 'fp_login_page', plugins_url( 'js/login_page.international.js', __FILE__ ), array('jquery'), '0.7.10.4', true);
        //     } else {
        //         wp_enqueue_script( 'fp_login_page', plugins_url( 'js/login_page.js', __FILE__ ), array('jquery'), '0.7.10.4', true);    
        //     }
        // } );
        add_action( 'login_head', function() {

            ?>

            <meta property="og:site_name" content="FLiPER" />
            <meta property="og:type" content="website" />
            <meta property="og:locale" content="zh_TW" />
            <meta property="fb:app_id" content="<?php echo esc_attr( fliper_facebook_app_id() ); ?>" />
            <meta property="og:title" content="FLiPER - Login" />
            <meta property="og:description" content="愛好與收藏精彩豐富的人事物" />
            <!-- <meta property="og:image" content="<?php //echo plugins_url( 'images/login_bg_2016_03_1920.png', __FILE__ ); ?>" />
            <meta property="og:image:width" content="1920" />
            <meta property="og:image:height" content="1080" /> -->

            <script type="text/javascript">var site_url = '<?php echo site_url(); ?>';</script>

            <style>
            body.fliper.login h1 a {
                background-image:url(<?php echo plugins_url( 'images/iconset-20180902@2x.png', __FILE__ ); ?>);
                background-size:340px;
                background-position-x: 0px;
                background-position-y: 0px;
                width: 156px;
                height: 62px;
            }
            body.fliper.login h1 a:focus {
                box-shadow: none;
            }
            </style>


            <?php

        } );

    }

    public function fp_notifications_hook() {
        add_action( 'fp_favorite_post', function( $user_id, $post_id ) {
            FP_Notification::add_favorite_post_notification( $user_id, $post_id );
        }, 10, 2 );

        add_action( 'wp_subscribe_author_subscribe', function( $user_id, $author_id ) {
            FP_Notification::add_follow_author_notification( $user_id, $author_id );
        }, 10, 2 );

        add_action( 'pending_to_publish', array( $this, 'on_publish_post' ), 10, 1 );
        add_action( 'draft_to_publish', array( $this, 'on_publish_post' ), 10, 1 );
        add_action( 'future_to_publish', array( $this, 'on_publish_post' ), 10, 1 );

        // 留言通知
        add_action( 'wp_insert_comment', function( $comment_id, $comment ) {
            // 取得作者 ID
            $post = get_post( $comment->comment_post_ID );
            $author_id = $post->post_author;

            // 取得該文章不包含作者的留言人數
            global $wpdb;
            $count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(DISTINCT user_id) FROM {$wpdb->comments} WHERE comment_post_ID = %d AND user_id != %d AND comment_approved = '1'",
                $comment->comment_post_ID,
                $author_id
            ) );

            // 檢查留言人是否為該文章作者，若是則不通知作者
            if ( $author_id != $comment->user_id ) {
                // 刪除舊的留言通知
                FP_Notification::delete_notification(
                    $author_id,
                    $comment->user_id, 
                    'user',
                    '"post_id":"' . $comment->comment_post_ID . '"', 
                    'comment_post'
                );

                // 通知作者
                FP_Notification::add_notification( 
                    $author_id, 
                    $comment->user_id, 
                    'user', 
                    json_encode( array( 'post_id' => $comment->comment_post_ID, 'user_count' => $count ) ), 
                    'comment_post'
                );

                // 即時通知使用者
                $GLOBALS[ 'pusher' ]->trigger( 'fp_notification_' . $author_id, 'reload', array() );
                if ( 1 == $count ) {
                    $text = get_userdata( $comment->user_id )->display_name . ' 在你的文章 ' . get_the_title( $post ) . ' 留言。';
                } else {
                    $text = get_userdata( $comment->user_id )->display_name . ' 與其他 ' . ( $count - 1 ) . ' 人在你的文章 ' . get_the_title( $post ) . ' 留言。';
                }
                $GLOBALS[ 'pusher' ]->notify(
                    array( 'fp_notification_' . $author_id ),
                    array(
                        'apns' => array(
                            'aps' => array(
                                'alert' => array(
                                    'body' => $text
                                ),
                                'badge' => intval( FP_Notification::get_new_notifications_count( $author_id ) ),
                                'fliper' => AUTHOR_ARTICLE_COMMENTED
                            ),
                        ),
                    )
                );

                // 透過 email 通知作者
                $author = get_userdata( $author_id );
                $headers[] = 'From: "FLiPER 服務信箱" <service@flipermag.com>';
                $headers[] = 'Content-type: text/html';
                wp_mail( $author->user_email,
                    '你在 FLiPER 發佈的文章《' . get_the_title( $post ) . '》有新的留言',
                    '<p>' . $author->display_name . ' 你好，</p><br/>
                    <p>你在 FLiPER 發佈的文章<a href="' . get_permalink( $post ) . '" target="_blank">《' . get_the_title( $post ) . '》</a>有新的留言，</p>
                    <p>通知你前往查看與回覆，讓更多人瞭解你的想法。</p>
                    <p></p>
                    <p>-----</p>
                    <p>謝謝你的支持，若有任何問題，請隨時與我們聯繫。</p>
                    <p><a href="' . site_url() . '" target="_blank">FLiPER</a> 祝你有美好的一天</p>',
                    $headers
                );
            }

            // 取得已留言者 id
            $objects = $wpdb->get_results( $wpdb->prepare( "SELECT DISTINCT user_id FROM {$wpdb->comments} WHERE comment_post_ID = %d AND comment_approved = '1'",
                $comment->comment_post_ID 
            ) );

            // 通知已留言者
            foreach ( $objects as $object ) {
                // 檢查已留言者是否為該文章作者，若是則不進行通知
                if ( $author_id == $object->user_id ) continue;

                // 檢查已留言者是否為本次留言者，若是則不進行通知
                if ( $comment->user_id == $object->user_id ) continue;

                // 取得該文章不包含要被通知的留言者的留言人數，
                $count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(DISTINCT user_id) FROM {$wpdb->comments} WHERE comment_post_ID = %d AND user_id != %d AND comment_approved = '1'",
                    $comment->comment_post_ID,
                    $object->user_id
                ) );

                // 刪除舊的留言通知
                FP_Notification::delete_notification(
                    $object->user_id,
                    $comment->user_id, 
                    'user',
                    '"post_id":"' . $comment->comment_post_ID . '"', 
                    'comment_post'
                );

                // 通知已留言者
                FP_Notification::add_notification( 
                    $object->user_id,
                    $comment->user_id, 
                    'user', 
                    json_encode( array( 'post_id' => $comment->comment_post_ID, 'user_count' => $count ) ), 
                    'comment_post'
                );

                // 即時通知使用者
                $GLOBALS[ 'pusher' ]->trigger( 'fp_notification_' . $object->user_id, 'reload', array() );
                $text = '有 ' . $count . ' 人也回應了 ' . get_the_title( $post ) . '。';
                $GLOBALS[ 'pusher' ]->notify(
                    array( 'fp_notification_' . $object->user_id ),
                    array(
                        'apns' => array(
                            'aps' => array(
                                'alert' => array(
                                    'body' => $text
                                ),
                                'badge' => intval( FP_Notification::get_new_notifications_count( $object->user_id ) ),
                                'fliper' => USER_ARTICLE_COMMENTED
                            ),
                        ),
                    )
                );

                // 透過 email 通知使用者
                $user = get_userdata( $object->user_id );
                $headers[] = 'From: "FLiPER 服務信箱" <service@flipermag.com>';
                $headers[] = 'Content-type: text/html';
                wp_mail( $user->user_email,
                    '你在 FLiPER 留言的文章《' . get_the_title( $post ) . '》有新的留言',
                    '<p>' . $user->display_name . ' 你好，</p><br/>
                    <p>你在 FLiPER 留言的文章<a href="' . get_permalink( $post ) . '" target="_blank">《' . get_the_title( $post ) . '》</a>有新的留言，</p>
                    <p>通知你前往查看與回覆，讓更多人瞭解你的想法。</p>
                    <p></p>
                    <p>-----</p>
                    <p>謝謝你的支持，若有任何問題，請隨時與我們聯繫。</p>
                    <p><a href="' . site_url() . '" target="_blank">FLiPER</a> 祝你有美好的一天</p>',
                    $headers
                );
            }
        }, 10, 2 );

        // 刪除文章時刪除通知
        add_action( 'delete_post', array( 'FP_Notification', 'delete_following_publish_post_notification' ) ); 
    }

    /**
     * post 從其他狀態被改成 publish 時觸發
     */
    public function on_publish_post( $post ) {
        if ( 'post' === $post->post_type ) {
            $post_id = $post->ID;
            $author_id = $post->post_author;

            $wpsamodel = new Wpsa_Model();
            if( $wpsamodel->get_num_subscribers( $author_id ) == 0 )
                return;
                 
            $subscribers = $wpsamodel->getAllSubscribers( $author_id );
            foreach( $subscribers as $subscriber ){
                $subscriber_id = $subscriber->subscriber_id;

                // 目前使用的訂閱作者外掛接受未登入訂閱，因此會出現訂閱者 id 為 0 的情況，在這邊強制處理當作沒看到
                if ( 0 == $subscriber_id )
                    continue;

                FP_Notification::add_notification( $subscriber_id, $post_id, 'post', '', 'following_publish_post' );
                $GLOBALS[ 'pusher' ]->trigger( 'fp_notification_' . $subscriber_id, 'reload', array() ); // 即時通知使用者
                $text = get_userdata( $author_id )->display_name . ' 發佈了一篇新的文章 ' . get_the_title( $post ) .'。';
                $GLOBALS[ 'pusher' ]->notify(
                    array( 'fp_notification_' . $subscriber_id ),
                    array(
                        'apns' => array(
                            'aps' => array(
                                'alert' => array(
                                    'body' => $text
                                ),
                                'badge' => intval( FP_Notification::get_new_notifications_count( $subscriber_id ) ),
                                'fliper' => FOLLOWING_PUBLISH_ARTICLE
                            ),
                        ),
                    )
                );
            }
        }
    }

    public function custom_wp_admin() {
        remove_meta_box('authordiv', 'post', 'normal');

        if ( post_type_supports( 'post', 'author' ) ) {
            if ( is_super_admin() || current_user_can( 'edit_others_posts' ) ) {
                add_meta_box( 'fp_authordiv', __( 'Author' ), function( $post ) {
                    global $user_ID, $wpdb;

                    $args = array(
                        'fields' => 'ID',
                        'meta_query' => array(
                            array(
                                'key' => $wpdb->prefix . 'capabilities',
                                'value' => 'writer',
                                'compare' => 'like'
                            )
                        )
                    );
                    $user_query = new WP_User_Query( $args );
                    $user_ids_array = $user_query->get_results();
                    $user_ids = implode( ',', $user_ids_array );
                    if ( empty( $post->ID ) && ! in_array( $user_ID, $user_ids_array ) ) {
                        $user_ids = $user_ID . ',' . $user_ids;
                    } else if ( ! empty( $post->ID ) && ! in_array( $post->post_author, $user_ids_array ) ) {
                        $user_ids = $post->post_author . ',' . $user_ids;
                    }
                    ?>

                    <label class="screen-reader-text" for="post_author_override"><?php _e( 'Author' ); ?></label>

                    <?php
                        wp_dropdown_users( array(
                            'include' => $user_ids,
                            'name' => 'post_author_override',
                            'selected' => empty( $post->ID ) ? $user_ID : $post->post_author,
                            'include_selected' => true
                        ) );
                }, 'post', 'normal' );
            }
        }
    }

    public function crawl_fb_share_count() {
        add_action( 'admin_menu', function(){

        add_submenu_page('fliper', 'FB Share Count', 'FB Share Count', 'manage_options', 'fliper-fb-share-count', function() {

            if ( ! current_user_can( 'manage_options' ) )  {
                wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
            } 
            
            if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
                if ( is_numeric( $_REQUEST['crawl_start_id'] ) && is_numeric( $_REQUEST['crawl_offset'] ) ) {
                    global $wpdb;

                    // $query = new WP_Query( array( 
                    //     'post_type' => 'fliper_artwork',
                    //     'posts_per_page' => -1,
                    //     'fields' => 'ids',
                    // ) );
                    // $artwork_ids = $query->get_posts();
                    // foreach ( $artwork_ids as $id ) {
                    //     $d = get_field( 'artwork_intro', $id );
                    //     $the_post = array(
                    //           'ID'           => $id,//the ID of the Post
                    //           'post_excerpt' => $d,
                    //       );
                    //     wp_update_post( $the_post );
                    // }
                    
                    $result = $wpdb->get_results( $wpdb->prepare( "SELECT ID FROM wp_posts WHERE ID >= %d AND ( post_type = %s OR post_type = %s ) ORDER BY ID ASC LIMIT %d",
                        $_REQUEST['crawl_start_id'],
                        'post',
                        'page',
                        $_REQUEST['crawl_offset']
                    ) );

                    $urls = array();
                    for ( $i = 0; $i < $_REQUEST['crawl_offset']; $i++ ) {
                        $urls[] = array( $result[ $i ]->ID => get_permalink( $result[ $i ]->ID ) );
                    }
                }
            }

            ?>

            <div class="wrap">
                <h2>Facebook 批次抓取分享數</h2>
                <div id="result">
                <?php $last_id = 0; if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) :
                for ( $i = 0; $i < $_REQUEST['crawl_offset']; $i++ ) {
                    foreach ( $urls[ $i ] as $key => $value ) {
                        $index = $i + 1;

                        echo '<p>第 ' . $index . ' 個：</p>';
                        echo '<p>開始抓取，ID：' . $key . '，URL：' . $value . '</p>';

                        $fb_url = 'https://developers.facebook.com/tools/debug/sharing/?q=' . $value;
                        $curl = curl_init();
                        curl_setopt( $curl, CURLOPT_URL, $fb_url );
                        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
                        $curl_res = curl_exec( $curl );
                        curl_close( $curl );

                        $url = 'https://flipermag.com/wp-json/api/v2/update-social-share-count?url=' . $value;
                        $curl = curl_init();
                        curl_setopt( $curl, CURLOPT_URL, $url );
                        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
                        $curl_res = curl_exec( $curl );
                        curl_close( $curl );
                        $ret = json_decode( $curl_res );
                        if ( $ret->count <= 0 ) {
                            echo '<p style="color:red">回傳 count 為 0，請手動檢查本篇文章，ID：' . $key . '，URL：' . $value . '</p>';
                            echo '<p style="color:red">可能失敗，分享數：' . $ret->count . '</p>';
                        } else {
                            echo '<p>成功，分享數：' . $ret->count . '，ID：' . $key . '，URL：' . $value . '</p>';
                        }
                        echo '<br/><br/>';
                        $last_id = $key;
                    }
                }
                endif; ?>
                </div>
                <form action="" method="post">
                    <div class="wrap">
                        <label>起始文章 / 頁面 ID</label>
                        <input id="crawl_start_id" name="crawl_start_id" type="text" size="16" value="<?php echo $last_id + 1; ?>" />
                    </div>
                    <div class="wrap">
                        <label>抓取篇數</label>
                        <input id="crawl_offset" name="crawl_offset" type="text" size="16" value="10" />
                    </div>
                    <div class="wrap">
                        <input class="button-primary" type="submit" name="submit" value="立刻抓" />
                    </div>
                </form>
            </div>

        <?php

        } );

        } );
    }

    public function get_homepage_monthly_topic_title() {
        return get_option('fliper_homepage_monthly_topic_title');
    }

    public function get_homepage_monthly_topic_cover() {
        return get_option('fliper_homepage_monthly_topic_cover');
    }

    public function get_homepage_monthly_topic_tag() {
        return get_option('fliper_homepage_monthly_topic_tag');
    }

    public function is_app_today_special_open() {
        $flag = get_option('fliper_app_today_special');

        $ret = false;
        if ( '1' === $flag ) {
            $ret = true;
        }

        return $ret;
    }

    public function get_app_today_special_title() {
        return get_option('fliper_app_today_special_title');
    }

    public function get_app_today_special_thumbnail_src() {
        return get_option('fliper_app_today_special_thumbnail_src');
    }

    public function get_app_today_special_original_src() {
        return get_option('fliper_app_today_special_original_src');
    }

    public function get_app_today_special_link() {
        return get_option('fliper_app_today_special_link');
    }

    public function is_homepage_gallery_quote_open() {
        $flag = get_option('fliper_homepage_gallery_quote');

        $ret = false;
        if ( '1' === $flag ) {
            $ret = true;
        }

        return $ret;
    }

    public function get_homepage_gallery_quote_image_src() {
        return get_option('fliper_homepage_gallery_quote_image_src');
    }

    public function get_homepage_gallery_quote_image_src_big() {
        return get_option('fliper_homepage_gallery_quote_image_src_big');
    }

    public function get_homepage_gallery_quote_image_description() {
        return get_option('fliper_homepage_gallery_quote_image_description');
    }

    public function get_homepage_gallery_quote_quote() {
        return get_option('fliper_homepage_gallery_quote_quote');
    }
    
    public function get_homepage_gallery_quote_author() {
        return get_option('fliper_homepage_gallery_quote_author');
    }

    public function get_homepage_gallery_quote_more_link() {
        return get_option('fliper_homepage_gallery_quote_more_link');
    }

    public function get_homepage_gallery_quote_more_link_title() {
        return get_option('fliper_homepage_gallery_quote_more_link_title');
    }

    public function get_author_manual_link() {
        return get_option('fliper_author_manual_link');
    }

    
 
    public function register_issue_nonhierarchical_taxonomy() {
        $labels = array(
            'name' => _x( '專題', 'taxonomy general name' ),
            'singular_name' => _x( '專題', 'taxonomy singular name' ),
            'search_items' =>  __( '搜尋專題' ),
            'popular_items' => __( '熱門專題' ),
            'all_items' => __( '所有專題' ),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => __( '編輯專題' ), 
            'update_item' => __( '更新專題' ),
            'add_new_item' => __( '新增專題' ),
            'new_item_name' => __( '新專題名稱' ),
            'separate_items_with_commas' => __( '使用逗號 , 分隔專題' ),
            'add_or_remove_items' => __( '新增或移除專題' ),
            'choose_from_most_used' => __( '選擇最常使用的專題' ),
            'menu_name' => __( '專題' ),
        ); 
 
        register_taxonomy( 'issue', 'post', array(
            'hierarchical' => false,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var' => true,
            'rewrite' => array( 'slug' => 'issue' ),
        ) );
    }

}

/* When a plugin goes through the activation process, it gets included *after* pluggable.php gets included.
   During the load process, it gets included before. */
// 客製化註冊 email
if ( ! function_exists( 'wp_new_user_notification' ) ) {

function wp_new_user_notification( $user_id, $deprecated = null, $notify = '' ) {
    global $wpdb, $wp_hasher;
    $user = get_userdata( $user_id );

    // The blogname option is escaped with esc_html on the way into the database in sanitize_option
    // we want to reverse this for the plain text arena of emails.
    $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

    $message  = sprintf(__('New user registration on your site %s:'), $blogname) . "\r\n\r\n";
    $message .= sprintf(__('Username: %s'), $user->user_login) . "\r\n\r\n";
    $message .= sprintf(__('Email: %s'), $user->user_email) . "\r\n";

    @wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Registration'), $blogname), $message);

    // `$deprecated was pre-4.3 `$plaintext_pass`. An empty `$plaintext_pass` didn't sent a user notifcation.
    if ( 'admin' === $notify || ( empty( $deprecated ) && empty( $notify ) ) ) {
        return;
    }

    $message = sprintf(__('Username: %s'), $user->user_login) . "\r\n\r\n";
    $message .= '歡迎你加入 FLiPER，馬上登入並開始愛好與收藏美好的人事物吧！' . "\r\n\r\n";

    $message .= '請由此登入：' . wp_login_url() . "\r\n";

    wp_mail($user->user_email, sprintf( '%s 你好，FLiPER 歡迎你的加入', $user->user_login ), $message );
}

}

add_action( 'plugins_loaded', array( 'FLiPER', 'get_instance' ) );

// 從資料庫取得 Facebook 分享數字
function FLiPER_get_facebook_share_count( $post_id ) {
    $meta_id = 'fb_share_count';
    $fb_share_count = get_post_meta( $post_id, $meta_id, true );

    // 抓出初始分享數，理論上這個數字只會越來越高
    if ( '' == $fb_share_count ) {
        $fb_share_count = 0;
    }

    return $fb_share_count;
}

// 從 Facebook Server 取得 Facebook 分享數字，若大於本地儲存資料，則儲存進入資料庫
function FLiPER_crawl_facebook_share_count( $post_id ) {
    $meta_id = 'fb_share_count';
    $url = get_permalink( $post_id );
    $fb_app_token = fliper_facebook_app_token();
    if ( '' === $fb_app_token ) {
        return;
    }

    $url = 'https://graph.facebook.com/v2.7/?id=' . rawurlencode( $url ) . '&access_token=' . rawurlencode( $fb_app_token ) . '&fields=og_object{engagement}';

    $curl = curl_init();
    curl_setopt( $curl, CURLOPT_URL, $url );
    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
    $curl_res = curl_exec( $curl );
    curl_close( $curl );
    $ret = json_decode( $curl_res );
    $fb_share_count = FLiPER_get_facebook_share_count( $post_id );
    if ( property_exists( $ret, 'og_object' ) ) {
        $count = $ret->og_object->engagement->count;
        if ( $count > $fb_share_count ) {
            update_post_meta( $post_id, $meta_id, $count );
            $fb_share_count = $count;
        }
    }
    
    return $fb_share_count;    
}

/**
 * 客製化 WordPress Popular Posts 的函式
 *
 */
function wpp_get_mostpopular_post($args = NULL) {

    $shortcode = '[wpp';

    if ( is_null( $args ) ) {
        $shortcode .= ']';
    } else {
        if( is_array( $args ) ){
            $atts = '';
            foreach( $args as $key => $arg ){
                $atts .= ' ' . $key . '="' . htmlspecialchars($arg, ENT_QUOTES, $encoding = ini_get("default_charset"), false) . '"';
            }
        } else {
            $atts = trim( str_replace( "&", " ", $args  ) );
        }

        $shortcode .= ' ' . $atts . ']';
    }
    
    add_filter( 'wpp_custom_html', function( $popular_posts, $instance ){
        global $wpp_popular_post_ids;
        foreach ( $popular_posts as $post ) {
            $wpp_popular_post_ids[] = $post->id;
        }
    }, 10, 2 );

    do_shortcode( $shortcode );

}

/**
 * 解決 Facebook 抓取 share count 時循環參考 url 的問題
 *
 */
function FLiPER_custom_rel_canonical() {
    if ( false !== strpos( $_SERVER['HTTP_USER_AGENT'], 'facebookexternalhit' ) ) {
        remove_action( 'wp_head', 'rel_canonical' );
    }
}
add_action( 'wp', 'FLiPER_custom_rel_canonical' );

/**
 * Return FB crawler the information that it needs for proper og.
 * Solve FB crawler get 404 on scheduled post.
 *
 * @package FLiPERMAG
 *
 * @return none
 */
function add_og_for_fb() {
    // Check if is FB crawler visiting
    if ( strpos( $_SERVER['HTTP_USER_AGENT'], 'facebookexternalhit' ) === false )
        return;
    
    // If post has been published then exit
    if ( ! is_404() ) 
        return;

    global $wp_query, $wpdb;

    // Get the post from WP parsed request
    $posts = $wpdb->get_results($wp_query->request);    

    // if found post than FB crawler is visiting a scheduled post 
    if( $posts ) {
        global $post;
        $post = $posts[0];

        // Make Plugin Working
        $wp_query->queried_object = $post;
        $wp_query->queried_object_id = $post->ID;

        
        // Facebook can only get future post not draft and so on.
        if ( 'future' != $post->post_status ) {
            return;
        }

        // Set http header and WP variables for proper http responsive
        status_header( 200 );
        $wp_query->is_404 = false;
        $wp_query->is_single = true;
        $wp_query->is_singular = true;

        // Fix future post permalink only show ?p=xxx issue
        $permalink = '';
        $post->post_status = 'publish'; // set the post status to publish to get the 'publish' permalink
        $permalink = get_permalink( $post );

        setup_postdata( $post );
        echo '<!DOCTYPE html><html xmlns="http://www.w3.org/1999/xhtml" lang="zh-TW" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                echo '<title>' . get_the_title() . '</title>';
                $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
                echo '<meta property="og:image" content="' . $thumb['0'] . '" />';
                echo '<meta property="og:url" content="' . $permalink . '" />';
                echo '<meta property="og:title" content="' . get_the_title() . '" />';
                echo '<meta property="og:description" content="' . get_the_excerpt() . '" />';
                echo '<meta property="og:type" content="article" />';
                echo '<meta property="og:locale" content="zh_TW" />';
                echo '<meta property="og:site_name" content="' . get_bloginfo( 'name' ) . '" />';
                echo '<meta property="article:author" content="' . get_bloginfo( 'url' ) . '/author/' . get_the_author_meta( 'user_login' ) . '" />';
                wp_head();
                echo '</head><body></body></html>';

        die();
    }
}
add_action('wp', 'add_og_for_fb');

/**
 * 將 ACF 的延伸商品資訊儲存進商品的 post meta
 *
 */
function save_post_relative_goods( $post_id ) {
    // 取得文章關聯的商品 ids
    $goods_ids = get_field('relative_goods');

    foreach ( $goods_ids as $id ) {
        // 取得商品的關聯文章清單
        $r = get_post_meta( $id, 'relative_post', true );
        if ( $r && 'null' != $r ) {
            $r = json_decode( $r );
        } else {
            $r = array();
        }
        
        // 避免重複加入文章
        if ( ! in_array( $post_id, $r ) ) {
            // 將文章加入關聯
            array_push( $r, $post_id );
        }
        
        $s = json_encode( $r );
        update_post_meta( $id, 'relative_post', $s );
    }
}
add_action( 'acf/save_post', 'save_post_relative_goods', 20 );

/**
 * 新增 FLiPER 專用角色與權限，只在 plugin activation 時執行
 *
 * @package FLiPERMAG
 *
 * @return none
 */
function fp_role() {

    // 移除部分 WordPress 預設角色
    remove_role( 'subscriber' );
    remove_role( 'contributor' );
    remove_role( 'author' );

    remove_role( 'fliper_creator' );

    // 新增讀者帳號
    remove_role( 'reader' ); // 若 reader 角色已經存在，直接執行 add_role 將會導致 WordPress 錯誤，因此加上 remove_role 防止錯誤
    $result = add_role(
        'reader',
        '讀者',
        array(
            'read' => true,
            'search' => true,
            'comment' => true,
            'message' => true,
            'favorite' => true,
            'follow' => true,
            'hashtag' => true,
            'report' => true,
            'edit_posts' => false,
            'delete_posts' => false,
            'upload_files' => true,
            'gallery' => false,
            'backstage' => false,
            'analysis' => false,
            'customer_service' => false,
            'edit_fliper_artworks' => true
        )
    );

    // 新增作者帳號
    remove_role( 'writer' );
    $result = add_role(
        'writer',
        '作者',
        array(
            'read' => true,
            'search' => true,
            'comment' => true,
            'message' => true,
            'favorite' => true,
            'follow' => true,
            'hashtag' => true,
            'report' => true,
            'read_post' => true,
            'edit_posts' => true,
            'delete_posts' => true,
            'upload_files' => true,
            'gallery' => true,
            'backstage' => true,
            'analysis' => true,
            'customer_service' => false,
            'edit_fliper_artworks' => true
        )
    );

    // 新增編輯權限
    $role = get_role( 'editor' );
    $role->add_cap( 'list_users' );
    $role->add_cap( 'edit_users' );
    $role->add_cap( 'create_users' );
    $role->add_cap( 'edit_others_fliper_artworks' );
    $role->add_cap( 'publish_fliper_artworks' );
    $role->add_cap('edit_published_fliper_artworks');
    $role->add_cap('delete_fliper_artworks');
    $role->add_cap('delete_others_fliper_artworks');
    $role->add_cap('delete_published_fliper_artworks');

    // 新增管理者權限
    $role = get_role( 'administrator' );
    $role->add_cap( 'edit_others_fliper_artworks' );
    $role->add_cap( 'publish_fliper_artworks' );
    $role->add_cap('edit_published_fliper_artworks');
    $role->add_cap('delete_fliper_artworks');
    $role->add_cap('delete_others_fliper_artworks');
    $role->add_cap('delete_published_fliper_artworks');
}
register_activation_hook( __FILE__, 'fp_role' );
// add_action('init', 'fp_role');

function fp_get_paid_user_start_time( $user_id ) { return ''; }
function fp_set_paid_user_start_time( $user_id, $paid_start_time ) { return false; }
function fp_get_paid_user_end_time( $user_id ) { return ''; }
function fp_set_paid_user_end_time( $user_id, $paid_end_time ) { return false; }
function fp_get_paid_user_paid_times( $user_id ) { return 0; }
function fp_set_paid_user_paid_times( $user_id, $paid_times ) { return false; }
function fp_get_paid_user_post_stock( $user_id ) { return 0; }
function fp_get_paid_user_post_count( $user_id ) { return 0; }
function fp_get_paid_user_remain_post_count( $user_id ) { return 0; }

function fp_is_reader( $user_id ) {
    $user_info = get_userdata( $user_id );
    if ( $user_info ) {
        $role = implode( ', ', $user_info->roles );
        return 'reader' === $role ? true : false;
    }
    return false;
}

function fp_is_paid_user( $user_id ) { return false; }

// 判斷他是否有寫作的權限
function fp_can_write( $user_id ){
    $user_info = get_userdata( $user_id );
    $role = implode( ', ', $user_info->roles );
    switch ( $role ) {
        case 'editor':
        case 'writer':
            return true;
            break;
    }
    return false;
}

function fp_get_profile_cover_url( $user_id ) {
    $url = get_user_meta( $user_id, 'fp_profile_cover_url', true );
    if ( '' === $url )
        $url = get_theme_root_uri() . '/braxton-child/images/bg_profile_cover_default.png';

    return $url;
}

function fp_save_profile_cover_url( $user_id, $url ) {
    update_user_meta( $user_id, 'fp_profile_cover_url', $url );
}

function fp_get_user_facebook_link( $user_id ) {
    $userdata = get_userdata( $user_id ); 
    if ( strpos( $userdata->facebook, 'https://www.facebook.com' ) !== false || strpos( $userdata->facebook, 'http://www.facebook.com' ) !== false ) {
        return $userdata->facebook;
    } else {
        return 'https://www.facebook.com/' . $userdata->facebook;
    }
}

function fp_get_user_instagram_link( $user_id ) {
    $userdata = get_userdata( $user_id ); 
    if ( strpos( $userdata->instagram, 'https://www.instagram.com/' ) !== false || strpos( $userdata->instagram, 'http://www.instagram.com/' ) !== false ) {
        return $userdata->instagram;
    } else {
        return 'https://www.instagram.com/' . $userdata->instagram;
    }
}

function fp_get_user_blog_link( $user_id ) {
    return get_the_author_meta( 'blog', $user_id );
}

function fp_get_user_website_link( $user_id ) {
    return get_the_author_meta( 'url', $user_id );
}

/**
 * 控制後台「媒體」，只顯示自己上傳的圖片
 * 編輯以上得使用者不受此影響
 *
 * @return none
 */
function fp_restrict_media_library( $wp_query ) {

    global $current_user, $pagenow;

    if ( 'upload.php' != $pagenow && ( 'admin-ajax.php' != $pagenow || $_REQUEST[ 'action' ] != 'query-attachments' ) )
        return;

    if ( current_user_can( 'publish_pages' ) )
        return;

    $wp_query->set( 'author', $current_user->id );
    
}
add_filter( 'parse_query', 'fp_restrict_media_library' );

/**
 * 延長 WordPress cookie 過期時間
 *
 * @return int
 */
function fp_keep_me_logged_in_for_1_year( $expirein ) {
    return 31556926; // 1 year in seconds
}
add_filter( 'auth_cookie_expiration', 'fp_keep_me_logged_in_for_1_year' );

/**
 * 後台「迴響」只顯示自己的留言
 * 編輯以上的使用者不受此影響
 * 
 * @return void
 */
function fp_restrict_comments( $wp_comment_query ) {
    global $current_user, $pagenow;
    if ( 'edit-comments.php' != $pagenow )
        return;
    if ( current_user_can( 'publish_pages' ) )
        return;

    $wp_comment_query->query_vars[ 'post_author' ] = $current_user->id;
}
add_action( 'pre_get_comments', 'fp_restrict_comments' );

/**
 * 移除後台選單「工具」選單，只有編輯以上使用者才看得到
 *
 * @return none
 */
function fp_remove_tools() {
    if ( ! current_user_can( 'publish_pages' ) )
        remove_menu_page( 'tools.php' );
}
add_action( 'admin_menu', 'fp_remove_tools', 99 );

/**
 * 將 username 限制成只包含英文數字、底線與英文句點
 *
 * @return none
 */
function fp_username_restrict( $username, $raw_username, $strict ) {
    $username = preg_replace( '|[^a-z0-9_.]|i', '', $username );
    return $username;
}
add_filter( 'sanitize_user', 'fp_username_restrict', 5, 3 );

/**
 * 防止作家編輯或刪除排程的文章
 *
 * @return none
 */
function fp_prevent_contributor_edit_prending_post( $allcaps, $caps, $args ) {
    // an arry of action we want to prevent
    $prevent = array( 'edit_posts', 'delete_posts' );

    // we are not checking for edit a post, do nothing
    if ( ! array_intersect( $prevent, (array) $caps ) ) return $allcaps; 

    // we are not checking for a specific post, do nothing
    if ( ! isset( $args[2] ) || ! is_numeric( $args[2] ) ) return $allcaps;

    // the user has the capability to edit published posts, do nothing
    if ( array_key_exists( 'edit_published_posts', (array) $allcaps ) ) return $allcaps;

    // if the post is not a future one, do nothing
    if ( get_post_status( $args[2] ) !== 'future' ) return $allcaps;

    // if we are here we have to prevent user to edit or delete post
    if ( isset( $allcaps[ 'edit_posts' ] ) ) unset( $allcaps[ 'edit_posts' ] );
    if ( isset( $allcaps[ 'delete_posts' ] ) ) unset( $allcaps[ 'delete_posts' ] );
    return $allcaps;
}
add_filter( 'user_has_cap', 'fp_prevent_contributor_edit_prending_post', 9999, 3 );

/**
 * 當專欄文章審核通過排程發表時間時，使用 E-mail 通知專欄作家
 *
 * @return none
 */
function fp_on_schedule_pending_post( $post ) {
    // Check if this post is column article.
    if ( user_can( $post->post_author, 'publish_posts' ) )
        return '';

    // Send email to the columnist of posted article.
    $headers[] = 'From: "FLiPER 編輯部" <editor@flipermag.com>';
    $headers[] = 'Content-type: text/html';
    $mail_title = '您的文章 ' . $post->post_title . ' 已經排程於 ' . get_the_time( 'Y-m-d H:i:s', $post ) . ' 時發佈';
    $mail_content = get_the_author_meta( 'display_name', $post->post_author ) . ' 您好，</p>
        <p>您的專欄文章 ' . $post->post_title . ' 已排程於 ' . get_the_time( 'Y-m-d H:i:s', $post ) . ' 時發佈，對於文章內容有任何問題，請來信至 <a href="mailto:editor@flipermag.com" target="_blank">editor@flipermag.com</a> 洽詢 FLiPER 編輯。</p>
        <p>感謝您的支持與配合，謝謝。</p>
        <p>-----</p>
        <p><a href="' . site_url() . '" target="_blank">FLiPER</a></p>';

    wp_mail( get_the_author_meta( 'user_email', $post->post_author ), $mail_title, $mail_content, $headers);

}
add_action( 'pending_to_future',  'fp_on_schedule_pending_post', 10, 1 );

/**
 * 發佈專欄文章時，使用 E-mail 通知專欄作家
 *
 * @return none
 */
function fp_on_publish_post( $post ) {

    // Check if this post is column article.
    if ( user_can( $post->post_author, 'publish_posts' ) )
        return '';

    // Send email to the columnist of posted article.
    $headers[] = 'From: "FLiPER 編輯部" <editor@flipermag.com>';
    $headers[] = 'Content-type: text/html';
    $mail_title = '您的文章 ' . $post->post_title . ' 已經發佈';
    $mail_content = get_the_author_meta( 'display_name', $post->post_author ) . ' 您好，</p>
        <p>您的專欄文章<a href="' . get_permalink( $post->ID ) . '" target="_blank">' . $post->post_title . '</a>已於 ' . get_the_time( 'Y-m-d H:i:s' ) . ' 時發佈，對於文章內容有任何問題，請來信至 <a href="mailto:editor@flipermag.com" target="_blank">editor@flipermag.com</a> 洽詢 FLiPER 編輯。</p>
        <p>感謝您的支持與配合，謝謝。</p>
        <p>-----</p>
        <p><a href="' . site_url() . '" target="_blank">FLiPER</a></p>';

    wp_mail( get_the_author_meta( 'user_email', $post->post_author ), $mail_title, $mail_content, $headers);

}
add_action(  'future_to_publish',  'fp_on_publish_post', 10, 1 );
add_action(  'pending_to_publish',  'fp_on_publish_post', 10, 1 );

/**
 * 在 WP 登入頁面 head 內加入客製化程式碼
 *
 * @return void
 */
function fp_wp_login_head() {
    return;
}
add_action('login_head', 'fp_wp_login_head');

/**
 * Add customize code into html head.
 *
 * @package FLiPERMAG
 *
 * @return void
 */
function fp_wp_head() {
    ?>

    <!-- Alougth Google does not parse this tag, but Bing still do it! -->
    <meta name="keywords" content="潮流,線上雜誌,藝文,藝術,流行,時尚,文化,fliper,設計,玩樂,新奇,創作,生活,觀點" />

    <!-- Add Facebook admin tags -->
    <meta property="fb:admins" content="100000022096774,1457631651,100000102357466" />
    <meta property="fb:app_id" content="<?php echo esc_attr( fliper_facebook_app_id() ); ?>" />
    <meta property="fb:pages" content="207682572590840" />
    
    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
    n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
    document,'script','https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '1769762313345891'); // Insert your pixel ID here.
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=1769762313345891&ev=PageView&noscript=1"
    /></noscript>
    <!-- DO NOT MODIFY -->
    <!-- End Facebook Pixel Code -->

    <?php
}
add_action('wp_head', 'fp_wp_head');

/**
 * 專欄作家編輯文章時，只顯示需要的 Metabox
 * 
 * @return void
 */
function fp_remove_edit_post_metaboxes_for_contributor() {
    // 只影響專欄作家（撰稿人員）或更低權限的使用者
    if ( ! current_user_can( 'edit_published_posts' ) ) {
        remove_meta_box( 'postcustom','post','normal' ); // 移除 Custom Fields Metabox
        remove_meta_box( 'postexcerpt','post','normal' ); // 移除 Excerpt Metabox
        remove_meta_box( 'revisionsdiv','post','normal' ); // 移除 Revisions Metabox
        remove_meta_box( 'trackbacksdiv','post','normal' ); // 移除 Trackback Metabox
        remove_meta_box( 'categorydiv', 'post', 'side' ); // 移除選取文章分類的 Metabox
        remove_meta_box( 'gn-genrediv', 'post', 'side' ); // 移除 Google Mews Genres 的 Metabox
        remove_meta_box( 'tagsdiv-gn-location-1', 'post', 'side' ); // 移除 Google Mews City 的 Metabox
        remove_meta_box( 'tagsdiv-gn-location-2', 'post', 'side' ); // 移除 Google Mews State/Province 的 Metabox
        remove_meta_box( 'tagsdiv-gn-location-3', 'post', 'side' ); // 移除 Google Mews Country 的 Metabox
        remove_meta_box( 'bj_lazy_load_skip_post', 'post', 'side' ); // 移除 Lazy Loading 的 Metabox
        remove_meta_box( 'wpseo_meta', 'post', 'normal' );
    }
}
add_action( 'add_meta_boxes', 'fp_remove_edit_post_metaboxes_for_contributor', 99999 );

/**
 * 專欄作家於後台文章列表內，只能看見自己的文章
 * 
 * @return void
 */
function fp_filter_admin_posts_for_author( $query ) {
    global $pagenow;
    if ( 'edit.php' != $pagenow || ! $query->is_admin )
        return $query;

    if ( ! current_user_can( 'manage_options' ) ) {
        global $user_ID;
        $query->set( 'author', $user_ID );
    }
    return $query;
}
add_action( 'pre_get_posts', 'fp_filter_admin_posts_for_author' );

/**
 * 不顯示讀者與專欄作家的 WP 管理選單
 *
 * @return none
 */

function fp_remove_admin_bar() {
    if ( ! current_user_can('delete_published_posts') ) {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'fp_remove_admin_bar');

/**
 * 隱藏編輯文章的內部功能
 *
 * @return none
 */
function fp_hide_funcionality_from_user() {
    if ( ! current_user_can( 'delete_published_posts' ) ) {
        echo '<style>a.button.cropThumbnailBox{display:none !important;}div.misc-pub-section.public-post-preview{display:none;}div.misc-pub-section.misc-pub-visibility{display:none;}</style>';
    }
}
add_action( 'admin_print_styles-post.php', 'fp_hide_funcionality_from_user');

function fp_review_add_menu_page() {
/*    add_menu_page( '評審評分', '評審評分', 'review_artwork', 'review_artwork', 'fp_review_show_menu_page' );
    add_action( 'admin_init', 'fp_review_init_list_table' );
}
add_action( 'admin_menu', 'fp_review_add_menu_page' );

function fp_review_init_list_table(){
    register_column_headers( 'toplevel_page_review_artwork', array(
        'titlem' => __( '標題', 'fliper_ghost' ),
        'reviewing' => __( '給予評分',  'fliper_ghost' ),
        'review' => __( '評分結果',  'fliper_ghost' )
    ) );

    add_action( 'manage_fliper_artwork_posts_custom_column' ,function( $column, $artwork_id ){        
        switch ( $column ) {
            case 'titlem' :
                echo '<a href="' . get_permalink( $artwork_id ) . '" target="_blank">' . get_the_title( $artwork_id ) . '</a>';
                break;
            case 'reviewing':
                echo '<input type="text" value="" data-id="' . $artwork_id . '" class="reviewing_grade" />';
                break;
            case 'review':
                echo get_post_meta( $artwork_id, 'the_void_of_22_gjun_grade', true );
                break;
        }
    }, 10, 2 );
*/}

function fp_review_show_menu_page() {
    if ( ! current_user_can( 'review_artwork' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    ?>

    <div class="wrap">
        <h2>The Void of 22 匠🌟獨具賞評審評分頁面</h2>
    
        <?php 
            $pagedm = isset( $_GET['paged'] ) ? $_GET['paged'] : 1;
            if ( ! class_exists( 'WP_Posts_List_Table' ) ) {
                require_once( ABSPATH . 'wp-admin/includes/class-wp-posts-list-table.php' );
            }
            global $current_screen, $post_type;
            $current_screen->post_type = 'fliper_artwork';
            $post_type = 'fliper_artwork';
            global $wp_query;
            $wp_query = new WP_Query( array(
                'post_type' => 'fliper_artwork',
                'post_status' => 'publish',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'artwork_related_event',
                        'field'    => 'slug',
                        'terms'    => 'pcschool-star-award-2021 ',
                    ),
                ),
                'posts_per_page' => 20,
                'paged' => $pagedm
            ) );

            $table = new WP_Posts_List_Table( array( 
                'screen' => get_current_screen()
            ) );
            
            $table->prepare_items();
            $table->display();
        ?>
    </div>

    <script>
        jQuery('document').ready(function(){
            jQuery('.reviewing_grade').on('keyup', function(e){
                var _this = jQuery(this);
                if (e.key === 'Enter' || e.keyCode === 13) {
                    jQuery.post('/wp-admin/admin-ajax.php?action=fp_review', {post_id: jQuery(this).attr('data-id'), grade: jQuery(this).val()}, function(response){
                        jQuery(_this).parent().parent().find('td.review').text(response.replace(/['"]+/g, ''));
                        jQuery(_this).val('');
                    });
                }            
            });
        });
    </script>

    <?php
}
