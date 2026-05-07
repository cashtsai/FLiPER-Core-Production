<?php

remove_action('wp_head', '_admin_bar_bump_cb');

get_header();

$query = new WP_Query( array(
	'tax_query' => array(
        array(
            'taxonomy' => 'artwork_related_event',
            'field'    => 'slug',
            'terms'    => 'pcschool-star-award-2021',
        ),
    ),
    'post_type' => 'fliper_artwork',
    'posts_per_page' => -1
) );

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

#footer .copyright {
	padding:0px;
	color:#FFF;
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
    font: normal normal 500 32px/42px EB Garamond, 'notoserifcjktc';
    letter-spacing: 1.6px;
    color: #FFFFFF;
}

h2 {
	font: normal normal 500 28px/40px EB Garamond, 'notoserifcjktc';
	letter-spacing: 1.4px;
	color: #FFFFFF;
}

h3 {
    font: normal normal 500 20px/28px EB Garamond, 'notoserifcjktc';
    letter-spacing: 1px;
    color: #FFFFFF;
}

h4 {
    letter-spacing: 0.8px;
    color: #A0A0A0;
    font:500 16px/24px EB Garamond, 'notoserifcjktc';
}

h5 {
	font: normal normal normal 14px/22px EB Garamond, 'notoserifcjktc';
	letter-spacing: 0.7px;
	color: #FFFFFF;
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
}

.t3 {
	font: normal normal 400 12px/20px EB Garamond, 'notoserifcjktc';
	letter-spacing: 0.3px;
	color: #FFFFFF;
}

html {
    scroll-behavior: smooth;
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

.topbar .iconset.arrow, .progress-bar .iconset.arrow {
    width: 96px;
    float: left;
    height: 22px;
    background-position: -99px -34px;
}

.topbar a:hover .iconset.arrow, .progress-bar a:hover .iconset.arrow {
	background-position: -200px -34px;
}

.topbar div, .progress-bar div {
	font: normal normal normal 14px/22px EB Garamond;
    letter-spacing: 0.7px;
    color: #FFFFFF;
}

.topbar > div {
    float: right;
}

.topbar a div:nth-child(2) {
    float: left;
    padding-left: 28px;
}

.hero-image {
	width:1100px;
	margin:40px auto;
}

.hero-image img {
	width:100%;
	display: block;
}

.intro {
    margin: 0px auto;
    padding:40px 90px 50px;
    width: 1100px;
    position: relative;
}

.intro h5 {
	padding:12px 0px;
}

.intro h4 {
    position: absolute;
    left: 180px;
    top: 0px;
    width: 84px;
}

.intro h3 {
	padding: 8px 0px;
}

.intro h1 {
	padding:8px 0px;
}

.intro-inner > div:nth-child(2) {
	padding:16px 0px;
	width:242px;
	float:left;
}

.intro .t2 {
    width: 550px;
    float: right; 
    padding:24px 0px 30px;
    text-align: justify;
}

#rating-now {
	width:1100px;
	margin:0 auto;
	padding:40px 90px 50px;
}

#rating-now-inner {
	width:920px;
	height: 360px;
}

.voting-arrangement {
	width:1100px;
	margin:0 auto;
	padding:40px 0px 50px;
}

.voting-arrangement-inner {
	width: 100%;
	padding:100px 175px;
	background: #C7C7C7;
	border-radius: 20px;
}

.voting-arrangement-inner h2, 
.voting-arrangement-inner h4,
.voting-arrangement-inner h5,
.voting-arrangement-inner .t2,
.voting-arrangement-inner .t3 {
	color:#1A1A1A;
}

.voting-arrangement-inner h2 {
	margin: 16px 0px 8px;
}

.voting-arrangement-inner .header-title {
	padding-bottom:36px;
}

.voting-arrangement-inner .dl {
	padding:16px 0px 36px;
}

.voting-arrangement-inner .dl h4 {
	float:left;
}

.voting-arrangement-inner .dl .t2 {
	width: 500px;
	float:right;
}

.voting-arrangement-inner .hr {
	border-top: 1px solid #707070;
	width: 900px;
	margin:50px -75px;
}

.award-table {
    padding: 16px 0px 36px;
}

.award-table h4,
.award-table .t3 {
	text-align: center;
}

.award-title,
.first-style,
.second-style {
    border-bottom: 1px solid #707070;
}

.award-table .award-title > div,
.award-table .first-style > div,
.award-table .second-style > div {
	float: left;
}

.award-table .award-title > div,
.award-table .first-style > div,
.award-table .second-style > div {
	width: 168px;
	padding:20px 14px;
}

.award-table .award-title div.big {
	height:88px;
	display: flex;
  	justify-content: center;
  	align-items: center;
}

.award-table .first-style > div {
	height: 100px;
	display: flex;
  	justify-content: center;
  	align-items: center;
}

.award-table .award-title > div:first-child,
.award-table .first-style > div:first-child,
.award-table .second-style > div:first-child {
    width: 78px;
}

.award-table .award-title > div:first-child {
	height: 1px;
}

.award-table .second-style > div:nth-child(2) {
	width:672px;
}

.award-rules {
	padding:36px 0px;
}

.voting-arrangement-inner .award-rules .t3 {
	color: #4B4B4B;
}

.go-vote {
    padding-top: 36px;
    text-align: center;
}

.go-vote .iconset.arrow {
    width: 24px;
    height: 40px;
    margin: 0 auto;
    background-position: 0px -81px;
    margin-top: 16px;
    display: block;
}

.go-vote .iconset.arrow:hover {
	background-position: -25px -81px;
}

.exhibition-hall-title-wrap {
	width:1100px;
	margin:0px auto;
	padding:16px 0px 36px;
	position: relative;
}

