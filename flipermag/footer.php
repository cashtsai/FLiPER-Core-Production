
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
				<a class="flipermag" href="/"></a>
				<a class="fliper-publish iconset" href="https://publish.flipermag.com" target="_blank"></a>
			</div>
			<div id="mobile-footer-links">
				<a class="instagram iconset" href="https://www.instagram.com/fliper_mag/" target="_blank"></a>
				<a class="facebook iconset" href="https://www.facebook.com/flipermag" target="_blank"></a>
				<br/>
				<a class="flipermag" href="/"></a>
				<a class="fliper-publish iconset" href="https://publish.flipermag.com" target="_blank"></a>
			</div>
		</div>

	</div>
	<div class="row">
		<div class="footer-tagline" style="text-align:center;margin-bottom:10px;">
			<div style="font:700 13px/1.6 'Roboto Slab',serif;letter-spacing:3px;color:#1A1A1A;">KEEP EXPLORING</div>
			<div style="font-size:12px;line-height:1.8;letter-spacing:1px;color:#777;">帶著渺小的自己，探索廣大的世界。</div>
		</div>
		<div class="copyright">© 2026 為善彰之股份有限公司 <br/>All Rights Reserved.</div>
	</div>
</div>

</div><!--#main-container-->

</div><!--.site-container-->

<style>
#site-deco {
	width: 26px;
	height: 90px;
	z-index:999999;
	position: fixed;
	background:url(/wp-content/themes/flipermag/assets/images/mobile_Artboard@2x.png); 
	background-size: 100%;
	right:0px;
	top:484px;
}

#site-deco a {
	display: block;
	width: 26px;
	height: 90px;
}

@media screen and (min-width: 1100px) {
	#site-deco {
		width: 120px;
		height: 160px;
		background:url(/wp-content/themes/flipermag/assets/images/Web_Artboard@2x.png); 
		background-size: 100%;
		right:0px;
		top:500px;
	}

	#site-deco a {
		width: 120px;
		height: 160px;
	}

}

</style>

<!-- <div id="site-deco"><a href="https://flipermag.com/22-online-design-exhibition/about/"></a></div> -->

<?php wp_footer(); ?>

<?php block_18_years_old(); // refer to function.php ?>
</body>
</html>
