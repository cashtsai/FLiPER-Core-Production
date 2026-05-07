<?php 

$org = get_term_by( 'id', get_field( 'artwork_org', get_the_ID() ), 'artwork_org');
$dept = get_term_by( 'id', get_field( 'artwork_org_dept', get_the_ID() ), 'artwork_org_dept');
$authors = get_field( 'artwork_author', get_the_ID() );

$website = get_field( 'website', get_the_ID() );
$artwork_fb = get_field( 'artwork_fb', get_the_ID() );
$artwork_ig = get_field( 'artwork_ig', get_the_ID() );

if ( has_term( 'the-void-of-22', 'artwork_related_event' ) ||
	has_term( 'xu-baozhen-online-calligraphy-exhibition', 'artwork_related_event' )
 ) :

wp_enqueue_style( 'single-fliper_artwork', get_stylesheet_directory_uri() . '/assets/css/single-fliper_artwork.css', array(), filemtime( get_stylesheet_directory() . '/assets/css/single-fliper_artwork.css' ) );

get_header(); 

?>

<style>
* {
	box-sizing: border-box;
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

.login-popup-inner-wrap {
	box-sizing: unset !important;
}

#main-menu {
	display: none;
}

.full-artwork-wrap {
	margin-top:0px;
	padding-top:0px;
	position: relative;
}

.close-artwork.iconset-22 {
	position: fixed;
	right:32px;
	top:32px;
	width:32px;
	height: 32px;
	background-position: 0px 0px;
	cursor:pointer;
}

.close-artwork.iconset-22:hover {
	background-position: -33px 0px;
}

.artwork-cover-wrap {
	max-width: 1100px;
	width: 100%;
	margin:0 auto;
	padding-bottom:40px;
}
.artwork-cover {
	width: 100%;
}

.exhibition-room {
	font: normal normal normal 14px/22px 'EB Garamond', 'notoserifcjktc';
	letter-spacing: 0.7px;
	padding:12px 0px;
}

h1 {
	letter-spacing: 1.4px !important;
	padding:24px 0px !important;
	font: 500 28px/40px 'EB Garamond', 'notoserifcjktc' !important;
	color:#fff !important;
}

.artwork-meta {
	max-width: 1100px;
	width: 100%;
	padding:40px 90px 50px !important;
	margin:0 auto;
	color:#ffffff;
}

.artwork-meta .left {
	float:left;
	width: 242px;
	padding-right:0px !important;
}

.artwork-meta .right {
	float:right;
	width: 550px !important;
	position: static !important;
}

.artwork-meta .right.gjun {
	width: 300px !important;
    top: 52px !important;
    right: 50% !important;
    text-align: center !important;
    position: absolute !important;
    margin-right:-150px;
}


.artwork-meta-author-wrap, .artwork-meta-category-wrap {
	padding:16px 0px;
}

.copy-link-wrap {
	padding-top:16px;
	margin-bottom:16px;
}

.copy-link {
	font: normal normal normal 14px/22px EB Garamond;
	letter-spacing: 0.7px;
	color: #FFFFFF;
	margin-right: 8px;
	border-bottom:1px solid #fff;
	float:left;
	cursor: pointer;
}

.copy-link-wrap .iconset-22 {
	width:22px;
	height: 22px;
	float:left;
	background-position: -0px -58px;
	cursor: pointer;
}

.copy-link-wrap .iconset-22:hover,
.copy-link:hover ~ .iconset-22 {
	background-position: -23px -58px;
}

.artwork-meta-label {
	padding:8px 0px;
	font: normal normal 600 16px/24px 'EB Garamond', 'notoserifcjktc';
	letter-spacing: 0.8px;
	color: #8C8C8C;
}

.artwork-meta .top-author, .artwork-meta .artwork-category {
	padding:8px 0px !important;
	font: normal normal 300 16px/28px 'EB Garamond', 'notoserifcjktc' !important;
	letter-spacing: 0.4px !important;
	color: #FFFFFF !important;
}

.artwork-meta .artwork-intro {
	text-align: left;
	padding:24px 0px !important;
	font: normal normal 300 16px/28px 'EB Garamond', 'notoserifcjktc' !important;
	letter-spacing: 0.4px !important;
	color: #FFFFFF !important;
}

.full-artwork-wrap .full-artwork {
	padding:100px 0px !important;
	margin:40px auto 50px !important;
	width:1100px;
}

.full-artwork-wrap .artwork-content .title {
	padding:16px 175px 0px;
	font: normal normal 500 20px/32px 'Zilla Slab', 'Noto Sans TC';
	letter-spacing: 1px;
	color: #1A1A1A;
}

.full-artwork-wrap .artwork-content .image {
	padding:16px 0px 80px;
}

.full-artwork-wrap .artwork-content .image.normal,
.full-artwork-wrap .artwork-content .youtube.normal {
	padding-left:175px;
	padding-right:175px;
}

.full-artwork-wrap .artwork-content .text {
	padding:16px 175px 80px;
	text-align: justify;
	font: normal normal 400 16px/30px 'Zilla Slab', 'Noto Sans TC';
	color: #1A1A1A;
}

.full-artwork-wrap .artwork-content .text .link:after {
	content: '｜';
	display: inline-block;
	color:#1A1A1A;
	font: normal normal 400 16px/30px 'Zilla Slab', 'Noto Sans TC';
}

.full-artwork-wrap .artwork-content .text .link:last-child:after {
	display: none;
}

.artwork-sep {
	margin:50px 100px;
	border:1px solid #707070;
	border-top:0px;
}

.full-artwork-wrap .artwork-author-wrap {
	background:#fff;
	padding:16px 175px;
	margin:0px;
}

.full-artwork-wrap .artwork-author-wrap .artwork-author h2 {
	font: normal normal 600 18px/24px 'Zilla Slab', 'Noto Sans TC';
	letter-spacing: 0px;
	color: #1A1A1A;
	padding: 0px 0px 20px 0px;
}

.artwork-info-wrap {
	padding:20px 0px;
}

.artwork-info-wrap .artwork-info-label {
	font: normal normal normal 12px/16px 'Zilla Slab', 'Noto Sans TC';
	letter-spacing: 0px;
	color: #1A1A1A;
	float:left;
}

.artwork-info-wrap .artwork-info-data-wrap {
	position: relative;
}

.artwork-info-wrap .artwork-info-data-wrap.author {
	border-bottom:1px solid rgba(112, 112, 112, 0.1);
	margin-left:118px;
}

.artwork-info-wrap .artwork-info-data-wrap.author:last-child {
	border-bottom:0px;
}

.artwork-info-wrap .artwork-info-data {
	font: normal normal normal 12px/16px 'Zilla Slab', 'Noto Sans TC';
	letter-spacing: 0px;
	color: #4B4B4B;
	padding:16px 0px 16px 118px;
	width:632px;
}

.artwork-info-wrap .artwork-info-data:first-child {
	padding-top:0px;
}

.artwork-info-link-wrap {
	width: 150px;
	height: 16px;
	position: absolute;
	top:0px;
	right:0px;
}

.artwork-info-link {
	width: 50px;
	height: 16px;
	text-align: center;
	font: normal normal normal 12px/16px Zilla Slab;
	letter-spacing: 0px;
	color: #4B4B4B;
	float:right;
}

.artwork-info-wrap .artwork-info-data-wrap.author .artwork-info-link-wrap {
	top:16px;
}

.artwork-info-author-name {
	font: normal normal normal 12px/16px 'Zilla Slab', 'Noto Sans TC';
	letter-spacing: 0px;
	color: #4B4B4B;
	padding:16px 0px;
	width: 100px;
	float:left;
}

