<?php

get_header();

$query = new WP_Query( array(
	'tax_query' => array(
        array(
            'taxonomy' => 'artwork_related_event',
            'field'    => 'slug',
            'terms'    => 'xu-baozhen-online-calligraphy-exhibition',
        ),
    ),
    'post_type' => 'fliper_artwork',
    'posts_per_page' => -1
) );

?>

<style>
/*** 共用 ***/
.iconset-22 {
	background-size: 1000px !important;
	background:url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/the_void_of_22_exhibition/0616_icon@2x.png);
}

body {
	padding-top:0px;
}

._mobile {
	display: none !important;
}

._desktop {
	display: block !important;
}

#wpadminbar {
	display: none;
}

#footer-menu {
	display: none;
}

#main-container {
	max-width: 100%;
	margin-top:0px;
}

.page-container * {
	box-sizing: border-box;
}

.copyright {
	width: 1100px;
	margin:0 auto;
	padding:16px 0px 60px;
	font: 400 14px/22px EB Garamond;
	letter-spacing: 0.7px;
}

#footer .copyright {
	padding:0px;
	font: 400 14px/22px EB Garamond;
	letter-spacing: 0.7px;
}

#sponsors {
	padding:32px 0px;
}

#sponsors-inner {
	width:1100px;
	margin:0 auto;
}

h1 {
    font: normal normal 500 32px/42px 'notoserifcjktc';
    letter-spacing: 1.6px;
}

h4 {
    letter-spacing: 0.8px;
    color: #A0A0A0;
    font:500 16px/24px 'notoserifcjktc';
}

.room-label div:first-child {
    font: normal normal normal 40px/48px EB Garamond;
    letter-spacing: 1px;
    float: left;
    color: #FFFFFF;
}

.room-label div:last-child {
    margin-left: 4px;
    margin-top: 8px;
    font: normal normal normal 16px/16px EB Garamond;
    letter-spacing: 0.4px;
    color: #FFFFFF;
    float: left;
}

.t2 {
    letter-spacing: 0.35px;
    color: #FFFFFF;
    font: normal normal 400 14px/24px EB Garamond, 'notoserifcjktc';
    letter-spacing: 0.7px;
}
/*** 共用 ***/

.topbar {
    padding: 7px 0px;
    width: 1100px;
    margin: 90px auto 0px;
}

.topbar a {
	display: block;
}

.topbar a:hover div {
	color:#A0A0A0;
}

.topbar .iconset-22.arrow, .progress-bar .iconset-22.arrow {
    width: 96px;
    float: left;
    height: 22px;
    background-position: -99px -34px;
}

.topbar a:hover .iconset-22.arrow, .progress-bar a:hover .iconset-22.arrow {
	background-position: -200px -34px;
}

.topbar div, .progress-bar div {
	font: normal normal normal 14px/22px EB Garamond, 'notoserifcjktc';
    letter-spacing: 0.7px;
}

.topbar > div {
    float: right;
}

.topbar a div:nth-child(2) {
    float: left;
    padding-left: 28px;
}

.intro {
    margin: 90px auto;
    width: 1100px;
    position: relative;
}

.intro h4 {
    position: absolute;
    left: 180px;
    top: 0px;
    width: 84px;
}

.intro h1 {
    margin-top: 28px;
}

.intro > div:last-child {}

.intro .t2 {
    width: 535px;
    /* float: right; */
    position: absolute;
    top: 0px;
    left: 565px;
    text-align: justify;
}

div#exhibition-hall {
    width: 1160px;
    margin: 0px auto;
    padding-top: 36px;
}

.artwork .cover img {
    width: 100%;
    display: block;
    transition: transform 0.2s;
}

.artwork .cover {
    width: 520px;
    overflow: hidden;
}

.artwork:hover .cover img {
	transform: scale(1.02);
}

.artwork {
    padding: 18px 30px;
    display: block;
}

