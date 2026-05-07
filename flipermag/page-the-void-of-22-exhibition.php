<?php

/* Template Name: The Void of 22 Exhibition */

get_header();

?>

<style>
.page-container * {
	box-sizing: border-box;
}

dl {
	margin: 0px;
}

#main-container {
	background: #000;
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
}

.header-section-inner {
	width:300px;
	margin:0 auto;
}

.header-section h1 {
	font: Bold 40px/50px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	color: #fff;
}

.header-section h1 span {
	display: block;
	padding:20px 0px 28px;
	font: Bold 20px/30px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 1px;
	color: #fff;
}

.header-section .custom-menu .custom-menu-item {
	padding:18px 0px;
	font: Bold 14px/14px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.42px;
	color: #fff;
	text-transform: uppercase;
}

.header-section .custom-menu .custom-menu-item a {
	text-decoration: none;
	color: #fff;
}

#whats-happening, #news {
	padding:24px 0px 0px;
}

#news {
	padding:64px 0px;
}

#whats-happening-inner, #news-inner {
	width:320px;
	background: #747474;
	border-radius: 30px;
	padding:58px 30px 48px;
	margin:0 auto;
	position: relative;
	z-index: 10;
}

h2.title {
	font: Bold 30px/40px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.9px;
	color: #fff;
	padding:0px 0px 24px;
}

#whats-happening-inner p {
	font: 500 16px/28px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	color: #fff;
	padding:0px 0px 24px;
}

#purpose {
	padding:134px 0px 70px;
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
	color: #fff;
	border-bottom:3px solid #fff;
	margin:0px 0px 24px;
	display: inline-block;
}

.purpose-list .purpose-item p {
	padding: 0px 0px 48px;
	font: 500 16px/28px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	color: #fff;
}

#lets-do-this, #events {
	padding:64px 0px 22px;
	/*background: #EFEFEF;*/
}

#lets-do-this-inner, #events-inner {
	width:300px;
	margin:0 auto;
}

h4.title {
	font: Bold 20px/32px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 1px;
	color: #fff;
	border-bottom:3px solid #fff;
	margin:0px 0px 32px;
	display: inline-block;
}

.info-item dt {
	font: Bold 18px/30px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.54px;
	color: #fff;
	width:40px;
	float:left;
}

.info-item dd {
	padding:0px 0px 48px 32px;
}

.info-item dd .title {
	font: 500 20px/30px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 1px;
	color: #8c8c8c;
	padding:0px 0px 12px;
}

.info-item dd .desc {
	font: 500 16px/28px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	color: #8c8c8c;
}

.info-item dd .time {
	font: 600 15px/25px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 1.5px;
	color: #8c8c8c;
	padding:0px 0px 12px;
}

.info-item-hr {
	height: 1px;
	background: #fff;
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
	color: #fff;
}

.info-item.full.light dt {
	color: #8c8c8c;
}

.info-item.full.light dd p {
	color: #8c8c8c;
}

#make-a-difference-now {
	padding:24px 0px 70px;
}

#make-a-difference-now-inner {
	width:320px;
	padding:58px 30px 72px;
	margin:0 auto;
	background: #747474;
	border-radius: 30px;
}

#make-a-difference-now-inner h2.title {
	text-align: center;
	color:#fff;
}

#make-a-difference-now-inner p.desc {
	text-align: center;
	padding:0px 40px 24px;
	font: 500 16px/28px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	color: #fff;
}

#cta-button {
	display: block;
	margin:0 auto;
	width:160px;
	height: 64px;
	background: #000000;
	border: 3px solid #000000;
	border-radius: 47px;
	text-align: center;
	font: Bold 16px/26px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.48px;
	color: #fff;
	padding:8px 0px 0px;
}

#cta-button span{
	display: block;
	font: 600 12px/12px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.36px;
}

#sponsors {
	padding:0px 0px 100px;
	/*background: #EFEFEF;*/
}

#sponsors-inner {
	width:320px;
	margin:0 auto;
	/*background: #FFFFFF;*/
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
	/*background: #EFEFEF;*/
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

#main-container {
	margin-top:30px;
}

.hero-image {
	padding-top:120px;
	z-index:10;
	background: #000;
	position: relative;
}

.hero-image .desktop {
	max-width: 1100px;
	margin: 30px auto 0px;
	position: relative;
	z-index: 10;
}

.header-section {
	padding:100px 0px 0px;
}

.header-section-inner {
	width:1100px;
	padding:0px 150px;
}

.header-section h1 {
	font: Bold 45px/65px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	color:#fff;
}

.header-section h1 span {
	padding:50px 0px 40px;
}

