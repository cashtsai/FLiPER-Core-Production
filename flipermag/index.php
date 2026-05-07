<?php
//get header
get_header();
?>

<style>
.archive-articles {
	padding-top:46px;
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
	font-size:22px;
	letter-spacing: 2.2px;
	line-height: 46px;
	display: flex;
	align-items: center;
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
		font-size:30px;
		letter-spacing: 3px;
		line-height: 50px;
	}

	.archive-articles .hero-title .en .slash {
    	margin-left:56px;
	}
}

</style>

<div class="archive-articles">
	<div class="row">
		<h1 class="hero-title">
			<?php if ( is_category() ) : 
				$current_category = single_cat_title('', false); 
				$category_id = get_cat_ID( $current_category );
			?>
			<div class="zh"><?php echo get_category( $category_id )->description; ?></div>
			<div class="en"><?php echo get_category( $category_id )->name; ?><span class="slash iconset"></span></div>
			<?php elseif ( is_tag() ) : ?>
			<div class="zh">關鍵字：<?php single_tag_title(); ?></div>
			<?php elseif ( is_search() ) : ?>
			<div class="zh">關於「<?php echo get_search_query(); ?>」的文章</div>
			<?php elseif ( is_author() ) : ?>
			<div class="zh">作者「<?php echo get_the_author_meta('display_name'); ?>」的文章</div>
			<?php else : ?>
			<div class="zh">最新文章</div>
			<div class="en">THE LATEST<span class="slash iconset"></span></div>
			<?php endif; ?>
		</h1>
	</div>
	
	<?php 
		global $wp_query;
		$count = 0;
		while( have_posts() ) : the_post();
			$cat_id = get_field( 'main_category', get_the_ID() );
			if ( 0 === $count % 3 ) :
	?>
	<ul class="list-articles-wrap row">
	<?php endif; ?>
		<li class="article">
			<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
			<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	<?php
		$main_category = get_category( $cat_id );
		$main_category_name = ( ! is_wp_error( $main_category ) && is_object( $main_category ) && ! empty( $main_category->name ) ) ? $main_category->name : '';
	?>
			<div class="article-info blue"><?php echo date( 'M', get_the_time('U') ) . get_the_date('.d.Y') . ( $main_category_name ? ' | ' . $main_category_name : '' ); ?></div>			
			<div class="excerpt"><?php the_excerpt(); ?></div>
		</li>
	<?php if ( 2 === $count % 3 || $count + 1 === $wp_query->post_count ) : ?>
	</ul>
	<?php endif; $count += 1; endwhile; ?>
	<?php if ( $wp_query->found_posts > get_option( 'posts_per_page' ) ) : ?>
	<div class="readmore row">
		<?php if ( is_category() ) : ?>
		<img id="infinite-readmore-icon" data-type="category" data-cat-id="<?php echo $category_id; ?>" data-page="2" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/loading.gif'; ?>" />
		<?php elseif ( is_tag() ) : ?>
		<img id="infinite-readmore-icon" data-type="tag" data-tag-id="<?php echo get_queried_object()->term_id; ?>" data-page="2" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/loading.gif'; ?>" />
		<?php elseif ( is_search() ) : ?>
		<img id="infinite-readmore-icon" data-type="search" data-keyword="<?php echo get_search_query(); ?>" data-page="2" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/loading.gif'; ?>" />
		<?php elseif ( is_author() ) : ?>
		<img id="infinite-readmore-icon" data-type="author" data-author-id="<?php echo get_the_author_meta('ID'); ?>" data-page="2" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/loading.gif'; ?>" />
		<?php else : ?>
		<img id="infinite-readmore-icon" data-type="new" data-page="2" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/loading.gif'; ?>" />
		<?php endif; ?>
	</div>
	<?php endif; ?>
</div>

<?php
//get footer
get_footer();
?>
