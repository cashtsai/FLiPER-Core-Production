<?php
/**
 * FLiPER Mobile App API  —  namespace: app/v1
 *
 * A slim, cacheable, mobile-first contract for the native iOS/Android app.
 * Replaces the app's direct /wp/v2 usage: list endpoints return light cards
 * (no full content), the article endpoint returns STRUCTURED content blocks
 * (so the client drops its HTML parser), and every image is returned as a
 * sized object {url, thumb, width, height}.
 *
 * Phase 1 (this file): read-only content. config / feed / articles(+blocks) /
 * related / authors / search / tags / trending, plus category.subLabel from
 * the ACF `main_category` field.
 *
 * Phase 2 (artworks / today / events) and Phase 3 (member auth, favorites,
 * follows, notifications, comments, push) are specified in
 * docs/APP_V1_API_SPEC.md and intentionally NOT implemented here yet.
 *
 * @package FLiPER
 * @version 1.0.0-draft
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class FLiPER_App_API extends WP_REST_Controller {

    const NS = 'app/v1';
    const PER_PAGE = 20;
    const MAX_PER_PAGE = 50;

    public function register_routes() {
        $public = array( $this, 'public_permission' );

        register_rest_route( self::NS, '/config', array(
            array( 'methods' => WP_REST_Server::READABLE, 'callback' => array( $this, 'get_config' ), 'permission_callback' => $public ),
        ) );

        register_rest_route( self::NS, '/feed', array(
            array( 'methods' => WP_REST_Server::READABLE, 'callback' => array( $this, 'get_feed' ), 'permission_callback' => $public ),
        ) );

        register_rest_route( self::NS, '/trending', array(
            array( 'methods' => WP_REST_Server::READABLE, 'callback' => array( $this, 'get_trending' ), 'permission_callback' => $public ),
        ) );

        register_rest_route( self::NS, '/articles/(?P<id>[\d]+)', array(
            array( 'methods' => WP_REST_Server::READABLE, 'callback' => array( $this, 'get_article' ), 'permission_callback' => $public ),
        ) );

        register_rest_route( self::NS, '/articles/(?P<id>[\d]+)/related', array(
            array( 'methods' => WP_REST_Server::READABLE, 'callback' => array( $this, 'get_related' ), 'permission_callback' => $public ),
        ) );

        register_rest_route( self::NS, '/authors/(?P<id>[\d]+)', array(
            array( 'methods' => WP_REST_Server::READABLE, 'callback' => array( $this, 'get_author' ), 'permission_callback' => $public ),
        ) );

        register_rest_route( self::NS, '/authors/(?P<id>[\d]+)/articles', array(
            array( 'methods' => WP_REST_Server::READABLE, 'callback' => array( $this, 'get_author_articles' ), 'permission_callback' => $public ),
        ) );

        register_rest_route( self::NS, '/search', array(
            array( 'methods' => WP_REST_Server::READABLE, 'callback' => array( $this, 'get_search' ), 'permission_callback' => $public ),
        ) );

        register_rest_route( self::NS, '/tags', array(
            array( 'methods' => WP_REST_Server::READABLE, 'callback' => array( $this, 'get_tags' ), 'permission_callback' => $public ),
        ) );

        register_rest_route( self::NS, '/tags/(?P<id>[\d]+)/articles', array(
            array( 'methods' => WP_REST_Server::READABLE, 'callback' => array( $this, 'get_tag_articles' ), 'permission_callback' => $public ),
        ) );
    }

    public function public_permission() { return true; }

    // ---------------------------------------------------------------------
    // Endpoints
    // ---------------------------------------------------------------------

    public function get_config( $request ) {
        $cats = array();
        foreach ( get_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'number' => 20, 'hide_empty' => true ) ) as $c ) {
            $cats[] = array(
                'id'       => (string) $c->term_id,
                'name'     => $c->name,
                'subLabel' => trim( (string) $c->description ),
                'slug'     => $c->slug,
            );
        }
        return $this->ok( array(
            'minimumSupportedVersion' => '0.1.0',
            'apiVersion'              => 'app/v1',
            'categories'              => $cats,
            'notices'                 => array(),
        ) );
    }

    public function get_feed( $request ) {
        $args = array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => $this->per_page( $request ),
            'paged'          => $this->page( $request ),
            'ignore_sticky_posts' => 1,
        );
        $cat = $request->get_param( 'category' );
        if ( $cat !== null && $cat !== '' ) $args['cat'] = intval( $cat );
        return $this->list_response( new WP_Query( $args ), $request );
    }

    public function get_trending( $request ) {
        $ids = $this->trending_ids( 8 );
        if ( empty( $ids ) ) {
            // Fallback: most recent.
            return $this->get_feed( $request );
        }
        $query = new WP_Query( array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'post__in'       => $ids,
            'orderby'        => 'post__in',
            'posts_per_page' => count( $ids ),
        ) );
        $items = array();
        while ( $query->have_posts() ) { $query->the_post(); $items[] = $this->article_card( get_post() ); }
        wp_reset_postdata();
        return $this->ok( array( 'items' => $items, 'nextCursor' => null ) );
    }

    public function get_article( $request ) {
        $post = get_post( intval( $request['id'] ) );
        if ( ! $post || $post->post_status !== 'publish' || $post->post_type !== 'post' ) {
            return $this->error( 404, 'article_not_found', '找不到文章' );
        }
        return $this->ok( $this->article_full( $post ) );
    }

    public function get_related( $request ) {
        $post = get_post( intval( $request['id'] ) );
        if ( ! $post ) return $this->error( 404, 'article_not_found', '找不到文章' );
        $tag_ids = wp_get_post_tags( $post->ID, array( 'fields' => 'ids' ) );
        $items = array();
        if ( ! empty( $tag_ids ) ) {
            $query = new WP_Query( array(
                'tag__in'        => $tag_ids,
                'post__not_in'   => array( $post->ID ),
                'posts_per_page' => 6,
                'ignore_sticky_posts' => 1,
            ) );
            while ( $query->have_posts() ) { $query->the_post(); $items[] = $this->article_card( get_post() ); }
            wp_reset_postdata();
        }
        return $this->ok( array( 'items' => $items, 'nextCursor' => null ) );
    }

    public function get_author( $request ) {
        $id = intval( $request['id'] );
        $user = get_userdata( $id );
        if ( ! $user ) return $this->error( 404, 'author_not_found', '找不到作者' );
        return $this->ok( $this->author_obj( $id, true ) );
    }

    public function get_author_articles( $request ) {
        $args = array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'author'         => intval( $request['id'] ),
            'posts_per_page' => $this->per_page( $request ),
            'paged'          => $this->page( $request ),
        );
        return $this->list_response( new WP_Query( $args ), $request );
    }

    public function get_search( $request ) {
        $q = trim( (string) $request->get_param( 'q' ) );
        if ( $q === '' ) return $this->ok( array( 'items' => array(), 'nextCursor' => null ) );
        $args = array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            's'              => $q,
            'posts_per_page' => $this->per_page( $request ),
            'paged'          => $this->page( $request ),
        );
        return $this->list_response( new WP_Query( $args ), $request );
    }

    public function get_tags( $request ) {
        $tags = get_terms( array( 'taxonomy' => 'post_tag', 'orderby' => 'count', 'order' => 'DESC', 'number' => 16, 'hide_empty' => true ) );
        $out = array();
        if ( ! is_wp_error( $tags ) ) foreach ( $tags as $t ) $out[] = $this->tag_obj( $t );
        return $this->ok( array( 'items' => $out, 'nextCursor' => null ) );
    }

    public function get_tag_articles( $request ) {
        $args = array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'tag_id'         => intval( $request['id'] ),
            'posts_per_page' => $this->per_page( $request ),
            'paged'          => $this->page( $request ),
        );
        return $this->list_response( new WP_Query( $args ), $request );
    }

    // ---------------------------------------------------------------------
    // Object builders
    // ---------------------------------------------------------------------

    private function article_card( $post ) {
        return array(
            'id'       => (string) $post->ID,
            'title'    => html_entity_decode( get_the_title( $post->ID ), ENT_QUOTES, 'UTF-8' ),
            'excerpt'  => $this->plain( get_the_excerpt( $post ) ),
            // 編輯閱讀後推薦給讀者的理由（非摘要）。編輯在 WP 後台自訂欄位
            // fp_editor_note 填寫；沒填就是 null,app 會退回 excerpt。
            'editorNote' => $this->plain( (string) get_post_meta( $post->ID, 'fp_editor_note', true ) ) ?: null,
            'category' => $this->primary_category( $post ),
            'author'   => $this->author_obj( $post->post_author, false ),
            'image'    => $this->image_obj( get_post_thumbnail_id( $post->ID ) ),
            'date'     => get_post_time( 'c', true, $post->ID ),
            'dateText' => get_post_time( 'Y.m.d', false, $post->ID ),
            'readTime' => $this->read_time( $post->post_content ),
            'url'      => get_the_permalink( $post->ID ),
        );
    }

    private function article_full( $post ) {
        $card = $this->article_card( $post );
        $tags = array();
        foreach ( wp_get_post_tags( $post->ID ) as $t ) $tags[] = $this->tag_obj( $t );
        $card['tags']   = $tags;
        $card['author'] = $this->author_obj( $post->post_author, true );
        $card['blocks'] = $this->blocks_from_html( apply_filters( 'the_content', $post->post_content ) );
        return $card;
    }

    private function primary_category( $post ) {
        $cats = get_the_category( $post->ID );
        $cat  = ! empty( $cats ) ? $cats[0] : null;
        // Sub-label is the category's description (Idea → 觀點, Creator → 人物),
        // matching flipermag.com's "Idea｜觀點" header. ACF `main_category` is a
        // fallback for any category without a description.
        $sub = $cat ? trim( (string) $cat->description ) : '';
        if ( $sub === '' && function_exists( 'get_field' ) ) {
            $main = get_field( 'main_category', $post->ID );
            if ( is_string( $main ) ) $sub = $main;
            elseif ( is_array( $main ) && isset( $main['name'] ) ) $sub = $main['name'];
        }
        return array(
            'id'       => $cat ? (string) $cat->term_id : '0',
            'name'     => $cat ? $cat->name : 'FLiPER',
            'subLabel' => $sub,
            'slug'     => $cat ? $cat->slug : '',
        );
    }

    private function author_obj( $id, $full ) {
        $id = intval( $id );
        $obj = array(
            'id'     => (string) $id,
            'name'   => html_entity_decode( get_the_author_meta( 'display_name', $id ), ENT_QUOTES, 'UTF-8' ),
            'handle' => get_the_author_meta( 'user_login', $id ),
            'avatar' => $this->avatar_url( $id ),
        );
        if ( $full ) {
            $obj['bio']          = $this->plain( get_the_author_meta( 'description', $id ) );
            $obj['articleCount'] = (int) count_user_posts( $id, 'post', true );
            $obj['links']        = array(
                'website'   => esc_url_raw( get_the_author_meta( 'user_url', $id ) ) ?: null,
                'instagram' => get_the_author_meta( 'instagram', $id ) ?: null,
                'facebook'  => get_the_author_meta( 'facebook', $id ) ?: null,
            );
        }
        return $obj;
    }

    private function tag_obj( $term ) {
        return array(
            'id'    => (string) $term->term_id,
            'name'  => html_entity_decode( $term->name, ENT_QUOTES, 'UTF-8' ),
            'slug'  => $term->slug,
            'count' => (int) $term->count,
        );
    }

    private function image_obj( $attachment_id ) {
        if ( ! $attachment_id ) return null;
        $large = wp_get_attachment_image_src( $attachment_id, 'large' );
        $thumb = wp_get_attachment_image_src( $attachment_id, 'medium' );
        if ( ! $large ) $large = wp_get_attachment_image_src( $attachment_id, 'full' );
        if ( ! $large ) return null;
        return array(
            'url'    => $large[0],
            'thumb'  => $thumb ? $thumb[0] : $large[0],
            'width'  => (int) $large[1],
            'height' => (int) $large[2],
        );
    }

    private function avatar_url( $id ) {
        if ( function_exists( 'get_wp_user_avatar_src' ) ) {
            $src = get_wp_user_avatar_src( $id, array( 192, 192 ) );
            if ( $src ) return $src;
        }
        return get_avatar_url( $id, array( 'size' => 192 ) );
    }

    private function read_time( $content ) {
        $chars = mb_strlen( $this->plain( $content ) );
        $minutes = max( 1, (int) round( $chars / 360 ) );
        return $minutes . ' min';
    }

    // ---------------------------------------------------------------------
    // HTML → structured blocks (DOMDocument)
    // ---------------------------------------------------------------------

    private function blocks_from_html( $html ) {
        $html = trim( $html );
        if ( $html === '' ) return array();

        libxml_use_internal_errors( true );
        $doc = new DOMDocument();
        $doc->loadHTML( '<?xml encoding="UTF-8"><div id="fp-root">' . $html . '</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
        libxml_clear_errors();

        $root = $doc->getElementById( 'fp-root' );
        if ( ! $root ) return array();

        $blocks = array();
        foreach ( $root->childNodes as $node ) {
            foreach ( $this->node_to_blocks( $node ) as $b ) $blocks[] = $b;
        }
        return $blocks;
    }

    private function node_to_blocks( $node ) {
        // Text node.
        if ( $node->nodeType === XML_TEXT_NODE ) {
            $t = $this->plain( $node->textContent );
            return $t === '' ? array() : array( array( 'type' => 'paragraph', 'text' => $t ) );
        }
        if ( $node->nodeType !== XML_ELEMENT_NODE ) return array();

        $tag = strtolower( $node->nodeName );

        switch ( $tag ) {
            case 'p':
                return $this->text_block( 'paragraph', $node );

            case 'h1': case 'h2': case 'h3': case 'h4': case 'h5': case 'h6':
                return $this->text_block( 'heading', $node );

            case 'figure':
                $img = $this->first_descendant( $node, 'img' );
                if ( $img ) {
                    $src = $img->getAttribute( 'src' );
                    $cap_node = $this->first_descendant( $node, 'figcaption' );
                    $block = array(
                        'type'    => 'image',
                        'image'   => array( 'url' => $src, 'thumb' => $src, 'width' => 0, 'height' => 0 ),
                        'caption' => $cap_node ? $this->plain( $cap_node->textContent ) : '',
                    );
                    return array( $block );
                }
                $embed = $this->embed_from_node( $node );
                if ( $embed ) return array( $embed );
                $t = $this->plain( $node->textContent );
                return $t === '' ? array() : array( array( 'type' => 'quote', 'text' => $t ) );

            case 'iframe':
                $embed = $this->embed_from_node( $node );
                return $embed ? array( $embed ) : array();

            case 'ul': case 'ol':
                $items = array();
                foreach ( $node->getElementsByTagName( 'li' ) as $li ) {
                    $t = $this->plain( $li->textContent );
                    if ( $t !== '' ) $items[] = $t;
                }
                return empty( $items ) ? array() : array( array( 'type' => 'list', 'ordered' => ( $tag === 'ol' ), 'items' => $items ) );

            case 'blockquote':
                return $this->text_block( 'quote', $node );

            case 'table':
                $rows = array();
                foreach ( $node->getElementsByTagName( 'tr' ) as $tr ) {
                    $cells = array();
                    foreach ( $tr->childNodes as $cell ) {
                        if ( $cell->nodeType === XML_ELEMENT_NODE && in_array( strtolower( $cell->nodeName ), array( 'td', 'th' ), true ) ) {
                            $cells[] = $this->plain( $cell->textContent );
                        }
                    }
                    if ( ! empty( $cells ) ) $rows[] = $cells;
                }
                return empty( $rows ) ? array() : array( array( 'type' => 'table', 'rows' => $rows ) );

            case 'hr':
                return array( array( 'type' => 'divider' ) );

            case 'div': case 'section':
                // Unwrap container — recurse into children.
                $out = array();
                foreach ( $node->childNodes as $child ) {
                    foreach ( $this->node_to_blocks( $child ) as $b ) $out[] = $b;
                }
                return $out;

            default:
                $t = $this->plain( $node->textContent );
                return $t === '' ? array() : array( array( 'type' => 'paragraph', 'text' => $t ) );
        }
    }

    private function embed_from_node( $node ) {
        $iframe = ( strtolower( $node->nodeName ) === 'iframe' ) ? $node : $this->first_descendant( $node, 'iframe' );
        $url = '';
        if ( $iframe ) $url = $iframe->getAttribute( 'src' );
        if ( $url === '' ) {
            if ( preg_match( '#https?://[^\s"<]*(?:youtube\.com|youtu\.be|vimeo\.com)[^\s"<]*#i', $node->textContent, $m ) ) {
                $url = $m[0];
            }
        }
        if ( $url === '' ) return null;
        $provider = ( stripos( $url, 'youtu' ) !== false ) ? 'YouTube' : ( ( stripos( $url, 'vimeo' ) !== false ) ? 'Vimeo' : '影片' );
        return array( 'type' => 'embed', 'provider' => $provider, 'url' => $url );
    }

    private function first_descendant( $node, $tag ) {
        $list = $node->getElementsByTagName( $tag );
        return $list->length > 0 ? $list->item( 0 ) : null;
    }

    // ---------------------------------------------------------------------
    // Helpers
    // ---------------------------------------------------------------------

    private function trending_ids( $limit ) {
        global $wpdb;
        $table = $wpdb->prefix . 'popularpostssummary';
        // Sum views over the last 7 days; tolerate a missing WPP table.
        $ids = $wpdb->get_col( $wpdb->prepare(
            "SELECT postid FROM {$table} WHERE last_viewed > DATE_SUB(NOW(), INTERVAL 7 DAY)
             GROUP BY postid ORDER BY SUM(pageviews) DESC LIMIT %d", $limit ) );
        return array_map( 'intval', (array) $ids );
    }

    private function plain( $html ) {
        $text = wp_strip_all_tags( (string) $html );
        $text = html_entity_decode( $text, ENT_QUOTES, 'UTF-8' );
        $text = preg_replace( '/\s+/u', ' ', $text );
        return trim( $text );
    }

    /// A text block ({type,text[,md]}). `text` is the plain fallback; `md` is
    /// inline Markdown (links/bold/italic) included only when the source had
    /// inline formatting, so the app keeps the article's hyperlinks/emphasis.
    private function text_block( $type, $node ) {
        $plain = $this->plain( $node->textContent );
        if ( $plain === '' ) return array();
        $block = array( 'type' => $type, 'text' => $plain );
        $md = trim( $this->inline_md( $node ) );
        if ( $this->has_markup( $md ) ) $block['md'] = $md;
        return array( $block );
    }

    // Recursively serialize a node's inline children to Markdown, escaping
    // literal text so stray *, _, [ in the copy can't become accidental markup.
    private function inline_md( $node ) {
        $out = '';
        foreach ( $node->childNodes as $child ) {
            if ( $child->nodeType === XML_TEXT_NODE ) {
                $out .= $this->md_escape( $child->textContent );
            } elseif ( $child->nodeType === XML_ELEMENT_NODE ) {
                $tag   = strtolower( $child->nodeName );
                $inner = $this->inline_md( $child );
                if ( $tag === 'a' ) {
                    $href = trim( $child->getAttribute( 'href' ) );
                    $out .= ( $href !== '' && trim( $inner ) !== '' ) ? '[' . $inner . '](' . $href . ')' : $inner;
                } elseif ( $tag === 'strong' || $tag === 'b' ) {
                    $out .= ( trim( $inner ) !== '' ) ? '**' . $inner . '**' : $inner;
                } elseif ( $tag === 'em' || $tag === 'i' ) {
                    $out .= ( trim( $inner ) !== '' ) ? '*' . $inner . '*' : $inner;
                } elseif ( $tag === 'br' ) {
                    $out .= ' ';
                } else {
                    $out .= $inner; // unwrap spans/etc.
                }
            }
        }
        return preg_replace( '/\s+/u', ' ', $out );
    }

    private function md_escape( $text ) {
        $text = html_entity_decode( $text, ENT_QUOTES, 'UTF-8' );
        return preg_replace( '/([\\\\`*_\[\]])/u', '\\\\$1', $text );
    }

    // True when the Markdown carries a link or emphasis the app would render
    // (an unescaped * / _, or a "](" link).
    private function has_markup( $md ) {
        return ( strpos( $md, '](' ) !== false ) || (bool) preg_match( '/(?<!\\\\)[*_]/u', $md );
    }

    private function per_page( $request ) {
        $n = intval( $request->get_param( 'limit' ) );
        if ( $n <= 0 ) $n = self::PER_PAGE;
        return min( $n, self::MAX_PER_PAGE );
    }

    private function page( $request ) {
        $c = $request->get_param( 'cursor' );
        $p = $c !== null && $c !== '' ? intval( $c ) : 1;
        return max( 1, $p );
    }

    private function list_response( $query, $request ) {
        $items = array();
        while ( $query->have_posts() ) { $query->the_post(); $items[] = $this->article_card( get_post() ); }
        wp_reset_postdata();
        $page = $this->page( $request );
        $next = ( $page < (int) $query->max_num_pages ) ? (string) ( $page + 1 ) : null;
        return $this->ok( array( 'items' => $items, 'nextCursor' => $next ) );
    }

    private function ok( $data ) {
        // ETag over the payload → conditional requests return 304 (no body),
        // saving bandwidth on the cards/feed that the app polls most. Works
        // transparently with the iOS APIClient's `useProtocolCachePolicy`.
        $etag = '"' . md5( wp_json_encode( $data ) ) . '"';
        $inm  = isset( $_SERVER['HTTP_IF_NONE_MATCH'] )
            ? trim( wp_unslash( $_SERVER['HTTP_IF_NONE_MATCH'] ) ) : '';

        if ( $inm !== '' && $this->etag_matches( $inm, $etag ) ) {
            $resp = new WP_REST_Response( null, 304 );
            $resp->header( 'ETag', $etag );
            $resp->header( 'Cache-Control', 'public, max-age=120' );
            return $resp;
        }

        $resp = new WP_REST_Response( $data, 200 );
        // Public, cacheable content.
        $resp->header( 'Cache-Control', 'public, max-age=120' );
        $resp->header( 'ETag', $etag );
        return $resp;
    }

    // True when the `If-None-Match` header matches our ETag, tolerating the
    // weak validator prefix, comma-separated lists, and `*`.
    private function etag_matches( $header, $etag ) {
        if ( $header === '*' ) return true;
        foreach ( array_map( 'trim', explode( ',', $header ) ) as $candidate ) {
            $candidate = preg_replace( '/^W\//', '', $candidate );
            if ( $candidate === $etag ) return true;
        }
        return false;
    }

    private function error( $status, $code, $message ) {
        return new WP_REST_Response( array( 'error' => array( 'code' => $code, 'message' => $message ) ), $status );
    }
}

add_action( 'rest_api_init', function () {
    ( new FLiPER_App_API() )->register_routes();
} );
