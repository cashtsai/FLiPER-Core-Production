<?php

if ( ! isset( $content_width ) ) {
	$content_width = 750;
}

// Add full page thumbnail size
if ( function_exists( 'add_theme_support' ) ) {
	add_image_size( 'post-thumb', 900, 500, true );
	add_image_size( 'home-slider-2x', 552, 352, true );
	add_image_size( 'home-top-big-2x', 900, 640, true );
	add_image_size( 'home-top-small-2x', 490, 370, true );
	add_image_size( 'list-articles-thumb-2x', 720, 458, true );
	add_image_size( 'full-post-thumb', 1000, 400, true );
	add_image_size( 'xl-post-thumb', 1080, 648, true );
	add_image_size( 'l-post-thumb', 750, 450, true );
	add_image_size( 'm-post-thumb', 640, 384, true );
	add_image_size( 's-post-thumb', 320, 192, true );
	add_image_size( 'xs-post-thumb', 160, 96, true );
	add_image_size( 'user-avatar', 300, 300, true );
	add_image_size( 'issue-cover', 890, 350, true );
	add_image_size( 'artwork-thumbnail', 600, 0, false );
	add_theme_support('post-formats', array('video') );
}

function flipermag_theme_setup() {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
	// add_theme_support( 'post-formats', array( 'gallery', 'video', 'audio' ) );

	register_nav_menu( 'flipermag_desktop_main_menu', esc_html__( 'Main Menu', 'flipermag' ) );
	register_nav_menu( 'flipermag_desktop_footer_menu', esc_html__( 'Footer Menu', 'flipermag' ) );
}
add_action( 'after_setup_theme', 'flipermag_theme_setup' );


function flipermag_register_scripts() {
	wp_enqueue_style( 'flipermag_style', get_stylesheet_uri(), array(), filemtime( get_stylesheet_directory() . '/style.css' ) );
	wp_enqueue_style( 'fullpage', get_stylesheet_directory_uri() . '/assets/css/fullpage.css', array(), filemtime( get_stylesheet_directory() . '/assets/css/fullpage.css') );

	wp_enqueue_script( 'jquery.timeago', get_stylesheet_directory_uri() . '/assets/js/jquery.timeago.js', array( 'jquery' ), '0.75', true );
	wp_enqueue_script( 'flipermag_script', get_stylesheet_directory_uri() . '/assets/js/scripts.js', array('jquery', 'jquery.timeago'), filemtime( get_stylesheet_directory() . '/assets/js/scripts.js' ), true );
	wp_localize_script( 'flipermag_script', 'FLIPER_THEME_CONFIG', array(
		'legacyApiToken' => defined( 'FLIPER_LEGACY_API_TOKEN' ) ? FLIPER_LEGACY_API_TOKEN : '',
	) );
	wp_enqueue_script( 'flipermag_comment_script', get_stylesheet_directory_uri() . '/assets/js/comment.js', array('flipermag_script'), filemtime( get_stylesheet_directory() . '/assets/js/comment.js' ), true );
	wp_enqueue_script( 'fullpage', get_stylesheet_directory_uri() . '/assets/js/fullpage.min.js', array('jquery'), filemtime( get_stylesheet_directory() . '/assets/js/fullpage.min.js' ), true );
	wp_enqueue_script( 'fullpage-extenstions', get_stylesheet_directory_uri() . '/assets/js/fullpage.extensions.min.js', array('fullpage'), filemtime( get_stylesheet_directory() . '/assets/js/fullpage.extensions.min.js' ), true );
	wp_enqueue_script( 'masonry', get_stylesheet_directory_uri() . '/assets/js/masonry.pkgd.min.js', array('jquery'), filemtime( get_stylesheet_directory() . '/assets/js/masonry.pkgd.min.js' ), true );

	if ( ! is_user_logged_in() ) {
		wp_enqueue_script( 'flipermag_login_script', get_stylesheet_directory_uri() . '/assets/js/login.js', array( 'jquery' ), filemtime( get_stylesheet_directory() . '/assets/js/login.js' ), true );
	}
}
if ( ! is_admin() ) {
	add_action( 'wp_enqueue_scripts', 'flipermag_register_scripts' );
}

