<div id="login-popup">
    <div class="login-popup-inner-wrap">
    	<div class="close-button"></div>
    	<h2>LOGIN</h2>
    	<div class="error-message"></div>
    	<div id="login-form">
			<input type="text" name="log" id="user-login" class="text-input" value="" size="20" placeholder="Username or Email" />
    		<input type="password" name="pwd" id="user-pass" class="text-input" value="" size="20" placeholder="Password" />
            <input type="hidden" name="redirect" id="login-redirect" value="" />
    		<div class="forget-me-not">
    			<label for="remember-me">記住我
					<input name="remember_me" type="checkbox" id="remember-me" value="forever" />
    				<span class="checkmark"></span>
    			</label>
    		</div>
    		<div class="login-submit-wrap">
    			<input type="submit" name="login_submit" id="login-submit" class="login-submit-button" value="登入" />
    		</div>
   		<?php /*
		<div class="facebook-login-wrap">
    			<a href="<?php echo home_url(); ?>/wp-login.php?loginFacebook=1&redirect=<?php echo home_url(); ?>" onclick="window.location = '<?php echo home_url(); ?>/wp-login.php?loginFacebook=1&redirect='+window.location.href; return false;" class="">or Login with <span class="facebook-login-button iconset"></span></a>
		</div>
		*/ ?>
            <div class="login-error"><span class="iconset error"></span><span class="text"></span></div>
    		<div class="login-popup-footer-wrap">
                <div class="left">
    			    <a class="lost-password-popup-link" href="#">忘記密碼？</a>
                </div>
                <div class="right">
    			    <a class="login-popup-link reg-link" href="#">註冊</a>
                </div>
    		</div>
    	</div>
        <a class="close-button iconset" href="#"></a>
    </div>
</div>

<div id="sign-up-popup">
    <div class="login-popup-inner-wrap">
        <div class="close-button"></div>
        <h2>SIGN UP</h2>
        <div class="error-message"></div>
        <div id="login-form">
            <input type="text" name="log" id="reg-user-login" class="text-input" value="" size="20" placeholder="Username" />
            <input type="text" name="log" id="reg-user-email" class="text-input" value="" size="20" placeholder="Email" />
            <input type="password" name="pwd" id="reg-user-pass" class="text-input" value="" size="20" placeholder="Password" />
            <div class="login-submit-wrap">
                <input type="submit" name="login_submit" id="reg-submit" class="login-submit-button" value="註冊" />
            </div>
            <?php /*
	    <div class="facebook-login-wrap">
                <a href="<?php echo home_url(); ?>/wp-login.php?loginFacebook=1&redirect=<?php echo home_url(); ?>" onclick="window.location = '<?php echo home_url(); ?>/wp-login.php?loginFacebook=1&redirect='+window.location.href; return false;" class="">or Login with <span class="facebook-login-button iconset"></span></a>
            </div>
	    */ ?>
            <div class="login-error"><span class="iconset error"></span><span class="text"></span></div>
            <div class="login-popup-footer-wrap">
                <div class="left">
                    <a class="lost-password-popup-link" href="#">忘記密碼？</a>
                </div>
                <div class="right">
                    <a class="login-popup-link login-link" href="#">登入</a>
                </div>
            </div>
        </div>
        <a class="close-button iconset" href="#"></a>
    </div>
</div>

<div id="forget-password-popup">
    <div class="login-popup-inner-wrap">
        <div class="close-button"></div>
        <h2>FORGOT<br/> PASSWORD</h2>
        <div class="error-message"></div>
        <div id="login-form">
            <input type="text" name="log" id="forgot-user-login" class="text-input" value="" size="20" placeholder="Username or Email" />
            <div class="description">請輸入你的帳號或電子郵件位址。你將收到含有建立新密碼鏈結的電子郵件。</div>
            <div class="login-submit-wrap">
                <input type="submit" name="login_submit" id="forgot-submit" class="login-submit-button" value="取得新密碼" />
            </div>
            <div class="login-error"><span class="iconset error"></span><span class="text"></span></div>
            <div class="login-popup-footer-wrap">
                <div class="left">
                    <a class="login-popup-link login-link" href="#">登入</a>
                </div>
                <div class="right">
                    <a class="login-popup-link reg-link" href="#">註冊</a>
                </div>
            </div>
        </div>
        <a class="close-button iconset" href="#"></a>
    </div>
