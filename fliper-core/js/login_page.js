jQuery(document).ready(function(){
    jQuery('body').prepend('<a href="' + site_url + '" class="home" title="回首頁"></a>');
    var redirect_to = jQuery('input[name=redirect_to]').val();
    if ( '' == redirect_to )
        redirect_to = site_url;

    if ( jQuery('#loginform').length ) {
        var p = jQuery('#user_login').parent().parent();
        p.after(jQuery('#user_login'));
        p.remove();
        jQuery('#user_login').attr('placeholder', '使用者帳號');

        p = jQuery('#user_pass').parent().parent();
        p.after(jQuery('#user_pass'));
        p.remove();
        jQuery('#user_pass').attr('placeholder', '密碼');

        jQuery('#rememberme').attr('checked', 'checked');

        if ( jQuery('#nav a:last-child').length ) {
            jQuery('#user_pass').css('width', '181px');
            jQuery('#user_pass').after(jQuery('#nav a:last-child').addClass('forgot-password'));    
        }

//        jQuery('body.fliper.login .submit').after('<a href="' + site_url + '/wp-login.php?loginFacebook=1&redirect=' + redirect_to + '" class="facebook-connect">使用 Facebook 帳號登入</a>');
        jQuery('.fliper.login .facebook-connect').after(jQuery('#nav a:first-child').addClass('sign-up'));
        jQuery('.sign-up').html('沒有帳號？請<span style="text-decoration:underline">註冊</span>');
        var t = jQuery('.sign-up').attr('href');
        jQuery('.sign-up').attr('href', t + '&redirect_to=' + redirect_to);
    } else if ( jQuery('#registerform').length ) {
        var p = jQuery('#user_login').parent().parent();
        p.after(jQuery('#user_login'));
        p.remove();
        jQuery('#user_login').attr('placeholder', '使用者帳號');

        p = jQuery('#user_email').parent().parent();
        p.after(jQuery('#user_email'));
        p.remove();
        jQuery('#user_email').attr('placeholder', '電子郵件信箱');

        jQuery('#reg_passmail').html('點擊註冊代表你已閱讀<a href="' + site_url + '/privacy-policy/" target="_blank">隱私政策</a>並同意<a href="' + site_url + '/terms-of-service/" target="_blank">服務條款</a>');
//        jQuery('body.fliper.login .submit').after('<a href="' + site_url + '/wp-login.php?loginFacebook=1&redirect=' + redirect_to + '" class="facebook-connect">使用 Facebook 帳號登入</a>');
        jQuery('body.fliper.login .submit').after('<p style="color:#fff;text-align:center;padding:5px 0px 15px 0px;clear:both;">或</p>');
        jQuery('.fliper.login .facebook-connect').after(jQuery('#nav a:first-child').addClass('sign-in'));
        jQuery('.sign-in').html('已有帳號？請<span style="text-decoration:underline">登入</span>');
        var t = jQuery('.sign-in').attr('href');
        jQuery('.sign-in').attr('href', t + '?redirect_to=' + redirect_to);
    }
});
jQuery(window).load(function(){
    if ( jQuery(window).height() < jQuery('#login').outerHeight() ) {
        jQuery('body').css('height', 'auto');
    }
});
