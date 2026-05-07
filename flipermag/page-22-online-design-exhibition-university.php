<?php 

/* Template Name: 22 Online Design Exhibition University */

$exhibition = get_field( '22-online-design-exhibition-university-info', get_the_ID() );

get_header(); 

?>

<style>
.desktop {
	display: none !important;
}
.iconset-22 {
	background-size: 300px !important;
	background:url(/wp-content/themes/flipermag/assets/images/__22_online_design_exhibition/__22_Icon_0518@2x.png);
}
#main-menu {
	background: transparent;
	z-index: 100;
    position: relative;
}
.hero-search-bg-wrap {
	background-image: url(/wp-content/themes/flipermag/assets/images/__22_online_design_exhibition/__22_Exhibition-bg-mobile.png);
	background-color:#FFEA00;
	background-size: cover;
	height: 358px;
	width: 100%;
	position: relative;
	z-index:-1;
	margin-top:-60px;
	position: absolute;
	left:0px;
	top:0px;
}
.hero-search-wrap .hero-search {
	padding:16px 17.5px 24px;
}
.hero-search-wrap .hero-search h1 {
	text-indent: -9999px;
	width:340px;
	height: 90px;
	position: relative;
	background-image:url(/wp-content/themes/flipermag/assets/images/__22_online_design_exhibition/__22_Exhibition-title-mobile.png);
	background-size:contain;
}
.hero-search-wrap .hero-search h1 img {
	display: block;
	width: 100%;
	position: absolute;
	left:0px;
	top:0px;
}
.hero-search-wrap .hero-search .about-22 {
	padding-top:8px;
	text-align:right;
	height: 16px;
}
.hero-search-wrap .hero-search .about-22 a {
	font: 700 12px/18px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	color: #1A1A1A;
	text-transform: uppercase;
	display: block;
	float:right;
}
.hero-search-wrap .hero-search .search-wrap {
	margin:10px 0px;
	padding:12px;
	background: #fff;
	height: 40px;
	border-radius: 16px;
}
.hero-search-wrap .hero-search .search-wrap .search-submit {
	width:32px;
	height: 32px;
	background-position: 0px -113px;
	border:0px;
	float:left;
	display: block;
	margin:4px 0px;
	padding:0px;
	cursor: pointer;
}
.hero-search-wrap .hero-search .search-wrap .search-input {
	width: 260px;
	height: 24px;
	padding:8px;
	font: 700 20px/24px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 1px;
	color: #8C8C8C;
	margin:0px 8px 0px 0px;
	border:0px;
	float:left;
	display: block;
}
.hero-search-wrap .hero-search .search-wrap .btn-search-type {
	margin:4px 0px;
	padding:6px 14px;
	border-radius: 12px;
	font: 700 15px/20px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.75px;
	color: #1A1A1A;
	float:left;
	display: block;
}
.hero-search-wrap .hero-search .search-wrap .btn-search-type.active {
	background: #EFEFEF;
}
.search-filter-wrap {
    padding: 10px 0px;
    display: flex;
    height: 40px;
    justify-content: space-between;
}
.btn-search-filter {
    width: 104px;
    padding: 10px;
    background: #DBDBDB;
    border-radius: 12px;
    box-sizing: border-box;
    position: relative;
}
.btn-search-filter a {
	font: 700 15px/20px Montserrat, "PingFang TC", "Noto Sans CJK TC";
    letter-spacing: 0.75px;
    color: #1A1A1A;
    display: block;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
}
.btn-search-filter a span.text {
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    display: block;
    padding-right: 15px; 
}

.btn-search-filter span.iconset-22 {
	width:10px;
	height: 10px;
	display: block;
	background-position: -0px -184px;
	margin:6px 0px 0px 5px;
	position: absolute;
	right:20px;
	top:12px;
}
.btn-search-filter.active span.iconset-22 {
    transform: rotate(180deg);
}
.list-search-filter {
    position: fixed;
    height: 200px;
    background: #EFEFEF 0% 0% no-repeat padding-box;
    width: 100%;
    left: 0px;
    bottom: 0px;
    padding: 12px 32.5px;
    z-index: 77;
    display: none;
    box-sizing: border-box;
    overflow: scroll;
}

.list-search-filter a {
	text-align: center;
	font: Bold 18px/24px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.9px;
	color: #747474;
	padding:12px 0px;
}