</div>

<div id="global-glass"></div>


<style>
#login-popup,
#sign-up-popup,
#forget-password-popup {
	display: none;
	background:#ebebeb;
	padding-top: 30px;
	position: fixed;
	width:100%;
	min-height: 100%;
	top:0px;
	left:0px;
	z-index:999999;
}
.login-popup-inner-wrap {
	width:224px;
    padding:0px 48px;
	margin:0 auto;
    position: relative;
}
.login-popup-inner-wrap h2 {
    line-height: 40px;
    color:#1a1a1a;
    text-align: center;
    font-family: Roboto Slab;
    font-weight: 700;
    font-size: 22px;
    letter-spacing: 2.2px;
    margin-bottom:32px;
}

#forget-password-popup .login-popup-inner-wrap h2 {
    line-height: 30px;
}


.login-popup-inner-wrap .text-input {
    width: 100%;
    padding: 0px 12px;
    line-height: 36px;
    font-size: 14px;
    box-sizing: border-box;
    border: none;
    margin-bottom: 32px;
    font-family: Roboto Slab;
    font-weight: 400;
    color:#1a1a1a;
    border-radius: 0px;
}
.login-popup-inner-wrap .text-input::placeholder {
	color:#8c8c8c;
}
.login-popup-inner-wrap .forget-me-not {
    margin-bottom:32px;
}
.login-popup-inner-wrap .forget-me-not > label {
	padding-left:16px;
    display: block;
    font-family: "Noto Sans TC";
    font-weight: 500;
    font-size:14px;
    line-height: 32px;
    color:#8c8c8c;
    position: relative;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
.login-popup-inner-wrap .forget-me-not #remember-me {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
}
.login-popup-inner-wrap .forget-me-not .checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 12px;
    width: 12px;
    background-color: #fff;
    margin: 10px 4px 10px 0px;
}
.login-popup-inner-wrap .forget-me-not .checkmark:after {
	display: none;
	content: "";
	position: absolute;
    left: 4px;
    top: 1px;
    width: 3px;
    height: 7px;
    border: solid #8c8c8c;
    border-width: 0 2px 2px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
    background:#fff;
}
.login-popup-inner-wrap .forget-me-not #remember-me:checked ~ .checkmark:after {
    display: block;
}
.login-popup-inner-wrap .login-submit-wrap {
    text-align: center;
    margin-bottom:20px;
}
.login-popup-inner-wrap .login-submit-wrap .login-submit-button {
    font-family: "Noto Sans TC";
    font-weight: 700;
    font-size:16px;
    padding-right:4px;
    line-height: 30px;
    letter-spacing: 1.6px;
    color:#1f7ba1;
    border:0px;
    border-bottom:2px solid #1f7ba1;
    background:none;
    border-radius: 0px;
    padding-left: 7px;
}
.login-popup-inner-wrap .facebook-login-wrap {
    text-align: center;
    margin-bottom:48px;
}
.login-popup-inner-wrap .facebook-login-wrap a {
    font-family: "Roboto Slab";
    font-weight: 400;
    font-size:12px;
    line-height: 32px;
    letter-spacing: 0px;
    color:#8c8c8c;
}

.login-popup-inner-wrap .facebook-login-wrap .facebook-login-button {
    display: inline-block;
    background-position-y: -351px;
    width: 16px;
    height: 16px;
    margin-top:8px;
    vertical-align: top;
    margin-left:8px;
}

.login-popup-inner-wrap .login-popup-footer-wrap .left,
.login-popup-inner-wrap .login-popup-footer-wrap .right {
    width:48%;
    display: inline-block;
}

.login-popup-inner-wrap .login-popup-footer-wrap .right {
    text-align: right;
}

.login-popup-inner-wrap .login-popup-footer-wrap a {
    font-family: "Noto Sans TC";
    font-weight: 500;
    font-size:14px;
    line-height: 32px;
    color:#3e9ab7;
}

.login-popup-inner-wrap .close-button {
    display: block;
    width: 36px;
    height: 36px;
    position: absolute;
    top: -14px;
    right: 6px;
    background-position-x: -587px;
    background-position-y: -159px;
}