function flipermag_wp_head() {
	?>

	<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400,600,700|Noto+Serif|EB+Garamond|Zilla+Slab" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
	<script type="text/javascript">var _jf = _jf || [];_jf.push(['p','56202']);_jf.push(['initAction',true]);_jf.push(['_setFont','notoserifcjktc_extralight','css','.notoserifcjktc_extralight']);_jf.push(['_setFont','notoserifcjktc_extralight','alias','notoserifcjktc']);_jf.push(['_setFont','notoserifcjktc_extralight','weight',100]);_jf.push(['_setFont','notoserifcjktc_light','css','.notoserifcjktc_light']);_jf.push(['_setFont','notoserifcjktc_light','alias','notoserifcjktc']);_jf.push(['_setFont','notoserifcjktc_light','weight',200]);_jf.push(['_setFont','notoserifcjktc_regular','css','.notoserifcjktc_regular']);_jf.push(['_setFont','notoserifcjktc_regular','alias','notoserifcjktc']);_jf.push(['_setFont','notoserifcjktc_regular','weight',300]);_jf.push(['_setFont','notoserifcjktc_medium','css','.notoserifcjktc_medium']);_jf.push(['_setFont','notoserifcjktc_medium','alias','notoserifcjktc']);_jf.push(['_setFont','notoserifcjktc_medium','weight',400]);_jf.push(['_setFont','notoserifcjktc_semibold','css','.notoserifcjktc_semibold']);_jf.push(['_setFont','notoserifcjktc_semibold','alias','notoserifcjktc']);_jf.push(['_setFont','notoserifcjktc_semibold','weight',600]);_jf.push(['_setFont','notoserifcjktc_bold','css','.notoserifcjktc_bold']);_jf.push(['_setFont','notoserifcjktc_bold','alias','notoserifcjktc']);_jf.push(['_setFont','notoserifcjktc_bold','weight',700]);(function(A,p,c,m,l,q,r,h,B,D){var b=A._jf;if(b.constructor!==Object){var t=!0,u=function(a){var f=!0,e;for(e in b)b[e][0]==a&&(f&&(f=f&&!1!==b[e][1].call(b)),b[e]=null,delete b[e])},v=/\S+/g,w=/[\t\r\n\f]/g,C=/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,n="".trim,x=n&&!n.call("\ufeff\u00a0")?function(a){return null==a?"":n.call(a)}:function(a){return null==a?"":(a+"").replace(C,"")},k=function(a){var f,b,g;if("string"===typeof a&&a&&(a=(a||"").match(v)||[],f=h[c]?(" "+h[c]+" ").replace(w," "):" ")){for(g=0;b=a[g++];)0>f.indexOf(" "+b+" ")&&(f+=b+" ");h[c]=x(f)}},d=function(a){var b,e,g;if(0===arguments.length||"string"===typeof a&&a){var d=(a||"").match(v)||[];if(b=h[c]?(" "+h[c]+" ").replace(w," "):""){for(g=0;e=d[g++];)for(;0<=b.indexOf(" "+e+" ");)b=b.replace(" "+e+" "," ");h[c]=a?x(b):""}}},y;b.addScript=y=function(b,f,e,g,d,c){d=d||function(){};c=c||function(){};var a=p.createElement("script"),h=p.getElementsByTagName("script")[0],k,m=!1,l=function(){a.src="";a.parentNode.removeChild(a);a=a.onerror=a.onload=a.onreadystatechange=null};g&&(k=setTimeout(function(){l();c()},g));a.type=f||"text/javascript";a.async=e;a.onload=a.onreadystatechange=function(b,c){m||a.readyState&&!/loaded|complete/.test(a.readyState)||(m=!0,g&&clearTimeout(k),l(),c||d())};a.onerror=function(a,b,d){g&&clearTimeout(k);l();c();return!0};a.src=b;h.parentNode.insertBefore(a,h)};for(var z in b)"initAction"==b[z][0]&&(t=b[z][1]);b.push(["_eventPreload",function(){1==t&&k(m);y(B,null,!1,3E3,null,function(){u("_eventInactived")})}]);b.push(["_eventReload",function(){d(r);d(q);k(l)}]);b.push(["_eventActived",function(){d(m);d(l);k(q)}]);b.push(["_eventInactived",function(){d(m);d(l);k(r)}]);u("_eventPreload")}})(this,this.document,"className","jf-loading","jf-reloading","jf-active","jf-inactive",this.document.getElementsByTagName("html")[0],"//d3gc6cgx8oosp4.cloudfront.net/js/stable/v/5.0.7/id/255049906119");</script>

	<?php
}
add_action( 'wp_head', 'flipermag_wp_head' );

function flipermag_wp_footer() {
	if ( ! is_user_logged_in() ) {
		get_template_part( 'parts/login' );
	}
}
add_action( 'wp_footer', 'flipermag_wp_footer' );

/**
 * 抓取相關文章，依照文章分類與 tag 抓取
 *
 */