.artwork-info-author-email {
	font: normal normal normal 12px/16px 'Zilla Slab', 'Noto Sans TC';
	letter-spacing: 0px;
	color: #4B4B4B;
	padding:16px 0px;
	width: 250px;
	margin-left:45px;
	float:left;
	display: block;
}

.footer-control {
	padding:50px 0px 32px;
	width: 1100px;
	margin:0 auto;
	position: relative;
}

.footer-control div {
	cursor: pointer;
	font: normal normal normal 20px/24px EB Garamond;
	letter-spacing: 0px;
	color: #FFFFFF;
	text-align: center;
	width: 80px;
    margin: 0 auto;
}

.footer-control div:hover {
	color:#A0A0A0;
}

.footer-control .prev {
	float:left;
	width:100px;
	height: 24px;
	background-position: -100px -33px; 
	display: block;
}

.footer-control .prev:hover,
.footer-control .next:hover {
	background-position: -201px -33px; 
}

.footer-control .next {
	position: absolute;
	right:0px;
	top:50px;
	width:100px;
	height: 24px;
	background-position: -100px -33px; 
	transform: rotate(0.5turn);
	display: block;
}

.gjun-vote-wrap {
	padding-top:30px;
}

.gjun-vote-wrap .gjun-vote-button {
    float: right;
    width: 88px;
    height: 40px;
    margin-left: 16px;
    background-position: 0px -122px;
    position: relative;
    margin-top:0px;
    cursor: pointer;
}

.gjun-vote-wrap .gjun-vote-button.active {
	background-position: -89px -122px;
}

.gjun-vote-wrap > div {
    float: right;
    font: normal normal normal 12px/16px 'Zilla Slab','Noto Sans TC';
    color: #747474;
    margin-top: 24px;
}

.gjun-vote-wrap > div a {
	color: #747474;
	text-decoration: underline;
}

.iconset-22 {
	background-size: 1000px !important;
	background:url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/the_void_of_22_exhibition/0616_icon@2x.png);
}

.gjun-vote-panel {
    position: absolute;
    width: 400px;
    background: #1A1A1A 0% 0% no-repeat padding-box;
    box-shadow: 4px 4px 10px #0000004D;
    border-radius: 5px;
    right: 0px;
    z-index: 10;
    bottom: 50px;
    padding: 32px 40px 48px;
    cursor: default;
    display: none;
}

.gjun-vote-button.active .gjun-vote-panel {
	display: block;
}

.gjun-vote-button-top.active .gjun-vote-panel {
	display: block;
}

.gjun-vote-button-top .gjun-vote-panel {
    text-align: left;
    right: 90px;
    bottom: unset;
    top: 85px;
}

.gjun-vote-panel > div:nth-child(1) {
    font: normal normal normal 12px/18px 'Zilla Slab','Noto Sans TC';
    letter-spacing: 0px;
    color: #FFFFFF;
    padding: 10px;
}

.gjun-vote-panel > div > label {
	padding:10px 10px 10px 40px;
	font: normal normal normal 14px/20px 'Zilla Slab','Noto Sans TC';
    letter-spacing: 0px;
    color: #FFFFFF;
    position: relative;
    display: inline-block;
    width:150px;
}

.gjun-vote-panel > div > label input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

.gjun-vote-panel > div > label .circle {
  position: absolute;
  top: 10px;
  left: 10px;
  height: 20px;
  width: 20px;
  background-color: #fff;
  border-radius: 20px;
}

.gjun-vote-panel > div > label .circle:after {
  content: "";
  position: absolute;
  display: none;
}

.gjun-vote-panel > div > label input:checked ~ .circle:after {
  display: block;
}

.gjun-vote-panel > div > label .circle:after {
  left: 4px;
  top: 4px;
  width: 12px;
  height: 12px;
  border-radius: 12px;
  background:#1A1A1A;
}

.gjun-vote-panel > div > label:hover {
	cursor: pointer;
}

.gjun-vote-panel > div:nth-child(3) {
	padding-top:32px;
	padding-bottom:16px;
	color: #C7C7C7;
	font: normal normal normal 12px/30px 'Zilla Slab','Noto Sans TC';
}

.gjun-vote-panel .vote-button {
	width:160px;
	height: 36px;
	margin:16px auto;
	background: #747474;
	border-radius: 18px;
	color:#FFF;
	cursor: pointer;
	display: block;
	font: normal normal 500 14px/20px 'Zilla Slab','Noto Sans TC';
	color: #FFFFFF;
	border:0px;
	cursor: default;
}

/*.gjun-vote-panel .vote-button:hover {
	background: #4B4B4B;
}*/

.gjun-vote-panel .status-success,
.gjun-vote-panel .status-voted,
.gjun-vote-panel .status-error,
.gjun-vote-panel .status-error-voted {
	width:220px;
	height:28px;
	position: absolute;
	bottom:20px;
	left:50%;
	margin-left:-110px;
	text-align: center;
	font: normal normal normal 12px/28px 'Zilla Slab','Noto Sans TC';
	letter-spacing: 0px;
	color: #FFFFFF;
	border-radius: 5px;
	display: none;
}

.status-success {
    background: #4C775D;
    
}

.status-error, 
.status-error-voted {
	background: #C65555;
}

.gjun-vote-panel a {
    color: #c7c7c7 !important;
    text-decoration: underline;
}

