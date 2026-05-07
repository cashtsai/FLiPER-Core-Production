<?php

/* Template Name: The Void of 22 Exhibition 4 Showroom */

remove_action('wp_head', '_admin_bar_bump_cb');

get_header();

?>

<style>
/*** 共用 ***/
.iconset {
	background-size: 1000px !important;
	background:url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/the_void_of_22_exhibition/0616_icon@2x.png);
}

body {
	padding-top:0px;
	background: #000;
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

#main-menu {
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
	color:#FFF;
	padding:16px 0px 60px;
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
    color: #FFFFFF;
}

h4 {
    letter-spacing: 0.8px;
    color: #A0A0A0;
    font:500 16px/24px 'notoserifcjktc';
}

.room-label {
	position: relative;
	z-index:10;
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
/*** 共用 ***/

.showroom {
    width: 850px;
    height: 480px;
    margin: 0 auto;
    position: relative;
}

.top-left-panel {
    position: absolute;
    width: 282px;
    height: 56px;
}

h3 a {
	display: block;
    width: 104px;
    color: #fff !important;
    font: 400 20px/28px EB Garamond;
    letter-spacing: 1px;
    float: left;
}

h3 a:hover {
	color: #A0A0A0 !important;
}

.cover {
	display: block;
	width: 360px;
	height: 360px;
	overflow: hidden;
}

.cover img {
    width: 100%;
}

.top-left-panel div {
    float: left;
    margin-left: 50px;
    font: italic normal normal 14px/22px EB Garamond;
    letter-spacing: 0.7px;
    color: #FFFFFF;
}

.room-1 .right-panel {
    position: absolute;
    right:0px;
    top:0px;
}

.room-1 .bottom-left-panel {
    position: absolute;
    left: 0px;
    bottom: 0px;
}

a.link-button {
    text-align: center;
    font: normal normal normal 18px/36px EB Garamond;
    letter-spacing: 0.45px;
    color: #FFFFFF;
    border: 1px solid #FFFFFF;
    width: 150px;
    display: block;
    margin-top: 50px;
}

a.link-button:hover {
	border: 1px solid #A0A0A0;
	color:#A0A0A0;	
}

.room-1 h1 {
	float:left;
	margin-top: 28px;
	width: 70px;
}

.room-1 .room-label {
	float: left;
	margin-top: 68px;
	margin-left: 16px;
}

#fp-nav.fp-right {
	right: 50%;
	margin-right:-550px;
}

#fp-nav.fp-right li:first-child span:last-child::before {
	content: "01";
}

#fp-nav.fp-right li:nth-child(2) span:last-child::before {
	content: "02";
}

#fp-nav.fp-right li:nth-child(3) span:last-child::before {
	content: "03";
}

#fp-nav.fp-right li:nth-child(4) span:last-child::before {
	content: "04";
}

#fp-nav.fp-right li span:last-child::before {
	color: #747474;
	font: normal normal normal 16px/24px EB Garamond;
	text-align: center;
	display: block;
	width:16px;
	height: 24px;
}

#fp-nav.fp-right li a.active span:last-child::before {
	color: #fff;
}

#fp-nav.fp-right li a:hover span:last-child::before {
	color:#A0A0A0;
}

#fp-nav.fp-right li {
	height:24px;
    width:16px;
    margin:42px 0px;
}

#fp-nav.fp-right li span:last-child {
    background: transparent;
    height:24px;
    width:16px;
}

#fp-nav.fp-right li:nth-child(5) {
	display: none;
}

#fp-nav ul li a.active span, #fp-nav ul li:hover span {
	margin:0px;
}

#fp-nav ul li a span {
	position: static;
	margin:0px;
}

#fp-nav .fp-sr-only {
	display: none;
}

.room-2 .middle-panel {
    position: absolute;
    left: 210px;
    bottom: 46px;
}

.room-2 .bottom-right-panel {
    position: absolute;
    right: 0px;
    bottom: 0px;
}

.room-2 h1 {
	margin-top:16px;
}

.room-2 h4 {
	margin-top:44px;
}

.room-3 .right-panel {
    position: absolute;
    right: 0px;
    top: 60px;
}

