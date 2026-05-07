<?php

/* Template Name: 22 Online Design Exhibition About */

get_header();

?>

<style>
.page-container * {
	box-sizing: border-box;
}

dl {
	margin: 0px;
}

#main-menu {
	background: transparent;
	z-index: 100;
    position: relative;
}

.hero-image {
	margin-top: -60px;
    position: relative;
    z-index: -1;
}

.hero-image img {
	width: 100%;
	display: block;
}

.desktop {
	display: none !important;
}

.header-section {
	padding:60px 0px 24px;
	background: #FFEA00;
}

.header-section-inner {
	width:300px;
	margin:0 auto;
}

.header-section h1 {
	font: Bold 40px/50px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	color: #000000;
}

.header-section h1 span {
	display: block;
	padding:20px 0px 28px;
	font: Bold 20px/30px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 1px;
	color: #000000;
}

.header-section .custom-menu .custom-menu-item {
	padding:18px 0px;
	font: Bold 14px/14px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.42px;
	color: #000000;
	text-transform: uppercase;
}

.header-section .custom-menu .custom-menu-item a {
	text-decoration: none;
	color: #000000;
}

#whats-happening, #news {
	padding:24px 0px 0px;
	background: #FFEA00;
}

#news {
	padding:64px 0px;
}

#whats-happening-inner, #news-inner {
	width:320px;
	background: #DBDBDB;
	border-radius: 30px;
	padding:58px 30px 48px;
	margin:0 auto;
	position: relative;
	z-index: 10;
}

h2.title {
	font: Bold 30px/40px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.9px;
	color: #000000;
	padding:0px 0px 24px;
}

#whats-happening-inner p {
	font: 500 16px/28px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	color: #000000;
	padding:0px 0px 24px;
}

#whats-happening .blank {
	background:#FFEA00;
	height: 100px;
	margin:-30px 0px 0px;
}

#purpose {
	padding:24px 0px 70px;
	background: #FFEA00;
}

#purpose-inner {
	width:300px;
	margin:0 auto;
}

.purpose-list .purpose-item img {
	padding: 0px 0px 24px;
}

h3.title {
	font: Bold 20px/32px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 1px;
	color: #000000;
	border-bottom:3px solid #000000;
	margin:0px 0px 24px;
	display: inline-block;
}

.purpose-list .purpose-item p {
	padding: 0px 0px 48px;
	font: 500 16px/28px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	color: #000000;
}

#lets-do-this {
	padding:24px 0px 70px;
	background: #FFEA00;
}

#lets-do-this-inner {
	width:350px;
	height: 750px;
	display: block;
	margin:0 auto;
	background-image:url(/wp-content/themes/flipermag/assets/images/__22_online_design_exhibition/Enter_The_Exhibition_mobile_0521@2x.png);
	background-size: 100%;
	position: relative;
	padding:186px 35px;
	box-sizing: border-box;
}

#lets-do-this-inner h2 {
	position: relative;
	text-align: center;
	font: 700 30px/40px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.9px;
	color: #FFFFFF;
	text-transform: uppercase;
}

#lets-do-this-inner h4 {
	position: relative;
	text-align: center;
	font: 700 14px/20px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.42px;
	color: #FFFFFF;
	text-transform: uppercase;
	padding-top:26px;
}

#lets-do-this-inner h3 {
	position: relative;
	text-align: center;
	font: 700 36px/46px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 1.08px;
	color: #FFFFFF;
	text-transform: uppercase;
	padding-top:16px;
}

#lets-do-this-inner h5 {
	position: relative;
	text-align: center;
	font: 700 18px/28px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.54px;
	color: #FFFFFF;
	text-transform: uppercase;
	padding-top:16px;
}

#lets-do-this-inner .btn-enter {
	position: relative;
	text-align: center;
	font: 100 24px/32px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.72px;
	color: #FFFFFF;
	text-transform: uppercase;
	margin:80px 15px 0px;
	padding:14px 0px;
	border:1px solid #FFFFFF;
	border-radius: 35px;
}

h4.title {
	font: 700 20px/32px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 1px;
	color: #000000;
	border-bottom:3px solid #000000;
	margin:0px 0px 32px;
	display: inline-block;
}

.info-item dt {
	font: 700 18px/30px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.54px;
	color: #747474;
	width:40px;
	float:left;
}

.info-item dd {
	padding:0px 0px 48px 32px;
}

.info-item dd .title {
	font: 500 20px/30px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 1px;
	color: #000000;
	padding:0px 0px 12px;
}

.info-item dd .desc {
	font: 500 16px/28px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	color: #000000;
}