.artwork p {
    padding: 12px 0px;
    font: normal normal normal 12px/20px EB Garamond, 'notoserifcjktc';
    letter-spacing: 0.6px;
    display: inline-block;
}

.artwork p::after {
	display: block;
	content:'.';
	text-indent: -9999px;
	height:1px;
	width:0px;
	background:#fff;
	transition: width 0.2s;
}

.artwork:hover p::after {
	width:100%;
}

.progress-bar {
    padding: 8px 0px;
    width: 1100px;
    margin:36px auto 0px;
}

.progress-bar.fixed {
    position: fixed;
    bottom: 0px;
    left: 50%;
    margin: 0px 0px 0px -550px;
    z-index: 99999;
    background: #fff;
    display: none;
}

.progress-bar a div:last-child {
    float: left;
    padding-left: 28px;
}

.progress-bar a:hover div:last-child {
	color:#A0A0A0;
}

.t3 {
    letter-spacing: 0.3px; 
    font: normal normal 400 12px/20px EB Garamond, 'notoserifcjktc';
}

.progress-bar > .t3 {
    float: left;
    position: absolute;
    left: 50%;
    margin-left: -39px;
}

.progress-bar > div:last-child {
    float: right;
}

.progress-bar .percent {
    margin-left: 6px;
    float:left;
}

.progress-bar .bar {
    width: 100px;
    border-top: 1px solid #fff;
    border-bottom: 1px solid #fff;
    /* height: 2px; */
    float: left;
    margin: 10px 0px;
    position: relative;
    z-index:1;
}

.progress-bar .bar-2 {
    display: block;
    position: absolute;
    top:-1px;
    right:0px;
    width: 0px;
    border-top: 1px solid #000;
    border-bottom: 1px solid #000;
    z-index:10;
}



@media screen and (max-width: 1099px) {
	/*** 共用 ***/
	._mobile {
		display: block !important;
	}

	._desktop {
		display: none !important;
	}

	#main-container {
		margin:0 auto;
		max-width:414px;
	}

	#sponsors {
	
	}

	#sponsors-inner {
		width:320px;
		margin:0 auto;
		border-radius: 30px;
	}

	#footer {
		padding:16px 0px 60px;
		margin:0px;
		background: #000;
	}

	.copyright {
		width: auto;
	}

	#footer .copyright {
		color:#FFF;
		padding:0px 20px;
		font: 400 14px/22px EB Garamond;
		letter-spacing: 0.7px;
	}

	#footer .copyright br {
		display: none;
	}
	/*** 共用 ***/

	.topbar {
	    width: 360px;
	    margin-top: 36px;
	    position: relative;
	    padding: 0px 8px;
	}

	.topbar a div:nth-child(2) {
	    float: none;
	    padding-left: 0px;
	    padding-top: 4px;
	}

	.topbar .iconset-22.arrow, .progress-bar .iconset-22.arrow {
	    float: none;
	}

	.topbar>div {
	    position: absolute;
	    right: 8px;
	    top: 0px;
	}

	.intro {
	    width: 360px;
	    margin-top: 48px;
    	margin-bottom: 60px;
    	padding: 0px 8px;
	}

	div#exhibition-hall {
	    width: 360px;
	    padding-bottom:60px;
	}

	.intro .t2 {
	    width: 280px;
	    position: static;
	    padding: 28px 0px;
	    margin-top:28px;
	}

	.intro h1 {
	    width: 100%;
	    margin-top: 6px;
	    font: normal normal 500 30px/40px 'notoserifcjktc';
	    letter-spacing: 1.5px;
	}

	.intro h4 {
	    position: static;
	    margin-top: 56px;
	}

	.artwork .cover {
	    width: 344px;
	}

	.artwork {
	    padding: 18px 8px;
	}

	.progress-bar {
		padding:16px 8px 20px;
	    width: 360px;
	    margin:0 auto;
	    position: relative;
	}

	.progress-bar.fixed {
    	margin: 0px 0px 0px -180px;
    	display: none;
	}

	.progress-bar .bar {
	    width: 60px;
	}

	.progress-bar>div:last-child {
	    position: absolute;
	    right: 8px;
	    top: 16px;
	}

}

