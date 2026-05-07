jQuery(document).ready(function($) {
	"use strict";
	
	// 手機版 user menu
	$('#mobile-user-menu .profile-icon.not-login').click(function(event){
		event.preventDefault();
		$('.login-error').hide();
		$('#login-popup').show();
		$('body').css('overflow', 'hidden');
	});
	// 桌機版 user menu
	$('#desktop-user-menu .profile-icon.not-login').click(function(event){
		event.preventDefault();
		$('.login-error').hide();
		$('#global-glass').show();
		$('#login-popup').show();
		$('body').css('overflow', 'hidden');
	});

	$('.login-popup-inner-wrap .close-button').click(function(){
		event.preventDefault();
		$('#login-popup').hide();
		$('#sign-up-popup').hide();
		$('#forget-password-popup').hide();
		$('#global-glass').hide();
		$('body').css('overflow', 'visible');
	});

	$('#global-glass').click(function(event){
		event.preventDefault();
		$('#login-popup').hide();
		$('#sign-up-popup').hide();
		$('#forget-password-popup').hide();
		$('#global-glass').hide();
		$('body').css('overflow', 'visible');
	});

	$('#login-popup #login-submit').click(function(){
		event.preventDefault();
		$('.login-error').hide();

		var username = $('#user-login').val();
		var pass = $('#user-pass').val();
		var remember = $('#remember-me').prop("checked");
		if ( '' == username || '' == pass ) {
			$('.login-error .text').text('請輸入帳號與密碼');
			$('.login-error').show();
			return;
		}

		var redirect = $('#login-redirect').val();

		$.post('/wp-json/api/v2/login', {user_login: username, password: pass }, function(response) {}).done(function(){
			if ( redirect ) {
				window.location = redirect;
			} else {
				window.location.reload();	
			}
		}).fail(function(response){
			$('.login-error .text').text(response.responseJSON.message);
			$('.login-error').show();
		});
	});

	$('.login-popup-inner-wrap .reg-link').click(function(event){
		event.preventDefault();
		$('.login-error').hide();
		$('#login-popup').hide();
		$('#forget-password-popup').hide();
		$('#sign-up-popup').show();
	});

	$('.login-popup-inner-wrap .login-link').click(function(event){
		event.preventDefault();
		$('.login-error').hide();
		$('#sign-up-popup').hide();
		$('#forget-password-popup').hide();
		$('#login-popup').show();
	});

	$('.login-popup-inner-wrap .lost-password-popup-link').click(function(event){
		event.preventDefault();
		$('.login-error').hide();
		$('#sign-up-popup').hide();
		$('#login-popup').hide();
		$('#forget-password-popup').show();
	});

	$('.facebook-login-wrap a').click(function(e){
		e.preventDefault();
		var redirect = $('#login-redirect').val();
		if ( ! redirect ) {
			redirect = window.location.href;
		}

		window.location = '/wp-login.php?loginFacebook=1&redirect=' + redirect;
	})

	$('#sign-up-popup #reg-submit').click(function(){
		event.preventDefault();
		$('.login-error').hide();

		var username = $('#reg-user-login').val();
		var email = $('#reg-user-email').val();
		var pass = $('#reg-user-pass').val();
		if ( '' == username || '' == email || '' == pass ) {
			$('.login-error .text').text('請輸入帳號、信箱與密碼');
			$('.login-error').show();
			return;
		}

		var redirect = $('#login-redirect').val();

		$.post('/wp-json/api/v2/sign-up', {user_login: username, email: email, password: pass }, function(response) {}).done(function(){
			if ( redirect ) {
				window.location = redirect;
			} else {
				window.location.reload();	
			}
		}).fail(function(response){
        	$('.login-error .text').text(response.responseJSON.message);
        	$('.login-error').show();
		});
	});

	$('#forget-password-popup #forgot-submit').click(function(){
		event.preventDefault();
		$('.login-error').hide();

		var username = $('#forgot-user-login').val();
		if ( '' == username ) {
			$('.login-error .text').text('請輸入帳號或信箱');
			$('.login-error').show();
			return;
		}

		$.post('/wp-json/api/v2/forgot_password', {user_login: username}, function(response) {}).done(function(response){
			alert(response.message);
		}).fail(function(response){
        	$('.login-error .text').text(response.responseJSON.message);
        	$('.login-error').show();
		});
	});

	$('.login-popup-inner-wrap .text-input[name=pwd]').keypress(function(event){
    	var keycode = (event.keyCode ? event.keyCode : event.which);
    	if(keycode == '13' ){
        	$(this).parent().find('input[type=submit]').click();
    	}
	});

	$('.login-popup-inner-wrap #forgot-user-login').keypress(function(event){
    	var keycode = (event.keyCode ? event.keyCode : event.which);
    	if(keycode == '13' ){
        	$(this).parent().find('input[type=submit]').click();
    	}
	});

});