<?php

get_header();

$year = get_query_var('year');
$month = get_query_var('monthnum');
$day = get_query_var('day');

$queried_timestamp = strtotime( $year . '-' . $month . '-' . $day . ' 12:00:00' );

// 若時間為 2019/11/01 之前，且為一般個用者，則不顯示頁面
if ( strtotime('2019/11/01 06:00:00') >= $queried_timestamp && ! current_user_can('delete_posts')) {
	wp_safe_redirect('/');
	exit;
}

// 處理直接用網址存取今天的文章頁面
if ( date( "Ymd", $queried_timestamp ) == date( "Ymd", current_time('timestamp') ) ) {
	wp_safe_redirect('/');
	exit;
}

$homepage_post_sequence = get_option( 'homepage_post_sequence_' . date( "Ymd", $queried_timestamp ) );

// $queried_category = array('art-design', 'the-world', 'life', 'self-realization');
// $categories_name = array( 'art-design' => 'ART & DESIGN', 'the-world' => 'THE WORLD', 'life' => 'LIFE RELATED', 'self-realization' => 'SELF REALIZATION' );
// $categories_name_zh = array( 'art-design' => '藝術設計', 'the-world' => '世界觀點', 'life' => '質感生活', 'self-realization' => '自我實現' );

if ( '' == $homepage_post_sequence ) {
	$seq = array();
	$hero_post = true;
	// foreach ( $queried_category as $category ) {
	// 	$query = new WP_Query( array(
	// 		'category_name' => $category,
	// 		'date_query' => array(
	//             array(
	//              	'year'  => date("Y", $queried_timestamp),
	//              	'month' => date("n", $queried_timestamp),
	//              	'day'   => date("j", $queried_timestamp),
	//            	),
	//        	),
	//         'orderby' => 'date',
	//        	'order' => 'ASC'
	// 	) );

	// 	$found_posts = $query->found_posts;

	// 	// 只有第一篇文章才會強制設定為最大版型
	// 	$n = rand( 1, min( $found_posts, 3 ) );
	// 	if ( $hero_post ) {
	// 		$n = 1;
	// 		$hero_post = false;
	// 	}

	// 	while ( $found_posts > 0 ) {
	// 		$found_posts -= $n;
	// 		array_push( $seq, $n );
	// 		if ( $found_posts > 0 ) {
	// 			$n = rand( 1, min( $found_posts, 3 ) );	
	// 		}
	// 	}
	// }

	$query = new WP_Query( array(
		'date_query' => array(
	        array(
	            'year'  => date("Y", $queried_timestamp),
	            'month' => date("n", $queried_timestamp),
	             'day'   => date("j", $queried_timestamp),
	        ),
	    ),
	    'orderby' => 'date',
	    'order' => 'ASC'
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
	update_option( 'homepage_post_sequence_' . date("Ymd", $queried_timestamp ), $homepage_post_sequence );	
}

$homepage_post_sequence = maybe_unserialize( $homepage_post_sequence );

// 取得上一頁與下一頁 label and link
$yesterday = $queried_timestamp - 86400;
if ( strtotime('2019/11/01 06:00:00') >= $yesterday ) {
	$yesterday_link = '';
	$yesterday_label = '';
} else {
	$yesterday_link = home_url( '/' . date( "Y", $yesterday ) . '/' . date( "m", $yesterday ) . '/' . date( "d", $yesterday ) . '/' );
	$yesterday_label = date( "M", $yesterday ) . '. ' . date( "d", $yesterday );
}
$tormorrow = $queried_timestamp + 86400;
if ( date("Ymd") == date( "Ymd", $tormorrow ) ) {
	$tormorrow_link = '/';
	$tormorrow_label = 'Today';
} else {
	$tormorrow_link = home_url( '/' . date( "Y", $tormorrow ) . '/' . date( "m", $tormorrow ) . '/' . date( "d", $tormorrow ) . '/' );
	$tormorrow_label = date( "M", $tormorrow ) . '. ' . date( "d", $tormorrow );
}

?>

<style>
.row {
	width:340px;
}

#main-menu {
	padding:0px 0px;
}

#masthead {
	padding:10px 0px;
}

#masthead h4 {
	text-align: center;
	font: Bold 12px/12px "Roboto Slab";
	letter-spacing: 1.2px;
	color: #1A1A1A;
}

#masthead h3 {
	text-align: center;
	font: Bold 20px/24px Roboto Slab;
	letter-spacing: 2px;
	text-transform: uppercase;
	color: #1A1A1A;
	padding:6px 0px;
}

#masthead h5 {
	text-align: center;
	font: Bold 10px/10px Roboto Slab;
	letter-spacing: 0.25px;
	color: #8C8C8C;
	transform: scale(0.83);
}

#masthead-desktop {
	display: none;
}

#home-feature-articles {
	border-top:2px solid #1A1A1A;
	border-bottom:2px solid #1A1A1A;
	margin-bottom:65px;
}

#home-feature-articles .hr {
	margin-top:4px;
	height:1px;
	background:#1A1A1A;
}

#home-feature-articles .hr.bottom {
	margin-top:25px;
	margin-bottom:4px;
}

#home-feature-articles .hero-article .feature-image {
	margin-bottom:16px;
}

#home-feature-articles .hero-article .feature-image img {
	display:block;
}

#home-feature-articles .hero-article .title {
	font: 700 25px/35px "Noto Sans TC";
	padding:0px 15px;
	margin-bottom:14px;
}

#home-feature-articles .hero-article .title a {
	display: block;
}