.info-item dd .time {
	font: 600 15px/25px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 1.5px;
	color: #000000;
	padding:0px 0px 12px;
}

.info-item-hr {
	height: 1px;
	background: #6E6E6E;
	margin:18px 0px 32px;
}

.info-item.full dt {
	width:100%;
	float:none;
	padding:0px 0px 24px;
}

.info-item.full dd {
	padding:0px 0px 24px;
	margin:0px;
}

.info-item.full dd p {
	padding:0px 0px 24px;
	font: 500 16px/28px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	color: #000000;
}

.info-item.full.light dt {
	color: #AFAFAF;
}

.info-item.full.light dd p {
	color: #8C8C8C;
}

#make-a-difference-now {
	padding:24px 0px 70px;
	background: #EFEFEF;
}

#make-a-difference-now-inner {
	width:320px;
	padding:58px 30px 72px;
	margin:0 auto;
	background: #DBDBDB;
	border-radius: 30px;
}

#make-a-difference-now-inner h2.title {
	text-align: center;
}

#make-a-difference-now-inner p.desc {
	text-align: center;
	padding:0px 40px 24px;
	font: 500 16px/28px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	color: #000000;
}

#cta-button {
	display: block;
	margin:0 auto;
	width:160px;
	height: 64px;
	background: #F8F8F8;
	border: 3px solid #000000;
	border-radius: 47px;
	text-align: center;
	font: Bold 16px/26px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.48px;
	color: #000000;
	padding:8px 0px 0px;
}

#cta-button span{
	display: block;
	font: 600 12px/12px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.36px;
}

#sponsors {
	padding:24px 0px 100px;
	background: #FFEA00;
}

#sponsors-inner {
	width:320px;
	margin:0 auto;
	background: #FFEA00;
	border-radius: 30px;
}

h5.title {
	text-align: center;
	font: 500 18px/28px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.9px;
	color: #8C8C8C;
	padding:44px 0px 24px;
}

.logo-item .fliper {
	width: 104px;
	height: 42px;
	margin:0px auto 46px;
	background: url('<?php echo get_stylesheet_directory_uri() . '/assets/images/iconset-20191119@2x.png'; ?>');
	background-repeat: no-repeat;
	background-position-x: 0px;
	background-position-y: -67px; 
	display: block;
}

.logo-item .to {
	width: 129px;
	height: 34px;
	background: transparent url('<?php echo get_stylesheet_directory_uri() . '/assets/images/__22_online_design_exhibition/to@2x.png'; ?>');
	background-repeat: no-repeat;
	background-size: 100%;
    margin: 0 auto 24px;
	display: block;
}

.logo-item .vo {
	width: 140px;
	height: 35px;
	background: transparent url('<?php echo get_stylesheet_directory_uri() . '/assets/images/__22_online_design_exhibition/vo@2x.png'; ?>');
	background-repeat: no-repeat;
	background-size: 100%;
    margin: 0 auto;
	display: block;
}

#footer {
	background: #FFEA00;
	padding:0px 0px 36px;
	margin:0px;
}

@media screen and (min-width: 1100px) {

.mobile {
	display: none !important;
}

.desktop {
	display: block !important;
}

#desktop-user-menu .profile-icon.logged .user-menu-wrap {
	background-color:transparent;
}

#desktop-user-menu .profile-icon.logged .user-menu {
	background: #fff;
}

.hero-image {
	margin-top:-120px;
}

.hero-image .desktop {
	max-width: 100%;
	margin: 0px;
	position: relative;
	z-index: 10;
}

.hero-image .desktop-block {
	margin-top:-138px;
	height: 138px;
	width:100%;
	background: #EFEFEF;
}

.header-section {
	padding:133px 0px;
}

.header-section-inner {
	width:1100px;
	padding:0px 150px;
}

.header-section h1 {
	font: Bold 45px/65px Montserrat, "PingFang TC", "Noto Sans CJK TC";
}

.header-section h1 span {
	padding:50px 0px 40px;	
}

.header-section .custom-menu .custom-menu-item {
	vertical-align: top;
	display: inline-block;
	padding:0px 72px 0px 0px;
	font: Bold 14px/18px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	height: 54px;
}

.header-section .custom-menu .custom-menu-item a:hover {
	color:#2BAB9F;
}

#whats-happening, #news {
	padding:100px 0px;
}

#whats-happening-inner, #news-inner {
	width:960px;
	border-radius: 50px;
	padding:100px 130px 92px;
}

h2.title {
	font: Bold 32px/42px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.96px;
	padding:0px 0px 70px;
}