@media screen and (max-width: 1099px) {
	._mobile {
		display: block !important;
	}

	._desktop {
		display: none !important;
	}


	.full-artwork-wrap .artwork-meta {
		width:320px;
		margin:0 auto;
		padding:20px 0px 60px !important;
	}

	.close-artwork.iconset-22 {
		right:16px;
		top:16px;
		width:24px;
		height: 24px;
		background-position: 0px -33px;
	}

	.close-artwork.iconset-22:hover {
		background-position: -25px -33px;
	}

	.full-artwork-wrap .artwork-meta h1 {
		letter-spacing: 1.3px !important;
		padding:28px 0px !important;
		font: 500 26px/38px 'EB Garamond', 'notoserifcjktc' !important;
	}

	.artwork-meta .left {
		width:100%;
	}

	.artwork-info-wrap .artwork-info-label {
		font: normal normal 600 16px/24px 'Zilla Slab', 'Noto Sans TC';
		letter-spacing: 0.4px;
		color: #8C8C8C;
		float:left;
	}

	.artwork-meta .top-author, .artwork-meta .artwork-category {
		padding:8px 0px !important;
		font: normal normal normal 14px/22px 'EB Garamond', 'notoserifcjktc' !important;
		letter-spacing: 0.35px !important;
		color: #FFFFFF !important;
	}

	.artwork-meta .right {
		width: 100% !important;
	}

	.artwork-meta .right.gjun {
		width: 100% !important;
    	position: static !important;
    	text-align: left !important;
    	margin-right:0px;
	}

	.artwork-meta .right.gjun-vote-button-top {
		position: absolute !important;
		right:0px;
	}

	.gjun-vote-button-top.active .gjun-vote-panel {
		right: -15px;
    	top: 33px;
    	left:unset;
	}

	.artwork-meta .artwork-intro {
		text-align: left;
		padding:16px 0px !important;
	}

	.full-artwork-wrap .full-artwork {
		padding:60px 0px 80px !important;
		margin:20px auto 60px !important;
		width:100%;
	}

	.full-artwork-wrap .artwork-content .title {
		padding:16px 0px 0px;
		width:310px;
		margin:0 auto;
		font: 500 500 500 20px/32px 'Zilla Slab', 'Noto Sans TC';
	}

	.full-artwork-wrap .artwork-content .image {
		padding:16px 0px 60px;
	}

	.full-artwork-wrap .artwork-content .image.normal,
	.full-artwork-wrap .artwork-content .youtube.normal {
		padding-left:0px;
		padding-right:0px;
		width: 310px;
		margin:0 auto;
	}

	.full-artwork-wrap .artwork-content .text {
		padding:16px 0px 60px;
		width: 310px;
		margin:0 auto;
	}

	.artwork-sep {
		width: 360px;
		margin:50px auto;
	}

	.full-artwork-wrap .artwork-author-wrap {
		width: 310px;
		padding:0px;
		margin:0 auto;
	}

	.full-artwork-wrap .artwork-author-wrap .artwork-author h2 {
		padding: 16px 0px 12px 0px;
	}

	.artwork-info-wrap {
		padding:40px 0px;
	}

	.artwork-info-wrap .artwork-info-label {
		font: normal normal normal 14px/20px 'Zilla Slab', 'Noto Sans TC';
		width:310px;
		color:#1A1A1A;
		float:none;
		padding-bottom:22px;
	}

	.artwork-info-wrap .artwork-info-data-wrap.author {
		margin-left:0px;
		padding:10px 0px;
	}

	.artwork-info-wrap .artwork-info-data {
		font: normal normal normal 14px/20px 'Zilla Slab', 'Noto Sans TC';
		color: #4B4B4B;
		padding:8px 0px;
		width:310px;
		margin:0 auto;
	}

	.artwork-info-link-wrap {
		width: 240px;
		height: 20px;
		position: static;
		padding:8px 0px;
	}

	.artwork-info-link {
		width: 80px;
		height: 20px;
		text-align: left;
		font: normal normal normal 14px/20px Zilla Slab;
		color: #4B4B4B;
		float:left;
	}

	.artwork-info-author-name {
		font: normal normal normal 14px/20px 'Zilla Slab', 'Noto Sans TC';
		letter-spacing: 0px;
		color: #4B4B4B;
		padding:8px 0px;
		width: 310px;
		float:none;
		margin:0 auto;
	}

	.artwork-info-author-email {
		font: normal normal normal 14px/20px 'Zilla Slab', 'Noto Sans TC';
		letter-spacing: 0px;
		color: #4B4B4B;
		padding:8px 0px;
		width: 310px;
		margin-left:0px;
		float:none;
		margin:0 auto;
	}

	.footer-control {
		width: 360px;
		padding:16px 0px 16px;
	}

	.footer-control .next {
		top:16px;
	}

	.exhibition-room {
		position: relative;
	}

	.exhibition-room .left {
		margin-top:8px;
	}

	.gjun-vote-panel {
	    width: 340px;
	    left: -15px;
	    bottom: 56px;
	    padding: 24px 40px 60px;
	}

	.gjun-vote-panel>div:nth-child(1) {
	    padding-top: 30px;
	    padding-bottom: 14px;
	}

	.gjun-vote-panel>div>label {
	    padding-top: 14px;
	    padding-bottom: 14px;
	}

	.gjun-vote-panel>div>label .circle {
	    top: 14px;
	}

	.gjun-vote-panel .status-success,
	.gjun-vote-panel .status-voted,
	.gjun-vote-panel .status-error,
	.gjun-vote-panel .status-error-voted {
		bottom:32px;
	}

	.gjun-vote-wrap .gjun-vote-button {
		float:none;
		margin-left:0px;
		margin-top:16px;
	}
}


</style>