.stat {
	height: 16px;
}
.stat .views {
	display: inline-block;
	font: 500 12px/16px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.6px;
	color: #1A1A1A;
}
.stat .views span.iconset-22 {
	display: block;
	float:left;
	background-position: -56px -166px;
	width:27px;
	height: 16px;
	margin-right:4px;
}
.stat .share {
	display: inline-block;
	margin-left:16px;
	font: 500 12px/16px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.6px;
	color: #1A1A1A;
}
.stat .share span.iconset-22 {
	display: block;
	float:left;
	background-position: -34px -166px;
	width:22px;
	height: 16px;
	margin-right:4px;
}
.artwork-list-wrap {
	background: #fff;
	width:360px;
	margin:0 auto;
	padding:16px 12.5px 32px;
}
.artwork-list .artwork-item {
	padding:24px 0px;
}
.artwork-list .artwork-item > a {
	display: block;
}
.artwork-list .artwork-item .thumbnail {
	width:350px;
}
.artwork-list .artwork-item .thumbnail img {
	display:block;
	width: 100%;
	border-radius: 5px;
}
.artwork-list .artwork-item > a:hover .thumbnail img {
	opacity: 0.5;
}
.artwork-list .artwork-item .artwork-item-meta {
	padding:16px 88px 0px 5px;
	position: relative;
}
.artwork-list .artwork-item .artwork-item-meta .right {
	position: absolute;
	top:18px;
	right: 5px;
}
.artwork-list .artwork-item h3 {
	font: 700 15px/24px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.75px;
	color: #1A1A1A;
}
.artwork-list .artwork-item > a:hover h3 {
	color:#8C8C8C;
}
.artwork-list .artwork-item .artwork-item-meta .artwork-author {
	font: 400 12px/18px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.6px;
	color: #1A1A1A;
	padding:8px 0px 0px;
}
.artwork-list .artwork-item > a:hover .artwork-item-meta .artwork-author {
	color:#8C8C8C;
}
.artwork-list .artwork-item .artwork-item-meta .stat {
	margin-top:0px;
}
.artwork-list .artwork-item .artwork-item-meta .stat .views {
	display: block;
	text-align:right;
	width:56px;
}
.artwork-list .artwork-item .artwork-item-meta .stat .views span.iconset-22 {
	margin-left:auto;
	margin-right:0px;
	margin-bottom:4px;
	float:none;
}
#sponsors {
	padding:24px 0px 100px;
	background: #EFEFEF;
}
#sponsors-inner {
	width:320px;
	margin:0 auto;
	background: #FFFFFF;
	border-radius: 30px;
}
#footer {
	background: #EFEFEF;
	padding:0px 0px 36px;
	margin:0px;
}


.exhibition-wrap {
    padding: 16px 12.5px 32px;
    background: #fff;
}
	
.exhibition-item {
    padding: 24px 0px;
    position: relative;
}

a.exhibition-left {
    display: block;
}

.cover.mobile img {
    display: block;
    border-radius: 5px;
}

.exhibition-item h2 {
    text-align: left;
    font: 700 15px/24px Montserrat;
    letter-spacing: 0.75px;
    color: #1A1A1A;
    opacity: 1;
    width:252px;
}

.cover.mobile {
	width:100%;
	height: 200px;
	overflow: hidden;
    margin-bottom: 16px;
}

.org-dept {
	width:252px;
    text-align: left;
    font: 400 12px/18px Montserrat;
    letter-spacing: 0.6px;
    color: #1A1A1A;
    opacity: 1;
    padding-top: 8px;
}

.exhibition-item .artwork-thumb-wrap {
	display: none;
}

.exhibition-item .exhibition-right {
	position: absolute;
	right:5px;
	top:240px;
}