#home-feature-articles .hero-article .excerpt p {
    font: 400 15px/25px "Noto Sans TC";
    color: #4A4A4A;
    padding:0px 0px 25px;
    margin:0px 15px 25px;
    border-bottom:1px solid #dddddd;
    text-align: justify;
}

#home-feature-articles .one-article .feature-image,
#home-feature-articles .two-article .feature-image,
#home-feature-articles .three-article .feature-image {
	margin-bottom:16px;
}

#home-feature-articles .one-article .feature-image img,
#home-feature-articles .two-article .feature-image img,
#home-feature-articles .three-article .feature-image img {
	display:block;
}

#home-feature-articles .one-article .title,
#home-feature-articles .two-article .title,
#home-feature-articles .three-article .title {
	font: 700 18px/28px "Noto Sans TC";
	color: #1A1A1A;
	padding:0px 15px;
	margin-bottom:16px;
}

#home-feature-articles .one-article .excerpt p,
#home-feature-articles .two-article .excerpt p,
#home-feature-articles .three-article .excerpt p {
    font: 400 15px/25px "Noto Sans TC";
    color: #4A4A4A;
    padding:0px 0px 25px;
    margin:0px 15px 25px;
    border-bottom:1px solid #dddddd;
    text-align: justify;
}

#home-feature-articles .category-wrap > div:nth-last-child(2) div:last-child .excerpt:last-child p {
	border-bottom:0px;
	margin-bottom:0px;
}

#masthead-pinned {
	width: 100%;
	max-width: 100%;
	padding-top:8px;
	padding-bottom:6px;
	display: none;
	position: fixed;
	top:0px;
	background:#fff;
}

#masthead-pinned .hr {
	margin-top:2px;
	height:2px;
	background:#1A1A1A;
}

#masthead-pinned .hr-2 {
	margin-top:4px;
	height:1px;
	background:#1A1A1A;
}

#masthead-pinned h3 {
	font: Bold 14px/14px "Roboto Slab";
	letter-spacing: 1.4px;
	color: #1A1A1A;
	display: inline-block;
	text-transform: uppercase;
}

#masthead-pinned h5 {
	float:right;
	font: Bold 10px/10px "Roboto Slab";
	letter-spacing: 0.25px;
	line-height: 26px;
	transform-origin: top right;
	color: #8C8C8C;
	transform: scale(0.83);
}

.category-header {
	padding:20px 10px;
	border-bottom:1px solid #1A1A1A;
	margin-bottom:25px;
}

.category-header .category-count {
	font: Bold 36px/44px "Roboto Slab";
	letter-spacing: 3.6px;
	color: #1A1A1A;
	display: inline-block;
}

.category-header .category-name {
	float:right;
}

.category-header .category-name .en {
	font: Bold 14px/22px "Roboto Slab";
	text-align: right;
	letter-spacing: 1.4px;
	color: #1A1A1A;
}

.category-header .category-name .zh {
	text-align: right;
	font: 500 14px/22px "Noto Sans TC";
	letter-spacing: 1.4px;
	color: #1A1A1A;
}

#home-feature-activity {
	margin-bottom:60px;
}

#home-feature-activity h2 {
	text-align: center;
	font: 700 18px/18px "Roboto Slab", "Noto Sans TC";
	letter-spacing: 1.8px;
	color: #1A1A1A;
	padding-bottom:20px;
	border-bottom:1px solid #1A1A1A;
	margin-bottom:25px;
}

#home-feature-activity .thumbnail {
	margin-bottom:16px;
}

#home-feature-activity .thumbnail a,
#home-feature-activity .thumbnail img {
	display: block;
}

#home-feature-activity .activity-wrap {
	padding:0px 15px;
}

#home-feature-activity .date {
	font: 400 16px/16px "Roboto Slab", "Noto Sans TC";
	letter-spacing: 0.4px;
	color: #FFC612;
	margin-bottom:16px;
}

#home-feature-activity .title {
	text-align: left;
	font: 700 18px/28px "Noto Sans TC";
	color: #1A1A1A;
	margin-bottom:14px;
}
	
#home-feature-activity .excerpt {
	font: 500 15px/25px "Noto Sans TC";
	color: #4A4A4A;
	text-align: justify;
}

#home-feature-articles .paginator {
	height: 24px;
	margin-bottom:25px;
}

#home-feature-articles .paginator .old-page {
	float:right;
	font: 400 15px/20px "Roboto Slab";
	letter-spacing: 0.38px;
	color: #8C8C8C;
	display: block;
	border-bottom:1px solid #8c8c8c;
	padding-bottom:4px;
}

#home-feature-articles .paginator .arrow {
	background-position-x: -275px;
    background-position-y: -297px;
	display: block;
	width: 20px;
	height: 20px;
	float:right;
}

#home-feature-articles .paginator .new-page {
	float:left;
	font: 400 15px/20px "Roboto Slab";
	letter-spacing: 0.38px;
	color: #8C8C8C;
	display: block;
	border-bottom:1px solid #8c8c8c;
	padding-bottom:4px;
}

#home-feature-articles .paginator .arrow.reversed {
	float:left;
	transform: rotate(180deg);
}

@media screen and (min-width: 1100px) {

body {
    padding-top: 52px;
}

.row {
	width:1100px;
}

#main-menu .site-logo {
	width: 170px;
	height: 40px;
	background-position-x:-222px;
	background-position-y:-114px; 
	visibility: hidden;
}

#masthead-desktop .site-logo {
	width: 170px;
	height: 40px;
	background-position-x:-222px;
	background-position-y:-114px; 
	margin-bottom:50px;
	display: block;
}

