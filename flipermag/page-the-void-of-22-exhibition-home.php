<?php

/* Template Name: The Void of 22 Exhibition Home */

remove_action('wp_head', '_admin_bar_bump_cb');

get_header();

?>

<style>
.iconset {
	background-size: 1000px !important;
	background:url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/the_void_of_22_exhibition/0621-icon@2x.png);
}

body {
	background: #000;
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

#footer {
	padding:16px 0px 60px;
	margin:0px;
	background: #000;
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

.page-container * {
	box-sizing: border-box;
}

#main-container {
	margin:0 auto;
	max-width:414px;
	background: #000;
}

.hero-image {
	margin-bottom:16px;
}

.hero-image img {
	width: 100%;
	display: block;
}

.desktop {
	display: none !important;
}

.header-section {
	padding:20px 0px 60px;
}

.header-section-inner {
	width:360px;
	margin:0 auto;
	padding:0px 8px;
	position: relative;
}

.header-section h1 {
	color: #fff;
	font: 500 30px/40px EB Garamond;
	letter-spacing: 1.5px;
	padding:28px 0px;
}

.header-section h3 {
	padding:16px 0px 40px;
	font: 400 16px/24px EB Garamond;
	letter-spacing: 0.8px;
	color: #FFFFFF;
}

.header-section p {
	padding:16px 0px;
	letter-spacing: 0.7px;
	color: #FFFFFF;
	font: 400 14px/24px EB Garamond, "notoserifcjktc";
}


.header-section-inner .by-fliper {
	position: absolute;
	top:28px;
	right:8px;
	color:#fff;
	font: 400 14px/24px EB Garamond;
	letter-spacing: 0.35px;
}

.by-fliper .iconset.fliper-logo {
	width: 44px;
    height: 20px;
    float: right;
    background-position: -42px -163px;
    margin-left:4px;
    margin-top:2px;
}

.header-section .action-button {
	width: 344px;
	height: 36px;
	margin:36px auto;
	display: block;
	border: 1px solid #FFFFFF;
	background: #000;
	color:#fff;
	text-align: center;
	font: 400 18px/36px EB Garamond;
	letter-spacing: 0.45px;
}

#gjun-banner {
	width:360px;
	margin:0px auto 40px;
	padding:24px 0px 20px;
}

#sponsors {
	
}

#sponsors-inner {
	width:320px;
	margin:0 auto;
	/*background: #FFFFFF;*/
	border-radius: 30px;
}

#retrospect {
	display: block;
	padding:40px 0px 100px;
	width:360px;
	margin:0 auto;
}

#retrospect div {
	padding:12px 0px;
	position: relative;
}

#retrospect div:first-child {
	margin-top:20px;
}

#retrospect div.iconset.arrow {
	background-position: 0px -213px;
	width:28px;
	height: 50px; 
	margin-left:auto;
	margin-right:auto;
}

#retrospect div, #retrospect a {
	text-align: center;
	color:#fff;
	letter-spacing: 0.4px;
	font: 400 16px/28px "EB Garamond", 'notoserifcjktc';
}

#retrospect a:hover {
	color:#A0A0A0;
}

#retrospect div span {
	font: 400 12px/20px EB Garamond;
	letter-spacing: 0.3px;
	text-align:center;
	display: block;
}

.gjun-wording h3 {
	font: normal normal normal 14px/22px "EB Garamond", 'notoserifcjktc';
	letter-spacing: 0.7px;
	color: #FFFFFF;
	position: absolute;
    right: 0px;
    top: 0px;
}

.gjun-wording h5 {
	font: normal normal normal 20px/28px "EB Garamond", 'notoserifcjktc';
	letter-spacing: 1px;
	color: #FFFFFF;
}

.gjun-wording .t3 {	
	font: normal normal normal 14px/24px "EB Garamond", 'notoserifcjktc';
	letter-spacing: 0.7px;
	color: #FFFFFF;
	text-align: justify;
}

.gjun-wording {
    width: 360px;
    margin: 0 auto;
    padding: 20px 8px 24px;
}

.gjun-wording .left-wording {
    position: relative;
    padding-bottom: 30px;
}

