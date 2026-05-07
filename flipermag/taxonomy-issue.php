<?php
//get header
get_header();
?>

<style>
.issue-block {
    width:375px;
    margin:0 auto;
}

.issue-cover {
    margin-bottom: 22px;
}

.issue-cover img {
    display: block;
}

.issue-label {
	color: #1A1A1A;
    font-size: 14px;
    line-height: 24px;
    text-align: center;
    letter-spacing: 2.4px;
    margin-bottom: 12px;
    font-family: "PingFang TC", "Noto Sans TC";
}

.issue-title {
	color: #1A1A1A;
}

.issue-title .web {
	display: none;
}

.issue-title .mobile {
    font-size: 28px;
    text-align: center;
    font-weight: 500;
    line-height: 40px;
    letter-spacing: 2.8px;
    font-family: "PingFang TC", "Noto Sans TC";
    margin: 0px auto 20px;
    max-width: 310px;
}

.issue-description {
	color: #1A1A1A;
    width: 300px;
    margin: 0px auto 30px;
    font-size: 15px;
    line-height: 24px;
    font-family: "PingFang TC", "Noto Sans TC";
}

ul.issue-article-list {
	padding-top: 5px;
    flex-wrap: nowrap;
    overflow-x: scroll;
    -webkit-overflow-scrolling: touch;
    display: flex;
    margin: 0px auto 40px;
    width: 310px;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

ul.issue-article-list li.article {
    width: 170px;
    min-width: 170px;
    position: relative;
    padding-right: 30px;
    padding-top: 26px;
    border-top: 1px solid #1A1A1A;
}

ul.issue-article-list li.article .dot {
    position: absolute;
    width: 8px;
    height: 8px;
    border: 1px solid #1A1A1A;
    border-radius: 10px;
    background: #1A1A1A;
    left: 0px;
    top: -5px;
}

ul.issue-article-list li.article .date {
    font-size: 12px;
    font-family: "Roboto Slab";
    letter-spacing: 1.2px;
    color: #2BAB9F;
    margin-bottom: 16px;
    line-height: 16px;
}

ul.issue-article-list li.article .index {
    font-size: 12px;
    letter-spacing: 1.2px;
    line-height: 12px;
    font-family: "Roboto Slab";
    margin-bottom: 12px;
}

ul.issue-article-list li.article .title {
    font-size: 14px;
    line-height: 22px;
    letter-spacing: 1.4px;
    font-weight: 700;
    font-family: "PingFang TC", "Noto Sans TC";
}

ul.issue-article-list li.article.disable .dot {
	background: #fff;
}

ul.issue-article-list li.article.disable .date,
ul.issue-article-list li.article.disable .index,
ul.issue-article-list li.article.disable .title {
	opacity: 0.4;
}

@media screen and (min-width: 1100px) {
	.issue-block {
    	width:1100px;
    	margin:0 auto;
	}

	.issue-cover {
    	margin: 50px auto 32px;
    	width: 890px;
	}

	.issue-label {
    	line-height: 20px;
    	letter-spacing: 1.4px;
    	font-weight: 500;
    	font-family: "notoserifcjktc";
	}

	.issue-title .web {
    	font-size: 28px;
    	letter-spacing: 2.8px;
    	line-height: 42px;
    	display: block;
    	text-align: center;
    	font-weight: 500;
    	font-family: "notoserifcjktc";
    	width: 420px;
    	margin: 0px auto 20px;
	}

	.issue-title .mobile {
		display: none;
	}

	.issue-description {
    	font-family: "notoserifcjktc";
    	font-size: 14px;
    	letter-spacing: 1.4px;
    	width: 590px;
    	margin: 0 auto 60px;
    	font-weight: 500;
	}

	ul.issue-article-list {
		cursor:grab;
		overflow: hidden;
		width:1060px;
		margin:0px auto 50px;
		padding:25px 0px;
	}

	ul.issue-article-list li.article .title {
    	font-family: "notoserifcjktc";
    	font-weight:500;
	}
}

</style>

<?php $issue = get_queried_object(); ?>
<div class="issue-block">
	<div class="issue-cover">
		<img src="<?php the_field( 'issue_cover', $issue ); ?>" />
	</div>
	<div class="issue-label">ISSUE | 專題</div>
	<h1 class="issue-title">
		<div class="web"><?php echo nl2br( get_field( 'issue_title_web', $issue ) ); ?></div>
		<div class="mobile"><?php echo nl2br( get_field( 'issue_title_mobile', $issue ) ); ?></div>
	</h1>
	<div class="issue-description"><?php echo $issue->description; ?></div>

	<?php if( have_rows( 'issue_articles', $issue ) ): ?>
	<ul class="issue-article-list">
		<?php while( have_rows( 'issue_articles', $issue ) ): the_row(); ?>
		<li class="article <?php echo get_sub_field('issue_article') && 'publish' === get_post_status( get_sub_field('issue_article') ) ? '' : 'disable'; ?>">
			<div class="dot"></div>
			<div class="date"><?php echo date( 'M.d.Y', strtotime( get_sub_field('issue_article_publish_time') ) ); ?></div>
			<div class="index"><?php the_sub_field('issue_article_index'); ?> /</div>
			<div class="title"><?php echo get_sub_field('issue_article') && 'publish' === get_post_status( get_sub_field('issue_article') ) ? get_the_title( get_sub_field('issue_article') ) : get_sub_field('issue_article_title_tmp'); ?></div>
		</li>
		<?php endwhile; ?>
	</ul>
	<?php endif; ?>

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
			$category = get_category( $cat_id );
			$category_name = ( $category && ! is_wp_error( $category ) ) ? $category->name : '';
		?>
		<div class="article-info blue"><?php echo date( 'M', get_the_time('U') ) . get_the_date('.d.Y') . ( $category_name ? ' | ' . $category_name : '' ); ?></div>
		<div class="excerpt"><?php the_excerpt(); ?></div>
	</li>
<?php if ( 2 === $count % 3 || $count + 1 === $wp_query->post_count ) : ?>
</ul>
<?php endif; $count += 1; endwhile; ?>

<?php if ( ! wp_is_mobile() ) : ?>
<script>
const slider = document.querySelector('ul.issue-article-list');
let isDown = false;
let startX;
let scrollLeft;

slider.addEventListener('mousedown', (e) => {
  isDown = true;
  slider.classList.add('active');
  startX = e.pageX - slider.offsetLeft;
  scrollLeft = slider.scrollLeft;
});
slider.addEventListener('mouseleave', () => {
  isDown = false;
  slider.classList.remove('active');
});
slider.addEventListener('mouseup', () => {
  isDown = false;
  slider.classList.remove('active');
});
slider.addEventListener('mousemove', (e) => {
  if(!isDown) return;
  e.preventDefault();
  const x = e.pageX - slider.offsetLeft;
  const walk = (x - startX) * 3; //scroll-fast
  slider.scrollLeft = scrollLeft - walk;
  console.log(walk);
});
</script>
<?php endif; ?>

<?php
//get footer
get_footer();
?>
