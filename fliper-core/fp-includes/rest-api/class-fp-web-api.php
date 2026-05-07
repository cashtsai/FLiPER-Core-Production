<?php
/**
 * FLiPER Website API (using wp-rest-api plugin)
 * 
 * Version: 1.0.0
 * Author: Rasiel-FLiPER
 * Author URI: https://github.com/rasielchang
 */

/**
 * FLiPER Website API Route (using wp-rest-api plugin)
 *
 * @author      Rasiel-FLiPER
 * @package     FLiPER
 * @version     1.0.0
 */
class FLiPER_Web_Route extends WP_REST_Controller {

    /**
     * Register the routes for the objects of the controller.
     *
     */
    public function register_routes() {

        $version = '1';
        $namespace = 'web/v' . $version;
        register_rest_route( $namespace, '/mobile-related-posts/(?P<id>[\d]+)', array(
            'methods'         => WP_REST_Server::READABLE,
            'callback'        => array( $this, 'get_mobile_related_posts' ),
            'permission_callback' => array( $this, 'get_items_permissions_check' ),
            'args'            => array()
        ) );
/*
        register_rest_route( $namespace, '/filter-artworks', array(
            'methods'         => WP_REST_Server::READABLE,
            'callback'        => array( $this, 'get_filtered_artworks' ),
            'permission_callback' => array( $this, 'get_items_permissions_check' ),
            'args'            => array()
        ) );

        register_rest_route( $namespace, '/artworks/(?P<id>[\d]+)', array(
            'methods'         => WP_REST_Server::READABLE,
            'callback'        => array( $this, 'get_artwork' ),
            'permission_callback' => array( $this, 'get_items_permissions_check' ),
            'args'            => array()
        ) );
*/
    }

