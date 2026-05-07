<?php 

$today = current_time('timestamp');

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

	<!--meta tag-->
	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="http://gmpg.org/xfn/11"/>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"/>
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri() . '/assets/images/favicon.png'; ?>" />

	<script type="text/javascript">
	// Define global variable for wp_is_mobile check.
	var is_mobile = '<?php echo wp_is_mobile(); ?>';
	var site_url = '<?php echo site_url(); ?>';
	var current_user_id = '<?php echo get_current_user_id(); ?>';

	<?php if ( is_single() ) : ?>
	var article_id = '<?php the_ID(); ?>';
	<?php endif; ?>
	</script>

	<?php wp_head(); ?>

</head><!--#header-->
<body <?php body_class(); ?>>

<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v3.3&appId=404071816353493&autoLogAppEvents=1"></script>

<div class="site-container">
	<div id="main-menu" class="main-menu-wrap row">
		<div>
			<a href="/" class="site-logo"></a>
			<div style="display: inline-block;vertical-align: top;margin-top: 16px;">
				<div class="hide-on-mobile">
					<h6 style="font: 700 14px/14px 'Roboto Slab';letter-spacing: 1.4px;color: #1A1A1A;margin-bottom:4px;"><?php echo date("Y", $today); ?></h6>
					<h6 style="font: 700 14px/14px 'Roboto Slab';letter-spacing: 1.4px;color: #1A1A1A;"><?php echo date('F d', $today); ?></h6>
				</div>
			</div>
		</div>
		<div id="desktop-user-menu">
			<?php wp_nav_menu( array(
				'theme_location' => 'flipermag_desktop_main_menu',
				'container'      => '',
				'menu_class'     => 'fp-2024-main-menu',
				'echo'           => true,
			) ); ?>

			<a href="#" class="search-icon iconset"></a>
			<form class="search-form" method="get" action="/"> 
				<input class="search-form-input" name="s" type="text" placeholder="SEARCH FLiPER" value="">
				<input type="submit" value=""> 
			</form>
			<?php if ( is_user_logged_in() ) : ?>
			<div class="profile-icon logged">
				<img style="width:100%;border-radius:22px;display:block;border:1px solid #1a1a1a;" src="<?php echo get_wp_user_avatar_src( get_current_user_id(), 'thumbnail'); ?>" />
				<div class="user-menu-wrap">
					<ul class="user-menu">
						<?php if ( user_can( get_current_user_id(), 'edit_posts' ) ) : ?>
						<li class="user-menu-item"><a href="<?php echo esc_url( home_url( '/article-manager/' ) ); ?>">文章管理</a></li>
						<li class="user-menu-item"><a href="<?php echo esc_url( get_author_posts_url( get_current_user_id() ) ); ?>">個人頁面</a></li>
						<?php endif; ?>
						<li class="user-menu-item"><a href="<?php echo esc_url( home_url( '/favorite/' ) ); ?>">我的書籤</a></li>
						<li class="user-menu-item"><a href="<?php echo esc_url( home_url( '/account/' ) ); ?>">帳號管理</a></li>
						<li class="user-menu-item"><a href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>">登出</a></li>
					</ul>
				</div>
			</div>
			<?php else : ?>
			<a href="#" class="profile-icon not-login iconset"></a>
			<?php endif; ?>
		</div>
		<div id="mobile-user-menu">
			<a href="#" class="search-icon iconset"></a>
			<form class="search-form" method="get" action="/"> 
				<input class="search-form-input" name="s" type="text" placeholder="SEARCH FLiPER" value="">
				<input type="submit" value=""> 
			</form>
			<?php if ( is_user_logged_in() ) : ?>
			<div class="profile-icon logged"><img style="width:100%;border-radius:22px;display:block;border:1px solid #1a1a1a;" src="<?php echo get_wp_user_avatar_src( get_current_user_id(), 'thumbnail'); ?>" /></div>
			<div class="user-menu-wrap">
				<ul class="user-menu">
					<?php if ( user_can( get_current_user_id(), 'edit_posts' ) ) : ?>
					<li class="user-menu-item"><a href="<?php echo esc_url( home_url( '/article-manager/' ) ); ?>">文章管理</a></li>
					<li class="user-menu-item"><a href="<?php echo esc_url( get_author_posts_url( get_current_user_id() ) ); ?>">個人頁面</a></li>
					<?php endif; ?>
					<li class="user-menu-item"><a href="<?php echo esc_url( home_url( '/favorite/' ) ); ?>">我的書籤</a></li>
					<li class="user-menu-item"><a href="<?php echo esc_url( home_url( '/account/' ) ); ?>">帳號管理</a></li>
					<li class="user-menu-item"><a href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>">登出</a></li>
				</ul>
			</div>
			<?php else : ?>
			<a href="#" class="profile-icon not-login iconset"></a>
			<?php endif; ?>

			<a herf="#" class="nav-icon iconset"></a>
			<div class="mobile-main-menu-inner">
				<?php wp_nav_menu( array(
					'theme_location' => 'flipermag_desktop_main_menu',
					'container'      => '',
					'menu_class'     => 'fp-2024-main-menu',
					'echo'           => true,
				) ); ?>
			</div>
		</div>
	</div>
	<div id="main-container">
	
