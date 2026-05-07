<?php
/**
 * FLiPER 客製 WP 後台的 class
 * 
 * Version: 1.0.0
 * Author: Rasiel-FLiPER
 * Author URI: https://github.com/rasielchang
 */


/**
 * FLiPER 客製 WP 後台的 class
 *
 * @author 		Rasiel-FLiPER
 * @package 	FLiPER
 * @version		1.0.0
 */
class FLiPER_Admin {

	public function __construct() {

		// 設定 class 變數，由於不知為何不能在 parse_query action 內使用 WP_Query，因此預先於 wp_loaded action 內抓出 parse_query action 所需要的變數
		add_action( 'wp_loaded', array( $this, 'pre_get_query' ) );

		// 新增用來篩選文章的變數
		add_filter( 'parse_query', array( $this, 'posts_filter' ) );

		// 於編輯文章頁面新增作者資訊區塊
		add_action( 'add_meta_boxes', array( $this, 'add_author_extra_info_on_edit_post_page' ) );

		// 控制編輯個人資料內的外站連結
		add_filter( 'user_contactmethods', array( $this, 'hide_instant_messaging' ), 999, 1 );

		// 在編輯個人資料頁面內新增欄位，只有編輯以上的使用者才可以看見這些欄位
		add_action( 'show_user_profile', array( $this, 'custom_profile_fields' ) );
		add_action( 'edit_user_profile', array( $this, 'custom_profile_fields' ) );

		// 儲存編輯個人資料頁面的客製化欄位
 	 	add_action( 'personal_options_update', array( $this, 'save_custom_profile_fields' ) );
		add_action( 'edit_user_profile_update', array( $this, 'save_custom_profile_fields' ) );

		// 控制後台首頁顯示 widgets
		add_action( 'wp_dashboard_setup', array( $this, 'dashboard_widgets' ) );

		// 客製化 WP 使用者列表頁面
		add_filter( 'manage_users_columns', array( $this, 'custom_user_columns' ), 15, 1 );
		add_action( 'manage_users_custom_column', array( $this, 'custom_user_columns_data' ), 15, 3 );

		// 客製化 WP 使用者列表頁面，審核中作者的顯示順序
		add_filter( 'pre_user_query', array( $this, 'admin_users_filter' ) );

	}

	// 設定 class 變數，由於不知為何不能在 parse_query action 內使用 WP_Query，因此預先於 wp_loaded action 內抓出 parse_query action 所需要的變數
	public function pre_get_query() {

		global $pagenow;
		$type = 'post';
    	if ( isset( $_GET[ 'post_type' ] ) ) {

        	$type = $_GET[ 'post_type' ];

    	}

	}

	/**
 	 * 新增用來篩選文章的變數
	 */
	public function posts_filter( $query ) {

    	global $pagenow;
    	$type = 'post';
    	if ( isset( $_GET[ 'post_type' ] ) ) {

        	$type = $_GET[ 'post_type' ];

    	}

	}

	// 於編輯文章頁面新增作者資訊區塊
	public function add_author_extra_info_on_edit_post_page() {

		// 於編輯文章頁面新增作者資訊區塊
		add_meta_box( 'author_extra_info' , __( '作者其他資訊', 'flipermag' ) , array( $this, 'get_author_extra_info_on_edit_post_page' ), 'post', 'normal' );

	}

	// 取得作者資訊區塊的 html
	public function get_author_extra_info_on_edit_post_page() {

		global $post;

		?>

		<p>作者信箱：<a href="mailto:<?php echo get_the_author_meta( 'user_email', $post->post_author ); ?>" target="_blank"><?php echo get_the_author_meta( 'user_email', $post->post_author ); ?></a></p>

		<?php if ( '' != get_the_author_meta( 'facebook' ) ): ?>

		<p>作者 Facebook 頁面：<a href="<?php echo get_the_author_meta( 'facebook', $post->post_author ); ?>" target="_blank"><?php echo get_the_author_meta( 'facebook', $post->post_author ); ?></a></p>

		<?php else: ?>

		<p>作者 Facebook 頁面：未填寫</p>

		<?php endif; ?>

		<?php 

	}

