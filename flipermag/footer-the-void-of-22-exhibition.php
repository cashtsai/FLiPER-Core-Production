
<style>
#sponsors {
	background: #000;
	padding:0px;
}

#sponsors-inner {
	max-width: 1100px;
	width: 100%;
	border-radius: 0px;
	background: transparent;
	margin:0 auto;
	padding-bottom:32px;
}

#footer {
	background: #000;
	margin-bottom:0px;
}

#footer .copyright {
	font: normal normal normal 14px/22px 'EB Garamond', 'notoserifcjktc';
	letter-spacing: 0.7px;	
	color:#fff;
	padding:16px 0px 60px;
	max-width: 1100px;
	margin:0 auto;
}

@media screen and (max-width: 1099px) {
	#footer .copyright {
		width: 310px;
		margin:0 auto;
	}
}

</style>
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

<div id="footer">
	<div class="copyright">© 2021 FLiPER Creative Inc. All Rights Reserved.</div>
</div>

</div><!--#main-container-->

</div><!--.site-container-->

<?php wp_footer(); ?>

<?php block_18_years_old(); // refer to function.php ?>
</body>
</html>