function get_category_related_posts( $post_id, $category_id, $count = 3 ) {
	$args = array(
    	'post__not_in' => array( $post_id ),
        'posts_per_page' => $count, // Number of related posts that will be shown.
	    'ignore_sticky_posts' => 1,
    	'category__in' => array( $category_id )
    );	
	
	$tags = wp_get_post_tags( $post_id );
    if ( $tags ) {
        $tag_ids = array();
        foreach ( $tags as $individual_tag ) {
        	$tag_ids[] = $individual_tag->term_id;
        }
        $args[ 'tag__in' ] = $tag_ids;
    } 

    $related_posts = new WP_Query( $args );
    if ( $related_posts->have_posts() ) {
    	return $related_posts;
    }

    return false;
}

/**
 * 取得分類英文與中文名稱（需於後台設定分類說明）
 *
 */
function fp_get_category_name( $category_id ) {
	$category = get_category( $category_id );
	if ( ! $category || is_wp_error( $category ) ) {
		return '';
	}

	return $category->name . '｜' . $category->description;
}

/**
 * Custom excerpt
 * 
 */
function fp_custom_excerpt_more( $more ) {
	return ' ......';
}
add_filter('excerpt_more', 'fp_custom_excerpt_more' );

/**
 * 首頁加入 og:image
 * 
 */
add_filter( 'fb_meta_tags', function( $meta_tags, $post ) {
	if ( '12958' == get_the_ID() ) {
		$meta_tags['og:image'] = get_stylesheet_directory_uri() . '/assets/images/homepage_og.png';
		$meta_tags['og:image:width'] = '1200';
		$meta_tags['og:image:height'] = '630';
	}

	return $meta_tags;
}, 10, 2 );

/**
 * 檢查是否為限制級內容
 *
**/
function block_18_years_old() {
	if ( ! is_single() or ! has_tag('xxx') ) return;
	if ( $_COOKIE['block18'] != null ) return;

	?>
	<style>
	#block-18-masker {
		width:100%;
		height:100%;
		position:fixed;
		left:0;
		top:0;
		background:#fff;
		opacity:0.7;
		filter:alpha(opacity=70);
		z-index:9999;
	}
	#block-18 {
		background:#ebebeb;
		position:fixed;
		z-index:10000;
		padding: 42px 80px;
    	box-sizing: border-box;
    	width: 540px;
    	height: 372px;
    	border: 1px solid #1a1a1a;
    	border-radius: 4px;
    	box-shadow: 1px 1px 6px rgba(0,0,0,0.18);
	}
	#block-18 h2 {
	    text-align: center;
	    line-height: 40px;
	    margin-bottom: 48px;
	    font-family: "Roboto Slab";
	    font-weight: bold;
	    font-size: 30px;
	    letter-spacing: 3px;
	}
	#block-18 h3 {
	    width: 380px;
	    padding: 0px 32px;
	    line-height: 24px;
	    margin-bottom: 12px;
	    font-size: 14px;
	    box-sizing: border-box;
	    font-family: Noto Sans TC;
	    color: #1a1a1a;
	    font-weight: 500;
	}
	#block-18 p {
	    width: 380px;
	    padding: 0px 32px;
	    line-height: 24px;
	    margin-bottom: 12px;
	    font-size: 14px;
	    font-family: Noto Sans TC;
	    font-weight: 300;
	    font-weight: 350;
	    color: #8c8c8c;
	    box-sizing: border-box;
	    text-align: justify;
	    margin-bottom: 60px;
	}
	#block-18-yes {
		width: 80px;
		height: 30px;
		bottom: 42px;
		cursor: pointer;
		float: right;
		color: #1f7ba1;
		border-bottom: 2px solid #1f7ba1;
		font-weight: bold;
		font-size: 16px;
		line-height: 30px;
		letter-spacing: 1.6px;
		font-family: Noto Sans TC;
		text-align: center;
	}
	#block-18-yes:hover {
		color: #8ab8bf;
    	border-color: #8ab8bf;
	}
	#block-18-no {
		width: 80px;
	    height: 30px;
	    bottom: 42px;
	    cursor: pointer;
	    float: left;
	    color: #f84555;
	    border-bottom: 2px solid #f84555;
	    font-weight: bold;
	    font-size: 16px;
	    line-height: 30px;
	    letter-spacing: 1.6px;
	    font-family: Noto Sans TC;
	    text-align: center;
	}
	#block-18-no:hover {
		color: #ef95a4;
    	border-color: #ef95a4;
	}

	@media screen and (max-width: 1099px) {
		#block-18 {
		    left: 50% !important;
		    top: 0px !important;
		    width: 320px;
		    height: 100%;
		    margin-left: -160px;
		    border: none;
		    box-shadow: none;
		    padding: 30px 48px;
			position:fixed;
		}

		#block-18-masker {
		    background: #ebebeb;
		    opacity: 1;
		    filter: alpha(opacity=100);
		}

		#block-18 h2 {
		    margin-bottom: 32px;
		    font-size: 22px;
		    line-height: 32px;
		    letter-spacing: 2.2px;
		}

		#block-18 h3 {
		    width: 224px;
		    padding: 0px 12px;
		    margin-bottom: 16px;
		}

		#block-18 p {
		    margin-bottom: 80px;
		    width: 224px;
		    padding: 0px 12px;
		}
	}
	</style>
	<div id="block-18-masker"></div>
	<div id="block-18">
		<h2>ADULTS ONLY</h2>
		<h3>依電腦網路內容分級法，本區未滿 18 歲不得瀏覽</h3>
		<p>限定為年滿 18 歲已具有完整行為能力且願意接受本網站內影音內容及各項條款之網友才可瀏覽，未滿 18 歲謝絕進入。</p>
		<div id="block-18-no">未滿18歲</div>
		<div id="block-18-yes">已滿18歲</div>
	</div>
	<script>
		var e = jQuery('#block-18');
		e.css("top", Math.max(0, ((jQuery(window).height() - e.outerHeight()) / 2) ) + "px");
    	e.css("left", Math.max(0, ((jQuery(window).width() - e.outerWidth()) / 2) + jQuery(window).scrollLeft()) + "px");
    	jQuery('html').css('overflow', 'hidden');
    	jQuery('#block-18-yes').click(function(){
    		document.cookie="block18=1; path=/";
    		jQuery('html').css('overflow', 'auto');
    		jQuery('#block-18-masker').css('display', 'none');
    		jQuery('#block-18').css('display', 'none');
    	});
    	jQuery('#block-18-no').click(function(){
    		window.location.href = 'https://flipermag.com';
    	});
    </script>
	<?php 
}