.login-error {
    margin:-26px auto 4px;
    display: none;
}

.login-error .error {
    display: inline-block;
    vertical-align: top;
    width: 21px;
    height: 21px;
    background-position-x:-250px;
    background-position-y:-297px;
}

.login-error .text {
    vertical-align: top;
    margin-left:10px;
    font: 500 12px/20px "Noto Sans TC";
    color: #F84555;
    display: inline-block;
}

.login-popup-inner-wrap .description {
    color:#8c8c8c;
    font-family: "Noto Sans TC";
    font-weight: 400;
    font-size:12px;
    line-height: 24px;
    margin-top:-14px;
    margin-bottom:32px;
}

#global-glass {
    display: none;
}

@media screen and (min-width: 1100px) {

#global-glass {
    position: fixed;
    width: 100%;
    height: 100%;
    background: rgba(255,255,255,0.7);
    top: 0px;
    left: 0px;
}

#login-popup,
#forget-password-popup {
    width:540px;
    height: 408px;
    border:1px solid #1a1a1a;
    border-radius: 4px;
    min-height: auto;
    position: fixed;
    top:50%;
    left:50%;
    margin-top:-204px;
    margin-left:-270px;
    padding-top:42px;
    box-shadow: 1px 1px 10px rgba(0,0,0,0.2);
}

#sign-up-popup {
    width:540px;
    height: 484px;
    border:1px solid #1a1a1a;
    border-radius: 4px;
    min-height: auto;
    position: fixed;
    top:50%;
    left:50%;
    margin-top:-242px;
    margin-left:-270px;
    padding-top:42px;
    box-shadow: 1px 1px 10px rgba(0,0,0,0.2);
}

.login-popup-inner-wrap {
    width: 380px;
    padding:0px 80px;
}

.login-popup-inner-wrap h2 {
    font-size: 30px;
    letter-spacing: 3px;
    margin-bottom:28px;
}

.login-popup-inner-wrap .text-input {
    padding: 16px 18px;
    line-height: 16px;
    font-size: 16px;
    margin-bottom: 28px;
}

.login-popup-inner-wrap .forget-me-not {
    display: inline-block;
    width: 150px;
}

.login-popup-inner-wrap .forget-me-not > label {
    padding-left:24px;
    padding-top:8px;
    padding-bottom:8px;
    font-family: "notoserifcjktc";
    font-size:12px;
    line-height: 16px;
}

.login-popup-inner-wrap .forget-me-not .checkmark {
    top: 1px;
    height: 16px;
    width: 16px;
    margin: 8px 8px 8px 0px;
}

.login-popup-inner-wrap .forget-me-not .checkmark:after {
    width: 5px;
    height: 9px;
}

.login-popup-inner-wrap .login-submit-wrap {
    display: inline-block;
    width: 68px;
    margin-bottom:32px;
}

#sign-up-popup .login-popup-inner-wrap .login-submit-wrap {
    margin-left:150px;
}

#forget-password-popup .login-popup-inner-wrap .login-submit-wrap {
    width: 100%;
}

.login-popup-inner-wrap .login-submit-wrap .login-submit-button {
    line-height: 32px;
    cursor: pointer;
    letter-spacing: 3.2px;
}

.login-popup-inner-wrap .login-submit-wrap .login-submit-button:hover {
    color:#3e9ab7;
    border-bottom-color: #3e9ab7;
}

.login-popup-inner-wrap .facebook-login-wrap {
    width: 150px;
    display: inline-block;
    text-align: right;
    line-height: 32px;
    margin-bottom:32px;
}

.login-popup-inner-wrap .facebook-login-wrap .facebook-login-button {
    margin-top:9px;
}

.login-popup-inner-wrap .login-popup-footer-wrap a {
    font-size:12px;
    line-height: 40px;
}

.login-popup-inner-wrap .login-popup-footer-wrap a:hover {
    color:#8ab8bf;
}

.login-popup-inner-wrap .close-button {
    top: -24px;
    right: 22px;
}

.login-popup-inner-wrap .description {
    margin-top:0px;
    padding-left:18px;
    padding-right:18px;
}

#forget-password-popup .login-popup-inner-wrap h2 {
    line-height: 40px;
}

#forget-password-popup .login-popup-inner-wrap h2 br {
    display: none;
}

}
</style>
