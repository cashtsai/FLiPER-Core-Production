
<div id="sponsors">
	<div id="sponsors-inner">
		<img class="mobile" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/__22_online_design_exhibition/__22-sponsor-mobile-0522.png'; ?>" usemap="#mobile-logo-map" />
		<map name="mobile-logo-map">
  			<area shape="rect" coords="115,70,210,105" href="/" target="_blank" alt="FLiPER">
  			<area shape="rect" coords="70,200,250,225" href="https://url.rhinoshield.tw/fliper" target="_blank" alt="RHINOSHIELD 犀牛盾">
  			<area shape="rect" coords="40,350,150,380" href="https://buzzorange.com/techorange/" target="_blank" alt="techorange">
  			<area shape="rect" coords="175,350,285,380" href="https://buzzorange.com/vidaorange/" target="_blank" alt="vidaorange">
  			<area shape="rect" coords="40,410,150,450" href="https://www.huashan1914.com/" target="_blank" alt="華山1914文化創意產業園區">
  			<area shape="rect" coords="175,410,285,450" href="https://www.songshanculturalpark.org/" target="_blank" alt="松山文創園區">
  			<area shape="rect" coords="75,485,240,510" href="https://culture.skm.com.tw/" target="_blank" alt="財團法人新光三越文教基金會">
  			<area shape="rect" coords="75,535,240,570" href="http://www.fubonart.org.tw/" target="_blank" alt="富邦藝術基金會">
  			<area shape="rect" coords="40,600,150,650" href="https://www.tpac-taipei.org/" target="_blank" alt="臺北藝術表演中心">
  			<area shape="rect" coords="175,600,285,650" href="https://educate.children.org.tw/?utm_source=fliper2k7&utm_medium=weblogolink&utm_campaign=2020educate" target="_blank" alt="兒童福利聯盟">
		</map>
		<img class="desktop" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/__22_online_design_exhibition/__22-sponsor-web-0522.png'; ?>" usemap="#desktop-logo-map" />
		<map name="desktop-logo-map">
  			<area shape="rect" coords="120,105,260,145" href="/" target="_blank" alt="FLiPER">
  			<area shape="rect" coords="120,260,330,300" href="https://url.rhinoshield.tw/fliper" target="_blank" alt="RHINOSHIELD 犀牛盾">
  			<area shape="rect" coords="120,410,320,460" href="https://buzzorange.com/techorange/" target="_blank" alt="techorange">
  			<area shape="rect" coords="380,275,575,450" href="https://buzzorange.com/vidaorange/" target="_blank" alt="vidaorange">
  			<area shape="rect" coords="625,415,840,460" href="https://culture.skm.com.tw/" target="_blank" alt="財團法人新光三越文教基金會">
 			<area shape="rect" coords="120,520,320,590" href="https://www.huashan1914.com/" target="_blank" alt="華山1914文化創意產業園區">
  			<area shape="rect" coords="385,510,575,600" href="https://www.songshanculturalpark.org/" target="_blank" alt="松山文創園區">
  			<area shape="rect" coords="630,530,840,600" href="http://www.fubonart.org.tw/" target="_blank" alt="富邦藝術基金會">
  			<area shape="rect" coords="120,650,320,750" href="https://www.tpac-taipei.org/" target="_blank" alt="臺北藝術表演中心">
  			<area shape="rect" coords="385,650,575,750" href="https://educate.children.org.tw/?utm_source=fliper2k7&utm_medium=weblogolink&utm_campaign=2020educate" target="_blank" alt="兒童福利聯盟">
		</map>
	</div>
</div>

<div id="footer">
	<div class="row">
		<div id="footer-menu" class="footer-menu-wrap">
			<?php wp_nav_menu( array(
				'theme_location' => 'flipermag_desktop_footer_menu',
				'container'      => '',
				'menu_class'     => 'footer-menu-inner',
				'depth'          => 4,
				'echo'           => true,
			) ); ?>

			<div id="desktop-footer-links">
				<a class="instagram iconset" href="https://www.instagram.com/fliper_mag/" target="_blank"></a>
				<a class="facebook iconset" href="https://www.facebook.com/flipermag" target="_blank"></a>
				<a class="flipermag iconset" href="/"></a>
				<a class="fliper-publish iconset" href="https://publish.flipermag.com" target="_blank"></a>
			</div>
			<div id="mobile-footer-links">
				<a class="instagram iconset" href="https://www.instagram.com/fliper_mag/" target="_blank"></a>
				<a class="facebook iconset" href="https://www.facebook.com/flipermag" target="_blank"></a>
				<br/>
				<a class="flipermag iconset" href="/"></a>
				<a class="fliper-publish iconset" href="https://publish.flipermag.com" target="_blank"></a>
			</div>
		</div>

	</div>
	<div class="row">
		<div class="copyright">© 2020 FLiPER Creative Inc. <br/>All Rights Reserved.</div>
	</div>
</div>

</div><!--#main-container-->

</div><!--.site-container-->

<?php wp_footer(); ?>

<?php block_18_years_old(); // refer to function.php ?>
</body>
</html>