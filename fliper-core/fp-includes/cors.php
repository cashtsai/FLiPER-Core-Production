<?php
defined( 'ABSPATH' ) || exit;

add_action( 'rest_api_init', function() {
    remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );
    add_filter( 'rest_pre_serve_request', 'fliper_send_cors_headers', 15 );
}, 15 );

function fliper_send_cors_headers( $value ) {
    $allowed = array(
        'https://cashtsai.github.io',
        'http://localhost:3000',
    );
    $origin = get_http_origin();
    if ( $origin && in_array( $origin, $allowed, true ) ) {
        header( 'Access-Control-Allow-Origin: ' . esc_url_raw( $origin ) );
        header( 'Vary: Origin' );
        header( 'Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS' );
        header( 'Access-Control-Allow-Headers: Authorization, Content-Type, X-WP-Nonce' );
        header( 'Access-Control-Expose-Headers: Link, X-WP-Total, X-WP-TotalPages' );
        header( 'Access-Control-Max-Age: 600' );
    }
    return $value;
}