<?php if ( have_posts() ) : the_post(); ?>
<div class="full-artwork-wrap">
	<div class="close-artwork iconset-22"></div>

	<div class="artwork-cover-wrap">
		<img class="artwork-cover" src="<?php echo wp_get_attachment_image_src( get_field( 'artwork_cover', get_the_ID() ), 'full' )[0]; ?>" />
	</div>
	<div class="artwork-meta clearfix">
		<?php if ( has_term( 'the-void-of-22', 'artwork_related_event' ) ) : ?>
		<div class="exhibition-room clearfix">
			<?php if ( has_term( 'hall-1', 'artwork_related_event' ) ) : ?>
				<div class="right <?php if ( 'pcschool-star-award-2021' == $_GET['so'] ) { echo 'gjun'; } ?>">Exhibition Room 01</div>
				<div class="left">派對現場</div>
			<?php elseif ( has_term( 'hall-2', 'artwork_related_event' ) ) : ?> 
				<div class="right <?php if ( 'pcschool-star-award-2021' == $_GET['so'] ) { echo 'gjun'; } ?>">Exhibition Room 02</div>
				<div class="left">夢境長廊</div>
			<?php elseif ( has_term( 'hall-3', 'artwork_related_event' ) ) : ?> 
				<div class="right <?php if ( 'pcschool-star-award-2021' == $_GET['so'] ) { echo 'gjun'; } ?>">Exhibition Room 03</div>
				<div class="left">共生之島</div>
			<?php elseif ( has_term( 'hall-4', 'artwork_related_event' ) ) : ?> 
				<div class="right <?php if ( 'pcschool-star-award-2021' == $_GET['so'] ) { echo 'gjun'; } ?>">Exhibition Room 04</div>
				<div class="left">日記工廠</div>
			<?php endif; ?>
			<?php if ( 'pcschool-star-award-2021' == $_GET['so'] ) : ?>
				<div class="right gjun-vote-button-top" style="border-bottom:1px solid #fff;cursor:pointer;width:auto !important;">投票給作品🌟
					<div class="gjun-vote-panel">
						<div>匠🌟獨具賞－投票選出你最推薦這個作品的發展領域：</div>
						<div>
							<?php 
								$v = get_post_meta( get_the_ID(), 'vote_1_1', true );
								if ( ! $v ) :
									global $wpdb;
									// 更新票數
									$sql = 'SELECT COUNT(vote_id) FROM wp_votes WHERE post_id =' . get_the_ID() . ' AND event_id = 1 AND event_item_id = 1';
									$count = $wpdb->get_var( $sql );
									update_post_meta( get_the_ID(), 'vote_1_1', $count);
								endif;
							?>
							<label>遊戲原創（<span><?php $v = get_post_meta( get_the_ID(), 'vote_1_1', true ); echo $v != '' ? $v : '0'; ?></span>）
								<input type="radio" value="1" name="top_event_item_id" checked="checked" />
								<div class="circle"></div>
							</label>
							<?php 
								$v = get_post_meta( get_the_ID(), 'vote_1_2', true );
								if ( ! $v ) :
									global $wpdb;
									// 更新票數
									$sql = 'SELECT COUNT(vote_id) FROM wp_votes WHERE post_id =' . get_the_ID() . ' AND event_id = 1 AND event_item_id = 2';
									$count = $wpdb->get_var( $sql );
									update_post_meta( get_the_ID(), 'vote_1_2', $count);
								endif;
							?>
							<label>平面設計（<span><?php $v = get_post_meta( get_the_ID(), 'vote_1_2', true ); echo $v != '' ? $v : '0'; ?></span>）
								<input type="radio" value="2" name="top_event_item_id" />
								<div class="circle"></div>
							</label>
							<?php 
								$v = get_post_meta( get_the_ID(), 'vote_1_3', true );
								if ( ! $v ) :
									global $wpdb;
									// 更新票數
									$sql = 'SELECT COUNT(vote_id) FROM wp_votes WHERE post_id =' . get_the_ID() . ' AND event_id = 1 AND event_item_id = 3';
									$count = $wpdb->get_var( $sql );
									update_post_meta( get_the_ID(), 'vote_1_3', $count);
								endif;
							?>
							<label>動態影像（<span><?php $v = get_post_meta( get_the_ID(), 'vote_1_3', true ); echo $v != '' ? $v : '0'; ?></span>）
								<input type="radio" value="3" name="top_event_item_id" />
								<div class="circle"></div>
							</label>
							<?php 
								$v = get_post_meta( get_the_ID(), 'vote_1_4', true );
								if ( ! $v ) :
									global $wpdb;
									// 更新票數
									$sql = 'SELECT COUNT(vote_id) FROM wp_votes WHERE post_id =' . get_the_ID() . ' AND event_id = 1 AND event_item_id = 4';
									$count = $wpdb->get_var( $sql );
									update_post_meta( get_the_ID(), 'vote_1_4', $count);
								endif;
							?>
							<label>室內設計（<span><?php $v = get_post_meta( get_the_ID(), 'vote_1_4', true ); echo $v != '' ? $v : '0'; ?></span>）
								<input type="radio" value="4" name="top_event_item_id" />
								<div class="circle"></div>
							</label>
						</div>
						<div>
							・參與投票即有機會抽中 iPad 第 8 代<br/>
							・一天一個帳號不論作品只能投一票<br/>
							・詳情請至<a href="https://flipermag.com/artwork-related-event/pcschool-star-award-2021/" target="_blank">巨匠活動頁面</a><br/>
							・括弧內為當前累積票數
						</div>
						<div>
							<button class="vote-button" data-post-id="<?php the_ID(); ?>" data-location="top" type="button">投票已截止</button>
						</div>
						<div class="status-success"><div class="iconset-22"></div>投票成功</div>
						<div class="status-voted">今天已經投過囉！</div>
						<div class="status-error"><div class="iconset-22"></div>系統錯誤，請聯繫客服人員</div>
						<div class="status-error-voted">今天已經投過囉！</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<h1><?php the_title(); ?></h1>
		<div class="left">
			<?php if ( has_term( 'the-void-of-22', 'artwork_related_event' ) ) : ?>
			<div class="artwork-meta-author-wrap">
				<div class="artwork-meta-label">作者</div>
				<div class="top-author"><?php $i = 0; foreach ( $authors as $a ) { if ( 0 === $i ) : echo esc_html( $a['name'] ); $i = 1;  else : echo '、' . esc_html( $a['name'] ); endif; } ?></div>
			</div>
			<div class="artwork-meta-category-wrap">
				<div class="artwork-meta-label">創作領域</div>
				<div class="artwork-category">
					<?php 
						$terms = get_the_terms( get_the_ID(), 'artwork_category' );
						$i = 0;
						foreach ( $terms as $t ) {
							if ( 0 === $i ) :
								echo $t->name;
								$i = 1;	
							else :
								echo '、' . $t->name;
							endif;
						}
					?>
				</div>
			</div>
			<?php endif; ?>
			<div class="copy-link-wrap clearfix" data-url="<?php the_permalink(); ?>">
				<div class="copy-link">Share Link</div>
				<div class="iconset-22"></div>
			</div>
		</div>
		<div class="right">
			<div class="artwork-intro"><?php echo nl2br( esc_html( get_field( 'artwork_intro', get_the_ID() ) ) ); ?></div>
		</div>
	</div>

	<?php if ( has_term( 'the-void-of-22', 'artwork_related_event' ) ) : ?>
	<div class="full-artwork">
		<div class="full-artwork-inner">
			<div class="artwork-content">
				<?php $contents = get_field( 'artwork_content', get_the_ID() );
				$links = '';
				foreach ( $contents as $c ) {
					switch ( $c['acf_fc_layout'] ) {
						case 'block_text':
							if ( $links ) :
								echo '<div class="text">' . $links . '</div>';
								$links = '';
							endif;
							echo '<div class="text">' . nl2br( esc_html( $c['text'] ) ) . '</div>';
							break;
						case 'block_image':
							if ( $links ) :
								echo '<div class="text">' . $links . '</div>';
								$links = '';
							endif;
							$layout = $c['image_layout'] == 'normal' ? 'normal' : '';
							echo '<img class="image ' . $layout . '" src="' . $c['image']['url'] . '" />';
							break;
						case 'block_video':
							if ( $links ) :
								echo '<div class="text">' . $links . '</div>';
								$links = '';
							endif;
      						$embed = new WP_Embed();
      						$layout = $c['video_layout'] == 'normal' ? 'normal' : '';
      						echo '<div class="youtube ' . $layout . '">' . $embed->shortcode( array(), $c['youtube'] ) . '</div>';
							break;
						case 'block_title':
							if ( $links ) :
								echo '<div class="text">' . $links . '</div>';
								$links = '';
							endif;
							echo '<h2 class="title">' . esc_html( $c['title'] ) . '</h2>';
							break;
						case 'block_link':
							$links .= '<a class="link" target="_blank" href="' . esc_attr( $c['link_url'] ) . '">' . esc_html( $c['link_text'] ) . '</a>';
							// echo '<div class="text"><a class="link" target="_blank" href="' . esc_attr( $c['link_url'] ) . '">' . esc_html( $c['link_text'] ) . '</a></div>'; 
							break;
					}
				}
				if ( $links ) :
					echo '<div class="text">' . $links . '</div>';
					$links = '';
				endif;
				?>
			</div>
		</div>
		<hr class="artwork-sep" />
		<div class="artwork-author-wrap">
			<div class="artwork-author">
				<h2>Info.</h2>
				<div class="artwork-info-wrap">
					<div class="artwork-info-label">作品 /</div>
					<div class="artwork-info-data-wrap">
						<div class="artwork-info-data"><?php the_title(); ?></div>
						<div class="artwork-info-link-wrap _desktop">
							<?php echo $artwork_ig == '' ? '' : '<a class="artwork-info-link" href="' . esc_attr( $artwork_ig ) . '" target="_blank">Ig.</a>'; ?>
							<?php echo $artwork_fb == '' ? '' : '<a class="artwork-info-link" href="' . esc_attr( $artwork_fb ) . '" target="_blank">Fb.</a>'; ?>
							<?php echo $website == '' ? '' : '<a class="artwork-info-link" href="' . esc_attr( $website ) . '" target="_blank">Web.</a>'; ?>
						</div>
						<div class="artwork-info-link-wrap _mobile">
							<?php echo $website == '' ? '' : '<a class="artwork-info-link" href="' . esc_attr( $website ) . '" target="_blank">Web.</a>'; ?>
							<?php echo $artwork_fb == '' ? '' : '<a class="artwork-info-link" href="' . esc_attr( $artwork_fb ) . '" target="_blank">Fb.</a>'; ?>
							<?php echo $artwork_ig == '' ? '' : '<a class="artwork-info-link" href="' . esc_attr( $artwork_ig ) . '" target="_blank">Ig.</a>'; ?>
						</div>
					</div>
				</div>
				<div class="artwork-info-wrap">
					<div class="artwork-info-label">作者 /</div>
					<div class="artwork-info-data-wrap">
						<div class="artwork-info-data"><?php echo $org->name; ?> ｜ <?php echo $dept->name; ?></div>
					</div>

					<?php foreach ( $authors as $a ) : ?>
					<div class="artwork-info-data-wrap author clearfix _desktop">
						<div class="artwork-info-author-name"><?php echo $a['name']; ?></div>
						<?php echo '' != $a['email'] ? '<div class="artwork-info-author-email">' . $a['email'] . '</div>' : ''; ?>
						<div class="artwork-info-link-wrap">
							<?php echo '' != $a['ig'] ? '<a class="artwork-info-link" href="' . esc_attr( $a['ig'] ) . '" target="_blank">Ig.</a>' : ''; ?>
							<?php echo '' != $a['fb'] ? '<a class="artwork-info-link" href="' . esc_attr( $a['fb'] ) . '" target="_blank">Fb.</a>' : ''; ?>
							<?php echo '' != $a['website'] ? '<a class="artwork-info-link" href="' . esc_attr( $a['website'] ) . '" target="_blank">Web.</a>' : ''; ?>
						</div>
					</div>
					<div class="artwork-info-data-wrap author clearfix _mobile">
						<div class="artwork-info-author-name"><?php echo $a['name']; ?></div>
						<?php echo '' != $a['email'] ? '<div class="artwork-info-author-email">' . $a['email'] . '</div>' : ''; ?>
						<div class="artwork-info-link-wrap">
							<?php echo '' != $a['website'] ? '<a class="artwork-info-link" href="' . esc_attr( $a['website'] ) . '" target="_blank">Web.</a>' : ''; ?>
							<?php echo '' != $a['fb'] ? '<a class="artwork-info-link" href="' . esc_attr( $a['fb'] ) . '" target="_blank">Fb.</a>' : ''; ?>
							<?php echo '' != $a['ig'] ? '<a class="artwork-info-link" href="' . esc_attr( $a['ig'] ) . '" target="_blank">Ig.</a>' : ''; ?>
						</div>
					</div>
					<?php endforeach; ?>
				</div>

				<?php if ( has_term( 'pcschool-star-award-2021', 'artwork_related_event' ) ) : ?>
				<div class="gjun-vote-wrap clearfix">
					<div class="_mobile" style="float:none !important;">*本作品參與<a href="https://flipermag.com/artwork-related-event/pcschool-star-award-2021/" target="_blank">匠🌟獨具賞</a>票選活動</div>
					<div class="gjun-vote-button iconset-22">
						<div class="gjun-vote-panel">
							<div>匠🌟獨具賞－投票選出你最推薦這個作品的發展領域：</div>
							<div>
								<?php 
									$v = get_post_meta( get_the_ID(), 'vote_1_1', true );
									if ( ! $v ) :
										global $wpdb;
										// 更新票數
									    $sql = 'SELECT COUNT(vote_id) FROM wp_votes WHERE post_id =' . get_the_ID() . ' AND event_id = 1 AND event_item_id = 1';
									    $count = $wpdb->get_var( $sql );
									    update_post_meta( get_the_ID(), 'vote_1_1', $count);
									endif;
								?>
								<label>遊戲原創（<span><?php $v = get_post_meta( get_the_ID(), 'vote_1_1', true ); echo $v != '' ? $v : '0'; ?></span>）
									<input type="radio" value="1" name="event_item_id" checked="checked" />
									<div class="circle"></div>
								</label>
								<?php 
									$v = get_post_meta( get_the_ID(), 'vote_1_2', true );
									if ( ! $v ) :
										global $wpdb;
										// 更新票數
									    $sql = 'SELECT COUNT(vote_id) FROM wp_votes WHERE post_id =' . get_the_ID() . ' AND event_id = 1 AND event_item_id = 2';
									    $count = $wpdb->get_var( $sql );
									    update_post_meta( get_the_ID(), 'vote_1_1', $count);
									endif;
								?>
								<label>平面設計（<span><?php $v = get_post_meta( get_the_ID(), 'vote_1_2', true ); echo $v != '' ? $v : '0'; ?></span>）
									<input type="radio" value="2" name="event_item_id" />
									<div class="circle"></div>
								</label>
								<?php 
									$v = get_post_meta( get_the_ID(), 'vote_1_3', true );
									if ( ! $v ) :
										global $wpdb;
										// 更新票數
									    $sql = 'SELECT COUNT(vote_id) FROM wp_votes WHERE post_id =' . get_the_ID() . ' AND event_id = 1 AND event_item_id = 3';
									    $count = $wpdb->get_var( $sql );
									    update_post_meta( get_the_ID(), 'vote_1_1', $count);
									endif;
								?>
								<label>動態影像（<span><?php $v = get_post_meta( get_the_ID(), 'vote_1_3', true ); echo $v != '' ? $v : '0'; ?></span>）
									<input type="radio" value="3" name="event_item_id" />
									<div class="circle"></div>
								</label>
								<?php 
									$v = get_post_meta( get_the_ID(), 'vote_1_4', true );
									if ( ! $v ) :
										global $wpdb;
										// 更新票數
									    $sql = 'SELECT COUNT(vote_id) FROM wp_votes WHERE post_id =' . get_the_ID() . ' AND event_id = 1 AND event_item_id = 4';
									    $count = $wpdb->get_var( $sql );
									    update_post_meta( get_the_ID(), 'vote_1_1', $count);
									endif;
								?>
								<label>室內設計（<span><?php $v = get_post_meta( get_the_ID(), 'vote_1_4', true ); echo $v != '' ? $v : '0'; ?></span>）
									<input type="radio" value="4" name="event_item_id" />
									<div class="circle"></div>
								</label>
							</div>
							<div>
								・參與投票即有機會抽中 iPad 第 8 代<br/>
								・一天一個帳號不論作品只能投一票<br/>
								・詳情請至<a href="https://flipermag.com/artwork-related-event/pcschool-star-award-2021/" target="_blank">巨匠活動頁面</a><br/>
								・括弧內為當前累積票數
							</div>
							<div>
								<button class="vote-button data-post-id="<?php the_ID(); ?>" data-location="bottom" type="button">投票已截止</button>
							</div>
							<div class="status-success"><div class="iconset-22"></div>投票成功</div>
							<div class="status-voted">今天已經投過囉！</div>
							<div class="status-error"><div class="iconset-22"></div>系統錯誤，請聯繫客服人員</div>
							<div class="status-error-voted">今天已經投過囉！</div>
						</div>
					</div>
					<div class="_desktop">*本作品參與<a href="https://flipermag.com/artwork-related-event/pcschool-star-award-2021/" target="_blank">匠🌟獨具賞</a>票選活動</div>
				</div>
				<?php endif; ?>
			</div>

		</div>
	</div>

	<div class="footer-control clearfix">
		<?php 
		$t = 'the-void-of-22';
		if ( 'hall-1' == $_GET['so'] ) :
			$t = 'hall-1';
		elseif ( 'hall-2' == $_GET['so'] ) :
			$t = 'hall-2';
		elseif ( 'hall-3' == $_GET['so'] ) :
			$t = 'hall-3';
		elseif ( 'hall-4' == $_GET['so'] ) :
			$t = 'hall-4';
		elseif ( 'pcschool-star-award-2021' == $_GET['so'] ) :
			$t = 'pcschool-star-award-2021';
		endif;

		$query = new WP_Query( array(
			'tax_query' => array(
		        array(
		            'taxonomy' => 'artwork_related_event',
		            'field'    => 'slug',
		            'terms'    => $t,
		        ),
		    ),
    		'post_type' => 'fliper_artwork',
    		'posts_per_page' => -1,
    		'fields' => 'ids'
		) );

		$prev_id = '';
		$next_id = '';
		$results = $query->posts;
		for ( $i = 0; $i < count( $results ); $i++ ) {
			if ( get_the_ID() == $results[ $i ] ) :
				if ( $i > 0 ) :
					$prev_id = $results[ $i - 1 ];	
				endif;
				if ( $i < count( $results ) - 1 ) :
					$next_id = $results[ $i + 1 ];
				endif;
				break;
			endif;
		}

		?>
		<?php if ( $prev_id ) : ?>
			<a href="<?php echo get_permalink( $prev_id ); ?>" class="iconset-22 prev defer-link">
		</a>
		<?php endif; ?>
		<div class="close-artwork">Close</div>
		<?php if ( $next_id ) : ?>
			<a href="<?php echo get_permalink( $next_id ); ?>" class="iconset-22 next defer-link"></a>
		<?php endif; ?>
	</div>
	<?php endif; ?>

