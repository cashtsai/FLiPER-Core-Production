<?php 

/* Template Name: 22 Online Design Exhibition Dept */

//https://flipermagstag.wpengine.com/22-online-design-exhibition-dept/?org=28643&dept=28644

$org_id = $_GET['org'];
$dept_id = $_GET['dept'];
if ( ! $org_id || ! $dept_id ) {
    wp_safe_redirect('/');
    exit;
}

if ( ! is_numeric( $org_id ) || ! is_numeric( $org_id ) ) {
    wp_safe_redirect('/');
    exit;   
}

$org = get_term_by( 'id', $org_id, 'artwork_org');
$dept = get_term_by( 'id', $dept_id, 'artwork_org_dept');
$exhibition = get_field( '22_design_exhibition_page', $dept );
if ( ! $exhibition ) {
    wp_safe_redirect('/');
    exit;
}

$this_exhibition = array();
foreach ($exhibition as $e ) {
    if ( $org_id == $e['org'] ) {
        $this_exhibition = $e;
    }
}

if ( ! $this_exhibition ) {
    wp_safe_redirect('/');
    exit;
}

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
            'terms'    => array( $org_id ),
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
.full-artwork-wrap {
    background-color: #fff;
    padding:25px 0px 0px;
}
.full-artwork {
    border-radius: 20px;
    padding:28px 12.5px 0px;
    background: #FFFFFF;
}
.small-22 {
    text-align: right;
    font: 500 12px/12px Montserrat, "PingFang TC", "Noto Sans CJK TC";
    letter-spacing: 0px;
    color: #1A1A1A;
    text-transform: uppercase;
    display: block;
}
#prev-page {
    width: 50px;
    height: 50px;
    display: block;
    float: left;
    background-position: -0px -61px;
}
.artwork-meta {
    padding:42px 20px 42px;
}
.artwork-meta h1 {
    font: 700 25px/40px Montserrat, "PingFang TC", "Noto Sans CJK TC";
    letter-spacing: 1.25px;
    color: #1A1A1A;
}
.artwork-meta .org-dept {
    margin-top:30px;
    font: 400 15px/25px Montserrat, "PingFang TC", "Noto Sans CJK TC";
    letter-spacing: 0.75px;
    color: #1A1A1A;
}
.top-author {
    margin-top:10px;
    font: 700 15px/25px Montserrat, "PingFang TC", "Noto Sans CJK TC";
    letter-spacing: 0.75px;
    color: #1A1A1A;
}
.artwork-meta .right .artwork-tag-wrap {
    display: none;
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

.artowk-link-and-share-link-wrap {
    padding:42px 0px 0px;
}
.artwork-link-wrap {
    padding:16px 20px 0px;
}
.artwork-link-wrap h4 {
    display: inline-block;
    font: 700 18px/20px Montserrat, "PingFang TC", "Noto Sans CJK TC";
    letter-spacing: 0.9px;
    color: #1A1A1A;
    height: 20px;
    padding:0px 26px 0px 0px;
}
.artwork-link-wrap a {
    display: inline-block;
    text-decoration: underline;
    font: 400 18px/20px Montserrat, "PingFang TC", "Noto Sans CJK TC";
    letter-spacing: 0.9px;
    color: #1A1A1A;
    text-transform: uppercase;
    height: 20px;
    padding:0px 18px 0px 0px;
}
.artwork-link-wrap a:last-child {
    padding:0px;

}
.share-link-wrap {
    padding:40px 20px;
}
.share-link-wrap h4 {
    display: inline-block;
    font: 700 18px/20px Montserrat, "PingFang TC", "Noto Sans CJK TC";
    letter-spacing: 0.9px;
    color: #1A1A1A;
    height: 20px;
    padding:0px 26px 0px 0px;
    vertical-align: top;
}
.share-link-wrap a.fb {
    display: inline-block;
    width:20px;
    height: 20px;
    margin:0px 18px 0px 0px;
    background-position: 0px -145px;
}
.share-link-wrap a.link {
    display: inline-block;
    width:32px;
    height: 20px;
    background-position: -43px -145px;
}

.about-exhibition {
    font: 500 16px/30px Montserrat, "PingFang TC", "Noto Sans CJK TC";
    color: #1A1A1A;
    opacity: 1;
    padding:0px 20px 42px;
}


.artwork-author .org-dept {
    padding:10px 0px 20px;
    font: 700 18px/24px Montserrat, "PingFang TC", "Noto Sans CJK TC";
    letter-spacing: 0.9px;
    color: #1A1A1A;
}
.artwork-author-inner {
    padding:0px 5px;
}
.artwork-author-inner .artwork-author-info {
    padding:32px 35px;
    width: 80px;
    float:left;
}
.artwork-author-inner .artwork-author-info .avatar img{
    width: 80px;
    height: 80px;
    border-radius: 80px;
    display: block;
}
.artwork-author-inner .artwork-author-info .author-name {
    text-align: center;
    font: 700 16px/22px Montserrat, "PingFang TC", "Noto Sans CJK TC";
    letter-spacing: 0.8px;
    color: #1A1A1A;
    padding:16px 0px 0px 0px;
}
.artwork-author-inner .artwork-author-info .desktop.author-links {
    display: none;
}
.artwork-author-inner .artwork-author-info .author-links {
    padding:12px 5px 0px;
    display: flex;
    justify-content:center;
}
.artwork-author-inner .artwork-author-info .author-links.justify {
    justify-content:space-between;
}
.artwork-author-inner .artwork-author-info .author-links a {
    text-align: center;
    font: 500 18px/22px Montserrat, "PingFang TC", "Noto Sans CJK TC";
    letter-spacing: 0.9px;
    color: #747474;
}
.related-artwork {
    background: #fff;
    padding:16px 12.5px 32px;
}
.related-artwork h2 {
    text-align: left;
    font: 700 30px/36px Montserrat, "PingFang TC", "Noto Sans CJK TC";
    letter-spacing: 1.5px;
    color: #1A1A1A;
    padding:16px 0px;
}
.artwork-list .artwork-item {
    padding:24px 0px;
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
    padding:16px 88px 0px 0px;
    position: relative;
}
.artwork-list .artwork-item .artwork-item-meta .right {
    position: absolute;
    top:18px;
    right: 0px;
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

@media screen and (min-width: 1100px) {
.mobile {
    display: none !important;
}

.desktop {
    display: block !important;
}

.full-artwork-wrap {
    margin-top: 0px;
    padding-top: 72px;
}
.full-artwork {
    width: 1100px;
    padding: 0px;
    margin:0 auto;
    box-sizing: border-box;
}

#prev-page {
    width: 60px;
    height: 60px;
    display: block;
    float: left;
    background-position: -0px -0px;
}
#prev-page:hover {
    background-position-x: -61px;   
}
.small-22:hover {
    color: #8C8C8C;
}
.artwork-meta {
    position: relative;
    padding:42px 60px;
}
.artwork-meta .left {
    padding-right:270px;
}
.artwork-meta .right {
    position: absolute;
    text-align: right;
    width: 230px;
    top:42px;
    right:75px;
}
.artwork-meta h1 {
    font: 700 35px/50px Montserrat, "PingFang TC", "Noto Sans CJK TC";
    letter-spacing: 1.75px;
    padding-bottom: 24px;
}
.artwork-meta .org-dept {
    margin-top:0px;
    font: 400 18px/28px Montserrat, "PingFang TC", "Noto Sans CJK TC";
    letter-spacing: 0.9px;
    color: #1A1A1A;
    padding:0px;
}
.hero-image.desktop {
    
}
.top-author {
    margin-top:0px;
    font: 700 14px/24px Montserrat, "PingFang TC", "Noto Sans CJK TC";
    letter-spacing: 0.7px;
    padding:5px 0px;
}
.artwork-meta .right .artwork-tag-wrap {
    display: block;
    padding:0px;
}
.artwork-meta .right .artwork-tag-wrap .tag {
    text-align: center;
    font: 500 14px/20px Montserrat, "PingFang TC", "Noto Sans CJK TC";
    letter-spacing: 0.7px;
    color: #1A1A1A;
    float:right;
    margin:8px 0px 8px 20px;
}
.artwork-meta .right .artwork-tag-wrap .tag:last-child {
    margin-left:0px;
}
.artwork-tag-wrap .tag:hover {
    background: #DBDBDB;
}
.stat {
    margin-top:10px;
    height: 30px;
    padding-bottom:9px;
}

.artowk-link-and-share-link-wrap {
    padding:42px 175px 32px;
}
.artwork-link-wrap {
    padding:0px;
    float:left;
}
.artwork-link-wrap span.desktop {
    display: inline !important;
}
.artwork-link-wrap h4 {
    padding:0px 32px 0px 0px;
}
.artwork-link-wrap a:hover {
    color: #8C8C8C;
}
.share-link-wrap {
    padding:0px;
    float:right;
}
.share-link-wrap h4 {
    padding:0px 32px 0px 0px;
}
.share-link-wrap a.fb:hover {
    background-position: -21px -145px;
}
.share-link-wrap a.link:hover {
    background-position: -76px -145px;
}

.about-exhibition {
    padding:0px 175px;
}

.artwork-author .org-dept {
    padding:10px 22.5px 20px;
}
.artwork-author-inner {
    padding:0px;
}
.artwork-author-inner .artwork-author-info {
    padding:32px 152.5px 32px 22.5px;
    width: 265px;
    box-sizing: border-box;
    position: relative;
    float:left;
}
.artwork-author-inner .artwork-author-info .right {
    position: absolute;
    width:132.5px;
    right:0px;
    bottom:32px;
}
.artwork-author-inner .artwork-author-info .avatar img{
    width: 90px;
    height: 90px;
    border-radius: 90px;
}
.artwork-author-inner .artwork-author-info .author-name {
    text-align: left;
    font: 700 15px/20px Montserrat, "PingFang TC", "Noto Sans CJK TC";
    letter-spacing: 0.75px;
    color: #1A1A1A;
    padding:8px 0px 0px 0px;
}
.artwork-author-inner .artwork-author-info .author-links {
    display: none;
}
.artwork-author-inner .artwork-author-info .desktop.author-links {
    display: block;
}
.artwork-author-inner .artwork-author-info .author-links {
    padding:0px;
    text-align: left;
}
.artwork-author-inner .artwork-author-info .author-links a {
    text-align: left;
    font: 400 15px/18px Montserrat, "PingFang TC", "Noto Sans CJK TC";
    letter-spacing: 0.75px;
    color: #747474;
    padding-right:16px;
}
.related-artwork {
    background: #fff;
    margin-top:0px;
    padding:72px 0px 64px;
}
.related-artwork-inner {
    width:1100px;
    margin:0 auto;
}
.related-artwork h2 {
    padding:16px 12.5px;
}
ul.artwork-list {
    margin:0px -15px;
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



}
</style>

<?php if ( have_posts() ) : the_post(); ?>
<div class="full-artwork-wrap">
    <div class="full-artwork">
        <div class="full-artwork-inner">
            <div class="clearfix">
                <a href="#" id="prev-page" class="iconset-22"></a>
                <a href="/22-online-design-exhibition-university/" class="small-22">_____ 2 2 Design exhibition</a>
            </div>
            <div class="artwork-meta">
                <div class="left">
                    <h1><?php echo esc_html( $this_exhibition['name'] ); ?></h1>
                    <div class="org-dept"><?php echo $org->name; ?> / <?php echo $dept->name; ?></div>
                </div>
                <div class="right">
                    <div class="stat">
                        <div class="views"><span class="iconset-22"></span><?php echo $exhibition_views; ?></div>
                        <div class="share" data-url="<?php echo urlencode( get_the_permalink() . '?org=' . $org_id . '&dept=' . $dept_id ); ?>"><span class="iconset-22"></span><span class="share-count"><?php echo FLiPER_get_facebook_share_count( get_the_ID() ); ?></span></div>
                    </div>
                </div>
            </div>
            <div class="hero-image desktop"><img src="<?php echo wp_get_attachment_image_src( $this_exhibition['hero_image_desktop'], 'full' )[0]; ?>" /></div>
            <div class="hero-image mobile"><img src="<?php echo wp_get_attachment_image_src( $this_exhibition['hero_image_mobile'], 'full' )[0]; ?>" /></div>
            </div>
            
            <div class="artowk-link-and-share-link-wrap clearfix">
                <div class="artwork-link-wrap">
                    <h4><span class="desktop">Department </span>Link</h4>
                    <?php echo $this_exhibition['website'] == '' ? '' : '<a href="' . esc_attr( $this_exhibition['website'] ) . '" target="_blank">WEB</a>'; ?>
                    <?php echo $this_exhibition['facebook'] == '' ? '' : '<a href="' . esc_attr( $this_exhibition['facebook'] ) . '" target="_blank">FB</a>'; ?>
                    <?php echo $this_exhibition['instagram'] == '' ? '' : '<a href="' . esc_attr( $this_exhibition['instagram'] ) . '" target="_blank">IG</a>'; ?>
                </div>
                <div class="share-link-wrap">
                    <h4>Share</h4>
                    <a class="iconset-22 fb" href="#" data-url="<?php echo get_the_permalink() . '?org=' . $org_id . '&dept=' . $dept_id; ?>"></a>
                    <a class="iconset-22 link btn-copy" href="#" data-url="<?php echo get_the_permalink() . '?org=' . $org_id . '&dept=' . $dept_id; ?>"></a>
                </div>
            </div>
            <div class="about-exhibition"><?php echo nl2br( esc_html( $this_exhibition['about'] ) ); ?></div>
        </div>
        
    </div>

    <?php 
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
                    'terms'    => array( $org_id ),
                ),
                array(
                    'taxonomy' => 'artwork_org_dept',
                    'field'    => 'term_id',
                    'terms'    => array( $dept->term_id ),
                )
            )
        ) );
        if ( $query->have_posts() ) :
    ?>
    <div class="related-artwork">
        <div class="related-artwork-inner">
            <ul class="artwork-list clearfix">
                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                <li class="artwork-item">
                    <a href="<?php the_permalink(); ?>">
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
        </div>
    </div>
    <?php endif; wp_reset_query(); ?>
</div>
<?php endif; ?>

<script>
$ = jQuery;
$('document').ready(function(){
    $('body').on('click', '#prev-page', function(event) {
        event.preventDefault();
        if ( window.history.length <= 2 ) {
            window.location = /22-online-design-exhibition-university/;
        } else {
            window.history.back();    
        }
    });


    $('.btn-copy').click(function(event){
        event.preventDefault();
        $('body').append('<input id="current-url" type="hidden" value="' + $(this).attr('data-url') + '" />');
        copy_url();
        $('#current-url').remove();
    }); 

    $('.stat .share').each(function(index, ele) {
        if ( 0 === index ) {
            var url = $(this).attr('data-url');
            var total = $(this).find('.share-count').text();
            $.getJSON( 'https://graph.facebook.com/?id=' + url + '&fields=og_object{engagement}', {}, function(response){
                if(response.hasOwnProperty('og_object')) {
                    if ( response.engagement.count > total ) {
                        total = response.engagement.count;
                        $.getJSON( '/wp-json/api/v2/update-social-share-count?url=' + url, {}, function(response){} );
                    }
                }
            }); 
        }
    }); 

    $('.share-link-wrap .fb').click(function(event){
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
})


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