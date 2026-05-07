<?php
/**
 * Template Name: Line RSS Template
 */
$postCount = 10; // The number of posts to show in the feed
$posts = new WP_Query(array('posts_per_page' => $postCount));
// $posts = query_posts('showposts=' . $postCount);
header('Content-Type: '.feed_content_type('rss-http').'; charset='.get_option('blog_charset'), true);
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';
?>
<articles>
    <UUID><?php echo guidv4(); ?></UUID>
    <time><?php echo time() * 1000; ?></time>
    <?php while($posts->have_posts() ) : $posts->the_post(); $categories = get_the_category(); $tags = get_the_tags();?>
    <article>
        <ID><?php the_ID(); ?></ID>
        <nativeCountry>TW</nativeCountry>
        <language>zh</language>
        <startYmdtUnix><?php echo get_post_time('U') * 1000; ?></startYmdtUnix>
        <endYmdtUnix>4133923200000</endYmdtUnix>
        <title><?php the_title(); ?></title>
        <?php if ( $categories ) : ?>
        <category><?php echo $categories[ 0 ]->slug; ?></category>
        <?php else : ?>
        <category>art-design</category>
        <?php endif; ?>
        <publishTimeUnix><?php echo get_post_time('U') * 1000; ?></publishTimeUnix>
        <updateTimeUnix><?php echo get_the_modified_date('U') * 1000; ?></updateTimeUnix>
        <contentType>0</contentType>
        <thumbnail><?php echo get_the_post_thumbnail_url(null, 'post-thumb'); ?></thumbnail>
        <contents>
            <?php $contents = get_the_content(); $contents = apply_filters( 'the_content', $contents ); ?>
            <text>
                <content>
                    <![CDATA[
                    <?php echo $contents; ?>
                    ]]>
                </content>
            </text>
        </contents>
        <?php if ( $categories ) : $related_posts = get_category_related_posts( get_the_ID(), $categories[ 0 ]->term_id );
            if ( $related_posts ) : ?>
        <recommendArticles>
            <?php while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>
            <article>
                <title><?php the_title(); ?></title>
                <url><?php the_permalink(); ?></url>
                <thumbnail><?php echo get_the_post_thumbnail_url(null, 'post-thumb'); ?></thumbnail>
            </article>
            <?php endwhile; $posts->reset_postdata(); ?>
        </recommendArticles>
        <?php endif; endif; ?>
        <author><?php echo get_the_author_meta( 'display_name' ); ?></author>
        <sourceUrl><?php the_permalink(); ?></sourceUrl>
        <?php if ( is_array( $tags ) ) {
            $xxx = false;
            foreach ( $tags as $tag ) {
                if ( $tag->name === 'xxx' ) {
                    $xxx = true;
                }
            }
            echo $xxx ? '<ageLimit>true</ageLimit>' : '<ageLimit>false</ageLimit>';

            echo '<tags>';
            foreach ( $tags as $tag ) {
                echo '<tag>' . $tag->name . '</tag>';
            }
            echo '</tags>';
        }
        ?>
    </article>
    <?php endwhile; ?>
</articles>