</div>

<?php endif; ?>

<script>
jQuery('document').ready(function(){
	jQuery('body').click(function(){
		if ( jQuery(event.target).hasClass('gjun-vote-button') ) {
			event.preventDefault();
			if ( jQuery('.gjun-vote-button').hasClass('active') ) {
				jQuery('.gjun-vote-button').removeClass('active');
			} else {
				jQuery('.gjun-vote-button').addClass('active');
			}		
		} else if ( jQuery(event.target).parents('.gjun-vote-button').length ) {
			
		} else {
			jQuery('.gjun-vote-button').removeClass('active');
		}
		
		if ( jQuery(event.target).hasClass('gjun-vote-button-top') ) {
			event.preventDefault();
			if ( jQuery('.gjun-vote-button-top').hasClass('active') ) {
				jQuery('.gjun-vote-button-top').removeClass('active');
			} else {
				jQuery('.gjun-vote-button-top').addClass('active');
			}		
		} else if ( jQuery(event.target).parents('.gjun-vote-button-top').length ) {
			
		} else {
			jQuery('.gjun-vote-button-top').removeClass('active');
		}
	});

	<?php if ( has_term( 'the-void-of-22', 'artwork_related_event' ) ) : ?>
	jQuery('.close-artwork').click(function(){
		event.preventDefault();
		let url_string = window.location.href;
		let url = new URL(url_string);
		var st = '';
		if ( url.searchParams.get("st") ) {
			st = url.searchParams.get("st");
		}
		if ( 'hall-1' == url.searchParams.get("so") ) {
			window.location = '/artwork-related-event/hall-1/?st=' + st;
		} else if ( 'hall-2' == url.searchParams.get("so") ) {
			window.location = '/artwork-related-event/hall-2/?st=' + st;
		} else if ( 'hall-3' == url.searchParams.get("so") ) {
			window.location = '/artwork-related-event/hall-3/?st=' + st;
		} else if ( 'hall-4' == url.searchParams.get("so") ) {
			window.location = '/artwork-related-event/hall-4/?st=' + st;
		} else if ( 'pcschool-star-award-2021' == url.searchParams.get("so") ) {
			window.location = '/artwork-related-event/pcschool-star-award-2021/?st=' + st;
		} else {
			window.location = '/the-void-of-22-home/';
		}
	});
	<?php else: ?>
	jQuery('.close-artwork').click(function(){
		event.preventDefault();
		window.history.back();
	});
	<?php endif; ?>

	// jQuery('.vote-button').click(function(event){
	// 	event.preventDefault();

	// 	if ( jQuery(this).hasClass('not-login') ) {
	// 		jQuery('#login-redirect').val('<?php // the_permalink(); ?>');
	// 		jQuery('.login-error').hide();
	// 		jQuery('#global-glass').show();
	// 		jQuery('#login-popup').show();
	// 		jQuery('body').css('overflow', 'hidden');
	// 	} else {
	// 		jQuery('.status-error').hide();
	// 	    jQuery('.status-error').hide();
	// 	    jQuery('.status-error-voted').hide();
	// 	    jQuery('.status-success').hide();

	// 		var post_id = jQuery(this).attr('data-post-id');
	// 		var event_item_id = '';
	// 		if ( jQuery(this).attr('data-location') == 'top' ) {
	// 			event_item_id = jQuery(this).parent().parent().find('input[name=top_event_item_id]:checked').val();
	// 		} else {
	// 			event_item_id = jQuery(this).parent().parent().find('input[name=event_item_id]:checked').val();
	// 		}
	// 		var data = {
	// 	        post_id: post_id,
	// 	        event_item_id: event_item_id
	// 	    };
	// 		var _this = jQuery(this);

	// 		jQuery.post("<?php //echo admin_url('/admin-ajax.php?action=fp_vote'); ?>", data, function(response){
	// 	        if ( response == '1' ) {
	// 	       		jQuery('.status-error').show();
	// 	        } else if ( response == '2' ) {
	// 	       		jQuery('.status-error').show();
	// 	       	} else if ( response == '3' ) {
	// 	       		jQuery('.status-error-voted').show();
	// 	        } else if ( response == '4' ) {
	// 	       		jQuery('.status-success').show();
	// 	       		if ( jQuery(_this).attr('data-location') == 'top' ) {
	// 					var n = jQuery(_this).parent().parent().find('input[name=top_event_item_id]:checked').parent().find('span').text();
	// 					n = parseInt( n ) + 1;
	// 					jQuery(_this).parent().parent().find('input[name=top_event_item_id]:checked').parent().find('span').text(n);
	// 				} else {
	// 					var n = jQuery(_this).parent().parent().find('input[name=event_item_id]:checked').parent().find('span').text();
	// 					n = parseInt( n ) + 1;
	// 					jQuery(_this).parent().parent().find('input[name=event_item_id]:checked').parent().find('span').text(n);
	// 				}
	// 	       } else if ( response == '11' ) {
	// 	       		jQuery('.status-error').show();
	// 	       		alert('投票時間已結束！');
	// 	       }
	// 	    }, 'json' );
	// 	}
	// });

	jQuery('.defer-link').click(function(){
		event.preventDefault();

		let url_string = window.location.href;
		let url = new URL(url_string);
		var so = '';
		if ( url.searchParams.get("so") ) {
			so = url.searchParams.get("so");
		}
		var st = '';
		if ( url.searchParams.get("st") ) {
			st = url.searchParams.get("st");
		}
		window.location = jQuery(this).attr('href') + '?so=' + so + '&st=' + st;
	});

	jQuery('.copy-link').click(function(event){
		event.preventDefault();
		jQuery('body').append('<input id="current-url" type="hidden" value="' + jQuery(this).parent().attr('data-url') + '" />');
		copy_url();
		jQuery('#current-url').remove();
	});

	jQuery('.copy-link-wrap .iconset-22').click(function(event){
		event.preventDefault();
		jQuery('body').append('<input id="current-url" type="hidden" value="' + jQuery(this).parent().attr('data-url') + '" />');
		copy_url();
		jQuery('#current-url').remove();
	}); 
});