	/**
 	 * 控制後台首頁顯示 widgets
 	 * 
 	 * @package FLiPERMAG
 	 *	
 	 * @return void
 	 */
	public function dashboard_widgets() {

		global $current_user;
		get_currentuserinfo();

		if ( ! current_user_can( 'publish_pages' ) ) {

			remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
		    remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
		    remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
    		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
		    remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
    		remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');//since 3.8

		}
    
	    // WordPress 內建 widget
    	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	    remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
    	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );

	    // plugin SEO Ultimate 產生的 widget
    	remove_meta_box( 'sdf_dashboard_widget', 'dashboard', 'normal');

    	// WPEngine 產生的 widget
    	remove_meta_box( 'wpe_dify_news_feed', 'dashboard', 'normal');
    
		// 帳號等級 widget
		wp_add_dashboard_widget( 'fp_dashboard_user_role', '你好，' . $current_user->user_login, array( $this, 'dashboard_user_role_widget' ) );

	}

	/**
 	 * 新增 dashboard 帳號等級 widget
 	 * 
 	 * @package FLiPER
 	 *	
 	 * @return void
 	 */
	public function dashboard_user_role_widget() {

		global $wp_roles;

		$user_info = get_userdata( get_current_user_id() );
		$role = implode( ', ', $user_info->roles );
		$role = isset( $wp_roles->role_names[ $role ] ) ? translate_user_role( $wp_roles->role_names[ $role ] ) : '帳號等級錯誤，請聯繫服務人員';
	
		?>

		<div class="user-role">
			<div style="float:left;margin-right:4px;">帳號等級：<span style="color:#39308e;"><?php echo $role; ?></span></div>

		</div>

		<br class="clear" />

		<?php

	}

	/**
	 * 控制編輯個人資料內的外站連結
 	 *
 	 * @package FLiPER
 	 *
 	 * @return $contactmethods
 	 */
	public function hide_instant_messaging( $contactmethods ) {

		$contactmethods['facebook'] = __( 'Facebook 粉絲團', 'fliper' );
		$contactmethods['instagram'] = __( 'Instagram 帳號', 'fliper' );
		$contactmethods['blog'] = __( 'Blog 網址', 'fliper' ); 
		unset($contactmethods['aim']);
		unset($contactmethods['yim']);
		unset($contactmethods['jabber']);
		unset($contactmethods['googleplus']);
		unset($contactmethods['twitter']);
		unset($contactmethods['pinterest']);
		unset($contactmethods['linkedin']);

		return $contactmethods;

	}

	/**
 	 * 在編輯個人資料頁面內新增欄位
 	 *
 	 * @package FLiPERMAG
 	 *
 	 * @return void
 	 */
	public function custom_profile_fields( $user ) {

		wp_enqueue_media();

		$user_real_name = get_user_meta( $user->ID, 'user_real_name', true );
		$user_phone = get_user_meta( $user->ID, 'user_phone', true );
		$user_job = get_user_meta( $user->ID, 'user_job', true );
		$user_address = get_user_meta( $user->ID, 'user_address', true );

		?>

		<h3>個人資訊</h3>
		<table class="form-table">
			<tr>
				<th><label for="user-real-name">真實姓名</label></th>
    			<td>
					<input type="text" name="user_real_name" id="user-real-name" value="<?php echo esc_attr( $user_real_name ); ?>" class="regular-text" />
				</td>
			</tr>
			<tr>
				<th><label for="user-phone">手機號碼</label></th>
				<td>
					<input type="text" name="user_phone" id="user-phone" value="<?php echo esc_attr( $user_phone ); ?>" class="regular-text" />
				</td>
			</tr>
			<tr>
				<th><label for="user-job">目前職業</label></th>
				<td>
					<input type="text" name="user_job" id="user-job" value="<?php echo esc_attr( $user_job ); ?>" class="regular-text" />
				</td>
			</tr>
			<tr>
				<th><label for="user-address">現居住地</label></th>
				<td>
					<input type="text" name="user_address" id="user-address" value="<?php echo esc_attr( $user_address ); ?>" class="regular-text" />
				</td>
			</tr>
		</table>

		<table class="form-table">
			<tr>
				<th><label for="fp-profile-cover-url">封面照片</label></th>
    			<td>
					<img id="fp-profile-cover-image" src="<?php echo esc_attr( fp_get_profile_cover_url( $user->ID ) ); ?>" />
					<input type="hidden" id="fp-profile-cover-image-url" name="fp_profile_cover_image_url" value="<?php echo esc_attr( fp_get_profile_cover_url( $user->ID ) ); ?>" />
					<p>
            			<button id="choose-fp-profile-cover-image" class="button">上傳照片</button>
            			<span class="description">照片尺寸需大於 1040 X 328</span>
        			</p>
				</td>
			</tr>
		</table>

		<script type="text/javascript">
		jQuery(document).ready(function(){
			$ = jQuery;
			var frame;
			$('#choose-fp-profile-cover-image').click(function(event){
				event.preventDefault();
				if ( frame ) {
      				frame.open();
      				return;
    			}

				frame = wp.media({
					title:'上傳封面圖片',
      				multiple: false
    			});

    			frame.on( 'select', function() {
					var selectionCollection = frame.state().get('selection');
					if ( selectionCollection.models[0].attributes.width < 1040 || selectionCollection.models[0].attributes.height < 328 ) {
						alert('照片尺寸需大於 1040 X 328');
					} else if ( selectionCollection.models[0].attributes.width == 1040 && selectionCollection.models[0].attributes.height == 328 ) {
						var url = selectionCollection.models[0].attributes.url;
						$('#fp-profile-cover-image').attr( 'src', url );
						$('#fp-profile-cover-image-url').val(url);
					} else {
						var url = selectionCollection.models[0].attributes.url;
						var ext = url.substr(url.lastIndexOf('.') + 1);
						url = url.substr(0, url.lastIndexOf('.'));
						url = url + '-1040x328.' + ext;
						$('#fp-profile-cover-image').attr( 'src', url );
						$('#fp-profile-cover-image-url').val(url);
					}
				} );
            	
    			frame.open();
    		});    		
		});
		</script>

		<?php 

		// 只有編輯以上的使用者才可以看見以下欄位
		if ( ! current_user_can( 'publish_pages' ) ) 
			return '';

		?>
		<?php
	
	}

	/**
 	 * 儲存編輯個人資料頁面的客製化欄位
 	 *
 	 * @package FLiPERMAG
 	 *
 	 * @return void
 	 */
	public function save_custom_profile_fields( $user_id ) {
		update_user_meta( $user_id, 'user_real_name', $_POST[ 'user_real_name' ] );
		update_user_meta( $user_id, 'user_phone', $_POST[ 'user_phone' ] );
		update_user_meta( $user_id, 'user_job', $_POST[ 'user_job' ] );
		update_user_meta( $user_id, 'user_address', $_POST[ 'user_address' ] );
		fp_save_profile_cover_url( $user_id, $_POST[ 'fp_profile_cover_image_url' ] );
 
		if ( ! current_user_can( 'edit_user', $user_id ) )
			return false;
		
		return true;
	}

	/**
 	 * 客製化 WP 使用者列表頁面
 	 *
 	 * @package FLiPER
 	 * @return void
 	 */
	function custom_user_columns( $defaults ) {
    	return $defaults;
	}

	/**
 	 * 客製化 WP 使用者列表頁面
 	 *
 	 * @package FLiPER
 	 * @return void
 	 */
	function custom_user_columns_data( $value, $column_name, $id ) {
		return $value;
    }

    /**
 	 * 客製化 WP 使用者列表頁面，審核中作者的顯示順序
 	 *
 	 * @package FLiPER
 	 * @return void
 	 */
    function admin_users_filter( $query ){
		global $pagenow, $wp_query;

		return;
	}
	
}

$GLOBALS[ 'FLiPER_Admin' ] = new FLiPER_Admin();
