<?php
/**
 * FP Notification API
 *
 * @package FLiPER
 */


define( 'USER_FOLLOW', 1001 );  // 有人 follow 我
define( 'FAVORITE_POST', 1002 ); // 某人喜愛我的文章
define( 'AUTHOR_ARTICLE_COMMENTED', 1003 ); // 作者的文章被留言(優先權較高)
define( 'USER_ARTICLE_COMMENTED', 1004 ); // 留言過的文章又被留言
define( 'FOLLOWING_PUBLISH_ARTICLE', 1005 ); // 喜愛的作者發了一篇文章

/**
 * Core class used to implement the FP_Notification object.
 *
 */
class FP_Notification {
	/**
	 * The notification's ID.
	 *
	 * @var int
	 */
	public $ID = 0;

	/**
	 * 通知擁有者 id
	 *
	 * @var int
	 */
	public $user_id;

	/**
	 * 產生通知的物件 id
	 *
	 * @var int
	 */
	public $object_id;

	/**
	 * 產生通知的物件資料形態
	 * 共有 user 等一種可能
	 *
	 * @var string
	 */
	public $object_type;

	/**
	 * 產生通知的延伸資料
	 *
	 * @var string
	 */
	public $data;

	/**
	 * 產生通知的原因
	 * 共有 following_publish_post、user_follow、favorite_post 等三種可能
	 *
	 * @var string
	 */
	public $action;

	/**
	 * 通知發生的時間
	 *
	 * @var string
	 */
	public $notification_date;

	/**
	 * 通知的狀態
	 * 共有 new、read 等兩種可能
	 *
	 * @var string
	 */
	public $status;

