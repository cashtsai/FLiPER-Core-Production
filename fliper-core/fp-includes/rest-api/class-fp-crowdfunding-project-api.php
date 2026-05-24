<?php
/**
 * FLiPER Crowdfunding Project Route (using wp-rest-api plugin)
 * 
 * Version: 1.0.0
 * Author: Rasiel-FLiPER
 * Author URI: https://github.com/rasielchang
 */

/**
 * FLiPER Crowdfunding Project Route (using wp-rest-api plugin)
 *
 * @author      Rasiel-FLiPER
 * @package     FLiPER
 * @version     1.0.0
 */
class FLiPER_Crowdfunding_Project_Route extends WP_REST_Controller {
	/**
     * A reference to an instance of this class.
     */
    private static $instance;

    /**
     * Returns an instance of this class.
     */
    public static function get_instance() {
        if ( null == self::$instance ) {
            self::$instance = new FLiPER_Crowdfunding_Project_Route();
        }
 
        return self::$instance;
    }

    /**
     * Register the routes for the objects of the controller.
     *
     */
    public function register_routes() {
        $version = '2';
        $namespace = 'api/v' . $version;
        $base = 'projects';
        
        register_rest_route( $namespace, '/' . $base . '/(?P<id>[\d]+)', array(
            array(
                'methods'         => WP_REST_Server::READABLE,
                'callback'        => array( $this, 'get_item' ),
                'permission_callback' => array( $this, 'get_item_permissions_check' ),
                'args'            => array()
            )
        ) );
    }

    /**
     * Get one item from the collection
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function get_item( $request ) {
        //get parameters from request
        $params = $request->get_params();
        $item = get_post( $params[ 'id' ] );

        //return a response or error based on some conditional
        if ( '' != $item ) {
            $data = $this->prepare_item_for_response( $params[ 'id' ], $request );
            return new WP_REST_Response( $data, 200 );
        }else{
            return new WP_Error( ERROR_CROWDFUNDING_PROJECT_NOT_FOUND, __( '找不到集資專案', 'fliper' ) );
        }
    }

    /**
     * Check if a given request has access to get items
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|bool
     */
    public function get_items_permissions_check( $request ) {
        $params = $request->get_params();

        if ( fliper_legacy_api_token_matches( isset( $params[ 'access_token' ] ) ? $params[ 'access_token' ] : '' ) ) {
            global $current_user_id;
            $current_user_id = 0;
            return true;
        }

        $user_id = get_current_user_id();
        if ( $user_id == 0 )
            return new WP_Error( ERROR_USER_NOT_LOGIN, __( '請先登入', 'fliper' ) );

        global $current_user_id;
        $current_user_id = $user_id;
        
        return true;
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

    /**
     * Prepare the item for the REST response
     *
     * @param mixed $item WordPress representation of the item.
     * @param WP_REST_Request $request Request object.
     * @return mixed
     */
    public function prepare_item_for_response( $item, $request ) {
        return FLiPER_Crowdfunding_Project_Route::prepare_crowdfunding_project_for_response( $item );
    }

    /**
     * 將 Corwdfunding Project 資料封裝成 JSON 格式
     *
     * @param int $project_id 將要被封裝的集資計劃 id
     * @return mixed
     */
    static public function prepare_crowdfunding_project_for_response( $project_id ) {
        global $current_user_id;
        $project = new FP_Ghost_Cloudfunding_Project( $project_id );
        $ret['id'] = $project_id;
        $ret['title'] = $project->get_title();
        $ret['url'] = $project->get_permalink();
		$ret['cover'] = array();
        $thumbnail_id = get_post_thumbnail_id( $project_id );
        $image = wp_get_attachment_image_src( $thumbnail_id, 'full' );
        if ( $image ) 
            $ret[ 'cover' ][ 'o' ] = array( 'width' => $image[ 1 ], 'height' => $image[ 2 ], 'source' => $image[ 0 ] );
        $sizes = array(
            array( 160, 96, 'xs' ),
            array( 320, 192, 's' ),
            array( 640, 384, 'm' ),
            array( 750, 450, 'l' ),
            array( 1080, 648, 'xl' )
        );
        foreach ( $sizes as $size ) {
            $image = wp_get_attachment_image_src( $thumbnail_id, $size );
            if ( $image && $size[ 0 ] == $image[ 1 ] && $size[ 1 ] == $image[ 2 ] )
                $ret[ 'cover' ][ $size[ 2 ] ] = array( 'width' => $image[ 1 ], 'height' => $image[ 2 ], 'source' => $image[ 0 ] );
        }
        $ret['current_amount'] = $project->get_current_amount();
		$ret['target_amount'] = $project->get_target_amount();				
		$ret['percentage'] = floor( $project->get_percentage() );
		$ret['sponsors']['count'] = $project->get_sponsors_count();				   	
		$ret['is_available'] = $project->is_available();
		if ( $project->is_available() ) {
			$ret['day_left'] = $project->get_day_left();
			$ret['hour_left'] = $project->get_hour_left();
			$ret['minute_left'] = $project->get_minute_left();
		}
        $ret[ 'shares' ] = array(
            'facebook' => FLiPER_get_facebook_share_count( $post->ID )
        );
        
        return $ret;
    }

}
