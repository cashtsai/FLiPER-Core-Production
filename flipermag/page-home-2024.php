<?php

/* Template Name: Home 2024 */

$today = current_time('timestamp');

get_header();

?>

<style type="text/css">
#masthead {
	padding:10px 0px;
	margin-bottom:20px;
}

#masthead h4 {
	text-align: center;
	font: Bold 12px/12px "Roboto Slab";
	letter-spacing: 1.2px;
	color: #1A1A1A;
}

#masthead h3 {
	text-align: center;
	font: Bold 20px/24px Roboto Slab;
	letter-spacing: 2px;
	text-transform: uppercase;
	color: #1A1A1A;
	padding:6px 0px;
}

#masthead h5 {
	text-align: center;
	font: Bold 10px/10px Roboto Slab;
	letter-spacing: 0.25px;
	color: #8C8C8C;
	transform: scale(0.83);
}

.hr {
	margin-top:4px;
	height:1px;
	background:#1A1A1A;
}

.list-articles-wrap .article .feature-image {
	margin-left:0px;
	margin-right:0px;
}

.list-articles-wrap.second,
.list-articles-wrap.third {
	display: block;
}

.list-articles-wrap.second .article,
.list-articles-wrap.third .article {
	display: flex;
	gap:16px;
	width: auto;
	margin-bottom:20px;
}

.list-articles-wrap.second .article .title,
.list-articles-wrap.third .article .title {
	margin-bottom:8px;
	font-size: 16px;
	line-height: 24px;
	max-height: 72px;
	overflow: hidden;
}

.list-articles-wrap.third .article .feature-image img {
	width: auto;
	height: auto;
}

@media screen and (min-width: 1100px) {
	#latest-articles-wrap {
		display:flex;
		gap:40px;
	}

	.list-articles-wrap.second,
	.list-articles-wrap.third {
		display:flex;
		flex-flow: row wrap;
		justify-content: space-between;
	}

	.list-articles-wrap.second .article {
		width: 46%;
		display: block;
	}

	.list-articles-wrap.third .article {
		display: list-item;
		width: 340px;
	}

	.list-articles-wrap.second .article .title {
		max-height: 48px;
	}

	.list-articles-wrap.third .article .title {
		margin-bottom:26px;
		font-size: 22px;
		line-height: 35px;
		max-height: 105px;
	}

	.list-articles-wrap.second .article .article-info {
		margin-bottom: 30px;
	}

	.list-articles-wrap.third .article .feature-image img {
		width: 340px;
    	height: 216px;
	}
}
</style>

<div id="masthead" class="row hide-on-desktop">
	<h4><?php echo date("Y l", $today); ?></h3>
	<h3><?php echo date('F d', $today); ?></h3>
	<h5>Let Wonders Enrich Our Life</h5>
</div>

<div id="latest-articles">
	<div class="hide-on-desktop row" style="border-top: 2px solid #1A1A1A;margin-bottom: 30px;">
		<div class="hr row"></div>
		<div style="display: flex;justify-content: space-between;">
			<h2 class="block-title" style="margin-left:0px;font-size: 16px;line-height: 60px;margin-bottom:0px;">最新文章</h2>
			<h2 class="block-title" style="margin-left:0px;font-size: 16px;line-height: 60px;margin-bottom:0px;">THE LATEST</h2>
		</div>
		<div class="hr row"></div>
	</div>
	<div class="hide-on-mobile" style="margin-top:50px;">
		<div class="row"><h2 class="hero-title">最新文章</h2></div>
		<div class="hero-title-en clearfix">
			<hr />
			<div class="row" style="text-align: center;"><h2>THE LATEST</h2></div>
		</div>
	</div>

	<?php 
		$query = new WP_Query( array(
			'posts_per_page' => 11
		) );
		$count = 0;
		while( $query->have_posts() ) : $query->the_post();
			$cats = wp_get_post_categories( get_the_ID(), array( 'fields' => 'names' ) );
			$cat_name = $cats ? $cats[0] : '';

			if ( 0 === $count ) :
	?>
	<div id="latest-articles-wrap" class="row">
		<div class="list-articles-wrap" style="flex:10">
			<div class="article" style="width:auto">
				<div class="feature-image auto-size" style="margin-bottom: 20px;"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
				<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<div class="article-info blue"><?php echo date( 'M', get_the_time('U') ) . get_the_date('.d.Y') . ' | ' . $cat_name; ?></div>
			</div>
		</div>
		<div class="list-articles-wrap second" style="flex:10;">
	<?php elseif ( 4 >= $count ) : ?>
			<div class="article">
				<div class="feature-image auto-size" style="margin-bottom:12px;flex:4"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
				<div style="flex:5;">
					<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="article-info blue"><?php echo date( 'M', get_the_time('U') ) . get_the_date('.d.Y') . ' | ' . $cat_name; ?></div>
				</div>
			</div>
	<?php 
		endif;
		if ( 4 === $count ) : 
	?>
		</div>
	</div>
	<?php 
		endif;
		if ( 4 < $count && 2 === $count % 3 ) : 
	?>
	<ul class="list-articles-wrap third row">
	<?php 
		endif; 
		if ( 4 < $count ) :
	?>
		<li class="article <?php echo 8 < $count ? 'hide-on-mobile' : ''; ?>">
			<div class="feature-image" style="flex:4"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
			<div style="flex:5">
				<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<div class="article-info blue"><?php echo date( 'M', get_the_time('U') ) . get_the_date('.d.Y') . ' | ' . $cat_name; ?></div>
			</div>
			<div class="excerpt hide-on-mobile"><?php the_excerpt(); ?></div>
		</li>
	<?php 
		endif; 
		if ( 4 < $count && 1 === $count % 3 ) : 
	?>
	</ul>
	<?php endif; $count += 1; endwhile; wp_reset_query(); ?>
	<div class="readmore row">
		<a href="/content/">READ MORE</a>
	</div>