.room-3 .bottom-left-panel {
    position: absolute;
    left: 0px;
    bottom: 0px;
}

.room-3 h1 {
	margin-top:28px;
}

.room-3 h4 {
	position: absolute;
	left: 196px;
    bottom: 82px;
    width: 138px;
}

.room-4 .bottom-left-panel {
    position: absolute;
    left: 0px;
    bottom: 0px;
}

.room-4 .bottom-right-panel {
    position: absolute;
    right: 0px;
    bottom: 0px;
}

.room-4 a.link-button {
    margin-bottom: 110px;
    margin-left: 54px;
}

.room-4 h4 {
    width: 102px;
    text-align: right;
    margin-left: auto;
    margin-top:28px;
}

.room-4 h1 {
	width:70px;
	float:right;
}

.room-4 .room-label {
	float:left;
}


@media screen and (max-width: 1099px) {
	/*** 共用 ***/
	._mobile {
		display: block !important;
	}

	._desktop {
		display: none !important;
	}

	#footer {
		display: none;
	}

	#main-container {
		margin:0 auto;
		max-width:414px;
		background: #000;
	}

	#sponsors {
	
	}

	#sponsors-inner {
		width:320px;
		margin:0 auto;
		border-radius: 30px;
	}

	/*** 共用 ***/

	.showroom {
    	width: 360px;
    	height: 100%;
    	position: relative;
	}

	.top-left-panel div {
		display: none;
	}

	.top-left-panel {
		top:36px;
		left:50%;
		margin-left:-180px;
		width:360px;
		padding:0px 8px;
	}

	h3 a {
    	width: 112px;
    	font: 500 16px/24px EB Garamond;
    	letter-spacing: 0.8px;
	}

	.mobile-panel {
		width:344px;
		height: 420px;
		position: absolute;
		top:45%;
		margin-top:-210px;
		left:50%;
		margin-left:-172px;
	}

	.mobile-panel h4 {
		position: relative;
		z-index:10;
	}

	.cover {
		width: 200px;
		height: 200px;
		position: absolute;
		overflow: hidden;
	}

	.room-1 .cover {
		right:0px;
		bottom:0px;
	}

	a.link-button {
    	width: 100%;
    	position: absolute;
    	bottom: 0px;
    	margin: 40px 0px 36px;
	}

	h1 {
	    font: normal normal 500 30px/40px 'notoserifcjktc';
	    letter-spacing: 1.5px;
	    width: 67px !important;
	    margin-top: 0px !important;
	}

	.room-label div:first-child {
    	font: normal normal normal 38px/46px EB Garamond;
    	letter-spacing: 0.95px;
	}

	.room-label div:last-child {
    	margin-left: 4px;
    	margin-top: 10px;
    	font: normal normal normal 14px/14px EB Garamond;
	    letter-spacing: 0.35px;
	}

	.room-1 .room-label {
		margin-top: 0px;
		margin-left: 8px;
	}

	.room-1 h4 {
		margin-top:16px;
		width: 84px;
	}

	.mobile-navigation {
	    float: right;
	    padding-left: 36px;
	}

	.mobile-navigation li {
		float:left;
		padding-left:26px;
	}

	.mobile-navigation li a {
		color: #747474;
		font: normal normal normal 16px/22px EB Garamond;
	}

	.mobile-navigation li a.active {
		color:#fff;
	}

	.room-2 .cover {
		right:0px;
		top:0px;
	}

	.room-2 h4 {
	    position: absolute;
	    bottom: 0px;
	    left: 0px;
	}

	.room-2 h1 {
	    position: absolute;
	    bottom: 40px;
	    left: 0px;
	}

	.room-2 .room-label {
	    position: absolute;
	    left: 78px;
	    bottom: 75px;
	}

	.room-3 .cover {
	    right: 0px;
	    top: 0px;
	}

	.room-3 .room-label {
	    position: absolute;
	    bottom: 0px;
	    left: 0px;
	}

	.room-3 h1 {
	    position: absolute;
	    bottom: 54px;
	    left: 0px;
	}

	.room-3 h4 {
		position: absolute;
	    right: 0px;
	    left: unset;
	    bottom: 0px;
	}

	.room-4 h1 {
	    float: none;
	}

	.room-4 .room-label {
	    margin-top: 8px;
	}

	.room-4 h4 {
	    width: 136px;
	    position: absolute;
	    right: 0px;
	    top: 0px;
	    margin-top: 0px;
	}

	.room-4 .cover {
	    right: 0px;
	    bottom: 0px;
	}

	.room-4 a.link-button {
	    margin: 40px 0 36px;
	}

	.copyright {
		width: 360px;
	}

	.page-container {
		height: 0px;
	}

}