	/**
	 * Constructor.
	 *
	 * @param int $id notification's ID
	 */
	public function __construct( $id_or_object ) {
		global $wpdb;
		if ( $id_or_object instanceof stdClass ) {
			$notification = $id_or_object;
		} elseif ( is_numeric( $id_or_object ) ) {
			$notification = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM wp_notifications WHERE ID = %d',
				$id_or_object
			) );
			if ( null === $notification )
				return;
		}		

		foreach ( get_object_vars( $notification ) as $key => $value )
			$this->$key = $value;
	}

	/**
	 * Determine whether the notification exists in the database.
	 *
	 * @return bool True if notification exists in the database, false if not.
	 */
	public function exists() {
		return ! empty( $this->ID );
	}

	/**
	 * 取得使用者的通知資料
	 *
	 * @param int $user_id 使用者 id
	 * @param int $offset
	 * @param int $count
	 */
	static function get_notifications( $user_id, $offset = 0, $count = 10 ) {
		global $wpdb;
		$notifications = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM wp_notifications WHERE user_id = %d ORDER BY notification_date DESC LIMIT %d, %d',
			$user_id,
			$offset,
			$count
		) );

		$ret = array();
		foreach ( $notifications as $notification ) {
			array_push( $ret, new FP_Notification( $notification ) );
		}

		return $ret;
	}

	/**
	 * 取得使用者未讀的通知總數
	 *
	 * @param int $user_id 使用者 id
	 */
	static function get_new_notifications_count( $user_id ) {
		global $wpdb;
		$count = $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(ID) FROM wp_notifications WHERE user_id = %d AND status = %s',
			$user_id,
			'new'
		) );

		return $count;
	}

	/**
	 * 新增使用者的通知資料
	 *
	 * @param int $user_id 使用者 id
	 * @param int $object_id 產生通知物件的 id
	 * @param string $object_type 產生通知物件的型態
	 * @param string $data 產生通知的其他資料
	 * @param string $action 產生通知的原因
	 */
	static function add_notification( $user_id, $object_id, $object_type, $data, $action ) {
		global $wpdb;
		$affected_row = $wpdb->insert( 'wp_notifications', 
			array(
				'user_id' => $user_id,
				'object_id' => $object_id,
				'object_type' => $object_type,
				'data' => $data,
				'action' => $action,
				'status' => 'new',
				'notification_date' => current_time( 'mysql' )
			),
			array(
				'%d',
				'%d',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s'
			)
		);

		return $affected_row; // 成功會回傳 1，失敗回傳 false
	}

	/**
	 * 刪除使用者的通知資料
	 *
	 * @param int $user_id 使用者 id
	 * @param int $object_id 通知物件的 id
	 * @param string $object_type 通知物件的型態
	 * @param string $data 通知的其他資料
	 * @param string $action 通知的原因
	 */
	static function delete_notification( $user_id, $object_id, $object_type, $data, $action ) {
		global $wpdb;
		$affected_row = $wpdb->query( $wpdb->prepare( "DELETE FROM wp_notifications WHERE user_id = %d AND object_id = %d AND object_type = %s AND action = %s AND data LIKE '%%%s%%'",
			$user_id,
			$object_id,
			$object_type,
			$action,
			$data
		) );

		return $affected_row; // 成功會回傳 1，失敗回傳 false
	}

	/**
	 * 刪除作者發佈新文章的通知。
	 * 用於新文章後來被刪除時。
	 *
	 * @param int $post_id 被刪除的文章 id
	 */
	static function delete_following_publish_post_notification( $post_id ) {
		global $wpdb;
		$affected_row = $wpdb->query( $wpdb->prepare( "DELETE FROM wp_notifications WHERE object_id = %d AND object_type = %s AND action = %s",
			$post_id,
			'post',
			'following_publish_post'
		) );

		return $affected_row; // 成功會回傳 1，失敗回傳 false
	}

	/**
	 * 將使用者未讀的通知全部改成已讀
	 *
	 * @param int $user_id 使用者 id
	 */
	static function read_all_notifications( $user_id ) {
		global $wpdb;
		$affected_row = $wpdb->update( 'wp_notifications', 
			array(
				'status' => 'read'
			),
			array(
				'user_id' => $user_id,
				'status' => 'new'
			),
			array(
				'%s'
			),
			array(
				'%d',
				'%s'
			)
		);

		return $affected_row; // 成功會回傳總共更新的通知數（ >= 0 ），失敗回傳 false
	}

	/**
	 * 新增使用者喜愛作者通知
	 *
	 * @param int $user_id 使用者 id
	 * @param int $author_id 被喜愛的作者 id
	 */
	static function add_follow_author_notification( $user_id, $author_id ) {
        if ( $user_id == $author_id ) return false;

        global $wpdb;
        $notification = $wpdb->get_results( $wpdb->prepare( "SELECT ID FROM wp_notifications WHERE user_id = %d AND object_id = %d AND object_type = 'user' AND action = 'user_follow'",
			$author_id,
			$user_id
		) );

		if ( ! empty( $notification ) ) return false;

		$status = FP_Notification::add_notification( $author_id, $user_id, 'user', '', 'user_follow' );

		// 即時通知使用者
        $GLOBALS[ 'pusher' ]->trigger( 'fp_notification_' . $author_id, 'reload', array() );
        $text = get_userdata( $user_id )->display_name . ' 開始愛好你。';
        $GLOBALS[ 'pusher' ]->notify(
            array( 'fp_notification_' . $author_id ),
            array(
                'apns' => array(
                    'aps' => array(
                        'alert' => array(
                            'body' => $text
                        ),
                        'badge' => intval( FP_Notification::get_new_notifications_count( $author_id ) ),
                        'fliper' => USER_FOLLOW
                    ),
                ),
            )
        );

		return $status;
	}

	/**
	 * 新增使用者收藏文章通知
	 *
	 * @param int $user_id 使用者 id
	 * @param int $post_id 被收藏的文章 id
	 */
	static function add_favorite_post_notification( $user_id, $post_id ) {
		$post = get_post( $post_id );
        if ( $user_id == $post->post_author ) return false;

        global $wpdb;
        $notification = $wpdb->get_results( $wpdb->prepare( "SELECT ID FROM wp_notifications WHERE user_id = %d AND object_id = %d AND object_type = 'user' AND action = 'favorite_post' AND data LIKE '%%%s%%'",
			$post->post_author,
			$user_id,
			json_encode( array( 'post_id' => $post_id ) )
		) );

		if ( ! empty( $notification ) ) return false;
		
        $status = FP_Notification::add_notification( $post->post_author, $user_id, 'user', json_encode( array( 'post_id' => $post_id ) ), 'favorite_post' );

        // 即時通知使用者
        $GLOBALS[ 'pusher' ]->trigger( 'fp_notification_' . $post->post_author, 'reload', array() );
        $text = get_userdata( $user_id )->display_name . ' 收藏了你的文章 ' . get_the_title( $post ) . '。';
        $GLOBALS[ 'pusher' ]->notify(
            array( 'fp_notification_' . $post->post_author ),
            array(
                'apns' => array(
                    'aps' => array(
                        'alert' => array(
                            'body' => $text
                        ),
                        'badge' => intval( FP_Notification::get_new_notifications_count( $post->post_author ) ),
                        'fliper' => FAVORITE_POST
                    ),
                ),
            )
        );

		return $status;
	}

	/**
	 * 是否有新留言通知
	 *
	 * @param int $user_id 使用者 id
	 * @param int $post_id 文章 id
	 * @return bool 
	 */
	static function topic_has_new_comment( $user_id, $post_id ) {
		global $wpdb;
		$count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(ID) FROM wp_notifications WHERE user_id = %d AND action = 'comment_post' AND status = 'new' AND data LIKE '%%%s%%'",
			$user_id,
			'"post_id":"' . $post_id . '"'
		) );

		return $count > 0 ? true : false;
	}

}