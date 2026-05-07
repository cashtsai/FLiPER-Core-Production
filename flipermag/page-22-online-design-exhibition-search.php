<?php 

/* Template Name: 22 Online Design Exhibition Search */

$sort = 'hot';
if ( 'date' == $_GET['sort']  ) {
	$sort = $_GET['sort'];
}
$q_cat = $_GET['cat'] ? $_GET['cat'] : 'all';
$q_org = $_GET['org'] ? $_GET['org'] : 'all';
$q_dept = $_GET['dept'] ? $_GET['dept'] : 'all';
$q_search = $_GET['search'] ? $_GET['search'] : '';

$category_id = '0';
$org_id = '0';
$dept_id = '0';

$query = array(
	'post_type' => 'fliper_artwork', 
	'posts_per_page' => 30, 
	'offset' => 0, 
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
		'offset' => 0,
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

$artwork_category = get_terms( 'artwork_category', array(
    'hide_empty' => false,
) );

$artwork_org = get_terms( 'artwork_org', array(
    'hide_empty' => false,
) );

$artwork_dept = get_terms( 'artwork_org_dept', array(
    'hide_empty' => false,
) );

wp_enqueue_style( 'single-fliper_artwork', get_stylesheet_directory_uri() . '/assets/css/single-fliper_artwork.css', array(), filemtime( get_stylesheet_directory() . '/assets/css/single-fliper_artwork.css' ) );

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
	margin-top:10px;
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
	margin:0 auto;
	width:350px;
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
	height: 248px;
	overflow: hidden;
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

.no-result {
    padding: 120px 0px 120px;
    text-align: center;
    font: 700 20px/30px Montserrat, "PingFang TC", "Noto Sans CJK TC";
    letter-spacing: 1px;
    color: #1A1A1A;
    display: none;
}

.no-result a {
    text-decoration: underline;
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
body.artwork {
	padding-top:28px;
}
body.artwork #main-menu {
	padding-top:0px;
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
	height: 540px;
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


}
</style>

<?php if ( have_posts() ) : the_post(); ?>
<div class="exhibition-22-page-wrap page-index-0">
	<div class="hero-search-bg-wrap"></div>
	<div class="hero-search-wrap">
		<div class="hero-search">
			<a style="display:block;" href="/22-online-design-exhibition-home/"><h1><?php the_title(); ?></h1></a>
			<div class="about-22">
				<a href="/22-online-design-exhibition/about">About <span class="desktop">＿＿ 22</span></a>
				<a href="/22-online-design-exhibition-university" style="margin-right:30px;">看系所</span></a>
			</div>
			<div class="search-wrap">
				<form id="search-form" action="" type="post">
					<input class="search-submit iconset-22" name="search_submit" type="submit" value="" />
					<input class="search-input" name="search_input" type="text" value="" placeholder="Search Artwork" />
					<input type="hidden" name="search_type" value="artwork" />
					<!-- <div class="sep-line"></div> -->
					<!-- <a class="btn-search-type artwork active" href="#">作品</a>
					<a class="btn-search-type org" href="#">系所</a> -->
				</form>
			</div>
			<div class="search-filter-wrap">
				<div class="btn-search-filter category" data-value="all">
					<a href="#"><span class="text">類別</span><span class="iconset-22"></span></a>
					<?php if ( $artwork_category ) : ?>
					<ul class="list-search-filter category">
						<li><a class="filter-item" data-value="all" href="#">所有類別</a></li>
						<?php foreach ( $artwork_category as $a ) : ?>
						<li><a class="filter-item" data-value="<?php echo $a->slug; ?>" href="#"><?php echo $a->name; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<?php endif; ?>
				</div>
				<div class="btn-search-filter org" data-value="all">
					<a href="#"><span class="text">學校</span><span class="iconset-22"></span></a>
					<?php if ( $artwork_org ) : ?>
					<ul class="list-search-filter org">
						<li><a class="filter-item" data-value="all" href="#">所有學校</a></li>
						<?php foreach ( $artwork_org as $a ) : ?>
						<li><a class="filter-item" data-value="<?php echo $a->slug; ?>" href="#"><?php echo $a->name; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<?php endif; ?>
				</div>
				<div class="btn-search-filter dept" data-value="all">
					<a href="#"><span class="text">系所</span><span class="iconset-22"></span></a>
					<?php if ( $artwork_dept ) : ?>
					<ul class="list-search-filter dept">
						<li><a class="filter-item" data-value="all" href="#">所有系所</a></li>
						<?php foreach ( $artwork_dept as $a ) : ?>
						<li><a class="filter-item" data-value="<?php echo $a->slug; ?>" href="#"><?php echo $a->name; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<?php endif; ?>
				</div>
				<div class="btn-search-filter sort desktop" data-value="hot">
					<a href="#"><span class="text">排序</span><span class="iconset-22"></span></a>
					<ul class="list-search-filter sort">
						<li><a class="filter-item" data-value="hot" href="#">熱門</a></li>
						<li><a class="filter-item" data-value="date" href="#">報名順序</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	
	<div class="artwork-list-wrap">
		<?php if ( $query->have_posts() ) : ?>
		<ul class="artwork-list clearfix" data-offset="0">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
			<li class="artwork-item">
				<a class="historical-link" href="<?php the_permalink(); ?>" data-id="<?php the_ID(); ?>">
					<div class="thumbnail"><?php the_post_thumbnail('home-top-big-2x'); ?></div>
					<div class="artwork-item-meta">
						<div class="left">
							<h3><?php the_title(); ?></h3>
							<div class="artwork-author">
								<?php 
									$artwork_authors = get_field( 'artwork_author', get_the_ID() );
									$i = 0; 
									foreach ( $artwork_authors as $a ) { 
										if ( 0 === $i ) { 
											echo esc_html( $a['name'] ); $i = 1; 
										} else { 
											echo '、' . esc_html( $a['name'] ); 
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
		<img id="infinite-loading" style="margin: auto;width: 120px;display: block;" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/loading.gif'; ?>" />
		<?php endif; wp_reset_query(); ?>
		<div class="no-result">沒有找到作品，<br class="mobile" />回去<a class="reset-filter" href="#">看看其他作品</a>吧！</div>
	</div>
	
</div>
<?php endif; ?>

<script>
$ = jQuery;
var load_artwork = false;
var load_end = false;
var load_count = 30;
var page_index = 0;
var scroll_top = [0];
var sort = '<?php echo $sort; ?>';
var cat = '<?php echo $q_cat; ?>';
var org = '<?php echo $q_org; ?>';
var dept = '<?php echo $q_dept; ?>';
var search = '<?php echo $q_search; ?>';
var offset = 0;
var pre_offset = 0;
$('document').ready(function(){
	window.offset = $('.artwork-list li').length;

	if ( ! $('.artwork-item').length ) {
		$('.no-result').show();
	}

	if ( 'hot' == sort ) {
		$('.btn-search-filter.sort span.text').text('熱門');
		$('.list-search-filter.sort .filter-item[data-value=hot]').addClass('active');
	} else {
		$('.btn-search-filter.sort span.text').text('報名順序');
		$('.list-search-filter.sort .filter-item[data-value=date]').addClass('active');
		$('.btn-search-filter.sort').attr('data-value', 'date');
	}
	$('.list-search-filter.category .filter-item[data-value="' + encodeURIComponent( cat ).toLowerCase() + '"]').addClass('active');
	$('.btn-search-filter.category span.text').text($('.list-search-filter.category .filter-item.active').text());
	$('.btn-search-filter.category').attr('data-value', encodeURIComponent( cat ).toLowerCase());
	$('.list-search-filter.org .filter-item[data-value="' + encodeURIComponent( org ).toLowerCase() + '"]').addClass('active');
	$('.btn-search-filter.org span.text').text($('.list-search-filter.org .filter-item.active').text());
	$('.btn-search-filter.org').attr('data-value', encodeURIComponent( org ).toLowerCase());
	$('.list-search-filter.dept .filter-item[data-value="' + encodeURIComponent( dept ).toLowerCase() + '"]').addClass('active');
	$('.btn-search-filter.dept span.text').text($('.list-search-filter.dept .filter-item.active').text());
	$('.btn-search-filter.dept').attr('data-value', encodeURIComponent( dept ).toLowerCase());
	$('.search-input').val(search);
	

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
		// load_end = false;
		// get_artworks(0);
		var cat = $('.btn-search-filter.category').attr('data-value');
		var org = $('.btn-search-filter.org').attr('data-value');
		var dept = $('.btn-search-filter.dept').attr('data-value');
		var sort = $('.btn-search-filter.sort').attr('data-value');
		var search = $('.search-input').val();
		var url = '/22-online-design-exhibition-home/';
		window.location = url + '?cat=' + cat + '&org='  + org + '&dept=' + dept + '&sort=' + sort + '&search=' + search;
	});

	$('#search-form').submit(function(event){
		event.preventDefault();
		// load_end = false;
		// get_artworks(0);
		var cat = $('.btn-search-filter.category').attr('data-value');
		var org = $('.btn-search-filter.org').attr('data-value');
		var dept = $('.btn-search-filter.dept').attr('data-value');
		var sort = $('.btn-search-filter.sort').attr('data-value');
		var search = $('.search-input').val();
		var url = '/22-online-design-exhibition-home/';
		window.location = url + '?cat=' + cat + '&org='  + org + '&dept=' + dept + '&sort=' + sort + '&search=' + search;
	});

	
	$(window).scroll(function(event){
		if ( $('#sponsors').length ) {
			if ( ! window.load_artwork && ! window.load_end && ( $(window).scrollTop() + 1000 > $('#sponsors').offset().top ) ) {
				get_artworks(window.offset);
			} 	
		}
	});
	$(window).scroll();

	$('.reset-filter').click(function(event){
		event.preventDefault();
		// $('.btn-search-filter.category').attr('data-value', 'all');
		// $('.btn-search-filter.category span.text').text('類別');
		// $('.btn-search-filter.org').attr('data-value', 'all');
		// $('.btn-search-filter.org span.text').text('學校');
		// $('.btn-search-filter.dept').attr('data-value', 'all');
		// $('.btn-search-filter.dept span.text').text('系所');
		// $('.btn-search-filter.sort').attr('data-value', 'hot');
		// $('.btn-search-filter.sort span.text').text('排序');
		// $('.list-search-filter .filter-item').removeClass('active');
		// var search = $('.search-input').val('');
		// $('.artwork-list').attr('data-offset', '0');
		// load_end = false;
		// get_artworks(0);
		window.location = '/22-online-design-exhibition-home/';
	});

	$('body').on('click', '.historical-link', function(event) {
		event.preventDefault();
		window.offset = window.pre_offset + $(this).parent('.artwork-item').index() + 1;
		window.pre_offset = window.offset;
		window.cat = $('.btn-search-filter.category').attr('data-value');
		window.org = $('.btn-search-filter.org').attr('data-value');
		window.dept = $('.btn-search-filter.dept').attr('data-value');
		window.sort = $('.btn-search-filter.sort').attr('data-value');
		window.search = $('.search-input').val();
		var url = $(this).attr('href');
		var id = $(this).attr('data-id');
		// window.location = url + '?offset=' + offset  + '&cat=' + cat + '&org='  + org + '&dept=' + dept + '&sort=' + sort + '&search=' + search;

		window.scroll_top[window.page_index] = $(window).scrollTop();
		window.page_index += 1;
		window.history.pushState({page_index: window.page_index, offset: window.offset, pre_offset: window.pre_offset}, 'home', url);
		$.getJSON( '/wp-json/web/v1/artworks/' + id, function(response){
			var html = '<div class="full-artwork-wrap page-index-' + window.page_index + '">' + response.html;
			html = html + '<div class="related-artwork">\
				<div class="related-artwork-inner">\
				<h2>繼續逛展</h2>\
				<ul class="artwork-list clearfix"></ul>\
				</div></div></div></div>'
			$('.page-index-' + (window.page_index - 1) ).hide();
			$('body').addClass('artwork');
			$($(html)).insertAfter($('.page-index-' + (window.page_index - 1) ));
			window.load_artwork = false;
			window.load_end = false;
			$('#infinite-loading').show();
			$(window).scrollTop(0);
		});
	});

	window.onpopstate = function(event) {
		if ( ! event.state ) {
			$('.page-index-1' ).hide();
			$('.page-index-0' ).show();
			window.page_index = 0;
			window.pre_offset = 0;
			$('body').removeClass('artwork');
		} else {
			$('.page-index-' + (event.state.page_index + 1) ).hide();
			$('.page-index-' + (event.state.page_index) ).show();
			$('.page-index-' + (event.state.page_index - 1) ).hide();
			window.page_index = event.state.page_index;
			window.offset = event.state.offset;
			window.pre_offset = event.state.pre_offset;
		}
		$(window).scrollTop(window.scroll_top[window.page_index]);
	};

	// Single page function
	$('body').on('click', '#prev-page', function(event) {
        event.preventDefault();
        if ( window.history.length <= 2 ) {
            window.location = /22-online-design-exhibition-home/;
        } else {
            window.history.back();
        }
    });

	$('body').on('click', '.btn-copy', function(event) {
		event.preventDefault();
		$('body').append('<input id="current-url" type="hidden" value="' + $(this).attr('data-url') + '" />');
		copy_url();
		$('#current-url').remove();
	}); 

	$('body').on('click', '.share-link-wrap .fb', function(event) {
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
});

function get_artworks( offset ) {
	var cat = $('.btn-search-filter.category').attr('data-value');
	var org = $('.btn-search-filter.org').attr('data-value');
	var dept = $('.btn-search-filter.dept').attr('data-value');
	var sort = $('.btn-search-filter.sort').attr('data-value');
	var search = $('.search-input').val();

	window.load_artwork = true;
	$.getJSON('/wp-json/web/v1/filter-artworks', {category: cat, org: org, dept: dept, search: search, offset: offset, sort: sort}, function(response) {
		if ( '0' == offset ) {
			$('.page-index-' + window.page_index + ' .artwork-list').empty();	
		}

		window.offset = response.offset;
		if ( window.load_count > response.count ) {
			window.load_end = true;
			$('#infinite-loading').hide();
		}
		response.list.forEach(function(item, index){
			var ele = '<li class="artwork-item">';
			ele += '<a class="historical-link" href="' + item.url + '" data-id="' + item.id + '">';
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
			$('.page-index-' + window.page_index + ' .artwork-list').append(ele);
		});

		if ( '0' == response.offset & '0' == response.count ) {
			$('.no-result').show();	
		} else {
			$('.no-result').hide();	
		}

		window.load_artwork = false;
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