#desktop-user-menu {
    padding-top:0px;
}

#masthead {
	display: none;
}

#masthead-desktop,
#masthead-desktop-shadow {
	display: block;
    width: 230px;
    float: left;
    box-sizing:border-box;
    position: relative;
    max-height: 568px;
}

#masthead-desktop-shadow {
	display: none;
}

#masthead-desktop h6 {
	font: 700 14px/14px "Roboto Slab";
	letter-spacing: 1.4px;
	color: #1A1A1A;
	margin-bottom:14px;
}

#masthead-desktop h3 {
	font: 700 22px/22px "Roboto Slab";
	text-transform: uppercase;
	letter-spacing: 2.2px;	
	color: #1A1A1A;
	margin-bottom:25px;
}

#masthead-desktop h4 {
	font: 400 16px/16px "Roboto Slab";
	letter-spacing: 0.4px;
	color: #000000;
	margin-bottom:40px;
}

#masthead-desktop h5 {
	font: 400 14px/22px "Roboto Slab";
	letter-spacing: 0.35px;
	color: #1F7BA1;
	margin-bottom:20px;
	position: absolute;
	bottom:0px;
}

#masthead-desktop .hr {
	margin-bottom:6px;
	border-bottom:2px solid #1A1A1A;
}

#masthead-desktop .inner-wrap {
	display: inline-block;
	border-bottom:1px solid #1A1A1A;
}

#masthead-desktop.fixed {
	position: fixed;
	top:52px;
}

#masthead-desktop.pinned-bottom {
	position: absolute;
	bottom:0px;
}

#home-feature-articles {
	margin-top:0px;
	border-top:0px;
	display: block;
	padding-left:270px;
	border-bottom:0px;
}

#home-feature-articles > .hr {
	display: none;
}

.category-header {
	padding:0px;
	border-bottom:0px;
	margin-bottom:30px;
	position: relative;
	display: flex;
}

.category-header .category-count {
	font: 700 32px/25px "Roboto Slab";
	letter-spacing: 3.2px;
	width: 40px;
	height: 32px;
	color: #1A1A1A;
	display: inline-block;
	padding-right: 12px;
	position: relative;
	z-index: 2;
	background: #fff;
}

.category-header .category-name {
	float:none;
	display: inline-block;
	vertical-align: top;
	height: 18px;
	line-height: 18px;
	padding-right:24px;
	position: relative;
	z-index: 2;
	background: #fff;
}

.category-header .category-name .en {
	font: 700 18px/18px "Roboto Slab";
	letter-spacing: 1.8px;
	color: #1A1A1A;
	display: inline-block;
	margin-right:8px;
}

.category-header .category-name .zh {
	font: 700 18px/18px "Noto Sans TC";
	letter-spacing: 1.8px;
	color: #1A1A1A;
	display: inline-block;
}

.category-header .category-hr {
	height: 1px;
	background:#1A1A1A;
	margin-top:9px;
	position: absolute;
	z-index: 1;
	top:0px;
	width: 100%;
}

.homepage-contaner {
	position: relative;
}

#home-feature-articles .hero-article > div,
#home-feature-articles .one-article > div {
	margin-bottom:45px;
	height: 356px;
	position: relative;
}

#home-feature-articles .hero-article .feature-image,
#home-feature-articles .one-article .feature-image {
	margin-bottom:0px;
	float:left;
	margin-right:40px;
}

#home-feature-articles .hero-article .feature-image img,
#home-feature-articles .one-article .feature-image img {
	display:block;
	width: 560px;
}

#home-feature-articles .hero-article .article-meta,
#home-feature-articles .one-article .article-meta {
	width:230px;
	position: absolute;
	bottom:0px;
	right:0px;
}

#home-feature-articles .hero-article .title,
#home-feature-articles .one-article .title {
	padding:0px;
	margin-bottom:16px;
	font: 600 20px/32px "notoserifcjktc";
	color: #1A1A1A;
}

#home-feature-articles .hero-article .excerpt p,
#home-feature-articles .one-article .excerpt p {
    font: 500 14px/24px "notoserifcjktc";
    padding:0px;
    margin:0px;
    border-bottom:0px;
}

#home-feature-articles .two-article {
	margin-bottom:45px;
	display: flex;
	justify-content: space-between;
}

#home-feature-articles .two-article > div {
	width:400px;
}

#home-feature-articles .two-article .feature-image {
	margin-bottom:28px;
}

#home-feature-articles .two-article .feature-image img {
	display: block;
	width: 400px;
}

#home-feature-articles .two-article .title {
	font: 600 18px/30px "notoserifcjktc";
	padding:0px;
	margin-bottom:12px;
}

#home-feature-articles .two-article .excerpt p {
	font: 500 13px/23px "notoserifcjktc";
    padding:0px;
    margin:0px;
    border-bottom:0px;
}

#home-feature-articles .three-article {
	margin-bottom:45px;
	display: flex;
	justify-content: space-between;
}

#home-feature-articles .three-article > div {
	width:262px;
}

#home-feature-articles .three-article .feature-image {
	margin-bottom:25px;
}


#home-feature-articles .three-article .feature-image img {
	display:block;
	width:262px;
}

#home-feature-articles .three-article .title {
	font: 600 16px/28px "notoserifcjktc";
	padding:0px;
	margin-bottom:12px;
}

#home-feature-articles .three-article .excerpt p {
    font: 500 12px/22px "notoserifcjktc";
    padding:0px;
    margin:0px;
    border-bottom:0px;
}