</div>

<div id="trending-articles" class="hide-on-mobile">
	<div class="hide-on-desktop">
		<div class="row">
			<h2 class="block-title">熱門文章 TRENDING<span class="slash">/</span></h2>
		</div>
	</div>
	<div class="hide-on-mobile">
		<div class="row"><h2 class="hero-title">熱門文章</h2></div>
		<div class="hero-title-en clearfix">
			<hr />
			<div class="row"><h2>TRENDING</h2></div>
		</div>
	</div>
	<?php 
		// Use WordPress Popular Posts function to get popular post ids
	    wpp_get_mostpopular_post( 'post_type="post"&order_by="views"&range="custom"&time_quantity="12"&time_unit="month"&limit="5"&freshness="1"' );
	    global $wpp_popular_post_ids;
	    
	    $query = new WP_Query( array( 'post__in' => $wpp_popular_post_ids, 'posts_per_page' => 5 ) );
	    $count = 1;
	    while ( $query->have_posts() ) : 
	    	$query->the_post();
	    	$cats = wp_get_post_categories( get_the_ID(), array( 'fields' => 'names' ) );
			$cat_name = $cats ? $cats[0] : '';

	    	if ( 1 === $count ) :
	?>
	<div class="big-article row clearfix">
		<div class="count hide-on-mobile">0<?php echo $count; ?> /</div>
		<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('home-top-big-2x'); ?></a></div>
		<div class="meta">
			<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<div class="article-info green"><?php echo date( 'M', get_the_time('U') ) . get_the_date('.d.Y') . ' | ' . $cat_name; ?></div>
			<div class="excerpt"><?php the_excerpt(); ?></div>
		</div>
	</div>
	<ul class="small-article-wrap row">
	<?php else : ?>
		<li class="small-article">
			<div class="count">0<?php echo $count; ?> /</div>
			<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('home-top-small-2x'); ?></a></div>
			<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<div class="article-info green"><?php echo date( 'M', get_the_time('U') ) . get_the_date('.d.Y') . ' | ' . $cat_name; ?></div>
		</li>
	<?php endif; $count += 1; endwhile; ?>
	</ul>
</div>

<style>
#home-feature-issue h2 {
	font: 700 18px/60px "Roboto Slab", "Noto Sans TC";
	letter-spacing: 1.8px;
	color: #1A1A1A;
	margin-bottom:20px;
	border-bottom:1px solid #1A1A1A;
	text-align: center;
}

.issue-block {
	margin-bottom:50px;
}

.issue-cover {
    margin-bottom: 16px;
}

.issue-cover a:hover img {
	opacity: .5;
}

.issue-cover img, .issue-cover a {
    display: block;
}

.issue-title {
	display: block;
	color: #1A1A1A;
   	font-size: 18px;
    font-weight: 700;
   	line-height: 28px;
    font-family: "Noto Sans TC";
   	margin-bottom: 14px;
    padding:0px 15px;
}

.issue-title:hover {
	color:gray;
}

#home-feature-issue .date {
	font: 400 16px/16px "Roboto Slab", "Noto Sans TC";
	letter-spacing: 0.4px;
	line-height: 28px;
	padding-left:15px;
	margin-bottom: 0px;
}

.issue-description {
	color: #4A4A4A;
   	padding:0px 15px;
    margin-bottom:30px;
   	font-size: 15px;
    line-height: 25px;
    font-family: "Noto Sans TC";
}

#home-feature-activity h2 {
	font: 700 18px/18px "Roboto Slab", "Noto Sans TC";
	letter-spacing: 1.8px;
	color: #1A1A1A;
	padding-bottom:20px;
	border-bottom:2px solid #1A1A1A;
	margin-bottom:25px;
	text-align: center;
}

#home-feature-activity .thumbnail {
	margin-bottom:16px;
}