.exhibition-hall-title-wrap h5 {
	margin-top:8px;
}

div#exhibition-hall {
    width: 1128px;
    margin: 0px auto;
    padding: 36px 0px;
}

.artwork {
    padding: 14px;
    display: block;
}

.artwork .cover {
    width: 254px;
    overflow: hidden;
}

.artwork .cover img {
    width: 100%;
    display: block;
    transition: transform 0.2s;
}

.artwork:hover .cover img {
	transform: scale(1.02);
}

.artwork p {
    padding: 10px 0px;
    font: normal normal normal 12px/20px EB Garamond, 'notoserifcjktc';
    letter-spacing: 0.6px;
    color: #FFFFFF;
    display: inline-block;
    max-width:254px;
    overflow: hidden;
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

.search-wrap {
    width: 208px;
    position: absolute;
    top: 24px;
    right: 0px;
}

.search-wrap input.search-input {
    width: 180px;
    background: #000;
    border: 0px;
    border-bottom: 1px solid #fff;
    text-align: right;
    font: normal normal normal 14px/24px EB Garamond, 'notoserifcjktc';
    letter-spacing: 0.35px;
    color: #747474;
    padding: 0px 8px 0px 0px;
    padding-left:22px;
}

.search-wrap input.search-input::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
  	color: #747474;
  	opacity: 1; /* Firefox */
}

.search-wrap input.search-input:-ms-input-placeholder { /* Internet Explorer 10-11 */
  	color: #747474;
}

.search-wrap input.search-input::-ms-input-placeholder { /* Microsoft Edge */
  	color: #747474;
}

.iconset.search-icon {
    width: 24px;
    height: 24px;
    float: right;
    background-position: -403px -33px;
    cursor: pointer;
    margin-top:1px;
}

.rating-tab-menu h4 {
    float: left;
    border: 1px solid #fff;
    padding: 18px 28px;
    margin-right: 16px;
    border-radius: 20px 20px 0px 0px;
    z-index: 10;
    position: relative;
    color: #747474;
    cursor: pointer;
    background: #000;
    float: right;
}

.rating-tab-menu {
    float: right;
}

.rating-tab-menu h4.active {
    color: #fff;
    border-bottom: 1px solid #000;
}

.rating-tab-menu h4:hover {
    color: #A0A0A0;
}

.rating-tab-panel {
    width: 922px;
    height: 300px;
    padding: 54px 52px;
    border:  1px solid #fff;
    border-radius: 5px;
    display: none;
    float:left;
    position: relative;
    z-index: 1;
    top: -1px;
}

.rating-tab-panel-label > div {
    font: normal normal 500 28px/40px 'notoserifcjktc';
    letter-spacing: 1.4px;
    color: #FFFFFF;
    margin-bottom: 20px;
    margin-top: 24px;
}

.rating-tab-panel-label {
    width: 60px;
    float:left;
}

.rating-tab-panel-artwork {
    float: left;
    margin-left: 68px;
    width: 165px;
    display: block;
}

.rating-tab-panel-artwork.first {
    width: 206px;
    margin-left: 82px;
}

.rating-tab-panel-artwork.first img {
    width: 140px;
    height: 140px;
}

.rating-tab-panel-artwork img {
    height: 100px;
    width: 100px;
    display: block;
    float:left;
}

.rating-tab-panel-artwork-cover {
    margin-top: 40px;
    position: relative;
}

.rating-tab-panel-artwork.first .rating-tab-panel-artwork-cover {
    margin-top: 0px;
}

.rating-tab-panel-artwork-cover div:nth-child(2) {
    text-align: right;
    letter-spacing: 0.3px;
    color: #FFFFFF;
    font: 500 12px/24px EB Garamond, 'notoserifcjktc';
    position: absolute;
    bottom: 24px;
    right: 0px;
}

.rating-tab-panel-artwork.first .rating-tab-panel-artwork-cover div:nth-child(2) {
    bottom: 32px;
}

.rating-tab-panel-artwork-cover div:nth-child(3) {
    font: normal normal 500 16px/24px EB Garamond, 'notoserifcjktc';
	letter-spacing: 0.4px;
    color: #FFFFFF;
    position: absolute;
    right: 0px;
    bottom: 0px;
}

.rating-tab-panel-artwork.first .rating-tab-panel-artwork-cover div:nth-child(3) {
    font: normal normal 500 24px/32px EB Garamond, 'notoserifcjktc';
    letter-spacing: 0.6px;
}

.rating-tab-panel-artwork-wrap p {
    margin-top: 16px;
    height: 36px;
    overflow: hidden;
    font: normal normal normal 12px/18px Noto Serif CJK TC;
    letter-spacing: 0.3px;
    color: #FFFFFF;
}