#home-feature-articles .desktop-article-hr {
	height: 1px;
	background-color:#dddddd;
	margin:0px 25px 45px;
}

#home-feature-articles .category-wrap .desktop-article-hr:last-child {
	display: none;
}

#home-feature-articles .desktop-articles-hr {
	margin-top:30px;
	background:#1A1A1A;
	height: 1px;
	width: 100%;
}

#home-feature-articles .desktop-articles-hr-2 {
	margin-top:8px;
	background:#1A1A1A;
	height: 2px;
	width: 100%;
}

#home-feature-activity {
	margin-bottom:45px;
	border-bottom:0px solid #1A1A1A;
	margin-left:270px;
	padding-bottom:45px;
	position: relative;
}

#home-feature-activity h2 {
	text-align: left;
	font: 700 18px/18px "Roboto Slab", "Noto Sans TC";
	padding-bottom:0px;
	border-bottom:0px;
	margin-bottom:30px;
}

#home-feature-activity .thumbnail {
	margin-bottom:0px;
	width:420px;
	margin-right:30px;
}

#home-feature-activity .activity-wrap {
	padding:0px;
	position: absolute;
	right:0px;
	bottom:45px;
	width:380px;
}

#home-feature-activity .date {
	margin-bottom:12px;
}

#home-feature-activity .title {
	text-align: left;
	font: 600 18px/30px "notoserifcjktc";
	margin-bottom:12px;
}
	
#home-feature-activity .excerpt {
	font: 500 13px/23px "notoserifcjktc";
}


#home-feature-articles .paginator {
	margin-bottom:30px;
}

#home-feature-articles .paginator .old-page:hover,
#home-feature-articles .paginator .new-page:hover {
	color: #DDDDDD;
	border-bottom:1px solid #DDDDDD;
}

#home-feature-articles .paginator .old-page:hover .arrow,
#home-feature-articles .paginator .new-page:hover .arrow {
	background-position-x: -300px;
}

#home-feature-activity.two-col {
	margin-top:-25px;
}

#home-feature-activity.two-col .item {
	padding-top:25px;
    width: 380px;
    display: block;
    float:left;
    margin-bottom:35px;
    padding-bottom:25px;
}

#home-feature-activity.two-col .item:first-child {
	border-right:1px solid #1A1A1A;
    padding-right:34px;
}

#home-feature-activity.two-col .item:nth-child(2) {
    padding-left: 34px;
}

#home-feature-activity.two-col .item .thumbnail {
    width: 380px;
    height: 210px;
    margin-bottom: 28px;
}

#home-feature-activity.two-col .activity-wrap {
	position: static;
}

}
</style>

<div id="masthead" class="row">
	<h4><?php echo date("Y l", $queried_timestamp); ?></h3>
	<h3><?php echo date('F d', $queried_timestamp); ?></h3>
	<h5>Let Wonders Enrich Our Life</h5>
</div>
<div id="masthead-pinned">
	<div class="row">
		<h3><?php echo date('F d', $queried_timestamp); ?></h3>
		<h5>Let Wonders Enrich Our Life</h5>
		<div class="hr"></div>
		<div class="hr-2"></div>
	</div>