#whats-happening-inner p {
	font: 500 18px/28px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	padding:0px 0px 28px;
}

#whats-happening .blank {
	background:#fff;
	height: 100px;
	margin:-30px 0px 0px;
}

#purpose {
	padding:100px 0px;
}

#purpose-inner {
	width:860px;
}

.purpose-list {
	padding:0px 30px;
	display: flex;
    justify-content: space-between;
}

.purpose-list .purpose-item {
	width:350px;
}

.purpose-list .purpose-item img {
	padding: 0px 0px 48px;
}

h3.title {
	font: Bold 24px/34px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 1.2px;
	margin:0px 0px 48px;
}

.purpose-list .purpose-item p {
	padding: 0px;
	font: 500 18px/28px Montserrat, "PingFang TC", "Noto Sans CJK TC";
}

#lets-do-this {
	padding:100px 0px;
}

#lets-do-this-inner {
	width:1100px;
	height: 588px;
	background-image:url(/wp-content/themes/flipermag/assets/images/__22_online_design_exhibition/Enter_The_Exhibition_web_0521@2x.png);
	position: relative;
	padding:72px 275px;
}

#lets-do-this-inner:hover {
	opacity: 0.9;
}

#lets-do-this-inner h2 {
	position: relative;
	text-align: center;
	font: 700 32px/36px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.96px;
	color: #FFFFFF;
	text-transform: uppercase;
}

#lets-do-this-inner h4 {
	position: relative;
	text-align: center;
	font: 700 32px/36px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.96px;
	color: #FFFFFF;
	text-transform: uppercase;
	padding-top:28px;
}

#lets-do-this-inner h3 {
	position: relative;
	text-align: center;
	font: 700 56px/60px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 1.68px;
	color: #FFFFFF;
	text-transform: uppercase;
	padding-top:40px;
}

#lets-do-this-inner h5 {
	position: relative;
	text-align: center;
	font: 700 30px/40px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.9px;
	color: #FFFFFF;
	text-transform: uppercase;
	padding-top:40px;
}

#lets-do-this-inner .btn-enter {
	position: relative;
	text-align: center;
	font: 100 32px/40px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.96px;
	color: #FFFFFF;
	text-transform: uppercase;
	margin:84px 80px 0px;
	padding:20px 0px;
	border:1px solid #FFFFFF;
	border-radius: 35px;
}

#lets-do-this-inner:hover .shadow {
	position: absolute;
	top:0px;
	bottom: 0px;
	left:0px;
	right: 0px;
	background: #fff 0% 0% no-repeat padding-box;
	opacity: 0.3;
}

h4.title {
	font: Bold 24px/34px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 1.2px;
	margin:0px 0px 70px;
}

.info-item dl.info {
	display: inline-block;
	vertical-align: top;
}

.info-item dt {
	font: Bold 20px/30px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.6px;
	width:246px;
	float:none;
}

.info-item dd {
	width:246px;
	padding:0px;
	margin:34px 55px 70px 0px;
}

.info-item dl.info:last-child dd {
	margin-right:0px;
}

.info-item dd .title {
	font: 500 26px/38px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 1.3px;
	padding:0px 0px 20px;
}

.pb-10 {
	padding-bottom:10px !important;
}

.info-item dd .desc {
	font: 500 18px/28px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	color: #000000;
}

.info-item dd .time {
	font: 600 18px/28px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 1.8px;
	padding:0px 0px 20px;
}

.info-item-hr {
	height: 2px;
	background: #707070;
	margin:70px 0px;
}

.info-item.full dt {
	width:50px;
	float:left;
	padding:0;
}

.info-item.full dd {
	width: 860px;
	padding:0px 0px 70px 160px;
}

.info-item.full dd p {
	padding:0px 0px 28px;
	font: 500 18px/28px Montserrat, "PingFang TC", "Noto Sans CJK TC";
}

#make-a-difference-now {
	padding:100px 0px;
}

#make-a-difference-now-inner {
	width:960px;
	padding:100px 130px 120px;
	margin:0 auto;
	border-radius: 50px;
}

#make-a-difference-now-inner h2.title {
	text-align: center;
}

#make-a-difference-now-inner p.desc {
	text-align: center;
	padding:0px 0px 28px;
	font: 500 18px/28px Montserrat, "PingFang TC", "Noto Sans CJK TC";
}

.cta-button-wrap {
	padding:42px 0px 0px;
}

#cta-button {
	width:220px;
	height: 90px;
	border-radius: 45px;
	text-align: center;
	font: Bold 20px/30px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.6px;
	padding:16px 0px 0px;
}

#cta-button span{
	font: 600 15px/25px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.45px;
}

