<?php

/* Template Name: Instagram Search */

if ( 'POST' === $_SERVER['REQUEST_METHOD'] ) {
	
	if ( ! isset( $_POST['code'] ) ) {
		wp_safe_redirect('/instagram-search/?e=1');
		exit;
	}

	$post_id = $_POST['code'];

	if ( ! is_numeric( $post_id ) ) {
		wp_safe_redirect('/instagram-search/?e=2');
		exit;
	}

	if ( 'publish' != get_post_status( $post_id ) || 'post' != get_post_type( $post_id ) ) { // The post does not exist
		wp_safe_redirect( '/instagram-search/?e=3&code=' . $post_id );
		exit;
	} 
	
	wp_safe_redirect( '/?p=' . $post_id );
	exit;
}

get_header();

?>

<style>
#instagram-search-wrap {
	min-height: 500px;
}

.hero-title {
	margin-top:74px;
	text-align: center;
	letter-spacing: 1.2px;
	color: #1A1A1A;
}

.hero-title .en {
	font: 700 24px/36px "Roboto Slab";
	display: block;
}

.hero-title .zh {
	font: 500 24px/36px "Noto Sans TC";
	display: block;
}

.description {
	margin:43px auto 0px;
	width: 172px;
	text-align: center;
	font: 400 12px/18px "Noto Sans TC";
	color: #1A1A1A;
}

.description-desktop {
	display: none;
}

#instagram-search-form {
	margin:35px auto 0;
	width: 300px;
	text-align: center;
}

#instagram-search-form input[type=text] {
	border: 1px solid #1A1A1A;
	height: 50px;
	width: 300px;
	box-sizing:border-box;
	text-align: center;
	font: 400 16px/16px "Roboto Slab";
	color: #8C8C8C;
	border-radius: 0px;
	padding:0px;
	box-shadow: none;
	outline:none;
}

#instagram-search-form input[type=submit] {
	margin-top:40px;
	text-decoration: underline;
	font: 400 18px/18px "Roboto Slab";
	color: #2BAB9F;
	border:0px;
	padding:0px;
	background: transparent;
}

#error-message {
	margin:40px auto 0px;
	width: 172px;
	display: none;
	text-align: center;
}

#error-message .error {
	display: inline-block;
	vertical-align: top;
	width: 20px;
	height: 20px;
	background-position-x:-250px;
	background-position-y:-297px;
}

#error-message .text {
	vertical-align: top;
	text-align: left;
	margin-left:10px;
	font: 500 12px/20px "Noto Sans TC";
	color: #F84555;
	max-width: 142px;
	display: inline-block;
}


@media screen and (min-width: 1100px) {

#instagram-search-wrap {
	max-width: 512px;
	margin:0 auto;
}

.hero-title {
	margin-top:180px;
	text-align: left;
	letter-spacing: 1px;
}

.hero-title .en {
	font: 400 20px/35px "Roboto Slab";
}

.hero-title .zh {
	font: 600 20px/35px "notoserifcjktc";
}

.description {
	display: none;
}

.description-desktop {
	margin-top:12px;
	font: 500 14px/14px "notoserifcjktc";
	color: #1A1A1A;
	display: block;
	margin-bottom:30px;
}

#instagram-search-form {
	margin:30px auto 0;
	width: 100%;
	text-align: left;
}

#instagram-search-form input[type=text] {
	width: 420px;
	text-align: left;
	padding-left:16px;
	display: inline-block;
	vertical-align: top;
}

#instagram-search-form input[type=submit] {
	margin-left:12px;
	margin-top:0px;
	padding:0px;
	line-height: 50px;
	vertical-align: top;
	border: 0px;
}

#error-message {
	margin:30px 0px 50px;
	width: 100%;
	text-align: left;
}

#error-message .text {
	margin-left:10px;
	font: 500 14px/20px "notoserifcjktc";
	max-width: 482px;
	display: inline-block;
}

	
}

</style>

<div id="instagram-search-wrap" class="row">
	<h1 class="hero-title"><span class="en">Instagram</span><span class="zh">貼文文章搜尋</span></h1>
	<div class="description">輸入 Instagram 貼文下方代碼，點選 SEARCH 即可找到完整文章</div>
	<form id="instagram-search-form" action="" method="post">
		<input name="code" type="text" value="<?php echo isset( $_GET['code'] ) ? $_GET['code'] : ''; ?>" placeholder="ENTER POST CODE" />
		<input type="submit" value="SEARCH" />
	</form>
	<div class="description-desktop">輸入 Instagram 貼文下方代碼，點選 SEARCH 即可找到完整文章</div>
	<div id="error-message"><span class="iconset error"></span><span class="text">《Grandpa Santa》當脆弱的心不堪一擊，就用理解重新找回愛的模樣</span></div>
</div>

<script>
$ = jQuery;
$(document).ready(function(){

	<?php if ( isset( $_GET['e'] ) && '1' === $_GET['e'] ) : ?>
		$('#error-message .text').text('請輸入代碼');
		$('#error-message').show();
		_jf.flush();
	<?php endif; ?>

	<?php if ( isset( $_GET['e'] ) && '2' === $_GET['e'] ) : ?>
		$('#error-message .text').text('貼文代碼應為數字，請重新輸入');
		$('#error-message').show();
		_jf.flush();
	<?php endif; ?>

	<?php if ( isset( $_GET['e'] ) && '3' === $_GET['e'] ) : ?>
		$('#error-message .text').text('貼文代碼不存在，請檢查代碼並重新輸入');
		$('#error-message').show();
		_jf.flush();
	<?php endif; ?>

	$('#instagram-search-form').submit(function(event){
		event.preventDefault();
		$('#error-message').hide();
		
		var x = $('#instagram-search-form input[name=code]').val();

		if ( '' == x ) {
			$('#error-message .text').text('請輸入代碼');
			$('#error-message').show();
			_jf.flush();
			return;
		}

		if ( ! parseInt(x) ) {
			$('#error-message .text').text('貼文代碼應為數字，請重新輸入');
			$('#error-message').show();
			_jf.flush();
			return;
		}

		$('#instagram-search-form').unbind('submit');
		$('#instagram-search-form').submit();
	});
});

$(window).load(function(){
	var min = 500;
	if ($(window).width() < 1100) {
		min = $(window).height() - $('#instagram-search-wrap').offset().top;
	} else {
		min = $(window).height() - $('#instagram-search-wrap').offset().top - $('#footer').outerHeight(true);
	}
	$('#instagram-search-wrap').css('min-height', min+'px');
});
</script>


<?php get_footer(); ?>