    /**
     * Get related posts, display on mobile.
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function get_mobile_related_posts( $request ) {

        $default[ 'page' ] = 1;
        $default[ 'count' ] = 10;

        //get parameters from request
        $params = $request->get_params();
        $count = $default[ 'count' ];
        $page = is_numeric( $params[ 'page' ] ) ? $params[ 'page' ] : $default[ 'page' ];
        if ( 0 > $page ) $page = $default[ 'page' ];

        $post = get_post( $params[ 'id' ] );

        $related_posts = array();

        //return a response or error based on some conditional
        if ( '' != $post ) {

            $tags = wp_get_post_tags( $post->ID );

            if ( $tags ) {

                $tag_ids = array();
                foreach( $tags as $individual_tag ) $tag_ids[] = $individual_tag->term_id;
                $args = array(
                    'tag__in' => $tag_ids,
                    'post__not_in' => array( $post->ID ),
                    'posts_per_page' => $count, // Number of related posts that will be shown.
                    'ignore_sticky_posts' => 1,
                    'paged' => $page
                );

                $query = new WP_Query( $args );
                while( $query->have_posts() ) {

                    $query->the_post();
                    $related_posts[] = $query->post;

                }

                wp_reset_query();

            }

        }

        if ( $count > count( $related_posts ) ) {

            $diff = $count - count( $related_posts );
            $related_post_ids[] = $post->ID;
            foreach ( $related_posts as $related_post ) {
                $related_post_ids[] = $related_post->ID;
            }

            $diff_query = new WP_Query( array(
                'post__not_in' => $related_post_ids,
                'posts_per_page' => $diff,
                'ignore_sticky_posts' => 1,
                'paged' => $page
            ) );
            while ( $diff_query->have_posts() ) {

                $diff_query->the_post();
                $related_posts[] = $diff_query->post;

            }

            wp_reset_query();

        }

        $articles = array();
        foreach ( $related_posts as $post ) {

            $ret = array();
            $ret[ 'id' ] = $post->ID;
            $ret[ 'title' ] = get_the_title( $post->ID );
            $ret[ 'url' ] = get_the_permalink( $post->ID );
            $ret[ 'cover_src' ] = '';
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-thumb' );
            if ( $image ) 
                $ret[ 'cover_src' ] = $image[ 0 ];
            $ret[ 'date' ] = get_post_time( 'Y/m/d', false, $post->ID );
            $author_id = $post->post_author;
            $author = array(
                'id' => $author_id,
                'display_name' => get_the_author_meta( 'display_name', $author_id ),
                'avatar' => get_wp_user_avatar_src( $author_id, array( 300, 300 ) ),
                'url' => site_url( '/author/' . get_the_author_meta( 'user_login', $author_id ) ),
                'is_paid' => '0'
            );
            $ret[ 'author' ] = $author;

            // Extract content from post
            $ret[ 'content' ] = wpautop( $post->post_content );

            // Translate shortcode into html
            $ret[ 'content' ] = do_shortcode( $ret[ 'content' ] );

            $license_area = '<div class="license-area">';
            if ( get_post_meta( $post->ID, 'fp_article_license', true ) ) {

                $license_area .= '<br /><br /><p>' . get_post_meta( $post->ID, 'fp_article_license', true ) . '<br />';

                if ( get_post_meta( $post->ID, 'fp_author_reference', true ) ) {

                    if ( get_post_meta( $post->ID, 'fp_author_reference_url', true ) ) {

                        $license_area .= '文 / <a href="' . get_post_meta( $post->ID, 'fp_author_reference_url', true ) . '">' . get_post_meta( $post->ID, 'fp_author_reference', true ) . '</a>';

                    } else {

                        $license_area .= '文 / ' . get_post_meta( $post->ID, 'fp_author_reference', true );

                    }

                }

                if ( get_post_meta( $post->ID, 'fp_photo_reference', true ) ) {

                    if ( get_post_meta( $post->ID, 'fp_photo_reference_url', true ) ) {

                        $license_area .= ' │ 圖 / <a href="' . get_post_meta( $post->ID, 'fp_photo_reference_url', true ) . '">' . get_post_meta( $post->ID, 'fp_photo_reference', true ) . '</a>';

                    } else {

                        $license_area .= ' │ 圖 / ' . get_post_meta( $post->ID, 'fp_photo_reference', true );

                    }

                }

                $license_area .= '</p>';

            }
            $license_area .= '</div>';
            $ret[ 'content' ] .= $license_area;

            $articles[] = $ret;

        }

        $ret = array(
            'page' => $page,
            'count' => $count,
            'articles' => $articles
        );
        
        return new WP_REST_Response( $ret, 200 );
    }

    /**
     * Get Filtered Artwork
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function get_filtered_artworks( $request ) {
        $default['offset'] = 0;
        $default['count'] = 30;
        $default['sort'] = 'hot';
        $default['category'] = 'all';
        $default['org'] = 'all';
        $default['dept'] = 'all';
        $default['s'] = '';

        //get parameters from request
        $params = $request->get_params();
        $count = $default[ 'count' ];
        $offset = is_numeric( $params[ 'offset' ] ) ? $params[ 'offset' ] : $default[ 'offset' ];
        if ( 0 > $offset ) $offset = $default[ 'offset' ];

        $sort = $default['sort'];
        if ( 'hot' === $params['sort'] || 'date' === $params['sort'] ) {
            $sort = $params['sort'];
        }

        $category = $params['category'] ? $params['category'] : $default['category'];
        $org = $params['org'] ? $params['org'] : $default['org'];
        $dept = $params['dept'] ? $params['dept'] : $default['dept'];
        $s = $params[ 'search' ] ? $params[ 'search' ] : $default[ 's' ];

        $category_id = '0';
        $org_id = '0';
        $dept_id = '0';

        $query = array(
            'post_type' => 'fliper_artwork', 
            'posts_per_page' => $count, 
            'offset' => $offset, 
            'orderby' => 'ID',
            'order' => 'ASC',
            's' => $s,
            'tax_query' => array()
        );
        if ( 'all' != $category ) {
            $tax = $query['tax_query'];
            array_push( $tax, array( 
                'taxonomy' => 'artwork_category', 
                'field' => 'slug', 
                'terms' => array( $category )
            ) );
            $query['tax_query'] = $tax;
            $category_id = get_term_by( 'slug', $category, 'artwork_category' )->term_id;
        }
        if ( 'all' != $org ) {
            $tax = $query['tax_query'];
            array_push( $tax, array( 
                'taxonomy' => 'artwork_org', 
                'field' => 'slug', 
                'terms' => array( $org )
            ) );
            $query['tax_query'] = $tax;
            $org_id = get_term_by( 'slug', $org, 'artwork_org' )->term_id;
        }
        if ( 'all' != $dept ) {
            $tax = $query['tax_query'];
            array_push( $tax, array( 
                'taxonomy' => 'artwork_org_dept', 
                'field' => 'slug', 
                'terms' => array( $dept )
            ) );
            $query['tax_query'] = $tax;
            $dept_id = get_term_by( 'slug', $dept, 'artwork_org_dept' )->term_id;
        }

        if ( 'hot' === $sort ) {
            // Sort 取得熱門
            $a_sort = [
                'range' => 'all', 
                'order_by' => 'views', 
                'post_type' => 'fliper_artwork',
                'offset' => $offset,
                'limit' => $count
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

            if ( $s ) {
                add_filter( 'wpp_query_where', function( $v ) use ( $s ) {
                    global $wpdb;
                    $where = $wpdb->prepare('p.post_title LIKE "%%%s%%"', $s);
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
        
        $data = array();
        while( $query->have_posts() ) {
            $query->the_post();
            
            global $post;
            $itemdata = array();
            $itemdata['id'] = $post->ID;
            $itemdata['title'] = get_the_title( $post->ID );
            $itemdata['url'] = get_the_permalink( $post->ID );
            $thumbnail_id = get_post_thumbnail_id( $post->ID );
            $itemdata['thumbnail_src'] = wp_get_attachment_image_src( $thumbnail_id, 'home-top-big-2x' )[0];
            $itemdata['views'] = wpp_get_views( get_the_ID() );
            $artwork_authors = get_field( 'artwork_author', get_the_ID() );
            $i = 0; 
            $author = '';
            foreach ( $artwork_authors as $a ) { 
                if ( 0 === $i ) { 
                    $author .= $a['name'];
                    $i = 1; 
                } else { 
                    $author .= '、' . $a['name']; 
                } 
            } 
            $itemdata[ 'author' ] = $author;
    
            $data[] = $itemdata;            
        }

        $ret = array(
            'offset' => $offset + $query->post_count,
            'count' => $query->post_count,
            'list' => $data
        );

        wp_reset_postdata();
        
        return new WP_REST_Response( $ret, 200 );
    }

    /**
     * Get Artwork
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function get_artwork( $request ) {
        //get parameters from request
        $params = $request->get_params();
        $artwork = get_post( $params['id'] );
        
        if ( '' == $artwork ) {
            return new WP_Error( ERROR_ARTICLE_NOT_FOUND, __( '找不到作品', 'fliper' ) );
        } else if ( 'fliper_artwork' != get_post_type( $artwork ) ) {
            return new WP_Error( ERROR_ARTICLE_NOT_FOUND, __( '找不到作品', 'fliper' ) );
        }

        global $post;
        $post = $artwork;
        setup_postdata( $post ); 

        $ret = array();
        
        $org = get_term_by( 'id', get_field( 'artwork_org', $post->ID ), 'artwork_org');
        $dept = get_term_by( 'id', get_field( 'artwork_org_dept', $post->ID ), 'artwork_org_dept');
        $website = get_field( 'website', $post->ID );
        $artwork_fb = get_field( 'artwork_fb', $post->ID );
        $artwork_ig = get_field( 'artwork_ig', $post->ID );
        $website_html = $website == '' ? '' : '<a href="' . esc_attr( $website ) . '" target="_blank">WEB</a>';
        $artwork_fb_html = $artwork_fb == '' ? '' : '<a href="' . esc_attr( $artwork_fb ) . '" target="_blank">FB</a>';
        $artwork_ig_html = $artwork_ig == '' ? '' : '<a href="' . esc_attr( $artwork_ig ) . '" target="_blank">IG</a>';

        $author_name = '';
        $authors = get_field( 'artwork_author', $post->ID );
        $i = 0; 
        foreach ( $authors as $a ) { 
            if ( 0 === $i ) { 
                $author_name = esc_html( $a['name'] );
                $i = 1; 
            } else { 
                $author_name .= '、' . esc_html( $a['name'] ); 
            } 
        }
        $authors_html = '';
        foreach ( $authors as $a ) {
            $class = $a['fb'] && $a['ig'] ? 'justify' : '';
            $fb = '' != $a['fb'] ? '<a class="fb" href="' . esc_attr( $a['fb'] ) . '" target="_blank">FB</a>' : '';
            $ig = '' != $a['ig'] ? '<a class="ig" href="' . esc_attr( $a['ig'] ) . '" target="_blank">IG</a>' : '';
            $authors_html .= '<div class="artwork-author-info">
                            <div class="left">
                                <div class="avatar"><img src="' . wp_get_attachment_image_src( $a['avatar']['id'], 'user-avatar' )[0] . '" /></div>
                            </div>
                            <div class="right">
                                <div class="desktop author-links ' . $class . '">' . $fb . $ig . '</div>
                                <div class="author-name">' . $a['name'] . '</div>
                                <div class="author-links ' . $class . '">' . $fb . $ig . '</div>
                            </div>
                        </div>';
        }

        $tag_html = '';
        $artwork_tags = get_field( 'artwork_category', $post->ID );
        foreach ( $artwork_tags as $tag_id ) {
            $tag = get_term_by( 'id', $tag_id, 'artwork_category' );
            $tag_html .= '<a class="tag" href="/22-online-design-exhibition-home/?cat=' . $tag->slug . '&org=all&dept=all&sort=hot&search=">' . $tag->name . '</a>';
        }

        $content_html = '';
        $contents = get_field( 'artwork_content', $post->ID );
        foreach ( $contents as $c ) {
            switch ( $c['acf_fc_layout'] ) {
                case 'block_text':
                    $content_html .= '<div class="text">' . nl2br( esc_html( $c['text'] ) ) . '</div>';
                    break;
                case 'block_image':
                    $content_html .= '<img class="image" src="' . $c['image']['url'] . '" />';
                    break;
                case 'block_video':
                    $embed = new WP_Embed();
                    $content_html .= '<div class="youtube">' . $embed->shortcode( array(), $c['youtube'] ) . '</div>';
                    break;
                case 'block_title':
                    $content_html .= '<h2 class="title">' . esc_html( $c['title'] ) . '</h2>';
                    break;
                case 'block_link':
                    $content_html .= '<div class="text"><a class="link" target="_blank" href="' . esc_attr( $c['link_url'] ) . '">' . esc_html( $c['link_text'] ) . '</a></div>'; 
                    break;
            }
        }
                        
        $ret['html'] = '<link href="/wp-content/themes/flipermag/assets/css/single-fliper_artwork.css"><div class="full-artwork">
        <div class="full-artwork-inner">
            <div class="clearfix">
                <a href="#" id="prev-page" class="iconset-22"></a>
                <a href="/22-online-design-exhibition-home/" class="small-22">_____ 2 2 Design exhibition</a>
            </div>
            <div class="artwork-meta">
                <div class="left">
                    <h1>' . get_the_title( $post->ID ) . '</h1>
                    <div class="org-dept">' . $org->name . ' / ' . $dept->name .'</div>
                    <div class="top-author">' . $author_name . '</div>
                </div>
                <div class="right">
                    <div class="stat">
                        <div class="views"><span class="iconset-22"></span>' . wpp_get_views( get_the_ID() ) . '</div>
                        <div class="share" data-url="' . get_the_permalink( $post->ID ) . '"><span class="iconset-22"></span><span class="share-count">' . FLiPER_get_facebook_share_count( get_the_ID() ) . '</span></div>
                    </div>
                    <div class="artwork-tag-wrap clearfix">' . $tag_html . '</div>
                </div>
            </div>
            <div class="artwork-content">
                <div class="text">' . nl2br( esc_html( get_field( 'artwork_intro', $post->ID ) ) ) . '</div>' . $content_html . '
            </div>
            <div class="artowk-link-and-share-link-wrap clearfix">
                <div class="artwork-link-wrap">
                    <h4>Artwork Link</h4>' . $website_html . $artwork_fb_html . $artwork_ig_html . '
                </div>
                <div class="share-link-wrap">
                    <h4>Share</h4>
                    <a class="iconset-22 fb" href="#" data-url="' . get_the_permalink( $post->ID ) . '"></a>
                    <a class="iconset-22 link btn-copy" href="#" data-url="' . get_the_permalink( $post->ID ) . '"></a>
                </div>
            </div>
            <div class="artwork-tag-wrap clearfix mobile">' . $tag_html . '</div>
        </div>
        <div class="artwork-author-wrap">
            <div class="artwork-author">
                <h2>Designer</h2>
                <div class="org-dept">' . $org->name . ' / ' . $dept->name .'</div>
                <div class="artwork-author-inner clearfix">' . $authors_html . '</div>
            </div>
        </div>
    </div>';
        
        return new WP_REST_Response( $ret, 200 );
    }

    /**
     * Check if a given request has access to get items
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|bool
     */
    public function get_items_permissions_check( $request ) {
        return true;
        // return current_user_can( 'read' );
    }

    /**
     * Check if a given request has access to get a specific item
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|bool
     */
    public function get_item_permissions_check( $request ) {
        return $this->get_items_permissions_check( $request );
    }

}