@media screen and (min-width: 1100px) {

	body {
		padding-top:0px;
	}

	.mobile {
		display: none !important;
	}

	.desktop {
		display: block !important;
	}

	#main-container {
		max-width: 100%;
		margin-top:0px;
	}

	.hero-image {
		margin-bottom: 0px;
		z-index:10;
		background: #000;
		position: relative;
	}

	.hero-image .desktop {
		max-width: 1366px;
		margin: 0px auto 120px;
		position: relative;
		z-index: 10;
	}

	.header-section {
		padding:0px 0px 120px;
	}

	.header-section-inner {
		width:1100px;
		padding:0px 242px;
	}

	.header-section-inner .by-fliper {
		position: absolute;
		top:12px;
		right:242px;
		color:#fff;
		font: 400 14px/24px EB Garamond;
		letter-spacing: 0.35px;
	}

	.by-fliper .iconset.fliper-logo {
		width: 44px;
	    height: 20px;
	    float: right;
	    background-position: -42px -163px;
	    margin-left:4px;
	    margin-top:2px;
	}

	.header-section h1 {
		font: 500 32px/42px "EB Garamond";
		letter-spacing: 1.6px;
		padding:12px 0px;
		color:#fff;
	}

	.header-section h3 {
		padding:12px 0px 44px;
		font: 400 20px/28px EB Garamond;
		letter-spacing: 1px;
		color: #FFFFFF;
	}

	.header-section p {
		padding:24px 0px;
		letter-spacing: 0.35px;
		color: #FFFFFF;
		font: 400 14px/24px EB Garamond, "notoserifcjktc";
	}

	.header-section .action-button {
		width: 180px;
		height: 36px;
		margin:20px auto;
		display: block;
		border: 1px solid #FFFFFF;
		background: #000;
		color:#fff;
		text-align: center;
		font: 400 18px/36px EB Garamond;
		letter-spacing: 0.45px;
	}

	.header-section .action-button:hover {
		color: #A0A0A0;
		border: 1px solid #A0A0A0;
	}

	#gjun-banner {
		width:616px;
		margin:0px auto;
		padding:0px 0px 100px;
	}

	#gjun-banner a {
		display: block;
	}

	#gjun-banner a:hover {
		opacity: 0.8;
	}

	#gjun-banner .desktop {
		max-width: 900px;
		width:100%;
		display: block;
		
	}

	#sponsors {
		padding:32px 0px;
	}

	#sponsors-inner {
		width:1100px;
	}

	#retrospect {
		display: block;
		padding:32px 0px;
		width:1100px;
		margin:0 auto;
	}

	#retrospect div {
		padding:0px 12px;
		margin-top:20px;
		float:left;
		position: relative;
	}

	#retrospect div:first-child {
		padding-left:0px;
	}

	#retrospect div:last-child {
		padding-right:0px;
	}

	#retrospect div.iconset.arrow {
		background-position: 0px -184px;
		width:834px;
		height: 28px; 
	}

	#retrospect div, #retrospect a {
		text-align: left;
		color:#fff;
		letter-spacing: 0.4px;
		font: 400 16px/28px "EB Garamond", 'notoserifcjktc';
	}

	#retrospect a:hover {
		color:#A0A0A0;
	}

	#retrospect div span {
		font: 400 12px/20px EB Garamond;
		letter-spacing: 0.3px;
		float:right;
		position: absolute;
		right:12px;
		top:-20px;
		text-align: left;
	}

	#retrospect div:last-child span {
		right:0px;
	}

	#footer .copyright {
		padding:0px;
	}

	.gjun-wording {
		padding:32px 20px 34px;
		width: 616px;
	}	

	.gjun-wording .left-wording {
		padding:7px 55px 7px 0px;
		width:170px;
		float:left;
	}

	.gjun-wording .right-wording {
		border-left:1px solid #fff;
		padding:12px 0px 12px 55px;
		width:405px;
		float:left;
	}

	.gjun-wording h3 {
		position: static;
	}

	.gjun-wording .t3 {
		font: normal normal normal 12px/20px "EB Garamond", 'notoserifcjktc';
		letter-spacing: 0.3px;
		color: #FFFFFF;
		text-align: justify;
	}

}

</style>

