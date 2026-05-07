<?php get_header(); ?>

<style>


@media screen and (min-width: 1100px) {
	

}

</style>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<div class="full-article row">
	<?php if ( has_post_thumbnail () ) : ?>
	<div class="feature-image"><?php the_post_thumbnail( 'post-thumb' ); ?></div>
	<?php endif; ?>
	<h1 class="title"><?php the_title(); ?></h1>
	<div class="content"><?php the_content(); ?></div>
	<div class="bottom-actions">
		<a class="share iconset" href="#" data-url="<?php the_permalink(); ?>"></a>
	</div>
</div>

<?php endwhile; endif; ?>

<?php get_footer(); ?>