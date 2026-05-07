<?php

/* Template Name: 22 Online Design Exhibition */

get_header();

?>

<style>
.page-container * {
	box-sizing: border-box;
}

dl {
	margin: 0px;
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
	background: #efefef;
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
	background: #efefef;
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
	background:#fff;
	height: 100px;
	margin:-30px 0px 0px;
}

#purpose {
	padding:24px 0px 70px;
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
	padding:64px 0px 22px;
	background: #EFEFEF;
}

#lets-do-this-inner {
	width:300px;
	margin:0 auto;
}

h4.title {
	font: Bold 20px/32px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 1px;
	color: #000000;
	border-bottom:3px solid #000000;
	margin:0px 0px 32px;
	display: inline-block;
}

.info-item dt {
	font: Bold 18px/30px Montserrat, "PingFang TC", "Noto Sans CJK TC";
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
	padding:0px 0px 100px;
	background: #EFEFEF;
}

#sponsors-inner {
	width:320px;
	margin:0 auto;
	background: #FFFFFF;
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
	background: #EFEFEF;
	padding:0px 0px 36px;
	margin:0px;
}

#pined-flag {
	display: none;
}

@media screen and (min-width: 1100px) {

.mobile {
	display: none !important;
}

.desktop {
	display: block !important;
}

.hero-image .desktop {
	max-width: 1100px;
	margin: 30px auto 0px;
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
	background: #efefef;
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
	background: #efefef;
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
	padding:100px 0px 30px;
	background: #EFEFEF;
}

#lets-do-this-inner {
	width:860px;
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
	padding:0px 0px 100px;
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

#pined-flag {
	display: block;
	transform: matrix(0, 1, -1, 0, 0, 0);
	height: 12px;
	width: 116px;
	top: 340px;
	position: fixed;
	font: Bold 12px/12px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	z-index:5;
}

}
</style>

