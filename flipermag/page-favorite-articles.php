<?php
	/* Template Name: Favorite Articles */

	if ( ! is_user_logged_in() ) {
		wp_safe_redirect( site_url() );
		exit;
	}
	get_header();

	$current_user = wp_get_current_user();
	$favorite_post_ids = FP_Favorite::get_favorite_post_ids( $current_user->ID, 0, 15 );
	$fav_query = new WP_Query();
	if ( $favorite_post_ids != array() && $favorite_post_ids != '' ) {
		$fav_query = new WP_Query( array( 'post__in' => $favorite_post_ids, 'orderby' => 'post__in', 'posts_per_page' => 15, 'offset' => 0 ) );
	}
?>

<style>
.archive-articles {
	margin-top:46px;
}

.archive-articles .hero-title {
	margin-bottom:36px;
	padding:0px 20px;
}

.archive-articles .hero-title .zh {
	font-family: "Noto Sans TC";
	font-weight: 600;
	font-size:14px;
	letter-spacing: 1.4px;
	line-height: 26px;
}

.archive-articles .hero-title .en {
	font-family: "Roboto Slab";
	font-weight: 400;
	font-size:12px;
	letter-spacing: 1.2px;
	line-height: 22px;
	color:#666;
	text-transform: uppercase;
}

.archive-articles .hero-title .en .slash {
    width: 28px;
    height: 28px;
    display: block;
    background-position-x: -66px;
    background-position-y: -237px;
    margin-left:16px;
}

.archive-articles .readmore img {
	margin:0px auto 100px auto;
	display: block;
	width:120px;
}

@media screen and (min-width: 1100px) {
	.archive-articles {
		margin-top:90px;
	}

	.archive-articles .hero-title {
		margin-bottom:72px;
		padding:0px;
	}

	.archive-articles .hero-title .zh {
		font-size:16px;
		letter-spacing: 1.6px;
		line-height: 36px;
		font-family: "notoserifcjktc";
	}

	.archive-articles .hero-title .en {
		font-size:14px;
		letter-spacing: 1.4px;
		line-height: 26px;
	}

	.archive-articles .hero-title .en .slash {
    	margin-left:56px;
	}
}

</style>

<div class="archive-articles">
	<div class="row">
		<h1 class="hero-title">
			<div class="zh">我的書籤</div>
			<div class="en">MY FAVORITE</div>
		</h1>
	</div>

	<?php if ( $fav_query->have_posts() ) : 
		$count = 0;
		while ( $fav_query->have_posts() ) : $fav_query->the_post();
			$cat_id = get_field( 'main_category', get_the_ID() );
			if ( 0 === $count % 3 ) :
	?>
	<ul class="list-articles-wrap row">
	<?php endif; ?>
		<li class="article">
			<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
			<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<div class="article-info blue"><?php echo date( 'M', get_the_time('U') ) . get_the_date('.d.Y') . ' | ' . get_category( $cat_id )->name; ?></div>
			<div class="excerpt"><?php the_excerpt(); ?></div>
		</li>
	<?php if ( 2 === $count % 3 ) : ?>
	</ul>
	<?php endif; $count += 1; endwhile; endif; wp_reset_query(); ?>
	<div class="readmore row">
		<img id="infinite-readmore-icon" data-type="favorite" data-user-id="<?php echo $current_user->ID; ?>" data-page="2" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/loading.gif'; ?>" />
	</div>
</div>


<?php get_footer(); ?>