function copy_url() {
  let testingCodeToCopy = document.querySelector('#current-url')
  testingCodeToCopy.setAttribute('type', 'text') // 不是 hidden 才能複製
  testingCodeToCopy.select()

  try {
    var successful = document.execCommand('copy');
    var msg = successful ? 'successful' : 'unsuccessful';
    alert('複製網頁連結成功');
  } catch (err) {
    alert('複製網頁連結失敗');
  }

  /* unselect the range */
  testingCodeToCopy.setAttribute('type', 'hidden')
  window.getSelection().removeAllRanges()
}
</script>

<?php if ( has_term( 'the-void-of-22', 'artwork_related_event' ) ) : ?>
<?php get_footer('the-void-of-22-exhibition'); ?>
<?php else: ?>
<style>
#footer-menu {
	display: none;
}
#footer {
	background: #fff;
	padding-top: 40px;
}
</style>
<?php get_footer(); ?>
<?php endif; ?>

<?php else :




$artwork_tags = get_field( 'artwork_category', get_the_ID() );

$offset = 0;
if ( $_GET['offset'] && is_numeric( $_GET['offset'] ) && $_GET['offset'] > 0 ) {
	$offset = $_GET['offset'];
}
$sort = 'hot';
if ( 'date' == $_GET['sort']  ) {
	$sort = $_GET['sort'];
}
$q_cat = $_GET['cat'] ? $_GET['cat'] : 'all';
$q_org = $_GET['org'] ? $_GET['org'] : 'all';
$q_dept = $_GET['dept'] ? $_GET['dept'] : 'all';
$q_search = $_GET['search'] ? $_GET['search'] : '';