.rating-tab-panel-artwork:hover p {
	color: #A0A0A0;
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
		background: #000;
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

	h1 {
	    font: normal normal 500 30px/40px 'notoserifcjktc';
	    letter-spacing: 1.5px;
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

	.topbar .iconset.arrow, .progress-bar .iconset.arrow {
	    float: none;
	}

	.topbar>div {
	    position: absolute;
	    right: 8px;
	    top: 0px;
	    text-align: right;
	}

	.hero-image {
		width: 360px;
		padding:16px 8px 20px;
		margin-top:20px;
		margin-bottom:16px;
	}

	.intro {
	    width: 360px;
	    padding: 0px 8px;
	    margin-bottom:60px;
	}

	.intro h1, .intro h4, .intro h5 {
		padding:5px 0px;
	}

	.intro h5 {
	    padding: 5px 0px;
	}

	.intro .t2 {
		width:100%;
		padding:16px 0px;
	}

	#rating-now {
		width:360px;
		padding:20px 8px 60px;
	}

	#rating-now-inner {
		width:100%;
		height: auto;
	}

	.voting-arrangement {
		width:100%;
		margin:0 auto;
		padding:20px 0px 60px;
	}

	.voting-arrangement-inner {
		width: 100%;
		padding:60px 0px 80px;
	}

	.voting-arrangement-inner h2 {
		width:310px;
		margin: 16px auto 8px;
	}

	.voting-arrangement-inner h5 {
		width:310px;
		margin:0 auto;
	}

	.voting-arrangement-inner .dl h4 {
		width:310px;
		margin:0 auto 12px;
		float:none;
	}

	.voting-arrangement-inner .dl .t2 {
		width: 310px;
		margin:0 auto;
		float:none;
	}

	.voting-arrangement-inner .hr {
		border-top: 1px solid #707070;
		width: 360px;
		margin:50px auto;
	}

	.award-table .award-table-inner {
	    width: 360px;
	    margin: 0 auto;
	    padding: 16px 25px 36px;
	}

	.award-table .award-table-inner h4 {
	    text-align: left;
	    margin-bottom: 12px;
	}

	.voting-arrangement-inner .award-table-inner .dl {
	    padding: 8px 0px;
	}

	.award-title,
	.first-style,
	.second-style {
	    border-bottom: 0px;
	}

	.award-table h4, .award-table .t3 {
	    text-align: left;
	}

	.t3 {
	    font: normal normal 400 14px/24px EB Garamond,'notoserifcjktc';
	    letter-spacing: 0.7px;
	}

	.voting-arrangement-inner .award-table-inner .dl div:first-child {
	    width: 60px;
	    float: left;
	}

	.voting-arrangement-inner .award-table-inner .dl div:last-child {
	    width: 220px;
	    float: right;
	}

	.award-rules {
	    padding-top: 0px;
	}

	.voting-arrangement-inner .award-rules .t3 {
	    width: 310px;
	    margin: 0 auto;
	}

	.award-rules {
	    padding-top: 0px;
	}

	.voting-arrangement-inner .award-rules .t3 {
	    width: 310px;
	    margin: 0 auto;
	}

	.exhibition-hall-title-wrap {
	    width: 360px;
	    padding: 16px 8px;
	}

	div#exhibition-hall {
	    padding: 20px 8px 60px;
	    width: 376px;
	}

	.artwork {
	    padding: 10px 8px;
	}

	.artwork .cover {
	    width: 164px;
	}

	.artwork .cover img {
		width: 100%;
	}

	.artwork p {
	    padding: 8px 0px;
	    overflow: hidden;
	    max-width:164px;
	}

	.intro-inner > div:nth-child(2) {
		padding:0px 0px 16px;
		width:100%;
		float:none;
	}

	.search-wrap {
	    width: 100%;
	    position: static;
	    margin-top: 36px;
	    padding:0px 4px;
	}

	.iconset.search-icon {
    	float: left;
	}

	.search-wrap input.search-input {
	    text-align: left;
	    width: 308px;
	    padding-left: 8px;
	    margin-left: 4px;
	    padding-right:22px;
	}

	.rating-tab-menu-mobile {
	    padding: 16px 0px;
	    width: 244px;
	    margin: 0 auto;
	}

	.rating-tab-menu-mobile > div {
	    font: normal normal 500 16px/20px EB Garamond,'notoserifcjktc';
	    letter-spacing: 0.8px;
	    color: #FFFFFF;
	    display: none;
	}

	.rating-tab-menu-mobile > div.active {
	    display: block;
	    text-align: center;
	}

	.rating-tab-menu-mobile .iconset.left-arrow {
	    display: block;
	    width: 20px;
	    height: 20px;
	    float: left;
	    background-position: 0px -163px;
	}

	.rating-tab-menu-mobile .iconset.right-arrow {
	    display: block;
	    width: 20px;
	    height: 20px;
	    float: right;
	    background-position: -21px -163px;
	}

	.rating-tab-panel-mobile {
	    width: 344px;
	    height: 552px;
	    border: 1px solid #FFFFFF;
	    border-radius: 5px;
	    margin-top: 8px;
	    padding: 16px 30px 36px;
	    display: none;
	}

	.rating-tab-panel-label-mobile > div {
	    font: normal normal 500 26px/38px EB Garamond,'notoserifcjktc';
	    letter-spacing: 1.3px;
	    color: #FFFFFF;
	    width: 56px;
	    float: left;
	}

	.rating-tab-panel-label-mobile {
	    padding: 20px 0px;
	    width: 100%;
	    position: relative;
	}

	.rating-tab-panel-label-mobile h5 {
	    font: normal normal normal 14px/22px EB Garamond,'notoserifcjktc';
	    letter-spacing: 0.7px;
	    color: #FFFFFF;
	    width: 42px;
	    position: absolute;
	    left: 68px;
	    bottom: 23px;
	}

	.rating-tab-panel-artwork-wrap-mobile a {
	    display: block;
	    padding: 10px 0px;
	    position: relative;
	}

	a.rating-tab-panel-artwork-mobile.first img {
	    width: 124px;
	    height: 124px;
	}

	a.rating-tab-panel-artwork-mobile.first > div {
	    width: 128px;
	}

	a.rating-tab-panel-artwork-mobile img {
	    width: 100px;
	    height: 100px;
	    float: left;
	}

	a.rating-tab-panel-artwork-mobile > div {
	    float: left;
	    width: 160px;
	    position: absolute;
	    right: 0px;
	    bottom: 10px;
	}

	.rating-tab-panel-artwork-mobile p {
	    font: normal normal normal 12px/18px EB Garamond,'notoserifcjktc';
	    letter-spacing: 0.3px;
	    color: #FFFFFF;
	    max-height: 36px;
	    overflow: hidden;
	}

	.rating-tab-panel-artwork-mobile.first p {
	    max-height: 54px;
	}

	a.rating-tab-panel-artwork-mobile > div > div:nth-child(2) {
	    font: normal normal 500 16px/24px EB Garamond,'notoserifcjktc';
	    letter-spacing: 0.4px;
	    color: #FFFFFF;
	    margin-bottom: 8px;
	}

	a.rating-tab-panel-artwork-mobile > div > div:nth-child(1) {
	    letter-spacing: 0.3px;
	    color: #FFFFFF;
	    font: normal normal 500 12px/24px EB Garamond,'notoserifcjktc';
	    margin-bottom: 4px;
	}

	a.rating-tab-panel-artwork-mobile.first > div > div:nth-child(2) {
	    font-size: 24px;
	    line-height: 32px;
	    letter-spacing: 0.6px;
	}

	.rating-tab-dot-wrap {
	    margin: 8px auto 0px;
	    padding: 16px 0px;
	    width: 160px;
	}

	.rating-tab-dot {
	    float: left;
	    width: 40px;
	    height: 8px;
	    cursor: pointer;
	}

	.rating-tab-dot span {
	    margin: 0 auto;
	    width: 8px;
	    height: 8px;
	    background: #fff;
	    opacity: 0.3;
	    border-radius: 8px;
	    display: block;
	}

	.rating-tab-dot.active span {
	    opacity: 1;
	}
}