</style>

<script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js"></script>

<div class="page-container">
	<div id="fullpage">
		<div class="section">
			<div class="showroom room-1">
				<div class="top-left-panel">
					<h3><a href="/the-void-of-22-home/">The Void of 22</a></h3>
					<div>Creations Exhibition</div>
					<ul class="mobile-navigation clearfix _mobile">
						<li><a class="active" href="#" data-sec="hall-1">01</a></li>
						<li><a href="#" data-sec="hall-2">02</a></li>
						<li><a href="#" data-sec="hall-3">03</a></li>
						<li><a href="#" data-sec="hall-4">04</a></li>
					</ul>
				</div>
				<div class="bottom-left-panel _desktop">
					<h4>在記憶失控以前</h4>
					<div class="clearfix">
						<h1>派對現場</h1>
						<div class="room-label clearfix">
							<div>01</div>
							<div>Exhibition<br/>Room</div>
						</div>
					</div>
					<a class="link-button" href="https://flipermag.com/artwork-related-event/hall-1/">View</a>
				</div>
				<div class="right-panel _desktop">
    				<div class="cover">
						<img class="lazyload" data-src="<?php echo get_stylesheet_directory_uri() . '/assets/images/the_void_of_22_exhibition/hall-entry/1/'; ?>" />	
					</div>
				</div>
				<div class="mobile-panel _mobile">
					<div class="clearfix">
						<h1>派對現場</h1>
						<div class="room-label clearfix">
							<div>01</div>
							<div>Exhibition<br/>Room</div>
						</div>
					</div>
					<h4>在記憶失控以前</h4>
					
					<div class="cover">
						<img class="lazyload" data-src="<?php echo get_stylesheet_directory_uri() . '/assets/images/the_void_of_22_exhibition/hall-entry/1/'; ?>" />	
					</div>
				</div>
				<a class="link-button _mobile" href="https://flipermag.com/artwork-related-event/hall-1/">View</a>
			</div>
		</div>
		<div class="section">
			<div class="showroom room-2">
				<div class="top-left-panel">
					<h3><a href="/the-void-of-22-home/">The Void of 22</a></h3>
					<div>Creations Exhibition</div>
					<ul class="mobile-navigation clearfix _mobile">
						<li><a class="active" href="#" data-sec="hall-1">01</a></li>
						<li><a href="#" data-sec="hall-2">02</a></li>
						<li><a href="#" data-sec="hall-3">03</a></li>
						<li><a href="#" data-sec="hall-4">04</a></li>
					</ul>
				</div>
				<div class="bottom-right-panel _desktop">
					<div class="clearfix">
						<div class="room-label clearfix">
							<div>02</div>
							<div>Exhibition<br/>Room</div>
						</div>
						<h1>夢境長廊</h1>
					</div>
					<h4>他的世界</h4>
					<a class="link-button" href="https://flipermag.com/artwork-related-event/hall-2/">View</a>
				</div>
				<div class="middle-panel _desktop">
					<div class="cover">
						<img class="lazyload" data-src="<?php echo get_stylesheet_directory_uri() . '/assets/images/the_void_of_22_exhibition/hall-entry/2/'; ?>" />	
					</div>
				</div>

				<div class="mobile-panel _mobile">
					<div class="clearfix">
						<h1>夢境長廊</h1>
						<div class="room-label clearfix">
							<div>02</div>
							<div>Exhibition<br/>Room</div>
						</div>
					</div>
					<h4>他的世界</h4>
					
					<div class="cover">
						<img class="lazyload" data-src="<?php echo get_stylesheet_directory_uri() . '/assets/images/the_void_of_22_exhibition/hall-entry/2/'; ?>" />	
					</div>
				</div>
				<a class="link-button _mobile" href="https://flipermag.com/artwork-related-event/hall-2/">View</a>
			</div>
		</div>
		<div class="section">
			<div class="showroom room-3">
				<div class="top-left-panel">
					<h3><a href="/the-void-of-22-home/">The Void of 22</a></h3>
					<div>Creations Exhibition</div>
					<ul class="mobile-navigation clearfix _mobile">
						<li><a class="active" href="#" data-sec="hall-1">01</a></li>
						<li><a href="#" data-sec="hall-2">02</a></li>
						<li><a href="#" data-sec="hall-3">03</a></li>
						<li><a href="#" data-sec="hall-4">04</a></li>
					</ul>
				</div>
				<div class="bottom-left-panel _desktop">
					<div class="clearfix">
						<div class="room-label clearfix">
							<div>03</div>
							<div>Exhibition<br/>Room</div>
						</div>
						<h1>共生之島</h1>
					</div>
					<h4>天空、大海、以及那些與你的其他</h4>
					<a class="link-button" href="https://flipermag.com/artwork-related-event/hall-3/">View</a>
				</div>

				<div class="right-panel _desktop">
					<div class="cover">
						<img class="lazyload" data-src="<?php echo get_stylesheet_directory_uri() . '/assets/images/the_void_of_22_exhibition/hall-entry/3/'; ?>" />	
					</div>
				</div>

				<div class="mobile-panel _mobile">
					<div class="clearfix">
						<h1>共生之島</h1>
						<div class="room-label clearfix">
							<div>03</div>
							<div>Exhibition<br/>Room</div>
						</div>
					</div>
					<h4>天空、大海、以及那些與你的其他</h4>
					
					<div class="cover">
						<img class="lazyload" data-src="<?php echo get_stylesheet_directory_uri() . '/assets/images/the_void_of_22_exhibition/hall-entry/3/'; ?>" />	
					</div>
				</div>
				<a class="link-button _mobile" href="https://flipermag.com/artwork-related-event/hall-3/">View</a>
			</div>
		</div>
		<div class="section">
			<div class="showroom room-4">
				<div class="top-left-panel">
					<h3><a href="/the-void-of-22-home/">The Void of 22</a></h3>
					<div>Creations Exhibition</div>
					<ul class="mobile-navigation clearfix _mobile">
						<li><a class="active" href="#" data-sec="hall-1">01</a></li>
						<li><a href="#" data-sec="hall-2">02</a></li>
						<li><a href="#" data-sec="hall-3">03</a></li>
						<li><a href="#" data-sec="hall-4">04</a></li>
					</ul>
				</div>
				<div class="bottom-right-panel _desktop">
					<div class="clearfix">
						<div class="room-label clearfix">
							<div>04</div>
							<div>Exhibition<br/>Room</div>
						</div>
						<h1>日記工廠</h1>
					</div>
					<h4>一首稍顯過長的詩</h4>
					<a class="link-button" href="https://flipermag.com/artwork-related-event/hall-4/">View</a>
				</div>
				<div class="bottom-left-panel _desktop">
					<div class="cover">
						<img class="lazyload" data-src="<?php echo get_stylesheet_directory_uri() . '/assets/images/the_void_of_22_exhibition/hall-entry/4/'; ?>" />	
					</div>
				</div>

				<div class="mobile-panel _mobile">
					<div class="clearfix">
						<h1>日記工廠</h1>
						<div class="room-label clearfix">
							<div>04</div>
							<div>Exhibition<br/>Room</div>
						</div>
					</div>
					<h4>一首稍顯過長的詩</h4>
					
					<div class="cover">
						<img class="lazyload" data-src="<?php echo get_stylesheet_directory_uri() . '/assets/images/the_void_of_22_exhibition/hall-entry/4/'; ?>" />	
					</div>
				</div>
				<a class="link-button _mobile" href="https://flipermag.com/artwork-related-event/hall-4/">View</a>
			</div>
		</div>
		<div class="section fp-auto-height">
			<div id="sponsors" >
				<div id="sponsors-inner">
					<img class="_mobile" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/the_void_of_22_exhibition/logo-mobile_0422@2x.png'; ?>" usemap="#mobile-logo-map" />
					<map name="mobile-logo-map">
		  				<area shape="rect" coords="40,75,125,105" href="https://flipermag.com" target="_blank" alt="FLiPER">
		  				<area shape="rect" coords="190,80,310,105" href="https://www.pcschool.com.tw/design-college" target="_blank" alt="pcschool">
		  				<area shape="rect" coords="40,200,100,255" href="https://www.facebook.com/nipelly" target="_blank" alt="nipelly">
		  				<area shape="rect" coords="150,200,310,255" href="https://www.yodex.com.tw/" target="_blank" alt="YODEX">
					</map>
					<img class="_desktop" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/the_void_of_22_exhibition/logo-web_0422@2x.png'; ?>" usemap="#desktop-logo-map" />
					<map name="desktop-logo-map">
		  			<area shape="rect" coords="0,0,120,132" href="https://flipermag.com" target="_blank" alt="FLiPER">
		  			<area shape="rect" coords="120,0,300,132" href="https://www.pcschool.com.tw/design-college" target="_blank" alt="pcschool">
		  			<area shape="rect" coords="340,0,430,132" href="https://www.facebook.com/nipelly" target="_blank" alt="nipelly">
		  			<area shape="rect" coords="430,0,700,132" href="https://www.yodex.com.tw/" target="_blank" alt="YODEX">
				</map>
				</div>
			</div>

			<div class="copyright">© 2021 FLiPER Creative Inc. All Rights Reserved.</div>
		</div>
	</div>	