@media screen and (min-width: 1100px) {
.mobile {
	display: none !important;
}

.desktop {
	display: block !important;
}
body {
	padding-top:0px;
}
#main-menu {
	padding-top:28px;
}
#desktop-user-menu .profile-icon.logged .user-menu-wrap {
	background-color:transparent;
}
#desktop-user-menu .profile-icon.logged .user-menu {
	background: #fff;
}
.hero-search-bg-wrap {
	background-image: url(/wp-content/themes/flipermag/assets/images/__22_online_design_exhibition/__22_Exhibition-bg-web.png);
	background-color:#FFEA00;
	background-size: cover;
	height: 362px;
	width: 100%;
	position: relative;
	z-index:-1;
	margin-top:-62px;
	position: absolute;
	left:0px;
	top:0px;
}
.hero-search-wrap {
	width:1100px;
	margin:0 auto;
}
.hero-search-wrap .hero-search {
	padding:70px 175px 100px;
}
.hero-search-wrap .hero-search h1 {
	text-indent: -9999px;
	width:750px;
	height: 106px;
	position: relative;
	background-image:url(/wp-content/themes/flipermag/assets/images/__22_online_design_exhibition/__22_exhibition-title-web.png);
	background-size:contain;
}
.hero-search-wrap .hero-search h1 img {
	display: block;
	width: 100%;
	position: absolute;
	left:0px;
	top:0px;
}
.hero-search-wrap .hero-search .about-22 {
	padding-top:6px;
	height: 18px;
}
.hero-search-wrap .hero-search .about-22 a span {
	display: inline !important;
}
.hero-search-wrap .hero-search .about-22 a:hover {
	color: #496ABD;
}
.hero-search-wrap .hero-search .search-wrap {
	margin:16px 0px;
}
.hero-search-wrap .hero-search .search-wrap .search-input {
	width: 634px;
}
.hero-search-wrap .hero-search .search-wrap .btn-search-type {
	margin-left:6px;
}
.hero-search-wrap .hero-search .search-wrap .sep-line {
	width:2px;
	height: 40px;
	background: #DBDBDB;
	margin:0px 28px;
	float:left;
}
.search-filter-wrap {
    padding: 16px 0px;
    height: 50px;
}
.btn-search-filter {
    width: 200px;
    padding: 12px 20px;
    border-radius: 16px;
	position: relative;
}
.btn-search-filter:hover {
	background: #BCBCBC 0% 0% no-repeat padding-box;
}
.btn-search-filter.active {
	background: #FFC612 0% 0% no-repeat padding-box;
}
.btn-search-filter a {
	font: 700 20px/26px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 1px;
}
.btn-search-filter a span.text {
	padding-right:26px;
}
.btn-search-filter.sort {
	width:108px;
	background: #FFEA00 0% 0% no-repeat padding-box;
}
.btn-search-filter.sort:hover {
	background: #EAD700 0% 0% no-repeat padding-box;
}
.btn-search-filter.sort.active {
	background: #FFEA00 0% 0% no-repeat padding-box;
}
.btn-search-filter span.iconset-22 {
	margin:8px 0px 0px 16px;
}
.list-search-filter {
    position: absolute;
    box-shadow: 3px 3px 5px #00000019;
    border-radius: 16px;
    padding: 28px 26px;
    box-sizing: border-box;
    z-index: 99;
    top: 73px;
    bottom:auto;
    display: none;
    height: 240px;
    overflow: scroll;
}
.list-search-filter:before {
	content:'.';
	text-indent: -9999px;
	position: absolute;
	width: 0; 
  	height: 0; 
  	border-left: 18px solid transparent;
    border-right: 18px solid transparent;
    border-bottom: 16px solid #EFEFEF;
    top: -16px;
    left:36px;
}
.list-search-filter.category {
	width:240px;
	left:0px;
}
.list-search-filter.org {
	width:240px;
	left:0px;
}
.list-search-filter.dept {
	width:382px;
	left:0px;
}
.list-search-filter.sort {
	width: 144px;
	right: 0px;
	height: auto;
}
.list-search-filter.sort:before {
	left:auto;
	right:36px;
}
.list-search-filter a {
	text-align: left;
	font: 700 14px/20px Montserrat, "PingFang TC", "Noto Sans CJK TC";
	letter-spacing: 0.7px;
	color:#747474;
	padding:4px 10px;
}
.list-search-filter a:hover {
	color:#1A1A1A;
	background: #FFEA00 0% 0% no-repeat padding-box;
	border-radius: 10px;
}
.list-search-filter a.active {
	color: #496ABD;
}
    
ul.artwork-list {
	margin:0px -15px;
}

.artwork-list-wrap {
	padding:64px 0px;
	width:1100px;
}

.stat {
	margin-top:10px;
	height: 30px;
	padding-bottom:9px;
}
.related-artwork {
	background: #fff;
	margin-top:120px;
	padding:64px 0px;
}
.related-artwork-inner {
	width:1100px;
	margin:0 auto;
}
.related-artwork h2 {
	padding:16px 12.5px;
}
.artwork-list .artwork-item {
	padding:24px 12.5px;
	width:350px;
	float:left;
}
.artwork-list .artwork-item-meta h3 {
	height: 72px;
	overflow: hidden;
}

.artwork-list .artwork-item-meta .artwork-author {
	height: 36px;
	overflow: hidden;
}

#sponsors {
	padding:100px 0px 100px;
}

#sponsors-inner {
	width:960px;
	border-radius: 50px;
}

.no-result {
	padding: 24px 0px 120px;
    font: 700 20px/26px Montserrat, "PingFang TC", "Noto Sans CJK TC";
}