</style>

<script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js"></script>

<div class="page-container">
	<div class="intro">
		<div>
			<div class="clearfix">
				<h1><?php single_term_title(); ?></h1>
			</div>
		</div>
		<div class="t2"><?php echo term_description(); ?></div>
	</div>

	<div id="exhibition-hall" class="clearfix">
		<?php while( $query->have_posts() ) : $query->the_post(); ?>
		<a class="artwork defer-link" href="<?php the_permalink(); ?>?so=hall-1">
			<div class="cover">
				<img class="lazyload" data-src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' )[0]; ?>" width="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' )[1]; ?>" height="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' )[2]; ?>" />
			</div>
			<p><?php the_title(); ?></p>
		</a>

		<?php endwhile; ?>
	</div>

	<div class="progress-bar clearfix fixed">
		<div><div class="bar"><div class="bar-2"></div></div><div class="percent t3">0 %</div></div>
	</div>
	<div class="progress-bar clearfix bottom">
		<div><div class="bar"><div class="bar-2"></div></div><div class="percent t3">0 %</div></div>
	</div>

</div>


</div> <!-- #main-container end -->

</div> <!-- .site-container end -->

<script type="text/javascript">
jQuery(document).ready(function() {
	let images = document.querySelectorAll(".lazyload");
	new LazyLoad(images, {
	    root: null,
	    rootMargin: "0px 0px 500px 0px",
	    threshold: 0
	});

	jQuery('.lazyload').each(function(){
		var h = jQuery(this).attr('height');
		var w = jQuery(this).attr('width');

		var vw = 520;
		if ( jQuery(window).width() < 1100 ) {
			vw = 344;
		}
		
		var vh = ( vw / w ) * h;
		jQuery(this).height(vh + 'px');
	});

	var cw = 580;
	if ( jQuery(window).width() < 1100 ) {
		cw = 360;
	}

	jQuery('#exhibition-hall').masonry({
  		// options
  		itemSelector: '.artwork',
  		columnWidth: cw
	});
	
	jQuery(window).on('scroll', function(){
		var con = parseInt( jQuery(window).scrollTop() ) + parseInt( jQuery(window).height() ) <= jQuery('.progress-bar.bottom').offset().top + jQuery('.progress-bar.bottom').outerHeight();
		if ( jQuery(window).scrollTop() >= 100 && con ) {
			jQuery('.progress-bar.fixed').show();
		} else {
			jQuery('.progress-bar.fixed').hide();
		}
		calculate_progress();
	});

	let url_string = window.location.href;
	let url = new URL(url_string);
	if ( url.searchParams.get("st") ) {
		jQuery(window).scrollTop(url.searchParams.get("st"));
	}

	jQuery('.back-button').click(function(){
		event.preventDefault();
		window.location = '/the-void-of-22-4-showroom/#hall-1';
	});

	jQuery('.defer-link').click(function(){
		event.preventDefault();

		var	st = jQuery(window).scrollTop();
		window.location = jQuery(this).attr('href') + '&st=' + st;
	});
});

function calculate_progress() {
	var h = jQuery('body').height();
	var cp = parseInt( jQuery(window).scrollTop() ) + parseInt( jQuery(window).height() );
	var p  = parseInt( ( cp / h ) * 100 );
	if ( p > 100) {
		p = 100;
	}
	jQuery('.progress-bar .percent').text(p + ' %');

	if ( jQuery(window).width() < 1100 ) {
		p = p * 0.6;
	}
	jQuery('.progress-bar .bar-2').css('width', p + 'px' );
}

</script>


<?php get_footer(); ?>