</div>


</div> <!-- #main-container end -->

</div> <!-- .site-container end -->

<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery('.cover img').each(function(){
		var h = jQuery(this).attr('data-src');
		var i = Math.floor(Math.random() * 5 ) + 1;
		h = h + i + '.png';
		jQuery(this).attr('data-src', h);
	});
	
	let images = document.querySelectorAll(".lazyload");
	new LazyLoad(images, {
	    root: null,
	    rootMargin: "0px 0px 500px 0px",
	    threshold: 0
	});

	jQuery('#fullpage').fullpage({
		//options here
		autoScrolling:true,
		navigation: true,
		scrollHorizontally: true,
		setFitToSection: true,
		anchors:['hall-1', 'hall-2', 'hall-3', 'hall-4'],
		licenseKey: 'DE2F833D-C799410B-84551C22-6E41CB64',

		afterLoad: function(origin, destination, direction){
			var loadedSection = this;

			jQuery('.mobile-navigation a').removeClass('active');
			jQuery('.mobile-navigation a').each(function(){
				var mi = destination.index + 1;
				mi = 'hall-' + mi;
				if ( mi == jQuery(this).attr('data-sec') ) {
					jQuery(this).addClass('active');
				}
			});
		}
	});

	//methods
	jQuery.fn.fullpage.setAllowScrolling(true);

	jQuery('.mobile-navigation a').click(function(){
		event.preventDefault();
		var index = jQuery(this).attr('data-sec');
		fullpage_api.moveTo(index);
		jQuery('.mobile-navigation a').removeClass('active');
		jQuery('.mobile-navigation a').each(function(){
			if ( index == jQuery(this).attr('data-sec') ) {
				jQuery(this).addClass('active');
			}
		});
	});
});

jQuery(window).load(function(){
	jQuery('.mobile-panel').each(function(){
		var e = jQuery(this).parent().find('.top-left-panel');
		var tl = e.offset().top + e.outerHeight();
		if ( tl > jQuery(this).offset().top ) {
			var m = jQuery(this).parent().offset().top;
			tl = parseInt( tl ) - parseInt( m );
			jQuery(this).css('top', tl + 'px');
			jQuery(this).css('margin-top', '0px');
		}

		var be = jQuery(this).parent().find('.link-button._mobile');
		var bl = parseInt( be.offset().top ) - 40;
		if ( jQuery(this).offset().top + jQuery(this).outerHeight() > bl ) {
			var ho = parseInt(jQuery(this).offset().top) + parseInt(jQuery(this).outerHeight()) - bl;
			var h = jQuery(this).height() - ho;
			jQuery(this).height(h);
		}
	});
});

</script>


<?php get_footer(); ?>