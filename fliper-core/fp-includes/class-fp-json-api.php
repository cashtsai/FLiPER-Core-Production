<?php

function fp_register_ajax() {		
	$ajax_events = array(
		'fp_vote' => false,
		'fp_review' => false
	);

	foreach ( $ajax_events as $ajax_event => $nopriv ) {
		add_action( 'wp_ajax_' . $ajax_event, $ajax_event );

		if ( $nopriv ) {
			add_action( 'wp_ajax_nopriv_' . $ajax_event, $ajax_event );
		}
	}
}
add_action( 'init', 'fp_register_ajax' );

function fp_vote() {
	if ( ! $_POST['post_id'] || ! is_numeric( $_POST['post_id'] ) ) {
		echo json_encode('1');
		exit;
	}

	if ( ! $_POST['event_item_id'] || 
		! ( $_POST['event_item_id'] == '1' ||
		$_POST['event_item_id'] == '2' ||
		$_POST['event_item_id'] == '3' ||
		$_POST['event_item_id'] == '4' )
	) {
		echo json_encode('2');
		exit;
	}

	global $wpdb;

	$user_id = get_current_user_id();
	$post_id = $_POST['post_id'];
	$event_id = 1;
	$event_item_id = $_POST['event_item_id'];

	// 若已經超過投票時間，則拒絕投票
	$now = current_time('timestamp');
	$end_time = strtotime( '2021-07-19 23:59:59' );
	if ( $now > $end_time ) {
		echo json_encode('11');
		exit;
	}

	// 檢查今日是否已經投過票
	$sql = 'SELECT vote_datetime FROM wp_votes WHERE user_id=' . $user_id . ' order by vote_datetime desc limit 1';
	$results = $wpdb->get_results( $sql );
	foreach ( $results as $item ) {
		$vote_datetime = $item->vote_datetime;
		if  ( $vote_datetime != 0) {
            $now = current_time('Y-m-d');
            $vote_datetime = date( 'Y-m-d', strtotime( $vote_datetime ) );
            if ( $now == $vote_datetime ) {
                echo json_encode('3');
                exit;
            }
        }
	}

	// 投票
    $sql = "INSERT into wp_votes (user_id,post_id,vote_datetime,event_id,event_item_id) values
            (
            '" . $user_id . "',
            " . $post_id . ",
            '" . current_time("Y-m-d H:i:s") . "',
            " . $event_id . ",
            '" . $event_item_id . "'
            )";
    $results = $wpdb->get_results( $sql );

    // 更新票數
    $sql = 'SELECT COUNT(vote_id) FROM wp_votes WHERE post_id =' . $post_id . ' AND event_id = 1 AND event_item_id = ' . $event_item_id;
    $count = $wpdb->get_var( $sql );
    update_post_meta( $post_id, 'vote_1_' . $event_item_id, $count );

    echo json_encode('4');
	exit;
}    

function fp_review() {
	$user = wp_get_current_user();
	
	if ( in_array( 'reviewer', (array) $user->roles ) ) {
	    if ( ! is_numeric( $_POST['grade'] ) ) {
			echo json_encode('error');
			exit;
		}

		$post_id = $_POST['post_id'];

		update_post_meta( $post_id, 'the_void_of_22_gjun_grade', $_POST['grade'] );
		echo json_encode( $_POST['grade'] );
		exit;
	}

	echo json_encode('error 2');
	exit;
}
