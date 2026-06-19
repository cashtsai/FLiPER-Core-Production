<?php
/**
 * FLiPER Core - REST meta bridge and small routing fixes.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class FP_REST_Meta {

    public static function init() {
        add_action( 'rest_api_init', [ __CLASS__, 'register_post_meta' ] );
        add_action( 'template_redirect', [ __CLASS__, 'redirect_missing_tag_archives' ] );
        add_filter( 'get_post_metadata', [ __CLASS__, 'fallback_revision_preview_meta' ], 10, 4 );
    }

    public static function register_post_meta() {
        $auth_callback = function () {
            return current_user_can( 'edit_posts' );
        };

        $string_fields = [
            'editors_note',
            'article_copyright',
            '_yoast_wpseo_title',
            '_yoast_wpseo_metadesc',
            '_yoast_wpseo_focuskw',
            '_yoast_wpseo_focuskw_synonyms',
            '_fliper_fb_post',
            '_fliper_threads_post',
            '_fliper_fb_posted',
        ];

        foreach ( $string_fields as $key ) {
            $args = [
                'show_in_rest'  => true,
                'single'        => true,
                'type'          => 'string',
                'auth_callback' => $auth_callback,
            ];
            if ( 'article_copyright' === $key ) {
                $args['default'] = 'cc';
            }
            register_post_meta( 'post', $key, $args );
        }

        register_post_meta( 'post', 'main_category', [
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => 'integer',
            'auth_callback' => $auth_callback,
        ] );
    }

    public static function redirect_missing_tag_archives() {
        if ( is_404() && isset( $_SERVER['REQUEST_URI'] ) && preg_match( '#^/tag/#', $_SERVER['REQUEST_URI'] ) ) {
            wp_redirect( home_url( '/' ), 301 );
            exit;
        }
    }

    public static function fallback_revision_preview_meta( $value, $object_id, $meta_key, $single ) {
        static $in_filter = false;
        if ( $in_filter || null !== $value ) {
            return $value;
        }

        $preview_fields = [
            'editors_note',
            'article_copyright',
            '_yoast_wpseo_focuskw',
            '_yoast_wpseo_focuskw_synonyms',
            '_yoast_wpseo_title',
            '_yoast_wpseo_metadesc',
        ];
        if ( ! in_array( $meta_key, $preview_fields, true ) ) {
            return $value;
        }

        $post = get_post( $object_id );
        if ( ! $post || 'revision' !== $post->post_type || ! $post->post_parent ) {
            return $value;
        }

        $in_filter = true;
        $parent_value = get_post_meta( $post->post_parent, $meta_key, true );
        $in_filter = false;

        if ( '' === $parent_value || false === $parent_value ) {
            return $value;
        }

        return $single ? $parent_value : [ $parent_value ];
    }
}