wp_enqueue_style( 'single-fliper_artwork', get_stylesheet_directory_uri() . '/assets/css/single-fliper_artwork.css', array(), filemtime( get_stylesheet_directory() . '/assets/css/single-fliper_artwork.css' ) );

get_header(); 

?>

<?php if ( have_posts() ) : the_post(); ?>
<div class="full-artwork-wrap">
	<div class="full-artwork">
		<div class="full-artwork-inner">
			<div class="clearfix">
				<a href="#" id="prev-page" class="iconset-22"></a>
				<a href="/22-online-design-exhibition-home/" class="small-22">_____ 2 2 Design exhibition</a>
			</div>
			<div class="artwork-meta">
				<div class="left">
					<h1><?php the_title(); ?></h1>
					<div class="org-dept"><?php echo $org->name; ?> / <?php echo $dept->name; ?></div>
					<div class="top-author"><?php $i = 0; foreach ( $authors as $a ) { if ( 0 === $i ) { echo esc_html( $a['name'] ); $i = 1; } else { echo '、' . esc_html( $a['name'] ); } } ?></div>
				</div>
				<div class="right">
					<div class="stat">
						<div class="views"><span class="iconset-22"></span><?php echo wpp_get_views( get_the_ID() ); ?></div>
						<div class="share" data-url="<?php the_permalink(); ?>"><span class="iconset-22"></span><span class="share-count"><?php echo FLiPER_get_facebook_share_count( get_the_ID() ); ?></span></div>
					</div>
					<div class="artwork-tag-wrap clearfix">
						<?php foreach ( $artwork_tags as $tag_id ) : $tag = get_term_by( 'id', $tag_id, 'artwork_category' ); ?>
						<a class="tag" href="/22-online-design-exhibition-home/?cat=<?php echo $tag->slug; ?>&org=all&dept=all&sort=hot&search="><?php echo $tag->name; ?></a>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<div class="artwork-content">
				<div class="text"><?php echo nl2br( esc_html( get_field( 'artwork_intro', get_the_ID() ) ) ); ?></div>
				<?php $contents = get_field( 'artwork_content', get_the_ID() );
				foreach ( $contents as $c ) {
					switch ( $c['acf_fc_layout'] ) {
						case 'block_text':
							echo '<div class="text">' . nl2br( esc_html( $c['text'] ) ) . '</div>';
							break;
						case 'block_image':
							echo '<img class="image" src="' . $c['image']['url'] . '" />';
							break;
						case 'block_video':
      						$embed = new WP_Embed();
      						echo '<div class="youtube">' . $embed->shortcode( array(), $c['youtube'] ) . '</div>';
							break;
						case 'block_title':
							echo '<h2 class="title">' . esc_html( $c['title'] ) . '</h2>';
							break;
						case 'block_link':
							echo '<div class="text"><a class="link" target="_blank" href="' . esc_attr( $c['link_url'] ) . '">' . esc_html( $c['link_text'] ) . '</a></div>'; 
							break;
					}
				}
				?>
			</div>
			<div class="artowk-link-and-share-link-wrap clearfix">
				<div class="artwork-link-wrap">
					<h4>Artwork Link</h4>
					<?php echo $website == '' ? '' : '<a href="' . esc_attr( $website ) . '" target="_blank">WEB</a>'; ?>
					<?php echo $artwork_fb == '' ? '' : '<a href="' . esc_attr( $artwork_fb ) . '" target="_blank">FB</a>'; ?>
					<?php echo $artwork_ig == '' ? '' : '<a href="' . esc_attr( $artwork_ig ) . '" target="_blank">IG</a>'; ?>
				</div>
				<div class="share-link-wrap">
					<h4>Share</h4>
					<a class="iconset-22 fb" href="#" data-url="<?php the_permalink(); ?>"></a>
					<a class="iconset-22 link btn-copy" href="#" data-url="<?php the_permalink(); ?>"></a>
				</div>
			</div>
			<div class="artwork-tag-wrap clearfix mobile">
				<?php foreach ( $artwork_tags as $tag_id ) : $tag = get_term_by( 'id', $tag_id, 'artwork_category' ); ?>
					<a class="tag" href="/22-online-design-exhibition-home/?cat=<?php echo $tag->slug; ?>&org=all&dept=all&sort=hot&search="><?php echo $tag->name; ?></a>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="artwork-author-wrap">
			<div class="artwork-author">
				<h2>Designer</h2>
				<div class="org-dept"><?php echo $org->name; ?> / <?php echo $dept->name; ?></div>
				<div class="artwork-author-inner clearfix">
					<?php foreach ( $authors as $a ) : ?>
						<div class="artwork-author-info">
							<div class="left">
								<div class="avatar"><img src="<?php echo wp_get_attachment_image_src( $a['avatar']['id'], 'user-avatar' )[0]; ?>" /></div>
							</div>
							<div class="right">
								<div class="desktop author-links <?php if ( $a['fb'] && $a['ig'] ) echo 'justify'; ?>">
									<?php echo '' != $a['fb'] ? '<a class="fb" href="' . esc_attr( $a['fb'] ) . '" target="_blank">FB</a>' : ''; ?>
									<?php echo '' != $a['ig'] ? '<a class="ig" href="' . esc_attr( $a['ig'] ) . '" target="_blank">IG</a>' : ''; ?>
								</div>
								<div class="author-name"><?php echo $a['name']; ?></div>
								<div class="author-links <?php if ( $a['fb'] && $a['ig'] ) echo 'justify'; ?>">
									<?php echo '' != $a['fb'] ? '<a class="fb" href="' . esc_attr( $a['fb'] ) . '" target="_blank">FB</a>' : ''; ?>
									<?php echo '' != $a['ig'] ? '<a class="ig" href="' . esc_attr( $a['ig'] ) . '" target="_blank">IG</a>' : ''; ?>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

		</div>
	</div>

	<?php 
		$category_id = '0';
        $org_id = '0';
        $dept_id = '0';

		$query = array(
	        'post_type' => 'fliper_artwork', 
	        'posts_per_page' => 30, 
	        'offset' => $offset, 
	        'orderby' => 'ID',
	        'order' => 'ASC',
	        's' => $q_search,
	        'tax_query' => array()
	    );
	    if ( 'all' != $q_cat ) {
	        $tax = $query['tax_query'];
	        array_push( $tax, array( 
	            'taxonomy' => 'artwork_category', 
	            'field' => 'slug', 
	            'terms' => array( $q_cat )
            ) );
            $query['tax_query'] = $tax;
	        $category_id = get_term_by( 'slug', $q_cat, 'artwork_category' )->term_id;
	    }
	    if ( 'all' != $q_org ) {
	        $tax = $query['tax_query'];
	        array_push( $tax, array( 
	            'taxonomy' => 'artwork_org', 
	            'field' => 'slug', 
	            'terms' => array( $q_org )
	        ) );
	        $query['tax_query'] = $tax;
	        $org_id = get_term_by( 'slug', $q_org, 'artwork_org' )->term_id;
	    }
	    if ( 'all' != $q_dept ) {
	        $tax = $query['tax_query'];
	        array_push( $tax, array( 
	            'taxonomy' => 'artwork_org_dept', 
	            'field' => 'slug', 
	            'terms' => array( $q_dept )
	        ) );
	        $query['tax_query'] = $tax;
	        $dept_id = get_term_by( 'slug', $q_dept, 'artwork_org_dept' )->term_id;
	    }

	    if ( 'hot' === $sort ) {
            // Sort 取得熱門
            $a_sort = [
                'range' => 'all', 
                'order_by' => 'views', 
                'post_type' => 'fliper_artwork',
                'offset' => $offset,
                'limit' => 30
            ];

            $sort_cat = '';
            $sort_cat_id = '';
            if ( $category_id ) {
                $sort_cat .= 'artwork_category;';
                $sort_cat_id .= $category_id . ';';
            }
            if ( $org_id ) {
                $sort_cat .= 'artwork_org;';
                $sort_cat_id .= $org_id . ';';
            }
            if ( $dept_id ) {
                $sort_cat .= 'artwork_org_dept;';
                $sort_cat_id .= $dept_id . ';';
            }
            if ( $sort_cat ) {
                $a_sort['taxonomy'] = $sort_cat;
                $a_sort['term_id'] = $sort_cat_id;
            }

            if ( $q_search ) {
                add_filter( 'wpp_query_where', function( $v ) use ( $q_search ) {
                    global $wpdb;
                    $where = $wpdb->prepare('p.post_title LIKE "%%%s%%"', $q_search);
                    $v .= ' AND ' . $where;
                    return $v;
                } );    
            }
            
            $query = new WordPressPopularPosts\Query( $a_sort );
            $ids = array();
            foreach ( $query->get_posts() as $p ) {
                array_push( $ids, $p->id );
            }

            if ( $ids ) {
                $query = new WP_Query( array(
                    'post__in' => $ids,
                    'orderby' => 'post__in',
                    'post_type' => 'fliper_artwork',
                    'posts_per_page' => -1
                ) );
            } else {
                $query = new WP_Query( array() );
            }
        } else {
            $query = new WP_Query( $query );
        }
	?>
	<div class="related-artwork">
		<div class="related-artwork-inner">
			<?php if ( $query->have_posts() ) : ?>
			<h2>繼續逛展</h2>
			<ul class="artwork-list clearfix">
				<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<li class="artwork-item">
					<a class="historical-link" href="<?php the_permalink(); ?>">
						<div class="thumbnail"><?php the_post_thumbnail('home-top-big-2x'); ?></div>
						<div class="artwork-item-meta">
							<div class="left">
								<h3><?php the_title(); ?></h3>
								<div class="artwork-author">
									<?php
    										$artwork_authors = get_field( 'artwork_author', get_the_ID() );
    										$i = 0;

   										 if ( ! empty( $artwork_authors ) && is_array( $artwork_authors ) ) {
     										   foreach ( $artwork_authors as $a ) {
        										    if ( ! is_array( $a ) || empty( $a['name'] ) ) {
             											   continue;
            											}

           										 if ( 0 === $i ) {
                										echo esc_html( $a['name'] );
                										$i = 1;
            										} else {
                										echo '、' . esc_html( $a['name'] );
            											}
        										}
    										}
									?>
								</div>
							</div>
							<div class="right">
								<div class="stat">
									<div class="views"><span class="iconset-22"></span><?php echo wpp_get_views( get_the_ID() ); ?></div>
								</div>
							</div>
						</div>
					</a>
				</li>
				<?php endwhile; ?>
			</ul>
			<?php $offset += $query->post_count; endif; wp_reset_query(); ?>
		</div>
	</div>