<div class="page-container">
	<div class="hero-image">
		<img class="mobile" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/the_void_of_22_exhibition/'; ?>Vi_Design-mobile@2x.png" />
		<img class="desktop" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/the_void_of_22_exhibition/'; ?>Vi_Design-Web@2x.png" />
	</div>

	<div class="header-section">
		<div class="header-section-inner">
			<div class="by-fliper">By <div class="iconset fliper-logo"></div></div>
			<h1>The Void of 22</h1>
			<h3>About <br class="mobile" />Exhibition</h3>
			<p>還記得 22 歲的自己，是什麼樣子嗎？那是一個極度強韌，又極度脆弱的年紀。當時的我們，帶著無數個理想以及想像邁開步伐離開了校園，殊不知名為人生的遊戲，才即將開始。 Void ，擁有空白，失落的意思，正如畢業給人既振奮，卻又不安的情緒。它同時乘載了不見底的抽象空間之意，一切雖然看似虛無，卻實然擁有無遠弗界的可能。<br/><br/>FLiPER 從去年開始舉辦 22 線上展，今年更將展覽對象從設計更改為創作，淡化展覽的理性元素，增加多一些感性基調。希望可以透過這樣的機會，讓更多元的作品，被更多人看到。<br/><br/>今年收錄共來自「80」個系所的「324」件作品，且為了提供更完整的思考空間，我們首次劃分了四個展間，並利用了 Void 的抽象空間之含義，將四大展間命名為四種不同的空間，分別為 「派對現場」、「 夢境長廊」、「共生之島」、「日記工廠」。希望讀者在每進入一個空間後，都可以擁有更完整的觀展視角，能快速進入屬於這些靈魂對生命的愛戀、想像、思考，以及呢喃，並與之對話。<br/><br/></p>
			<a class="action-button" href="https://flipermag.com/the-void-of-22-4-showroom/">Enter</a>
		</div>
	</div>

	<div class="gjun-wording clearfix">
		<div class="left-wording">
			<h3>周邊活動</h3>
			<h5>匠🌟獨具賞</h5>
		</div>
		<div class="right-wording">
			<p class="t3">除了展覽本身以外，我們也邀請所有的讀者一同參與《匠🌟獨具賞》投票行列，趕快參與投票，支持你喜歡的作品吧！</p>
		</div>
	</div>

	<div id="gjun-banner">
		<a href="https://flipermag.com/artwork-related-event/pcschool-star-award-2021/"><img class="mobile" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/the_void_of_22_exhibition/'; ?>gjun-home-mobile-0702.png" /></a>
		<a href="https://flipermag.com/artwork-related-event/pcschool-star-award-2021/"><img class="desktop" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/the_void_of_22_exhibition/'; ?>gjun-home-web-0702.png" /></a>
	</div>
	
	<div id="sponsors">
		<div id="sponsors-inner">
			<img class="mobile" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/the_void_of_22_exhibition/logo-mobile_0422@2x.png'; ?>" usemap="#mobile-logo-map" />
			<map name="mobile-logo-map">
  				<area shape="rect" coords="40,75,125,105" href="https://flipermag.com" target="_blank" alt="FLiPER">
  				<area shape="rect" coords="190,80,310,105" href="https://www.pcschool.com.tw/design-college" target="_blank" alt="pcschool">
  				<area shape="rect" coords="40,200,100,255" href="https://www.facebook.com/nipelly" target="_blank" alt="nipelly">
  				<area shape="rect" coords="150,200,310,255" href="https://www.yodex.com.tw/" target="_blank" alt="YODEX">
			</map>
			<img class="desktop" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/the_void_of_22_exhibition/logo-web_0422@2x.png'; ?>" usemap="#desktop-logo-map" />
			<map name="desktop-logo-map">
  			<area shape="rect" coords="0,0,120,132" href="https://flipermag.com" target="_blank" alt="FLiPER">
  			<area shape="rect" coords="120,0,300,132" href="https://www.pcschool.com.tw/design-college" target="_blank" alt="pcschool">
  			<area shape="rect" coords="340,0,430,132" href="https://www.facebook.com/nipelly" target="_blank" alt="nipelly">
  			<area shape="rect" coords="430,0,700,132" href="https://www.yodex.com.tw/" target="_blank" alt="YODEX">
		</map>
		</div>
	</div>

	<div id="retrospect" class="clearfix">
		<div>Retrospect 回顧</div>
		<div class="iconset arrow"></div>
		<!-- <div><a href="#"><span>2021</span>The Void of 22 線上創作展</a></div> -->
		<div><a href="https://flipermag.com/22-online-design-exhibition/about/" target="_blank"><span>2020</span>__22 線上設計展</a></div>
	</div>
</div>


</div> <!-- #main-container end -->

</div> <!-- .site-container end -->


<?php get_footer(); ?>