</style>

<script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js"></script>

<div class="page-container">
	<div class="topbar clearfix">
		<a href="#" class="back-button">
			<div class="iconset arrow"></div>
			<div>Back</div>
		</a>
		<div>The Void of 22 x<br class="_mobile" /> Gjun Design School</div>
	</div>
	<div class="hero-image">
		<img class="_desktop" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/the_void_of_22_exhibition/gjun-eventpage-web-0702.png" />
		<img class="_mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/the_void_of_22_exhibition/gjun-eventpage-mobile-0702.png" />
	</div>
	<div class="intro">
		<div class="intro-inner clearfix">
			<h5>Event</h5>
			<div>
				<h1>匠🌟獨具賞</h1>
				<h3>The Void of 22 x 巨匠</h3>
			</div>
			<div class="t2">匠🌟獨具賞為巨匠設計與 FLiPER，為了鼓勵畢業生在離開校園後，還能持續充實精進創作技能，進而共同舉辦參展作品票選大賞活動。無論是參展的作者們，還是參與投票的一般民眾，都有機會獲得精彩大獎，最大獎總價值超過三萬元！！！趕快下滑看詳細活動辦法吧！！！</div>
		</div>
	</div>
	<div id="rating-now">
		<div id="rating-now-inner">
			<div class="_desktop">
				<div class="rating-tab-menu clearfix">
					<h4 data-panel="4">室內設計賞</h4>
					<h4 data-panel="3">動態影像賞</h4>
					<h4 data-panel="2">平面設計賞</h4>
					<h4 class="active" data-panel="1">遊戲原創賞</h4>
					<div class="rating-tab-panel" data-panel="1" style="display: block;">
						<div class="rating-tab-panel-label">
							<div>最終排名</div>
							<h5>Final Rating</h5>
						</div>
						<div class="rating-tab-panel-artwork-wrap">
							<?php 
								// global $wpdb;
								// // 取得前三名
								// $sql = 'SELECT post_id, COUNT(vote_id) AS v FROM wp_votes WHERE event_id = 1 AND event_item_id = 1 GROUP BY post_id ORDER BY v DESC LIMIT 3';
								// $votes = $wpdb->get_results( $sql );

								// 公布總分
								$votes = array( 
									(object)[ 'post_id' => 321791, 'v' => '84.5'],
									(object)[ 'post_id' => 317621, 'v' => '79.9'],
									(object)[ 'post_id' => 320217, 'v' => '71.7']
								);
								for ( $i = 0; $i < 3; $i ++ ) :
									$v = $votes[ $i ];
							?>
							<a href="<?php echo get_the_permalink( $v->post_id ); ?>" class="rating-tab-panel-artwork <?php echo $i === 0 ? 'first' : ''; ?>" target="_blank">
								<div class="rating-tab-panel-artwork-cover clearfix">
									<img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( $v->post_id ), 'user-avatar' )[0]; ?>" />
									<!-- <div><?php // echo $v->v; ?> 票</div> -->
									<div><?php echo $v->v; ?> 分</div>
									<div><?php echo $i === 0 ? 'No.1' : '優選'; ?></div>
								</div>
								<p><?php echo get_the_title( $v->post_id ); ?></p>
							</a>
							<?php endfor; ?>
						</div>
					</div>
					<div class="rating-tab-panel" data-panel="2">
						<div class="rating-tab-panel-label">
							<div>最終排名</div>
							<h5>Final Rating</h5>
						</div>
						<div class="rating-tab-panel-artwork-wrap">
							<?php 
								// global $wpdb;
								// // 取得前三名
								// $sql = 'SELECT post_id, COUNT(vote_id) AS v FROM wp_votes WHERE event_id = 1 AND event_item_id = 2 GROUP BY post_id ORDER BY v DESC LIMIT 3';
								// $votes = $wpdb->get_results( $sql );

								// 公布總分
								$votes = array( 
									(object)[ 'post_id' => 321955, 'v' => '85'],
									(object)[ 'post_id' => 316323, 'v' => '84.9'],
									(object)[ 'post_id' => 318094, 'v' => '84.8']
								);
								for ( $i = 0; $i < 3; $i ++ ) :
									$v = $votes[ $i ];
							?>
							<a href="<?php echo get_the_permalink( $v->post_id ); ?>" class="rating-tab-panel-artwork <?php echo $i === 0 ? 'first' : ''; ?>" target="_blank">
								<div class="rating-tab-panel-artwork-cover clearfix">
									<img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( $v->post_id ), 'user-avatar' )[0]; ?>" />
									<!-- <div><?php // echo $v->v; ?> 票</div> -->
									<div><?php echo $v->v; ?> 分</div>
									<div><?php echo $i === 0 ? 'No.1' : '優選'; ?></div>
								</div>
								<p><?php echo get_the_title( $v->post_id ); ?></p>
							</a>
							<?php endfor; ?>
						</div>
					</div>
					<div class="rating-tab-panel" data-panel="3">
						<div class="rating-tab-panel-label">
							<div>最終排名</div>
							<h5>Final Rating</h5>
						</div>
						<div class="rating-tab-panel-artwork-wrap">
							<?php 
								// global $wpdb;
								// // 取得前三名
								// $sql = 'SELECT post_id, COUNT(vote_id) AS v FROM wp_votes WHERE event_id = 1 AND event_item_id = 3 GROUP BY post_id ORDER BY v DESC LIMIT 3';
								// $votes = $wpdb->get_results( $sql );

								// 公布總分
								$votes = array( 
									(object)[ 'post_id' => 321153, 'v' => '81.4'],
									(object)[ 'post_id' => 320357, 'v' => '81'],
									(object)[ 'post_id' => 316555, 'v' => '78.4']
								);
								for ( $i = 0; $i < 3; $i ++ ) :
									$v = $votes[ $i ];
							?>
							<a href="<?php echo get_the_permalink( $v->post_id ); ?>" class="rating-tab-panel-artwork <?php echo $i === 0 ? 'first' : ''; ?>" target="_blank">
								<div class="rating-tab-panel-artwork-cover clearfix">
									<img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( $v->post_id ), 'user-avatar' )[0]; ?>" />
									<!-- <div><?php // echo $v->v; ?> 票</div> -->
									<div><?php echo $v->v; ?> 分</div>
									<div><?php echo $i === 0 ? 'No.1' : '優選'; ?></div>
								</div>
								<p><?php echo get_the_title( $v->post_id ); ?></p>
							</a>
							<?php endfor; ?>
						</div>
					</div>
					<div class="rating-tab-panel" data-panel="4">
						<div class="rating-tab-panel-label">
							<div>最終排名</div>
							<h5>Final Rating</h5>
						</div>
						<div class="rating-tab-panel-artwork-wrap">
							<?php 
								// global $wpdb;
								// // 取得前三名
								// $sql = 'SELECT post_id, COUNT(vote_id) AS v FROM wp_votes WHERE event_id = 1 AND event_item_id = 4 GROUP BY post_id ORDER BY v DESC LIMIT 3';
								// $votes = $wpdb->get_results( $sql );

								// 公布總分
								$votes = array( 
									(object)[ 'post_id' => 317892, 'v' => '89.3'],
									(object)[ 'post_id' => 318121, 'v' => '75'],
									(object)[ 'post_id' => 316529, 'v' => '66']
								);
								for ( $i = 0; $i < 3; $i ++ ) :
									$v = $votes[ $i ];
							?>
							<a href="<?php echo get_the_permalink( $v->post_id ); ?>" class="rating-tab-panel-artwork <?php echo $i === 0 ? 'first' : ''; ?>" target="_blank">
								<div class="rating-tab-panel-artwork-cover clearfix">
									<img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( $v->post_id ), 'user-avatar' )[0]; ?>" />
									<!-- <div><?php // echo $v->v; ?> 票</div> -->
									<div><?php echo $v->v; ?> 分</div>
									<div><?php echo $i === 0 ? 'No.1' : '優選'; ?></div>
								</div>
								<p><?php echo get_the_title( $v->post_id ); ?></p>
							</a>
							<?php endfor; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="_mobile">
				<div class="rating-tab-menu-mobile clearfix">
					<div class="active" data-panel="1"><span class="iconset left-arrow"></span>遊戲原創賞<span class="iconset right-arrow"></span></div>
					<div data-panel="2"><span class="iconset left-arrow"></span>平面設計賞<span class="iconset right-arrow"></span></div>
					<div data-panel="3"><span class="iconset left-arrow"></span>動態影像賞<span class="iconset right-arrow"></span></div>
					<div data-panel="4"><span class="iconset left-arrow"></span>室內設計賞<span class="iconset right-arrow"></span></div>
				</div>
				<?php 
					global $wpdb;

					for ( $item_id = 1; $item_id < 5; $item_id ++ ) :
						// 取得前三名
						$sql = 'SELECT post_id, COUNT(vote_id) AS v FROM wp_votes WHERE event_id = 1 AND event_item_id = ' . $item_id . ' GROUP BY post_id ORDER BY v DESC LIMIT 3';
						$votes = $wpdb->get_results( $sql );
				?>
				<div class="rating-tab-panel-mobile" data-panel="<?php echo $item_id; ?>" <?php echo $item_id === 1 ? 'style="display: block;"' : ''; ?>>
					<div class="rating-tab-panel-label-mobile clearfix">
						<div>最終排名</div>
						<h5>Final Rating</h5>
					</div>
					<div class="rating-tab-panel-artwork-wrap-mobile">
						<?php 
							for ( $i = 0; $i < 3; $i ++ ) :
								$v = $votes[ $i ];
						?>
							<a href="<?php echo get_the_permalink( $v->post_id ); ?>" class="rating-tab-panel-artwork-mobile clearfix <?php echo $i === 0 ? 'first' : ''; ?>" target="_blank">
								<img class="rating-tab-panel-artwork-cover-mobile" src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( $v->post_id ), 'user-avatar' )[0]; ?>" />
								<div>
									<div><?php echo $v->v; ?> 票</div>
									<div><?php echo $i === 0 ? 'No.1' : '優選'; ?></div>
									<p><?php echo get_the_title( $v->post_id ); ?></p>
								</div>
							</a>
						<?php endfor; ?>
					</div>
				</div>
				<?php endfor; ?>
				<div class="rating-tab-dot-wrap clearfix">
					<div class="rating-tab-dot active" data-panel="1"><span></span></div>
					<div class="rating-tab-dot" data-panel="2"><span></span></div>
					<div class="rating-tab-dot" data-panel="3"><span></span></div>
					<div class="rating-tab-dot" data-panel="4"><span></span></div>
				</div>
			</div>
		</div>
	</div>
	<div class="voting-arrangement">
		<div class="voting-arrangement-inner">
			<div class="header-title">
				<h2>觀展者投票看這裡</h2>
				<h5>Voting Arrangement for Audience</h5>
			</div>
			<div class="dl clearfix">
				<h4>內容</h4>
				<div class="t2">依各作品潛力，投票選出該作品的潛在發展可能。凡投票即可抽最新 iPad 第 8 代</div>
			</div>
			<div class="dl clearfix">
				<h4>對象</h4>
				<div class="t2">所有人（含參展學生及觀展者）</div>
			</div>
			<div class="dl clearfix">
				<h4>活動期間</h4>
				<div class="t2">2021 年 6 月 21 日起至 2021 年 7 月 19 日 23:59 止。（ 7 月 21 日進行抽獎）</div>
			</div>
			<div class="dl clearfix">
				<h4>投票限制</h4>
				<div class="t2">每帳號每日限投一票</div>
			</div>
			<div class="dl clearfix">
				<h4>投票獎勵</h4>
				<div class="t2">最新 iPad 第 8 代乙台（貼心小提醒：每天來投票，中獎率越高！）</div>
			</div>
			<div class="dl clearfix">
				<h4>讀者投票辦法</h4>
				<div class="t2">路徑一<br/>
					1. 進入[匠🌟獨具賞]頁面，下拉至[參加作品]區<br/>
					2. 點選任意作品，進入作品頁面後<br/>
					3. 進入作品頁面後，下拉至頁面底部<br/>
					4. 底部將出現【投票給作品（Vote）】按鈕<br/>
					5. 點選【投票給作品（Vote）】後，將出現[投票視窗]<br/>
					6. 依據作品的潛力，於[投票視窗] 內，四選一選出最適合的發展方向<br/>
					7. 點選【送出】後，進行帳號註冊<br/>
					8. 投票流程結束<br/>
					<br/>
					路徑二<br/>
					1. 由四大展間進入各作品頁面<br/>
					2. 進入作品頁面後，下拉至頁面底部<br/>
					3. 若作品底部有註[本作品參與票選活動，投票給作品（ Vote ）]字樣，即可投票；若無該字樣，則表該作品未參加匠🌟獨具賞，即非本次投票對象，無法投票<br/>
					4. 點選【投票給作品（Vote）】後，將出現[投票視窗］<br/>
					5. 依據作品的潛力，於[投票視窗]內，四選一選最適合的發展方向<br/>
					6. 點選【送出】後，進行帳號註冊<br/>
					7.投票流程結束
                </div>
			</div>
			<div class="go-vote">
				<div class="t2">找到喜歡的作品，進去投票吧！</div>
				<a href="#exhibition-hall-title-wrap" class="iconset arrow"></a>
			</div>
		</div>
	</div>
	<div class="voting-arrangement">
		<div class="voting-arrangement-inner">
			<div class="header-title">
				<h2>大賞參展學生看這裡</h2>
				<h5>Awards for Creators</h5>
			</div>
			<div class="dl clearfix">
				<h4>內容</h4>
				<div class="t2">展覽期間，累積票數經結算後，總分最高者將獲得巨匠設計進階課程</div>
			</div>
			<div class="dl clearfix">
				<h4>對象</h4>
				<div class="t2">徵件時有勾選參加匠🌟獨具賞之所有作品</div>
			</div>
			<div class="dl clearfix">
				<h4>票數累積期間</h4>
				<div class="t2">2021 年 6 月 21 日起至 2021 年 7 月 19 日 23:59 止</div>
			</div>
			<div class="dl clearfix">
				<h4>大賞作品規則</h4>
				<div class="t2">1. 參加資格：於徵件時有勾選參加匠🌟獨具賞之作品。<br/><br/>
					2. 內容說明：展覽期間，累積票數經結算後，總分最高者將獲得巨匠設計進階課程。<br/><br/>
					3. 計算方式：0.6（單一選項票數計算成 PR 值）＋ 0.4（專人審核）之總分大小比較。
                </div>
			</div>
			<div class="dl clearfix">
				<h4>大賞獎勵</h4>
				<div class="t2">請見下方表格資訊</div>
			</div>
			<div class="award-table _desktop">
				<div class="award-title clearfix">
					<div></div>
					<div><h4>遊戲原創賞</h4></div>
					<div><h4>平面設計賞</h4></div>
					<div><h4>動態影像賞</h4></div>
					<div><h4>室內設計賞</h4></div>
				</div>
				<div class="first-style clearfix">
					<div class="t3">第一名</div>
					<div class="t3">CSP 數漫電繪接案實務班</div>
					<div class="t3">平面設計接案班</div>
					<div class="t3">AE 跨媒體影音特效剪輯或 C4D 動畫創意設計</div>
					<div class="t3">SketchUp & Vray 室內設計與擬真渲染或室內設計實務班</div>
				</div>
				<div class="second-style clearfix">
					<div class="t3">優選</div>
					<div class="t3">任選熱門單元課程二科</div>
				</div>
				<div class="second-style clearfix">
					<div class="t3">備註</div>
					<div class="t3">*第一名獲獎課程價值超過 30,000 元，優選獲獎課程價值超過 12,000 元</div>
				</div>
			</div>
			<div class="award-table _desktop">
				<div class="award-title clearfix">
					<div></div>
					<div class="big"><h4>新人潛力賞<br/>（佳作）</h4></div>
					<div class="big"><h4>參加獎</h4></div>
				</div>
				<div class="first-style clearfix">
					<div class="t3">獎項</div>
					<div class="t3">四大系列各取十名，任選熱門單元課程一科</div>
					<div class="t3">3hrs 體驗課一堂</div>
				</div>
				<div class="first-style clearfix">
					<div class="t3">備註</div>
					<div class="t3">*獲獎課程價值超過 6,000 元</div>
					<div class="t3">*限定 7 間設計學院<br/><br/>*課程價值超過 1,500 元</div>
				</div>
			</div>
			<div class="award-table _mobile">
				<div class="award-table-inner">
					<h4>遊戲原創賞</h4>
					<div class="dl clearfix">
						<div class="t3">第一名</div>
						<div class="t3">CSP 數漫電繪接案實務班</div>
					</div>
					<div class="dl clearfix">
						<div class="t3">優選</div>
						<div class="t3">任選熱門單元課程二科</div>
					</div>
					<div class="dl clearfix">
						<div class="t3">備註</div>
						<div class="t3">*第一名獲獎課程價值超過 30,000 元，優選獲獎課程價值超過 12,000 元</div>
					</div>
				</div>
				<div class="award-table-inner">
					<h4>平面設計賞</h4>
					<div class="dl clearfix">
						<div class="t3">第一名</div>
						<div class="t3">平面設計接案班</div>
					</div>
					<div class="dl clearfix">
						<div class="t3">優選</div>
						<div class="t3">任選熱門單元課程二科</div>
					</div>
					<div class="dl clearfix">
						<div class="t3">備註</div>
						<div class="t3">*第一名獲獎課程價值超過 30,000 元，優選獲獎課程價值超過 12,000 元</div>
					</div>
				</div>
				<div class="award-table-inner">
					<h4>動態影像賞</h4>
					<div class="dl clearfix">
						<div class="t3">第一名</div>
						<div class="t3">AE 跨媒體影音特效剪輯或 C4D 動畫創意設計</div>
					</div>
					<div class="dl clearfix">
						<div class="t3">優選</div>
						<div class="t3">任選熱門單元課程二科</div>
					</div>
					<div class="dl clearfix">
						<div class="t3">備註</div>
						<div class="t3">*第一名獲獎課程價值超過 30,000 元，優選獲獎課程價值超過 12,000 元</div>
					</div>
				</div>
				<div class="award-table-inner">
					<h4>室內設計賞</h4>
					<div class="dl clearfix">
						<div class="t3">第一名</div>
						<div class="t3">SketchUp & Vray 室內設計與擬真渲染或室內設計實務班</div>
					</div>
					<div class="dl clearfix">
						<div class="t3">優選</div>
						<div class="t3">任選熱門單元課程二科</div>
					</div>
					<div class="dl clearfix">
						<div class="t3">備註</div>
						<div class="t3">*第一名獲獎課程價值超過 30,000 元，優選獲獎課程價值超過 12,000 元</div>
					</div>
				</div>
				<div class="award-table-inner">
					<h4>新人潛力賞（佳作）</h4>
					<div class="dl clearfix">
						<div class="t3">獎項</div>
						<div class="t3">四大系列各取十名，任選熱門單元課程一科</div>
					</div>
					<div class="dl clearfix">
						<div class="t3">備註</div>
						<div class="t3">*獲獎課程價值超過 6,000 元</div>
					</div>
				</div>
				<div class="award-table-inner">
					<h4>參加獎</h4>
					<div class="dl clearfix">
						<div class="t3">獎項</div>
						<div class="t3">3hrs 體驗課一堂</div>
					</div>
					<div class="dl clearfix">
						<div class="t3">備註</div>
						<div class="t3">*限定 7 間設計學院<br/><br/>*課程價值超過 1,500 元</div>
					</div>
				</div>
			</div>
			<div class="award-rules">
				<div class="t3">※獎項規則<br/><br/>
					1. 獲獎課程限本人使用，禁止轉售。<br/><br/>
					2. 可透過分校選擇相同價值課程（或遇未開課如果有），價高者補差額。<br/><br/>
					3. 需於2021 年 12 月 31 日前啟用課程，禁止替換現金。<br/><br/>
					4. 若為團體報獎，獎項仍僅提供一份，由參展團體自行調配受獎人及課程使用者，但限參展團體成員。<br/><br/>
					5. 以上領獎人需簽授領獎合約備忘錄（使用限制、參與年底成果展、肖像作品授權同意宣傳用途等）。
				</div>
			</div>
			<div class="go-vote">
				<div class="t2">找到喜歡的作品，進去投票吧！</div>
				<a href="#exhibition-hall-title-wrap" class="iconset arrow"></a>
			</div>
		</div>
	</div>

	<div id="exhibition-hall-title-wrap" class="exhibition-hall-title-wrap">
		<h2>參加作品</h2>
		<h5>Artworks</h5>
		<div class="search-wrap">
			<div class="iconset search-icon _mobile"></div>	
			<input class="search-input" name="search_input" type="text" value="" placeholder="Search For Artwork" />
			<div class="iconset search-icon _desktop"></div>	
		</div>
	</div>

	<div id="exhibition-hall" class="clearfix">
		<?php while( $query->have_posts() ) : $query->the_post(); ?>
		<a class="artwork defer-link" href="<?php the_permalink(); ?>?so=pcschool-star-award-2021">
			<div class="cover">
				<img class="lazyload" data-src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' )[0]; ?>" width="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' )[1]; ?>" height="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' )[2]; ?>" />
			</div>
			<p><?php the_title(); ?></p>
		</a>

		<?php endwhile; ?>
	</div>

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

		var vw = 254;
		if ( jQuery(window).width() < 1100 ) {
			vw = 164;
		}
		
		var vh = ( vw / w ) * h;
		jQuery(this).height(vh + 'px');
	});

	var cw = 282;
	if ( jQuery(window).width() < 1100 ) {
		cw = 180;
	}
	jQuery('#exhibition-hall').masonry({
  		// options
  		itemSelector: '.artwork',
  		columnWidth: cw
	});

	let url_string = window.location.href;
	let url = new URL(url_string);
	if ( url.searchParams.get("st") ) {
		jQuery(window).scrollTop(url.searchParams.get("st"));
	}
	
	jQuery('.back-button').click(function(){
		event.preventDefault();
		window.location = '/the-void-of-22-home/';
	});
	
	jQuery('.defer-link').click(function(){
		event.preventDefault();

		var	st = jQuery(window).scrollTop();
		window.location = jQuery(this).attr('href') + '&st=' + st;
	});

	jQuery('.search-input').keypress(function(event){
		if ( event.which == 13 ) {
     		event.preventDefault();
     		filter_artwork(jQuery(this).val());
  		}
	});

	jQuery('.iconset.search-icon').click(function(event){
		event.preventDefault();
		filter_artwork(jQuery('.search-input').val());
	});

	jQuery('.rating-tab-menu h4').click(function(event){
		event.preventDefault();
		jQuery('.rating-tab-menu h4').removeClass('active');
		jQuery(this).addClass('active');
		var index = jQuery(this).attr('data-panel');
		jQuery('.rating-tab-panel').each(function(){
			if ( jQuery(this).attr('data-panel') != index ) {
				jQuery(this).hide();
			} else {
				jQuery(this).show();
			}
		});
	});

	jQuery('.rating-tab-menu h4').click(function(event){
		event.preventDefault();
		jQuery('.rating-tab-menu h4').removeClass('active');
		jQuery(this).addClass('active');
		var index = jQuery(this).attr('data-panel');
		jQuery('.rating-tab-panel').each(function(){
			if ( jQuery(this).attr('data-panel') != index ) {
				jQuery(this).hide();
			} else {
				jQuery(this).show();
			}
		});
	});

	var mobile_rating_index = 1;
	jQuery('.rating-tab-menu-mobile .left-arrow').click(function(event){
		mobile_rating_index = mobile_rating_index - 1;
		if ( mobile_rating_index <= 0 ) {
			mobile_rating_index = 4;
		}

		jQuery('.rating-tab-menu-mobile > div').each(function(){
			jQuery(this).removeClass('active');
			if ( jQuery(this).attr('data-panel') == mobile_rating_index ) {
				jQuery(this).addClass('active');
			}
		});

		jQuery('.rating-tab-panel-mobile').each(function(){
			jQuery(this).hide();
			if ( jQuery(this).attr('data-panel') == mobile_rating_index ) {
				jQuery(this).show();
			}
		});

		jQuery('.rating-tab-dot').each(function(){
			jQuery(this).removeClass('active');
			if ( jQuery(this).attr('data-panel') == mobile_rating_index ) {
				jQuery(this).addClass('active');
			}
		});
	});

	jQuery('.rating-tab-menu-mobile .right-arrow').click(function(event){
		mobile_rating_index = mobile_rating_index + 1;
		if ( mobile_rating_index >= 5 ) {
			mobile_rating_index = 1;
		}

		jQuery('.rating-tab-menu-mobile > div').each(function(){
			jQuery(this).removeClass('active');
			if ( jQuery(this).attr('data-panel') == mobile_rating_index ) {
				jQuery(this).addClass('active');
			}
		});

		jQuery('.rating-tab-panel-mobile').each(function(){
			jQuery(this).hide();
			if ( jQuery(this).attr('data-panel') == mobile_rating_index ) {
				jQuery(this).show();
			}
		});

		jQuery('.rating-tab-dot').each(function(){
			jQuery(this).removeClass('active');
			if ( jQuery(this).attr('data-panel') == mobile_rating_index ) {
				jQuery(this).addClass('active');
			}
		});
	});

	jQuery('.rating-tab-dot').click(function(event){
		event.preventDefault();
		mobile_rating_index = jQuery(this).attr('data-panel');
		
		jQuery('.rating-tab-menu-mobile > div').each(function(){
			jQuery(this).removeClass('active');
			if ( jQuery(this).attr('data-panel') == mobile_rating_index ) {
				jQuery(this).addClass('active');
			}
		});

		jQuery('.rating-tab-panel-mobile').each(function(){
			jQuery(this).hide();
			if ( jQuery(this).attr('data-panel') == mobile_rating_index ) {
				jQuery(this).show();
			}
		});

		jQuery('.rating-tab-dot').each(function(){
			jQuery(this).removeClass('active');
			if ( jQuery(this).attr('data-panel') == mobile_rating_index ) {
				jQuery(this).addClass('active');
			}
		});
	});
});

function filter_artwork(s) {
	if ( '' == s ) {
		jQuery('.artwork').show();
		jQuery('#exhibition-hall').masonry();
	} else {
		jQuery('.artwork p').each(function(){
			if ( -1 === jQuery(this).text().search(s) ) {
				jQuery(this).parent().hide();
			}
		});
		jQuery('#exhibition-hall').masonry();
	}
}


</script>


<?php get_footer(); ?>