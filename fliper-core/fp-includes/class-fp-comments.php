<?php
/**
 * FP Comments API
 *
 * @package FLiPER
 */

/**
 * Core class used to implement the FP_Comment object.
 *
 */
class FP_Comment {
	/**
	 * The comment's ID.
	 *
	 * @var int
	 */
	public $comment_ID = 0;

	/**
	 * 留言的文章 ID
	 *
	 * @var int
	 */
	public $comment_post_ID;

	/**
	 * 留言時間
	 *
	 * @var string
	 */
	public $comment_date;

	/**
	 * 留言內容
	 *
	 * @var string
	 */
	public $comment_content;

	/**
	 * 留言的使用者 id
	 *
	 * @var int
	 */
	public $user_id;

	/**
	 * Constructor.
	 *
	 * @param int $id favorite's ID
	 */
	public function __construct( $id_or_object ) {
		if ( $id_or_object instanceof stdClass || $id_or_object instanceof WP_Comment ) {
			$comment = $id_or_object;
		} elseif ( is_numeric( $id_or_object ) ) {
			$comment = get_comment( $id_or_object );
			if ( null === $favorite )
				return;
		}		

		foreach ( get_object_vars( $comment ) as $key => $value )
			$this->$key = $value;
	}

	/**
	 * Determine whether the comment exists in the database.
	 *
	 * @return bool True if comment exists in the database, false if not.
	 */
	public function exists() {
		return ! empty( $this->ID );
	}

	/**
	 * 取得留言的使用者 id
	 *
	 * @return int 文章 id
	 */
	public function get_user_id() {
		return $this->user_id;
	}	

	/**
	 * 取得留言的文章 id
	 *
	 * @return int 文章 id
	 */
	public function get_article_id() {
		return $this->comment_post_ID;
	}

	/**
	 * 取得留言時間
	 *
	 * @return int 文章 id
	 */
	public function get_date() {
		return date_format( date_create( $this->comment_date ), 'Y/m/d H:i:s' );
	}

	/**
	 * 取得留言內容
	 *
	 * @return int 文章 id
	 */
	public function get_content( $type = 'raw' ) {
		if ( 'raw' === $type ) {
			return $this->comment_content;
		} else if ( 'html' === $type ) {
			return nl2br( esc_html( $this->comment_content ) );
		}
	}

	/**
	 * 取得使用者的話題數量
	 *
	 * @param int $user_id 使用者 id
	 * @return int 話題數量
	 */
	static function get_topics_count( $user_id ) {
		global $wpdb;
		$count = $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(DISTINCT comment_post_ID) FROM wp_comments WHERE user_id = %d AND comment_approved = %s',
			$user_id,
			'1'
		) );

		return $count;
	}

	/**
	 * 取得使用者的話題
	 *
	 * @param int $user_id 使用者 id
	 * @param int $offset
	 * @param int $count
	 * @return array 話題
	 */
	static function get_topics( $user_id, $offset, $count ) {
		global $wpdb;
		$topics = $wpdb->get_results( $wpdb->prepare( 
			'SELECT * FROM wp_comments c1 WHERE user_id = %d AND comment_approved = %s AND comment_date = (SELECT max(comment_date) FROM wp_comments c2 WHERE c1.comment_post_ID = c2.comment_post_ID AND user_id = %d ) GROUP BY comment_post_ID ORDER BY comment_date DESC LIMIT %d, %d',
			$user_id,
			'1',
			$user_id,
			$offset,
			$count
		) );

		$ret = array();
		foreach ( $topics as $topic ) {
			array_push( $ret, new FP_Comment( $topic ) );
		}		

		return $ret;
	}

	/**
	 * 搜尋話題
	 *
	 * @param string $search 搜尋的字串
	 * @param int $offset
	 * @param int $count
	 * @return array 話題
	 */
	static function search_topics( $search, $offset, $count ) {
		global $wpdb;
		$topics = $wpdb->get_results( $wpdb->prepare( 
			'SELECT * FROM wp_comments c1 WHERE comment_approved = %s AND comment_content LIKE "%%%s%%" AND comment_date = (SELECT max(comment_date) FROM wp_comments c2 WHERE c1.comment_post_ID = c2.comment_post_ID AND comment_content LIKE "%%%s%%" ) GROUP BY comment_post_ID ORDER BY comment_date DESC LIMIT %d, %d',
			'1',
			$search,
			$search,
			$offset,
			$count
		) );

		$ret = array();
		foreach ( $topics as $topic ) {
			array_push( $ret, new FP_Comment( $topic ) );
		}		

		return $ret;
	}

	/**
	 * 探索話題
	 *
	 * @param int $offset
	 * @param int $count
	 * @return array 話題
	 */
	static function explore_topics( $offset, $count ) {
		// Use WordPress Popular Posts function to get popular post ids
        wpp_get_mostpopular_post( 'pid="40212,40993,37982,39646,32475,64998,60583"&post_type="post"&order_by="comments"&range="monthly"&limit="100"' );
        global $wpp_popular_post_ids;

        $ret = array();
        for ( $i = $offset; $i < $offset + $count; $i++ ) {
            if ( ! isset( $wpp_popular_post_ids[ $i ] ) ) {
                break;
            }

            $comments = get_comments( array(
                'post_id' => $wpp_popular_post_ids[ $i ],
                'number' => 1
            ) );

			array_push( $ret, new FP_Comment( $comments[ 0 ] ) );
        }

		return $ret;
	}

}