.header-section .custom-menu .custom-menu-item {
	vertical-align: top;
	display: inline-block;
	padding:0px 36px 0px 0px;
	font: normal normal bold 14px/18px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	height: 54px;
}

.header-section .custom-menu .custom-menu-item a:hover {
	color:#8C8C8C;
}

#whats-happening, #news {
	padding:100px 0px;
	/*background: #efefef;*/
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
	/*background: #efefef;*/
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

#lets-do-this, #events {
	padding:100px 0px 30px;
	/*background: #EFEFEF;*/
}

#lets-do-this-inner, #events-inner {
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
}

.info-item dd .time {
	font: 600 18px/28px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 1.8px;
	padding:0px 0px 20px;
}

.info-item-hr {
	height: 2px;
	background: #fff;
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

/*#cta-button:hover {
	background:#DBDBDB;
	border-color:#DBDBDB;
	color:#000;
}*/

#cta-button span{
	font: 600 15px/25px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.45px;
}

#sponsors {
	padding:40px 0px 100px;
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
	color:#fff;
}

}
</style>

<div class="page-container">
	<div id="pined-flag">The Void of 22</div>
	<div class="hero-image">
		<img class="mobile" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/the_void_of_22_exhibition/'; ?>solicit-mobile-cover-3.png" />
		<img class="desktop" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/the_void_of_22_exhibition/'; ?>solicit-web-cover-3.png" />
		<div class="desktop-block"></div>
	</div>

	<div class="header-section">
		<div class="header-section-inner">
			<h1>The Void of 22<span>線上創作展</span></h1>
			<ul class="custom-menu">
				<!-- <li class="custom-menu-item"><a class="smooth-scroll" href="#news"><span class="mobile">0 </span>ANNOUNCEMENT</a></li> -->
				<li class="custom-menu-item"><a class="smooth-scroll" href="#whats-happening"><span class="mobile">1 </span>WHAT'S <br class="desktop" />HAPPENING</a></li>
				<li class="custom-menu-item"><a class="smooth-scroll" href="#purpose"><span class="mobile">2 </span>PURPOSE</a></li>
				<li class="custom-menu-item"><a class="smooth-scroll" href="#lets-do-this"><span class="mobile">3 </span>LET'S DO <br class="desktop" />THIS!</a></li>
				<li class="custom-menu-item"><a class="smooth-scroll" href="#events"><span class="mobile">4 </span>EVENTS</a></li>
				<li class="custom-menu-item"><a class="smooth-scroll" href="#make-a-difference-now"><span class="mobile">5 </span>MAKE <br class="desktop" />A DIFFERENCE <br class="desktop" />NOW</a></li>
			</ul>
		</div>
	</div>

	<!-- <style>
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
			<?php //the_post(); the_content(); ?>
		</div>
	</div> -->
	
	<div id="whats-happening">
		<div id="whats-happening-inner">
			<h2 class="title">1</h2>
			<h2 class="title">WHAT’S HAPPENING</h2>
			<p>畢業，象徵了一切的終結，但同時也是一切的起頭。擠在這矛盾的時間點，我們呼吸，我們創作。Void，擁有空白，失落的意思，正如畢業給人既振奮，卻又不安的情緒。它同時乘載了不見底的抽象空間之意，一切雖然看似虛無，卻實然擁有無遠弗界的可能。</p>
     		<p>《The Void of 22》，是獻給每個 22 歲靈魂的專屬展覽。在這裏，世界將因為每個對作品的那份真心誠意，而變得溫柔，美麗。</p>
      		<p>FLiPER 繼去年《＿＿22 線上設計展》近 600 件作品的熱烈響應，今年將展覽擴大，從設計提升至創作。我們希望更多來自 22 歲的呢喃，可以被世界看見。</p>
      		<p>當每個人都能找到自己熱愛的事物時，世界會變成一個更美好的地方。現在就加入我們，讓 22 成為自己最耀眼的那一刻。</p>
		</div>
		<div class="blank mobile"></div>
	</div>
	<div id="purpose">
		<div id="purpose-inner">
			<h2 class="title">2</h2>
			<h2 class="title">PURPOSE</h2>
			<div class="purpose-list">
				<div class="purpose-item">
					<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/the_void_of_22_exhibition/'; ?>22-event-page-pic02.png" />
					<h3 class="title">FOR CREATORS</h3>
					<p>學生身份的終結，代表了某種自由的逝世，面對未來的恐懼與不安，也許我們將有好一段時間無法純粹的依照自己的理念來創作，然而在這個創作展中，我們可以永久保存 22 歲的自己，更可以跨出時間空間的侷限，透過 FLiPER 的力量，讓 22 歲時期的奇想，被更多人看見。</p>
				</div>
				<div class="purpose-item">
					<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/the_void_of_22_exhibition/'; ?>22-event-page-pic03.png" />
					<h3 class="title">FOR AUDIENCE</h3>
					<p>還記得 22 歲的自己，是什麼樣子嗎？那是一個極度強韌，又極度脆弱的年紀。當時的我們，帶著無數個理想以及想像邁開步伐離開了校園，殊不知名為人生的遊戲，才即將開始。然而數隔多年回頭看的時候我們反而會發現，少一點妥協的作品，多了好多閃閃發光的純粹......。</p>
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
						<dt>展出內容</dt>
						<dd>
							<div class="title">2021 年度畢業生創作之作品</div>
							<!-- <div class="desc">FLiPER 網站</div> -->
						</dd>
					</dl>
					<dl class="info">
						<dt>展出位置</dt>
						<dd>
							<div class="title">The Void of 22<br/>專屬網頁 </div>
							<!-- <div class="desc">FLiPER 網站</div> -->
						</dd>
					</dl>
					<dl class="info">
						<dt>展出時間</dt>
						<dd>
							<div class="title pb-10">2021.06.21 MON</div>
							<div class="time">06:00:00-</div>
							<div class="desc">至天荒地老（展出內容將永久保留在 FLiPER 平台上）</div>
						</dd>
					</dl>
				</div>
				<div class="info-item full">
					<dl class="info">
						<dt>活動獎勵</dt>
						<dd>
							<p>參加周邊活動，將有機會獲得：</p>
							<p>・巨匠電腦價值三萬以上之課程<br/>
							・2022 年書上設計展展出資格<br/>
							（詳細辦法請見下列 Events 說明）</p>
						</dd>
					</dl>
				</div>
				<div class="info-item-hr"></div>
				<h4 class="title">徵件辦法</h4>
				<div class="info-item">
					<dl class="info">
						<dt>參加資格</dt>
						<dd>
							<div class="title pb-10">2021 年大專院校應屆畢業生</div>
							<div class="desc">畢業製作作品，或具畢業製作意義的創作作品</div>
						</dd>
					</dl>
					<dl class="info">
						<dt>徵件期間</dt>
						<dd>
							<div class="title pb-10">2021.05.03 - 06.14</div>
							<div class="time">-23:59:59</div>
						</dd>
					</dl>
					<dl class="info">
						<dt>展覽費用</dt>
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
							<p>1. 每個作品需包含一張「封面圖片」與「作品名稱」。<br/>
							2. 作品內容文字字數不限，但需分段清楚，並使用正確的標點符號。<br/>
							3. 作品圖片說明：<br/>
							- 最小寬度建議為 1100px 以上，最大請在單邊 3000px 內。<br/>
							- 封面圖會維持原圖片比例呈現，直式圖片比例最長限 1 : 1.5，比例過長的圖片會自動裁切上下。<br/>
							- 承上，封面圖會維持比例呈現在所有作品的列表中。<br/>
							4. 影片請上傳到 YouTube 或是 Vimeo，作品內容影片檔案數不限，但需將檔案先上傳至團隊自有的 YouTube 帳號，再於表單內提供嵌入連結。</p>
						</dd>
					</dl>
				</div>
				<div class="info-item full light">
					<dl class="info">
						<dt>其他辦法</dt>
						<dd>
							<p>使用權利：<br/>
							完成報名後，所有作品、展覽與團隊之相關內容即視為同意 FLiPER 於自有平台上發表（包含但不限於 FLiPER 網站、Facebook 粉絲團、Instagram 帳號或其他由 FLiPER 所經營之網路平台）。若因不可抗力因素造成活動舉辦困難，FLiPER 保有修改及終止本活動之權利，如有任何變更內容或詳細注意事項將公布於 FLiPER 官方網站。</p>
							<p>對於活動有任何問題，請來信至 22.exhibition@flipermag.com 詢問。</p>
						</dd>
					</dl>
				</div>
				<div class="info-item full light">
					<dl class="info">
						<dt>Q&A</dt>
						<dd>
							<p>Ｑ：什麼是具畢業製作意義的創作作品？<br/>
							Ａ：凡應屆畢業生（不限科系）於當年度創作之作品，不需與學校課程、學分綁定。</p>
							<p>Ｑ：什麼叫創作類作品？<br/>
							Ａ：平面設計、遊戲設計、電影、美術、攝影、多媒體等內容都屬於創作類之範疇。</p>
						</dd>
					</dl>
				</div>
			</div>
		</div>
	</div>

	<div id="events">
		<div id="events-inner">
			<h2 class="title">4</h2>
			<h2 class="title">EVENTS</h2>
			<div class="info-list">
				<h4 class="title">匠🌟獨具賞</h4>
				<div class="info-item">
					<dl class="info">
						<dt>參加資格</dt>
						<dd>
							<div class="title">The Viod of 22<br/>參加作品均可報名</div>
						</dd>
					</dl>
					<dl class="info">
						<dt>票選時間</dt>
						<dd>
							<div class="title pb-10">2021.06.21 - 07.19</div>
							<div class="time">-23:59:59</div>
						</dd>
					</dl>
				</div>
				<div class="info-item full">
					<dl class="info">
						<dt>活動介紹</dt>
						<dd>
							<p>匠🌟獨具賞為巨匠設計與 FLiPER，為了鼓勵畢業生在離開校園後，還能持續充實精進創作技能，進而共同舉辦之參展作品票選大賞活動。無論是參展的作者們，還是參與投票的一般民眾，都有機會獲得精彩大獎，最大獎總價值超過三萬元！！！趕快下滑看詳細活動辦法吧！！！</p>
						</dd>
					</dl>
				</div>
				<div class="info-item full">
					<dl class="info">
						<dt>參加辦法</dt>
						<dd>
							<p>1.於徵件表單，勾選參加匠🌟獨具賞。<br/>
								（凡參加匠🌟獨具賞參展者都可以獲得價值 NT$ 1,500 的課程體驗）<br/>
								2.展覽期間，累積票數經結算後，總分最高者將獲得巨匠設計進階課程。<br/>
								3.計算方式：0.6（單一選項票數計算成PR值）＋0.4 (專人審核）之總分大小比較。</p>
						</dd>
					</dl>
				</div>
				<div class="info-item full">
					<dl class="info">
						<dt>獎勵資訊</dt>
						<dd>
							<p>票選計算後第一名者，將可獲得價值三萬元以上巨匠設計學院進階課程獎勵，優選兩組將可獲得價值 12,000 元以上課程。另外第 4 - 13 名，將可獲得價值超過 6,000 元課程。</p>
        					<p>所有參加作品，均可獲得價值 1,500 元的三小時體驗課資格。</p>
						</dd>
					</dl>
				</div>
				<div class="info-item-hr" style="background: #747474;"></div>
				<h4 class="title">尼普利《書上設計展2022》實體書刊登</h4>
				<!-- <div class="info-item">
					<dl class="info">
						<dt>參加資格</dt>
						<dd>
							<div class="title">2021 年大專院校應屆畢業生之畢業製作，或具畢業製作意義的創作作品</div>
						</dd>
					</dl>
					<dl class="info">
						<dt>徵件截止</dt>
						<dd>
							<div class="title pb-10">2020.05.31 MON</div>
							<div class="time">-23:59:59</div>
						</dd>
					</dl>
					<dl class="info">
						<dt>展覽費用</dt>
						<dd>
							<div class="title pb-10">FREE</div>
							<div class="desc">免費</div>
						</dd>
					</dl>
				</div> -->
				<div class="info-item full">
					<dl class="info">
						<dt>活動辦法</dt>
						<dd>
							<p>為了讓好的作品被更多人看見，本次線上創作展將與尼普利編輯室的書上設計展合作，於今年的展件中，透過內部推薦的方式，推薦作品至 《書上設計展2022》，獲選的作品即可以將作品刊登在《書上設計展2022》專刊中，並經各大書局經銷商通路販售。</p>
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
			<p class="desc">現在就加入我們，繼續用溫柔堅定的心，<br class="desktop" /><br class="desktop" />向世界宣告，我們來了。</p>
			<div class="cta-button-wrap">
				<?php /*if ( is_user_logged_in() ) : ?>
				<a id="cta-button" href="/wp-admin/post-new.php?post_type=fliper_artwork">我要報名<span>SIGN UP</span></a>
				<?php else : ?>
				<a id="cta-button" class="not-login" href="#">我要報名<span>SIGN UP</span></a>
				<?php endif; */ ?>
				<div id="cta-button">報名截止<span>Has Ended</span></div>
			</div>
		</div>
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

	$('#cta-button.not-login').click(function(e){
		e.preventDefault();
		$('#login-redirect').val('/wp-admin/post-new.php?post_type=fliper_artwork');
		$('.login-error').hide();
		$('#global-glass').show();
		$('#login-popup').show();
		$('body').css('overflow', 'hidden');
	});

});
</script>


<?php get_footer(); ?>