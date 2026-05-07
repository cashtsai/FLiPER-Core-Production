<?php
/**
 * FP Favorite API
 *
 * @package FLiPER
 */

/**
 * Core class used to implement the FP_Favorite object.
 *
 */
class FP_Favorite {
	/**
	 * The favorite's ID.
	 *
	 * @var int
	 */
	public $ID = 0;

	/**
	 * 收藏的使用者 id
	 *
	 * @var int
	 */
	public $user_id;

	/**
	 * 被收藏的物件的 id
	 *
	 * @var int
	 */
	public $object_id;

	/**
	 * 被收藏的物件的資料形態
	 * 共有 user, post, category 等三種可能
	 *
	 * @var string
	 */
	public $object_type;

	/**
	 * 收藏的狀態
	 * 共有 read, update 等兩種可能
	 *
	 * @var string
	 */
	public $status;

	/**
	 * 收藏的時間
	 *
	 * @var string
	 */
	public $favorite_date;

	/**
	 * 收藏的物件被修改的時間，若沒有被修改過則會等於 $favorite_date
	 *
	 * @var string
	 */
	public $updated_date;

	/**
	 * Constructor.
	 *
	 * @param int $id favorite's ID
	 */
	public function __construct( $id_or_object ) {
		global $wpdb;
		if ( $id_or_object instanceof stdClass ) {
			$favorite = $id_or_object;
		} elseif ( is_numeric( $id_or_object ) ) {
			$favorite = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM wp_favorites WHERE ID = %d',
				$id_or_object
			) );
			if ( null === $favorite )
				return;
		}		

		foreach ( get_object_vars( $favorite ) as $key => $value )
			$this->$key = $value;
	}

	/**
	 * Determine whether the favorite exists in the database.
	 *
	 * @return bool True if favorite exists in the database, false if not.
	 */
	public function exists() {
		return ! empty( $this->ID );
	}

	/**
	 * 取得使用者的收藏資料
	 *
	 * @param int $user_id 使用者 id
	 * @param int $offset
	 * @param int $count
	 */
	static function get_favorites( $user_id, $offset = 0, $count = 10 ) {
		global $wpdb;
		$favorites = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM wp_favorites WHERE user_id = %d LIMIT %d, %d',
			$user_id,
			$offset,
			$count
		) );

		$ret = array();
		foreach ( $favorites as $favorite ) {
			array_push( $ret, new FP_Favorite( $favorite ) );
		}

		return $ret;
	}

	/**
	 * 取得使用者收藏的文章 id
	 *
	 * @param int $user_id 使用者 id
	 * @param int $offset
	 * @param int $count
	 */
	static function get_favorite_post_ids( $user_id, $offset = 0, $count = 10 ) {
		global $wpdb;
		$favorites = $wpdb->get_results( $wpdb->prepare( 'SELECT object_id FROM wp_favorites WHERE user_id = %d AND object_type = %s ORDER BY favorite_date DESC, ID DESC LIMIT %d, %d',
			$user_id,
			'post',
			$offset,
			$count
		) );

		$ret = array();
		foreach ( $favorites as $favorite ) {
			array_push( $ret, $favorite->object_id );
		}

		return $ret;
	}

	/**
	 * 取得使用者的收藏總數
	 *
	 * @param int $user_id 使用者 id
	 */
	static function get_favorites_count( $user_id ) {
		global $wpdb;
		$count = $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(ID) FROM wp_favorites WHERE user_id = %d',
			$user_id
		) );

		return $count;
	}

	/**
	 * 取得收藏某個物件的使用者 id
	 *
	 * @param int $object_id
	 * @param int $object_type
	 * @param int $offset
	 * @param int $count
	 */
	static function get_favorite_user_ids( $object_id, $object_type, $offset = 0, $count = 10 ) {
		global $wpdb;
		$favorites = $wpdb->get_results( $wpdb->prepare( 'SELECT user_id FROM wp_favorites WHERE object_id = %d AND object_type = %s ORDER BY favorite_date DESC LIMIT %d, %d',
			$object_id,
			$object_type,
			$offset,
			$count
		) );

		$ret = array();
		foreach ( $favorites as $favorite ) {
			array_push( $ret, $favorite->user_id );
		}

		return $ret;
	}

	/**
	 * 取得收藏某物件的收藏資料
	 *
	 * @param int $object_id
	 * @param int $object_type
	 * @param int $offset
	 * @param int $count
	 */
	static function get_favorites_by_object( $object_id, $object_type, $offset = 0, $count = 10 ) {
		global $wpdb;
		$favorites = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM wp_favorites WHERE object_id = %d AND object_type = %s ORDER BY favorite_date DESC LIMIT %d, %d',
			$object_id,
			$object_type,
			$offset,
			$count
		) );

		return $favorites;
	}

	/**
	 * 取得使用者的收藏總數
	 *
	 * @param int $user_id 使用者 id
	 */
	static function get_favorite_users_count( $object_id, $object_type ) {
		global $wpdb;
		$count = $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(ID) FROM wp_favorites WHERE object_id = %d AND object_type = %s',
			$object_id,
			$object_type
		) );

		return $count;
	}

	/**
	 * 新增使用者的收藏資料
	 *
	 * @param int $user_id 使用者 id
	 * @param int $object_id 被收藏物件的 id
	 * @param int $object_type 被收藏物件的型態
	 */
	static function add_favorite( $user_id, $object_id, $object_type ) {
		global $wpdb;

		// 確認使否已經存在收藏，若有則直接回傳收藏成功
		$has_favorite = $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(ID) FROM wp_favorites WHERE user_id = %d AND object_id = %d AND object_type = %s',
			$user_id,
			$object_id,
			$object_type
		) );
		if ( $has_favorite ) return 1;

		$affected_row = $wpdb->insert( 'wp_favorites', 
			array(
				'user_id' => $user_id,
				'object_id' => $object_id,
				'object_type' => $object_type,
				'status' => 'read',
				'favorite_date' => current_time( 'mysql' ),
				'updated_date' => current_time( 'mysql' )
			),
			array(
				'%d',
				'%d',
				'%s',
				'%s',
				'%s',
				'%s'
			)
		);

		if ( $affected_row ) {
			switch ( $object_type ) {
				case 'post':
					do_action( 'fp_favorite_post', $user_id, $object_id );
					break;
			}
		}

		return $affected_row; // 成功會回傳 1，失敗回傳 false
	}

	/**
	 * 移除使用者的收藏資料
	 *
	 * @param int $user_id 使用者 id
	 * @param int $object_id 被收藏物件的 id
	 * @param int $object_type 被收藏物件的型態
	 */
	static function delete_favorite( $user_id, $object_id, $object_type ) {
		global $wpdb;

		// 確認使否存在收藏，若無則直接回傳移除收藏
		$has_favorite = $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(ID) FROM wp_favorites WHERE user_id = %d AND object_id = %d AND object_type = %s',
			$user_id,
			$object_id,
			$object_type
		) );
		if ( ! $has_favorite ) return 1;

		$affected_row = $wpdb->delete( 'wp_favorites', 
			array(
				'user_id' => $user_id,
				'object_id' => $object_id,
				'object_type' => $object_type
			),
			array(
				'%d',
				'%d',
				'%s'
			)
		);

		return $affected_row; // 成功會回傳 1，失敗回傳 false
	}

	/**
	 * 確認使用者是否已收藏某物件
	 *
	 * @param int $user_id 使用者 id
	 * @param int $object_id 收藏物件的 id
	 * @param int $object_type 收藏物件的型態
	 */
	static function has_favorite( $user_id, $object_id, $object_type ) {
		global $wpdb;
		$affected_row = $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(ID) FROM wp_favorites WHERE user_id = %d AND object_id = %d AND object_type = %s',
			$user_id,
			$object_id,
			$object_type
		) );

		return $affected_row > 0 ? true : false; // 已收藏會回傳 true，未收藏則失敗回傳 false
	}

}