</div>
<div class="row homepage-contaner">
	<div id="masthead-desktop" class="fixed">
		<div class="inner-wrap">
			<a href="/" class="site-logo iconset"></a>
			<h6><?php echo date("Y", $queried_timestamp); ?></h6>
			<h3><?php echo date('F d', $queried_timestamp); ?></h3>
			<h4><?php echo date("l", $queried_timestamp); ?></h4>
			<div class="hr"></div>
		</div>
		<h5>Let Wonders<br/>Enrich Our Life</h5>
	</div>
	<div id="masthead-desktop-shadow"></div>

	<div id="home-feature-articles">
		<div class="hr row"></div>
		<?php 
		$headline = false;
		$query = new WP_Query( array(
			'date_query' => array(
		        array(
			        'year'  => date("Y", $queried_timestamp),
		            'month' => date("n", $queried_timestamp),
		            'day'   => date("j", $queried_timestamp),
		        ),
		    ),
		    'orderby' => 'date',
		    'order' => 'ASC',
		    'category__not_in' => array(28800, 28842)
		) );

		$found_posts = $query->found_posts;
		$homepage_section_count = 1;
		if ( $found_posts > 0 ) :
		?>
		<div class="category-wrap clearfix">		
			<div class="category-header">
				<span class="category-count"><?php echo '0' . $homepage_section_count; ?></span>
				<div class="category-name">
					<div class="zh">質感好文，美好你的一天</div>
				</div>
				<div class="category-hr"></div>
			</div>
			<?php
			while( $query->have_posts() ) : $query->the_post();
				if ( ! $headline ) :
					$n = array_shift( $homepage_post_sequence );
			?>
			<div class="hero-article">
				<div>
					<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
					<div class="article-meta">
						<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="excerpt"><?php the_excerpt(); ?></div>
					</div>
				</div>
			</div>
			<div class="desktop-article-hr"></div>
			<?php 
				$headline = true;
				else: 
					$n = array_shift( $homepage_post_sequence );
					if ( 1 == $n ) :
			?>
			<div class="one-article">
				<div>
					<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
					<div class="article-meta">
						<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="excerpt"><?php the_excerpt(); ?></div>
					</div>
				</div>
			</div>
			<div class="desktop-article-hr"></div>
			<?php elseif ( 2 == $n ) : ?>
			<div class="two-article">
				<div>
					<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
					<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="excerpt"><?php the_excerpt(); ?></div>
				</div>
				<?php $query->the_post(); ?>
				<div>
					<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
					<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="excerpt"><?php the_excerpt(); ?></div>
				</div>
			</div>
			<div class="desktop-article-hr"></div>
			<?php elseif ( 3 == $n ) : ?>
			<div class="three-article">
				<div>
					<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
					<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="excerpt"><?php the_excerpt(); ?></div>
				</div>
				<?php $query->the_post(); ?>
				<div>
					<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
					<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="excerpt"><?php the_excerpt(); ?></div>
				</div>
				<?php $query->the_post(); ?>
				<div>
					<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
					<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="excerpt"><?php the_excerpt(); ?></div>
				</div>
			</div>
			<div class="desktop-article-hr"></div>
			<?php endif; endif; endwhile; ?>
		</div>
		<?php $homepage_section_count += 1; endif; wp_reset_query(); ?>

		<?php 
		// 若時間是 2020/03/18 以前，且使用者為編輯，則可以看到舊文區塊，否則隱藏
		$is_preview = 0;
		if ( strtotime('2020/03/18 06:00:00') <= $queried_timestamp || current_user_can('delete_posts') ) :
			if ( strtotime('2020/03/18 06:00:00') > $queried_timestamp && current_user_can('delete_posts') ) {
				$is_preview = 1;
			}
		
			$query = new WP_Query( array(
				'date_query' => array(
			        array(
				        'year'  => date("Y", $queried_timestamp) - ( 1 - $is_preview ),
			            'month' => date("n", $queried_timestamp),
			            'day'   => date("j", $queried_timestamp),
			        ),
			        array(
				        'year'  => date("Y", $queried_timestamp) - ( 2 - $is_preview ),
			            'month' => date("n", $queried_timestamp),
			            'day'   => date("j", $queried_timestamp),
			        ),
			        array(
				        'year'  => date("Y", $queried_timestamp) - ( 3 - $is_preview ),
			            'month' => date("n", $queried_timestamp),
			            'day'   => date("j", $queried_timestamp),
			        ),
			        'relation' => 'OR',
			    ),
			    'orderby' => 'date',
			    'order' => 'ASC',
			    'posts_per_page' => -1
			) );

			$found_posts = $query->found_posts;		
		?>
		<div class="category-wrap clearfix">
			<div class="category-header">
				<span class="category-count"><?php echo '0' . $homepage_section_count; ?></span>
				<div class="category-name">
					<div class="zh">精選舊文，重拾你的靈感</div>
				</div>
				<div class="category-hr"></div>
			</div>
			<?php for ( $i = 1; $found_posts / 3 >= $i; $i++ ) : $query->the_post(); ?>
			<div class="three-article">
				<div>
					<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
					<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="excerpt"><?php the_excerpt(); ?></div>
				</div>
				<?php $query->the_post(); ?>
				<div>
					<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
					<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="excerpt"><?php the_excerpt(); ?></div>
				</div>
				<?php $query->the_post(); ?>
				<div>
					<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
					<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="excerpt"><?php the_excerpt(); ?></div>
				</div>
			</div>
			<div class="desktop-article-hr"></div>
			<?php endfor; ?>
			<?php if ( $found_posts % 3 === 1 ) : $query->the_post(); ?>
			<div class="one-article">
				<div>
					<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
					<div class="article-meta">
						<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="excerpt"><?php the_excerpt(); ?></div>
					</div>
				</div>
			</div>
			<div class="desktop-article-hr"></div>
			<?php elseif ( $found_posts % 3 === 2 ) : $query->the_post(); ?>
			<div class="two-article">
				<div>
					<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
					<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="excerpt"><?php the_excerpt(); ?></div>
				</div>
				<?php $query->the_post(); ?>
				<div>
					<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
					<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="excerpt"><?php the_excerpt(); ?></div>
				</div>
			</div>
			<div class="desktop-article-hr"></div>
			<?php endif; ?>
		</div>
		<?php $homepage_section_count += 1; wp_reset_query(); endif; ?>

		<?php 
		$query = new WP_Query( array(
			'meta_query' => array(
				array(
					'key' => 'staff_pick_start',
					'value' => date( 'Ymd', $queried_timestamp ),
					'compare' => '<=' 
				), array(
					'key' => 'staff_pick_end',
					'value' => date( 'Ymd', $queried_timestamp ),
					'compare' => '>='
				),
			),
			'orderby' => 'date',
			'order' => 'DESC',
			'posts_per_page' => 3,
			'no_found_rows' => true
		) );
	
		if ( $query->have_posts() ) :
		?>
		<div class="category-wrap clearfix">		
			<div class="category-header">
				<span class="category-count"><?php echo '0' . $homepage_section_count; ?></span>
				<div class="category-name">
					<div class="zh">暖心推薦，讀懂你的心情</div>
				</div>
				<div class="category-hr"></div>
			</div>
			<?php if ( 1 === $query->post_count ) : $query->the_post(); ?>
			<div class="one-article">
				<div>
					<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
					<div class="article-meta">
						<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="excerpt"><?php the_excerpt(); ?></div>
					</div>
				</div>
			</div>
			<div class="desktop-article-hr"></div>
			<?php elseif ( 2 === $query->post_count ) : $query->the_post(); ?>
			<div class="two-article">
				<div>
					<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
					<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="excerpt"><?php the_excerpt(); ?></div>
				</div>
				<?php $query->the_post(); ?>
				<div>
					<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
					<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="excerpt"><?php the_excerpt(); ?></div>
				</div>
			</div>
			<div class="desktop-article-hr"></div>
			<?php elseif ( 3 == $query->post_count ) : $query->the_post(); ?>
			<div class="three-article">
				<div>
					<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
					<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="excerpt"><?php the_excerpt(); ?></div>
				</div>
				<?php $query->the_post(); ?>
				<div>
					<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
					<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="excerpt"><?php the_excerpt(); ?></div>
				</div>
				<?php $query->the_post(); ?>
				<div>
					<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
					<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="excerpt"><?php the_excerpt(); ?></div>
				</div>
			</div>
			<div class="desktop-article-hr"></div>
			<?php endif; ?>
		</div>
		<?php $homepage_section_count += 1; endif; wp_reset_query(); ?>

		<?php 
		$query = new WP_Query( array(
			'date_query' => array(
		        array(
			        'year'  => date("Y", $queried_timestamp),
		            'month' => date("n", $queried_timestamp),
		            'day'   => date("j", $queried_timestamp),
		        ),
		    ),
		    'orderby' => 'date',
		    'order' => 'ASC',
			'posts_per_page' => -1,
			'no_found_rows' => true,
			'category_name' => 'creation-is-everywhere'
		) );
	
		if ( $query->have_posts() ) :
		?>
		<div class="category-wrap clearfix">		
			<div class="category-header">
				<span class="category-count"><?php echo '0' . $homepage_section_count; ?></span>
				<div class="category-name">
					<div class="zh">Creation Is Everywhere</div>
				</div>
				<div class="category-hr"></div>
			</div>
			<?php if ( 1 === $query->post_count ) : $query->the_post(); ?>
			<div class="one-article">
				<div>
					<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
					<div class="article-meta">
						<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="excerpt"><?php the_excerpt(); ?></div>
					</div>
				</div>
			</div>
			<div class="desktop-article-hr"></div>
			<?php elseif ( 2 === $query->post_count ) : $query->the_post(); ?>
			<div class="two-article">
				<div>
					<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
					<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="excerpt"><?php the_excerpt(); ?></div>
				</div>
				<?php $query->the_post(); ?>
				<div>
					<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
					<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="excerpt"><?php the_excerpt(); ?></div>
				</div>
			</div>
			<div class="desktop-article-hr"></div>
			<?php elseif ( 3 == $query->post_count ) : $query->the_post(); ?>
			<div class="three-article">
				<div>
					<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
					<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="excerpt"><?php the_excerpt(); ?></div>
				</div>
				<?php $query->the_post(); ?>
				<div>
					<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
					<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="excerpt"><?php the_excerpt(); ?></div>
				</div>
				<?php $query->the_post(); ?>
				<div>
					<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
					<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="excerpt"><?php the_excerpt(); ?></div>
				</div>
			</div>
			<div class="desktop-article-hr"></div>
			<?php endif; ?>
		</div>
		<?php endif; wp_reset_query(); ?>

		<div class="paginator">
			<a class="new-page" href="<?php echo $tormorrow_link; ?>"><span class="reversed arrow iconset"></span><?php echo $tormorrow_label; ?></a>
			<?php if ( '' != $yesterday_link ) : ?>
			<a class="old-page" href="<?php echo $yesterday_link; ?>"><?php echo $yesterday_label; ?><span class="arrow iconset"></span></a>
			<?php endif; ?>
		</div>
		<div class="hr row bottom"></div>
		<div class="desktop-articles-hr"></div>
		<div class="desktop-articles-hr-2"></div>
	</div>

	<style>
	#home-feature-issue h2 {
		text-align: center;
		font: 700 18px/18px "Roboto Slab", "Noto Sans TC";
		letter-spacing: 1.8px;
		color: #1A1A1A;
		padding-bottom:20px;
		border-bottom:1px solid #1A1A1A;
		margin-bottom:25px;
	}

	.issue-block {
	    width:340px;
    	margin:0 auto;
	}

	.issue-cover {
    	margin-bottom: 16px;
	}

	.issue-cover img, .issue-cover a {
    	display: block;
	}

	.issue-title {
		display: block;
		color: #1A1A1A;
    	font-size: 18px;
    	font-weight: 700;
    	line-height: 28px;
    	font-family: "Noto Sans TC";
    	margin-bottom: 14px;
    	padding:0px 15px;
	}

	.issue-description {
		color: #4A4A4A;
    	padding:0px 15px;
    	margin-bottom:30px;
    	font-size: 15px;
    	line-height: 25px;
    	font-family: "Noto Sans TC";
	}

	ul.issue-article-list {
		padding-top: 5px;
	    flex-wrap: nowrap;
	    overflow-x: scroll;
	    -webkit-overflow-scrolling: touch;
	    display: flex;
	    margin: 0px auto 40px;
	    width: 310px;
	    -webkit-touch-callout: none;
	    -webkit-user-select: none;
	    -khtml-user-select: none;
	    -moz-user-select: none;
	    -ms-user-select: none;
	    user-select: none;
	}

	ul.issue-article-list li.article {
	    width: 170px;
	    min-width: 170px;
	    position: relative;
	    padding-right: 30px;
	    padding-top: 26px;
	    border-top: 1px solid #1A1A1A;
	}

	ul.issue-article-list li.article .dot {
	    position: absolute;
	    width: 8px;
	    height: 8px;
	    border: 1px solid #1A1A1A;
	    border-radius: 10px;
	    background: #1A1A1A;
	    left: 0px;
	    top: -5px;
	}

	ul.issue-article-list li.article .date {
	    font-size: 12px;
	    font-family: "Roboto Slab";
	    letter-spacing: 1.2px;
	    color: #2BAB9F;
	    margin-bottom: 16px;
	    line-height: 16px;
	}

	ul.issue-article-list li.article .index {
	    font-size: 12px;
	    letter-spacing: 1.2px;
	    line-height: 12px;
	    font-family: "Roboto Slab";
	    margin-bottom: 12px;
	}

	ul.issue-article-list li.article .title {
	    font-size: 14px;
	    line-height: 22px;
	    letter-spacing: 1.4px;
	    font-weight: 500;
	    font-family: "Noto Sans TC";
	}

	ul.issue-article-list li.article.disable .dot {
		background: #fff;
	}

	ul.issue-article-list li.article.disable .date,
	ul.issue-article-list li.article.disable .index,
	ul.issue-article-list li.article.disable .title {
		opacity: 0.4;
	}

	@media screen and (min-width: 1100px) {

	#home-feature-issue {
		margin-bottom:45px;
		border-bottom:1px solid #1A1A1A;
		margin-left:270px;
		padding-bottom:45px;
		position: relative;
	}

	#home-feature-issue h2 {
		text-align: left;
		letter-spacing: 1.8px;
		font: 700 18px/18px "Roboto Slab", "Noto Sans TC";
		margin-bottom:30px;
		border-bottom:0px;
	}

	.issue-block {
    	width:100%;
    	margin-bottom:30px;
	}

	.issue-block:last-child {
		margin-bottom:0px;
	}

	.issue-cover {
    	margin: 0px;
    	padding-left:290px;
    	width: 540px;
    	margin-bottom: 30px;
	}

	.issue-cover a:hover img {
		opacity: .5;
	}

	.issue-meta-wrap {
		position: relative;
	}

	.issue-meta-inner {
		float:left;
		position: absolute;
		bottom:0px;
	}

	.issue-title {
		padding-left:0px;
    	font-size: 16px;
    	line-height: 30px;
    	display: block;
    	font-weight: 500;
    	font-family: "notoserifcjktc";
    	width: 275px;
    	margin-bottom:12px;
	}

	.issue-title:hover {
		color:gray;
	}

	.issue-description {
		padding-left:0px;
    	font-family: "notoserifcjktc";
    	font-size: 12px;
    	list-style: 22px;
    	width: 275px;
    	margin-bottom:0px;
    	font-weight: 500;
    	color:#4A4A4A;
	}

	ul.issue-article-list {
		cursor:grab;
		overflow: hidden;
		width:830px;
		margin:0px auto;
		padding:25px 0px;
	}

	ul.issue-article-list li.article .title {
    	font-family: "notoserifcjktc";
    	font-weight:500;
	}

	ul.issue-article-list li.article a.title:hover {
		color:gray;
	}
	
	}

	</style>

	<?php 
		$number = 0;
		$term_query = new WP_Term_Query();
		$query = array( 
			'taxonomy' => 'issue', 
			'hide_empty' => false,
			'number' => $number,
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key' => 'issue_show_homepage',
					'value' => '1',
					'compare' => '='
				),
				array(
					'key' => 'issue_show_homepage_start_time',
					'value' => date( 'Ymd', $queried_timestamp ),
					'compare' => '<='
				),
				array(
					'key' => 'issue_show_homepage_end_time',
					'value' => date( 'Ymd', $queried_timestamp ),
					'compare' => '>='
				)
			)
		);
		$issues = $term_query->query( $query );
		if ( $issues ) : 
	?>
	<div id="home-feature-issue">
		<h2>ISSUE 專題</h2>
		<?php foreach ( $issues as $issue ) : ?>
		<div class="issue-block">
			<div class="issue-meta-wrap">
				<div class="issue-cover">
					<a href="<?php echo get_term_link( $issue ); ?>"><img src="<?php the_field( 'issue_cover', $issue ); ?>" /></a>
				</div>
				<div class="issue-meta-inner">
					<a class="issue-title" href="<?php echo get_term_link( $issue ); ?>"><?php echo $issue->name; ?></a>
					<div class="issue-description"><?php echo $issue->description; ?></div>
				</div>
			</div>
			<?php if ( have_rows( 'issue_articles', $issue ) ): ?>
			<ul class="issue-article-list">
				<?php while( have_rows( 'issue_articles', $issue ) ): the_row(); ?>
				<li class="article <?php echo get_sub_field('issue_article') && 'publish' === get_post_status( get_sub_field('issue_article') ) ? '' : 'disable'; ?>">
					<div class="dot"></div>
					<div class="date"><?php echo date( 'M.d.Y', strtotime( get_sub_field('issue_article_publish_time') ) ); ?></div>
					<div class="index"><?php the_sub_field('issue_article_index'); ?> /</div>
					<?php if ( get_sub_field('issue_article') && 'publish' === get_post_status( get_sub_field('issue_article') ) ) : ?>
					<a class="title" href="<?php echo get_permalink( get_sub_field('issue_article') ); ?>"><?php echo get_the_title( get_sub_field('issue_article') ); ?></a>
					<?php else : ?>
					<div class="title"><?php echo get_sub_field('issue_article_title_tmp'); ?></div>
					<?php endif; ?>
				</li>
				<?php endwhile; ?>
			</ul>
			<?php endif; ?>
			<div class="desktop-article-hr"></div>
		</div>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>

	<?php if ( ! wp_is_mobile() ) : ?>
	<script>
	const slider = document.querySelector('ul.issue-article-list');
	let isDown = false;
	let startX;
	let scrollLeft;

	slider.addEventListener('mousedown', (e) => {
		isDown = true;
		slider.classList.add('active');
		startX = e.pageX - slider.offsetLeft;
		scrollLeft = slider.scrollLeft;
	});
	slider.addEventListener('mouseleave', () => {
		isDown = false;
		slider.classList.remove('active');
	});
	slider.addEventListener('mouseup', () => {
		isDown = false;
		slider.classList.remove('active');
	});
	slider.addEventListener('mousemove', (e) => {
		if(!isDown) return;
		e.preventDefault();
		const x = e.pageX - slider.offsetLeft;
		const walk = (x - startX) * 3; //scroll-fast
		slider.scrollLeft = scrollLeft - walk;
		console.log(walk);
	});
	</script>
	<?php endif; ?>

	<?php 
	$event = false;
	$video = false;
	$query = new WP_Query( array(
		'post_type' => 'fliper_event',
		'meta_query' => array(
			array(
				'key' => 'event_end_date',
				'value' => date( 'Ymd', $queried_timestamp ),
				'compare' => '>=' 
			),
		),
		'orderby' => 'date',
		'order' => 'DESC',
		'posts_per_page' => 1,
		'no_found_rows' => true
	) );
	if ( $query->post_count > 0 ) {
		$query->the_post();
		$event['title'] = get_the_title();
		$event['thumbnail'] = get_the_post_thumbnail( null, 'full', array( 'class' => 'block' ) );
		$event['end_date'] = date( 'M.d.Y', strtotime( get_field( 'event_end_date', get_the_ID() ) ) );
		$event['excerpt'] = get_the_excerpt();
		$event['ref_link'] = get_field( 'ref_link', get_the_ID() );
	}

	$query = new WP_Query( array(
		'post_type' => 'fliper_video',
		'orderby' => 'date',
		'order' => 'DESC',
		'posts_per_page' => 1,
		'no_found_rows' => true
	) );
	if ( $query->post_count > 0 ) {
		$query->the_post();
		$video['title'] = get_the_title();
		$video['thumbnail'] = get_the_post_thumbnail( null, 'full', array( 'class' => 'block' ) );
		$video['video_channel'] = get_field( 'video_channel', get_the_ID() );
		$video['excerpt'] = get_the_excerpt();
		$video['ref_link'] = get_field( 'ref_link', get_the_ID() );
	}

	if ( $event || $video ) :
	?>

	<div id="home-feature-activity" class="<?php echo $event && $video ? 'two-col clearfix' : ''; ?>">
		<?php if ( $event ) : ?>
		<div class="item">
			<h2>EVENT 活動</h2>
			<div class="thumbnail"><a href="<?php echo $event['ref_link']; ?>" target="_blank"><?php echo $event['thumbnail']; ?></a></div>
 			<div class="activity-wrap">
				<div class="date"><?php echo $event['end_date']; ?></div>
				<div class="title"><a href="<?php echo $event['ref_link']; ?>" target="_blank"><?php echo $event['title']; ?></a></div>
				<div class="excerpt"><?php echo $event['excerpt']; ?></div>
 			</div>
 		</div>
 		<?php endif; ?>
 		<?php if ( $video ) : ?>
		<div class="item">
			<h2>CHANNEL 頻道</h2>
			<div class="thumbnail"><a href="<?php echo $video['ref_link']; ?>" target="_blank"><?php echo $video['thumbnail']; ?></a></div>
			<div class="activity-wrap">
				<div class="date"><?php echo $video['video_channel']; ?></div>
				<div class="title"><a href="<?php echo $video['ref_link']; ?>" target="_blank"><?php echo $video['title']; ?></a></div>
				<div class="excerpt"><?php echo $video['excerpt']; ?></div>
			</div>
		</div>
		<?php endif; ?>
 	</div>
 	<?php endif; ?>