#sponsors {
	padding:100px 0px;
}

#sponsors-inner {
	width:960px;
	border-radius: 50px;
}

h5.title {
	text-align: left;
}

.logo-item .fliper {
	margin:0px 0px 46px;
}

.logo-item .to {
    margin: 0px 0px 24px;
}

.logo-item .vo {
    margin: 0px;
}

.info-item.full.light dd p {
	font: 500 15px/25px Montserrat, "PingFang TC", "Noto Sans CJK TC";
}

}
</style>

<div class="page-container">
	<div class="hero-image">
		<img class="mobile" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/__22_online_design_exhibition/'; ?>__22_About-hero-mobile.png" style="background-color:#FFEA00;" />
		<img class="desktop" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/__22_online_design_exhibition/'; ?>__22_About-hero-web.png" style="background-color:#FFEA00;" />
		<div class="desktop-block"></div>
	</div>

	<div class="header-section">
		<div class="header-section-inner">
			<h1>＿＿ 22<span>線上設計展</span></h1>
			<ul class="custom-menu">
				<li class="custom-menu-item"><a class="smooth-scroll" href="#whats-happening"><span class="mobile">1 </span>WHAT'S <br class="desktop" />HAPPENING</a></li>
				<li class="custom-menu-item"><a class="smooth-scroll" href="#purpose"><span class="mobile">2 </span>PURPOSE</a></li>
				<li class="custom-menu-item"><a class="smooth-scroll" href="#lets-do-this-inner"><span class="mobile">3 </span>ENTER <br class="desktop" />THE <br class="desktop" />EXHIBITION</a></li>
			</ul>
		</div>
	</div>
	
	<div id="whats-happening">
		<div id="whats-happening-inner">
			<h2 class="title">1</h2>
			<h2 class="title">WHAT’S HAPPENING</h2>
			<p>2020 年，一個 COVID-19 徹底改變了世界的進程，身處於其中的我們隨時都在思考，要如何度過這場災難、要如何解決不斷冒出的問題、又該要如何塑造一個更好的未來。</p>
			<p>對於正值 22 年華的設計師來說，這是一個最好、也是最壞的時代。亂世出英雄，透過年輕設計師心中的藍圖，我們得以看見世界未來的樣貌。</p>
			<p>這是一個專屬於設計系畢業生的展覽，沒有華麗的名號、沒有浮誇的獎賞。讓我們用作品與理念，去碰撞真實世界裡的各種問題，創造更多美好的人事物。讓這個地球、這個世界變成每一個人心目中的理想鄉。</p>
			<p>你的 22 又是什麼樣子？一起去尋找吧！</p>
		</div>
		<div class="blank mobile"></div>
	</div>
	<div id="purpose">
		<div id="purpose-inner">
			<h2 class="title">2</h2>
			<h2 class="title">PURPOSE</h2>
			<div class="purpose-list">
				<div class="purpose-item">
					<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/__22_online_design_exhibition/'; ?>pic-For-Designers.png" />
					<h3 class="title">FOR DESIGNERS</h3>
					<p>給所有年輕設計師一個展現自我的舞台，完全以作品為出發點，沒有學校、系所等包袱，用作品訴求理念，用理念找到同好，然後一起改變世界。</p>
				</div>
				<div class="purpose-item">
					<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/__22_online_design_exhibition/'; ?>pic-For-Audience.png" />
					<h3 class="title">FOR AUDIENCE</h3>
					<p>日復一日、年復一年的生活，讓人疲憊又失去活力，看看這些創意十足、突破常理的創作作品，然後重新燃起我們對於「未來生活」的想像!</p>
				</div>
			</div>
		</div>
	</div>
	<div id="lets-do-this">
		<a id="lets-do-this-inner" href="/22-online-design-exhibition-home/">
			<div class="shadow"></div>
			<h2>3</h2>
			<h4>ENTER</h4>
			<h3>THE EXHIBITION</h3>
			<h5>進入展覽</h5>
			<div class="btn-enter">ENTER</div>
		</a>
	</div>
		
</div> <!-- #main-container end -->

</div> <!-- .site-container end -->

<script>
$ = jQuery;
$('document').ready(function(){
	var left = ( $(window).width() - 1100 ) / 2 - 58 + 12;
	var top = $(window).height() / 2 - 6;

	$('.smooth-scroll').click(function(e){
		e.preventDefault();
		var name = $(this).attr('href');
		$(name)[0].scrollIntoView({
			behavior: 'smooth'
		});
	});
});
</script>


<?php get_footer('22-online-design-exhibition'); ?> 