#home-feature-activity .thumbnail a,
#home-feature-activity .thumbnail img {
	display: block;
}

#home-feature-activity .thumbnail a:hover img {
	opacity: .5;
}

#home-feature-activity .activity-wrap {
	padding:0px 15px;
}

#home-feature-activity .date {
	font: 400 16px/16px "Roboto Slab", "Noto Sans TC";
	letter-spacing: 0.4px;
	color: #FFC612;
	margin-bottom:16px;
}

#home-feature-activity .title {
	text-align: left;
	font: 700 18px/28px "Noto Sans TC";
	color: #1A1A1A;
	margin-bottom:14px;
}
#home-feature-activity .title a:hover {
	color:gray;
}
	
#home-feature-activity .excerpt {
	font: 400 15px/25px "Noto Sans TC";
	color: #4A4A4A;
	text-align: justify;
}

#home-issue-event {
	display: block;
	margin-bottom:50px;
	border-top: 2px solid #1A1A1A;
}

@media screen and (min-width: 1100px) {
	#home-issue-event {
		display: flex;
		gap:60px;
		border:0px;
	}

	#home-feature-issue h2 {
		line-height: 18px;
		text-align: left;
		border-bottom:2px solid #1A1A1A;
		padding-bottom:20px;
		margin-bottom:25px;
	}

	#home-feature-activity h2 {
		text-align: left;
	}
}
</style>

<div id="home-issue-event" class="row">
<?php 
	$number = 0;
	$term_query = new WP_Term_Query();
	$query = array( 
		'taxonomy' => 'issue', 
		'hide_empty' => false,
		'number' => $number,
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key' => 'issue_show_homepage',
				'value' => '1',
				'compare' => '='
			),
			array(
				'key' => 'issue_show_homepage_start_time',
				'value' => date( 'Ymd', $today ),
				'compare' => '<='
			),
			array(
				'key' => 'issue_show_homepage_end_time',
				'value' => date( 'Ymd', $today ),
				'compare' => '>='
			)
		)
	);
	$issues = $term_query->query( $query );
	if ( $issues ) : 
?>
	<div id="home-feature-issue" style="flex:3">
		<div class="hr row hide-on-desktop"></div>
		<h2>ISSUE 專題</h2>
	<?php foreach ( $issues as $issue ) : ?>
		<div class="issue-block">
			<div class="issue-meta-wrap">
				<div class="issue-cover">
					<a href="<?php echo get_term_link( $issue ); ?>"><img src="<?php the_field( 'issue_cover', $issue ); ?>" /></a>
				</div>
				<div class="issue-meta-inner">
					<div>
						<div class="date yellow" style="float:right;margin-right:15px;"><?php echo date('F', strtotime( get_term_meta( $issue->term_id, 'issue_show_homepage_start_time', true ) ) ); ?></div>
						<a class="issue-title" href="<?php echo get_term_link( $issue ); ?>"><?php echo $issue->name; ?></a>
					</div>
					<div class="issue-description"><?php echo $issue->description; ?></div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
	</div>
<?php endif; ?>

	<div style="flex:2">
	<?php 
		$event = false;
		$query = new WP_Query( array(
			'post_type' => 'fliper_event',
			'meta_query' => array(
				array(
					'key' => 'event_end_date',
					'value' => current_time('Ymd'),
					'compare' => '>=' 
				),
			),
			'orderby' => 'date',
			'order' => 'DESC',
			'posts_per_page' => 1,
			'no_found_rows' => true
		) );
		if ( $query->post_count > 0 ) {
			$query->the_post();
			$event['title'] = get_the_title();
			$event['thumbnail'] = get_the_post_thumbnail( null, 'full', array( 'class' => 'block' ) );
			$event['start_date'] = date( 'Y.n.j', strtotime( get_field( 'event_start_date', get_the_ID() ) ) );
			$event['end_date'] = date( 'Y.n.j', strtotime( get_field( 'event_end_date', get_the_ID() ) ) );
			$event['excerpt'] = get_the_excerpt();
			$event['ref_link'] = get_field( 'ref_link', get_the_ID() );
		}

		if ( $event ) : 增加起始日和結束日，比如：
	?>
		<div id="home-feature-activity" class="">
			<div class="item">
				<h2>EVENT 活動</h2>
				<div class="thumbnail"><a href="<?php echo $event['ref_link']; ?>" target="_blank"><?php echo $event['thumbnail']; ?></a></div>
	 			<div class="activity-wrap">
					<div class="date"><?php echo $event['start_date'] . ' —> ' . $event['end_date']; ?></div>
					<div class="title"><a href="<?php echo $event['ref_link']; ?>" target="_blank"><?php echo $event['title']; ?></a></div>
					<div class="excerpt"><?php echo $event['excerpt']; ?></div>
	 			</div>
	 		</div>
	 	</div>
 	<?php endif; ?>
	</div>
</div>


<?php get_footer(); ?>