.exhibition-wrap {
    padding: 64px;
    width: 1100px;
    margin: 0 auto;
}

.exhibition-item {
    padding: 24px 0px;
}

.exhibition-item .exhibition-left {
	width:640px;
	display: block;
}

.cover.desktop {
    width: 640px;
    height: 243px;
    overflow: hidden;
}

.cover img {
	width:100%;
    display: block;
    border-radius: 5px;
}

.exhibition-item {
	position: relative;
}

.exhibition-item h2 {
    padding-top: 16px;
    text-align: left;
    font: 700 15px/24px Montserrat;
    letter-spacing: 0.75px;
    color: #1A1A1A;
    opacity: 1;
}

.exhibition-item .org-dept {
    padding-top: 8px;
    text-align: left;
    font: 400 12px/18px Montserrat;
    letter-spacing: 0.6px;
    color: #1A1A1A;
    opacity: 1;
}

.exhibition-left:hover img,
.exhibition-left:hover h2,
.exhibition-left:hover .org-dept,
.exhibition-right:hover .artwork-thumb img {
	opacity: 0.7;
}

.exhibition-item .exhibition-right {
	display: block;
	float:right;
	position: absolute;
	right:0px;
	top:24px;
}

.exhibition-item .artwork-thumb {
    width: 154px;
    margin-bottom: 22px;
}

.exhibition-item .artwork-thumb img {
	border-radius: 5px;
    display: block;
}

.exhibition-item .artwork-thumb-wrap {
    width: 330px;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
}

.exhibition-item .stat .views {
    float: right;
    text-align: right;
    margin-right: 4px;
}

.exhibition-item .stat {
    margin-top: -8px;
}

.exhibition-item .stat .views span.iconset-22 {
    float: none;
    margin-bottom: 4px;
    margin-right: 0px;
}

}
</style>

<?php if ( have_posts() ) : the_post(); ?>
<div class="exhibition-22-page-wrap">
	<div class="hero-search-bg-wrap"></div>
	<div class="hero-search-wrap">
		<div class="hero-search">
			<h1><?php the_title(); ?></h1>
			<div class="about-22">
				<a href="/22-online-design-exhibition/about">About <span class="desktop">＿＿ 22</span></a>
				<a href="/22-online-design-exhibition-home" style="margin-right:30px;">看作品</span></a>
			</div>
		</div>
	</div>
	<?php if ( $exhibition ) : ?>
	<div class="exhibition-wrap">
		<ul class="exhibition">
			<?php foreach ( $exhibition as $e ) : 
				$org = get_term_by( 'id', $e['org'], 'artwork_org');
				$dept = get_term_by( 'id', $e['dept'], 'artwork_org_dept');
				$eee = get_field( '22_design_exhibition_page', $dept );
				$this_exhibition = array();
				foreach ( $eee as $ee ) {
				    if ( $org->term_id == $ee['org'] ) {
					    $this_exhibition = $ee;
					}
				}
			?>
			<li>
				<div class="exhibition-item">
					<a class="exhibition-left" href="/22-online-design-exhibition-dept/?org=<?php echo $e['org']; ?>&dept=<?php echo $e['dept']; ?>">
						<div class="cover mobile"><img src="<?php echo wp_get_attachment_image_src( $this_exhibition['hero_image_mobile'], 'full' )[0]; ?>" /></div>
						<div class="cover desktop"><img src="<?php echo wp_get_attachment_image_src( $this_exhibition['hero_image_desktop'], 'full' )[0]; ?>" /></div>
						<h2><?php echo esc_html( $this_exhibition['name'] ); ?></h2>
						<div class="org-dept"><?php echo $org->name; ?> / <?php echo $dept->name; ?></div>
					</a>
					<a class="exhibition-right" href="/22-online-design-exhibition-dept/?org=<?php echo $e['org']; ?>&dept=<?php echo $e['dept']; ?>">
						<?php
							$a_sort = [
							    'range' => 'all', 
							    'order_by' => 'views', 
							    'post_type' => 'fliper_artwork',
							    'offset' => 0,
							    'limit' => 4,
							    'taxonomy' => 'artwork_org;artwork_org_dept',
							    'term_id' => $org->term_id . ';' . $dept->term_id
							];
							$query = new WordPressPopularPosts\Query( $a_sort );
							$ids = array();
							foreach ( $query->get_posts() as $p ) {
							    array_push( $ids, $p->id );
							}
							$query = new WP_Query( array(
								'post__in' => $ids,
								'orderby' => 'post__in',
								'post_type' => 'fliper_artwork',
								'posts_per_page' => -1,
								'fields' => 'ids'
							) );
							$artwork_ids = $query->get_posts();
        				?>
        				<div class="artwork-thumb-wrap">
        					<?php foreach ( $artwork_ids as $id ) : ?>
							<div class="artwork-thumb"><?php echo get_the_post_thumbnail( $id, 'home-top-big-2x' ); ?></div> 
							<?php endforeach; ?>
						</div>
						<div class="stat">
							<div class="views"><span class="iconset-22"></span><?php 
								// 取得 views
								$query = new WP_Query( array(
								    'post_type' => 'fliper_artwork',
								    'orderby' => 'date',
								    'order' => 'DESC',
								    'posts_per_page' => -1,
								    'no_found_rows' => true,
								    'tax_query' => array( 
								        'relation' => 'AND',
								        array(
								            'taxonomy' => 'artwork_org',
								            'field'    => 'term_id',
								            'terms'    => array( $org->term_id ),
								        ),
								        array(
								            'taxonomy' => 'artwork_org_dept',
								            'field'    => 'term_id',
								            'terms'    => array( $dept->term_id ),
								        )
								    ),
								    'fields' => 'ids'
								) );

								$exhibition_views = 0;
								foreach ( $query->get_posts() as $p ) {
								    $exhibition_views += wpp_get_views( $p );
								}
								echo $exhibition_views; ?>
							</div>
						</div>
					</a>
				</div>

			<?php endforeach; ?>
		</ul>
	</div>
	<?php endif; wp_reset_query(); ?>