<div class="page-container">
	<div id="pined-flag">_______________ 2 2</div>
	<div class="hero-image">
		<img class="mobile" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/__22_online_design_exhibition/'; ?>__22-vi-all-size-mobile.png" />
		<img class="desktop" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/__22_online_design_exhibition/'; ?>__22-vi-all-size-pc.png" />
		<div class="desktop-block"></div>
	</div>

	<div class="header-section">
		<div class="header-section-inner">
			<h1>＿＿ 22<span>線上設計展</span></h1>
			<ul class="custom-menu">
				<li class="custom-menu-item"><a class="smooth-scroll" href="#news"><span class="mobile">0 </span>NEWS</a></li>
				<li class="custom-menu-item"><a class="smooth-scroll" href="#whats-happening"><span class="mobile">1 </span>WHAT'S <br class="desktop" />HAPPENING</a></li>
				<li class="custom-menu-item"><a class="smooth-scroll" href="#purpose"><span class="mobile">2 </span>PURPOSE</a></li>
				<li class="custom-menu-item"><a class="smooth-scroll" href="#lets-do-this"><span class="mobile">3 </span>LET'S DO <br class="desktop" />THIS!</a></li>
				<li class="custom-menu-item"><a class="smooth-scroll" href="#make-a-difference-now"><span class="mobile">4 </span>MAKE <br class="desktop" />A DIFFERENCE <br class="desktop" />NOW</a></li>
			</ul>
		</div>
	</div>

	<style>
	.news-table {
		width:100%;
		border-spacing: 0px;
	}
	.news-table thead th {
		font: Bold 18px/18px Montserrat, "PingFang TC", "Noto Sans CJK TC";
		color: #fff;
    	background-color: #343a40;
    	border-color: #454d55;
		vertical-align: bottom;
    	border-bottom: 2px solid #454d55;
    	padding: .75rem;
    	border-top: 1px solid #dee2e6;
	}
	.news-table th, .news-table td {
		font: 14px/20px Montserrat, "PingFang TC", "Noto Sans CJK TC";
		padding: .75rem;
    	vertical-align: top;
    	border-top: 1px solid #dee2e6;
    	background: #fff;
	}
	.news-table th {
		vertical-align: middle;
	}
	.news-table a:hover {
		text-decoration: underline;
	}
	</style>

	<div id="news">
		<div id="news-inner">
			<h2 class="title">NEWS</h2>
			<?php the_post(); the_content(); ?>
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
		<div id="lets-do-this-inner">
			<h2 class="title">3</h2>
			<h2 class="title">LET’S DO THIS!</h2>
			<div class="info-list">
				<h4 class="title">展覽資訊</h4>
				<div class="info-item">
					<dl class="info">
						<dt>展出位置</dt>
						<dd>
							<div class="title">《__22》線上設計展專屬系列頁面</div>
							<div class="desc">FLiPER 網站</div>
						</dd>
					</dl>
					<dl class="info">
						<dt>展出時間</dt>
						<dd>
							<div class="title pb-10">2020.5.22 FRI</div>
							<div class="time">06:00:00-</div>
							<div class="desc">至天荒地老（展出內容將一直保留在 FLiPER 平台上）</div>
						</dd>
					</dl>
				</div>
				<div class="info-item-hr"></div>
				<h4 class="title">報名資訊</h4>
				<div class="info-item">
					<dl class="info">
						<dt>報名資格</dt>
						<dd>
							<div class="title">2020 年泛設計、藝術、建築、數位、傳播等有畢業製作或展覽之應屆畢業生</div>
						</dd>
					</dl>
					<dl class="info">
						<dt>徵件截止</dt>
						<dd>
							<div class="title pb-10" style="text-decoration: line-through;">2020.5.08 FRI</div>
							<div class="title pb-10"><span style="background-color:#ffe801">2020.5.17 SUN</span></div>
							<div class="time">-23:59:59</div>
						</dd>
					</dl>
					<dl class="info">
						<dt>報名費用</dt>
						<dd>
							<div class="title pb-10">FREE</div>
							<div class="desc">免費</div>
						</dd>
					</dl>
				</div>
				<div class="info-item full">
					<dl class="info">
						<dt>交件格式</dt>
						<dd>
							<p>歡迎大家以多元的作品類型參展，只要將作品用文字、圖片、影片等形式上傳至報名表單內就好囉！</p>
							<p>注意事項如下：</p>
							<p>1. 每個作品需包含一張「封面圖片」與「作品名稱」。</p>
							<p>2. 作品內容文字字數不限，但需分段清楚，並使用正確的標點符號。</p>
							<p>3. 作品內容圖片檔案數不限，考量網路下載速度，單檔最大5MB，且最大邊不得超過3840pixels。</p>
							<p>4. 作品內容影片檔案數不限，但需將檔案先上傳至團隊自有的Youtube帳號，再於表單內提供嵌入連結。</p>
							<p>5. 作品展出時，作品頁面內容將依照填寫表單時的順序顯示。</p>
						</dd>
					</dl>
				</div>
				<div class="info-item full light">
					<dl class="info">
						<dt>其他辦法</dt>
						<dd>
							<p>1. 我們將贊助參加展覽的每個設計團隊（沒錯，就是你）「一篇文章」！由正在發光發熱的你們自行撰寫過去的心路歷程、痛苦熬夜與爆肝的辛苦，化作一字一句後再經由 FLiPER 編輯部審核，便能發佈於 FLiPER 網站。</p>
							<p>2. 若同一系所參加之作品有 10 件以上的話，就會擁有 FLiPER 為你製作的專屬畢展頁面喔！（確認有 10 件作品以上的系所，我們將會提供給該系所表單進行填寫，且頁面是以「主題」為主，若兩個系使用共同主題，那就只會有一個頁面，但兩個系所的名稱都會標示）除此之外，我們還會贈送系所發布一篇贊助文章的機會噢，是不是很～厲～害～啊～（文章由團隊自行撰寫內容、FLiPER 編輯部審核，若通過即可發佈）。</p>
							<p>3. 所有文章內容需與作品或該系所之畢業展有關，可以加入相關的作品或展覽宣傳。</p>
							<p>4. 系所贊助請來信 public@flipermag.com 申請 </p>
							<p>使用權利：完成報名後，所有作品、展覽與團隊之相關內容即視為同意 FLiPER 於自有平台上發表（包含但不限於 FLiPER 網站、Facebook 粉絲團、Instagram 帳號或其他由 FLiPER 所經營之網路平台）。</p>
							<p>若因不可抗力因素造成活動舉辦困難，FLiPER 保有修改及終止本活動之權利，如有任何變更內容或詳細注意事項將公布於 FLiPER 官方網站。</p>
						</dd>
					</dl>
				</div>
				<div class="info-item full light">
					<dl class="info">
						<dt>Q&A</dt>
						<dd>
							<p>Ｑ：只有泛設計科系可以申請嗎？<br/>
							Ａ：由於我們收到許多非設計相關科系的同學們詢問是否可以報名，因此我們將報名資格擴大了！不管是設計、建築、藝術、傳播、數位等相關科系都「可以」報名，只要有畢業製作或者畢業展覽的系所皆可以參加哦！我們也非常歡迎大家以多元的作品類型參展，文字、圖片、影片不拘。</p>
							<p>Ｑ：同一學校、系所是否就要用一個共同帳號報名呢？<br/>
							Ａ：不是喔！本活動的報名方式是以「作品」為單位，建議一個作品用一個帳號，且同個系所不需要統一繳件。不過同一帳號可以報名多個作品，所以如果系所其中一人創立帳號後，也可以統一幫大家報名，但注意要分不同作品報名哦！</p>
							<p>Ｑ： 10 件作品以上有獨立畢展頁面，那麼樣式底圖需要系所設計的視覺嗎？<br/>
								Ａ：確認有 10 件作品以上的系所，我們將會提供給該系所表單進行填寫，屆時會有固定的規格，依照規格於表單內填寫資料即可。另外，頁面是以「主題」為主，若兩個系使用共同主題，那就只會有一個頁面，但兩個系所的名稱都會標示。<br/>
								表格內容需要提供：主題名稱、學校、系所名稱、主視覺圖片（ web 1640 x 624 px / mobile 700 x 396 px）、介紹文字、網站 / 臉書 / IG 連結網址。</p>
							<p>Ｑ：選擇或輸入學校、系所名稱時顯示讀取錯誤怎麼辦？<br/>
							Ａ：建議先存檔然後重新整理看看！</p>
						</dd>
					</dl>
				</div>
			</div>
		</div>
	</div>
	
	<div id="make-a-difference-now">
		<div id="make-a-difference-now-inner">
			<h2 class="title">MAKE <br class="mobile" />A DIFFERENCE NOW</h2>
			<p class="desc">當每個人都能找到自己熱愛的事物時，<br class="desktop" /><br class="desktop" />世界會變成一個更美好的地方。</p>
			<p class="desc">別再猶豫，現在就加入我們，<br class="desktop" /><br class="desktop" />讓 22 成為自己最耀眼的那一刻。</p>
			<div class="cta-button-wrap">
				<div id="cta-button" class="not-login">報名截止<span>Has Ended</span></div>				
			</div>
		</div>
	</div>
	<div id="sponsors">
		<div id="sponsors-inner">
			<img class="mobile" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/__22_online_design_exhibition/__22-sponsor-mobile-0430.png'; ?>" usemap="#mobile-logo-map" />
			<map name="mobile-logo-map">
  				<area shape="rect" coords="115,70,205,100" href="/" target="_blank" alt="FLiPER">
  				<area shape="rect" coords="40,210,155,240" href="https://buzzorange.com/techorange/" target="_blank" alt="techorange">
  				<area shape="rect" coords="175,210,285,240" href="https://buzzorange.com/vidaorange/" target="_blank" alt="vidaorange">
  				<area shape="rect" coords="40,265,155,300" href="https://www.huashan1914.com/" target="_blank" alt="華山1914">
  				<area shape="rect" coords="175,265,285,300" href="https://www.songshanculturalpark.org/" target="_blank" alt="松山文創園區">
  				<area shape="rect" coords="80,340,235,370" href="https://culture.skm.com.tw/" target="_blank" alt="財團法人新光三越文教基金會">
			</map>
			<img class="desktop" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/__22_online_design_exhibition/__22-sponsor-web-0430.png'; ?>" usemap="#desktop-logo-map" />
			<map name="desktop-logo-map">
  				<area shape="rect" coords="120,105,260,145" href="/" target="_blank" alt="FLiPER">
  				<area shape="rect" coords="120,275,320,325" href="https://buzzorange.com/techorange/" target="_blank" alt="techorange">
  				<area shape="rect" coords="385,275,575,325" href="https://buzzorange.com/vidaorange/" target="_blank" alt="vidaorange">
  				<area shape="rect" coords="630,275,835,325" href="https://culture.skm.com.tw/" target="_blank" alt="財團法人新光三越文教基金會">
  				<area shape="rect" coords="120,380,320,445" href="https://www.huashan1914.com/" target="_blank" alt="華山1914">
  				<area shape="rect" coords="385,380,575,445" href="https://www.songshanculturalpark.org/" target="_blank" alt="松山文創園區">
			</map>
		</div>
	</div>
</div>


</div> <!-- #main-container end -->

</div> <!-- .site-container end -->

<script>
$ = jQuery;
$('document').ready(function(){
	var left = ( $(window).width() - 1100 ) / 2 - 58 + 12;
	var top = $(window).height() / 2 - 6;
	$('#pined-flag').css('left', left + 'px');
	$('#pined-flag').css('top', top + 'px');

	$('.smooth-scroll').click(function(e){
		e.preventDefault();
		var name = $(this).attr('href');
		$(name)[0].scrollIntoView({
			behavior: 'smooth'
		});
	});
});
</script>


<?php get_footer(); ?>