</div>
<?php endif; ?>

<script>
$ = jQuery;
var load_artwork = false;
var load_end = false;
var load_count = 30;
var offset = <?php echo $offset; ?>;
var sort = '<?php echo $sort; ?>';
var cat = '<?php echo $q_cat; ?>';
var org = '<?php echo $q_org; ?>';
var dept = '<?php echo $q_dept; ?>';
var search = '<?php echo $q_search; ?>';
$('document').ready(function(){
	$('body').on('click', '#prev-page', function(event) {
        event.preventDefault();
        window.location = /22-online-design-exhibition-home/;
    });


	$('.btn-copy').click(function(event){
		event.preventDefault();
		$('body').append('<input id="current-url" type="hidden" value="' + $(this).attr('data-url') + '" />');
		copy_url();
		$('#current-url').remove();
	}); 

	$('.stat .share').each(function(index, ele) {
		if ( 0 === index ) {
			var url = $(this).attr('data-url');
			var total = $(this).find('.share-count').text();
			$.getJSON( 'https://graph.facebook.com/?id=' + url + '&fields=og_object{engagement}', {}, function(response){
				if(response.hasOwnProperty('og_object')) {
					if ( response.og_object.engagement.count > total ) {
						total = response.engagement.count;
						$.getJSON( '/wp-json/api/v2/update-social-share-count?url=' + url, {}, function(response){} );
					}
				}
			});	
		}
	});	

	$('.share-link-wrap .fb').click(function(event){
		event.preventDefault();
		var url = $(this).attr('data-url');
		var scroll = $(window).scrollTop();
		FB.ui({
  			method: 'share',
  			href:url
		}, function(response){
			$(window).scrollTop(scroll);
		});
	});

	if ( $('.artwork-item').length < 30 ) {
		load_end = true;
	}

	$('body').on('click', '.historical-link', function(event) {
		event.preventDefault();
		window.offset = window.offset + $(this).parent('.artwork-item').index() + 1;
		var url = $(this).attr('href');
		window.location = url + '?offset=' + window.offset  + '&cat=' + cat + '&org='  + org + '&dept=' + dept + '&sort=' + sort + '&search=' + search;
	});

	$(window).scroll(function(event){
		if ( $('#sponsors').length ) {
			if ( ! load_artwork && ! load_end && ( $(window).scrollTop() + 1000 > $('#sponsors').offset().top ) ) {
				get_artworks(window.offset);
			} 	
		}
	});
	$(window).scroll();
		
})

function get_artworks( offset ) {
	load_artwork = true;
	$.getJSON('/wp-json/web/v1/filter-artworks', {category: cat, org: org, dept: dept, search: search, offset: offset, sort: sort}, function(response) {

		window.offset = response.offset
		if ( load_count > response.count ) {
			load_end = true;
		}
		response.list.forEach(function(item, index){
			var ele = '<li class="artwork-item">';
			ele += '<a class="historical-link" href="' + item.url + '">';
			ele += '<div class="thumbnail"><img width="900" height="640" src="' + item.thumbnail_src + '" class="attachment-home-top-big-2x size-home-top-big-2x wp-post-image" alt=""></div>';
			ele += '<div class="artwork-item-meta">';
			ele += '<div class="left">';
			ele += '<h3>' + item.title + '</h3>';
			ele += '<div class="artwork-author">' + item.author + '</div>';
			ele += '</div>';
			ele += '<div class="right">';
			ele += '<div class="stat">';
			ele += '<div class="views"><span class="iconset-22"></span>' + item.views + '</div>';
			ele += '</div></div></div></a></li>';
			$('.artwork-list').append(ele);
		});

		load_artwork = false;
	});
}


function copy_url() {
  let testingCodeToCopy = document.querySelector('#current-url')
  testingCodeToCopy.setAttribute('type', 'text') // 不是 hidden 才能複製
  testingCodeToCopy.select()

  try {
    var successful = document.execCommand('copy');
    var msg = successful ? 'successful' : 'unsuccessful';
    alert('複製網頁連結成功');
  } catch (err) {
    alert('複製網頁連結失敗');
  }

  /* unselect the range */
  testingCodeToCopy.setAttribute('type', 'hidden')
  window.getSelection().removeAllRanges()
}
</script>

<?php get_footer('22-online-design-exhibition'); ?>	

<?php endif; ?>