</div>
<?php endif; ?>

<script>
$ = jQuery;
var load_artwork = false;
var load_end = false;
var load_count = 30;
$('document').ready(function(){
	$('.artwork-list').attr('data-offset', $('.artwork-list li').length);

	// 全域清除 popup
	$('body').click(function(event){
		if ( $(event.target).is('.btn-search-filter') || $(event.target).parents('.btn-search-filter').length > 0 ) {

		} else {
			$('.list-search-filter').hide();	
			$('.btn-search-filter').removeClass('active');	
		}
		
	});

	$('.btn-search-filter').click(function(event){
		event.preventDefault();
		var flag = $(this).hasClass('active');
		$('.btn-search-filter').removeClass('active');
		$('.list-search-filter').hide();
		
		if ( $(window).width() < 1100 ) {
			var window_bottom = $(window).scrollTop() + $(window).height();
			var btn_bottom = $(this).offset().top + $(this).outerHeight();
			var h = window_bottom - btn_bottom - 10 - 23;
			$(this).find('.list-search-filter').height( h );
		}

		if ( flag ) {
			$(this).removeClass('active');
			$(this).find('.list-search-filter').hide();
		} else {
			$(this).addClass('active');
			$(this).find('.list-search-filter').show();
		}
	});

	$('.list-search-filter .filter-item').click(function(){
		event.preventDefault();
		var v = $(this).attr('data-value');
		var n = $(this).text();
		$(this).parents('.btn-search-filter').find('.filter-item').removeClass('active');
		$(this).addClass('active');
		$(this).parents('.btn-search-filter').attr('data-value', v);
		$(this).parents('.btn-search-filter').find('span.text').text(n);
		load_end = false;
		get_artworks(0);
	});

	$('#search-form').submit(function(event){
		event.preventDefault();
		load_end = false;
		get_artworks(0);
	});

	
	$(window).scroll(function(event){
		if ( ! load_artwork && ! load_end && ( $(window).scrollTop() + 1000 > $('#sponsors').offset().top ) ) {
			var offset = $('.artwork-list').attr('data-offset');
			get_artworks(offset);
		} 
	});
	$(window).scroll();
});

function get_artworks( offset ) {
	var cat = $('.btn-search-filter.category').attr('data-value');
	var org = $('.btn-search-filter.org').attr('data-value');
	var dept = $('.btn-search-filter.dept').attr('data-value');
	var sort = $('.btn-search-filter.sort').attr('data-value');
	var search = $('.search-input').val();

	load_artwork = true;
	$.getJSON('/wp-json/web/v1/filter-artworks', {category: cat, org: org, dept: dept, search: search, offset: offset, sort: sort}, function(response) {
		if ( '0' == offset ) {
			$('.artwork-list').empty();	
		}
		
		$('.artwork-list').attr('data-offset', response.offset);
		if ( load_count > response.count ) {
			load_end = true;
		}
		response.list.forEach(function(item, index){
			var ele = '<li class="artwork-item">';
			ele += '<a href="' + item.url + '">';
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
</script>


<?php get_footer('22-online-design-exhibition'); ?>	