</div>




<script>
$ = jQuery;
$(window).load(function(){
	if ( $(window).width() < 1100 ) {
		$(window).scroll(function(){
			if ( $(window).scrollTop() > $('#home-feature-articles').offset().top - 39 ) {
				$('#masthead-pinned').show();
			} else {
				$('#masthead-pinned').hide();
			}
		});	
	} else {
		var top = parseInt($('#masthead-desktop').css('top')) + parseInt($('html').css('margin-top'));
		$('#masthead-desktop').css('top', top + 'px');
		$('#masthead-desktop').outerHeight($(window).height() - $('#main-menu').height() - parseInt($('body').css('padding-top')) - parseInt($('html').css('margin-top')));
		$(window).scroll(function(){
			if ( $('#masthead-desktop').hasClass('fixed') ) {
				if ( $('#masthead-desktop').offset().top + $('#masthead-desktop').outerHeight() >= $('#footer').offset().top ) {
					$('#masthead-desktop').removeClass('fixed');
					$('#masthead-desktop').css('top', 'unset');
					$('#masthead-desktop').addClass('pinned-bottom');
					$('#masthead-desktop-shadow').show();
				}
			} else if ( $('#masthead-desktop').hasClass('pinned-bottom') ) {
				if ( $(window).scrollTop() <= $('#masthead-desktop').offset().top - top ) {
					$('#masthead-desktop').removeClass('pinned-bottom');
					$('#masthead-desktop').addClass('fixed');
					$('#masthead-desktop').css('top', top + 'px');
					$('#masthead-desktop-shadow').show();
				}
			}
		});	
	}
	
});

</script>

<?php get_footer(); ?>