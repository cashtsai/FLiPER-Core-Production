jQuery(document).ready(function(){
    jQuery('body').prepend('<a href="' + site_url + '" class="home" title="Back to Home"></a>');
    var redirect_to = jQuery('input[name=redirect_to]').val();
    if ( '' == redirect_to )
        redirect_to = site_url;

    if ( jQuery('#loginform').length ) {
        var p = jQuery('#user_login').parent().parent();
        p.after(jQuery('#user_login'));
        p.remove();
        jQuery('#user_login').attr('placeholder', 'username');

        p = jQuery('#user_pass').parent().parent();
        p.after(jQuery('#user_pass'));
        p.remove();
        jQuery('#user_pass').attr('placeholder', 'password');

        jQuery('#rememberme').attr('checked', 'checked');

        if ( jQuery('#nav a:last-child').length ) {
            jQuery('#user_pass').css('width', '181px');
            jQuery('#user_pass').after(jQuery('#nav a:last-child').addClass('forgot-password'));    
        }

//        jQuery('body.fliper.login .submit').after('<a href="' + site_url + '/wp-login.php?loginFacebook=1&redirect=' + redirect_to + '" class="facebook-connect">Facebook Login</a>');
        jQuery('.fliper.login .facebook-connect').after(jQuery('#nav a:first-child').addClass('sign-up'));
        jQuery('.sign-up').html('Or <span style="text-decoration:underline">Register Here</span>');
        var t = jQuery('.sign-up').attr('href');
        jQuery('.sign-up').attr('href', t + '&redirect_to=' + redirect_to);
    } else if ( jQuery('#registerform').length ) {
        var p = jQuery('#user_login').parent().parent();
        p.after(jQuery('#user_login'));
        p.remove();
        jQuery('#user_login').attr('placeholder', 'username');

        p = jQuery('#user_email').parent().parent();
        p.after(jQuery('#user_email'));
        p.remove();
        jQuery('#user_email').attr('placeholder', 'e-mail');

        jQuery('#reg_passmail').html('Creating an account means you agree with FLiPER\'s <a href="' + site_url + '/privacy-policy/" target="_blank">Privacy Policy</a> and <a href="' + site_url + '/terms-of-service/" target="_blank">Terms of Service</a>');
//        jQuery('body.fliper.login .submit').after('<a href="' + site_url + '/wp-login.php?loginFacebook=1&redirect=' + redirect_to + '" class="facebook-connect">Facebook Login</a>');
        jQuery('body.fliper.login .submit').after('<p style="color:#fff;text-align:center;padding:5px 0px 15px 0px;clear:both;">Or</p>');
        jQuery('.fliper.login .facebook-connect').after(jQuery('#nav a:first-child').addClass('sign-in'));
        jQuery('.sign-in').html('Already have account? <span style="text-decoration:underline">Login Here</span>');
        var t = jQuery('.sign-in').attr('href');
        jQuery('.sign-in').attr('href', t + '&redirect_to=' + redirect_to);
    }
});
jQuery(window).load(function(){
    if ( jQuery(window).height() < jQuery('#login').outerHeight() ) {
        jQuery('body').css('height', 'auto');
    }
});