function custom_excerpt_length( $length ) {
    return 118;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function custom_excerpts( $excerpt, $post ) {
	// Don't change anything inside /wp-admin/
	if ( is_admin() ) {
		return $excerpt;
	}

	$note = get_field( 'editors_note', $post->ID );
	if ( '' != $note ) {
		return wp_trim_words( $note, 118 );
	}
		
	return $excerpt;
}
add_filter( 'get_the_excerpt', 'custom_excerpts', 999, 2 );

// 取得首頁最新文章區塊版型，若找不得就產生並 cache 住
function get_homepage_new_article_cache( $today = '' ) {
	if ( ! $today ) {
		$today = current_time('timestamp');
	}

	$homepage_post_sequence = get_option( 'homepage_post_sequence_' . date( "Ymd", $today ) );

	// 若 cache 不存在，則隨機產生版型
	if ( '' == $homepage_post_sequence ) {
		$seq = array();
		$hero_post = true;
	
		$query = new WP_Query( array(
			'date_query' => array(
		        array(
		            'year'  => date("Y", $today),
		            'month' => date("n", $today),
		            'day'   => date("j", $today),
		        ),
		    ),
		    'orderby' => 'date',
		    'order' => 'ASC',
		    'post_status' => 'publish',
		    'category__not_in' => array(28800, 28842)
		) );

		$found_posts = $query->found_posts;

		// 只有第一篇文章才會強制設定為最大版型
		$n = rand( 1, min( $found_posts, 3 ) );
		if ( $hero_post ) {
			$n = 1;
			$hero_post = false;
		}

		while ( $found_posts > 0 ) {
			$found_posts -= $n;
			array_push( $seq, $n );
			if ( $found_posts > 0 ) {
				$n = rand( 1, min( $found_posts, 3 ) );
			}
		}

		$homepage_post_sequence = maybe_serialize( $seq );
		update_option( 'homepage_post_sequence_' . date( "Ymd", $today ), $homepage_post_sequence );
	}

	return maybe_unserialize( $homepage_post_sequence );
}

function remove_date_404_template( $flag, $wp_query ){
	if ( is_date() ) {
		$flag = true;		
	}

	return $flag;
}
add_filter( 'pre_handle_404', 'remove_date_404_template', 10, 2 );

function line_rss(){
	add_feed('line_rss', 'line_rss_func');
}
add_action('init', 'line_rss');

function line_rss_func(){
	get_template_part('rss', 'line_rss');
}

function guidv4($data = null) {
    // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);

    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

add_action( 'template_redirect', function () {
    if ( is_singular( 'fliper_artwork' ) ) {
        status_header( 410 );
        nocache_headers();
        include get_404_template();
        exit;
    }
}, 1 );
