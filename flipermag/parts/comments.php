<div class="comment-wrapper <?php echo '0' == $comment->comment_parent ? '' : 'replied'; ?>" data-date="<?php echo date_format( date_create( $comment->comment_date ), 'Y/m/d H:i:s' ); ?>">
	<div class="comment-meta">
		<div class="avatar" title="<?php echo esc_attr( get_userdata( $comment->user_id )->display_name ); ?>"><a href="<?php echo get_author_posts_url( $comment->user_id ); ?>"><?php echo get_avatar( $comment->user_id, '300' ); ?></a></div>
		<div class="comment-meta-inner">
			<div class="user-name">
				<a href="<?php echo get_author_posts_url( $comment->user_id ); ?>"><?php echo esc_attr( get_userdata( $comment->user_id )->display_name ); ?></a>
			</div>
			<time class="time timeago" datetime="<?php echo date_format( date_create( $comment->comment_date ), 'Y/m/d H:i:s' ); ?>" title="<?php echo date_format( date_create( $comment->comment_date ), 'Y/m/d H:i:s' ); ?>"><?php echo date_format( date_create( $comment->comment_date ), 'Y/m/d H:i:s' ); ?></time>
		</div>
	</div>
	<div class="comment-body"><?php echo nl2br( esc_html( $comment->comment_content ) ); ?></div>
	<div class="reply-wrapper">
		<?php if ( is_user_logged_in() ) : ?>
		<button class="reply">回覆</button>
		<?php else: ?>
		<a class="reply-not-login" href="<?php echo wp_login_url( get_the_permalink() . '#comment-input-wrapper-' . get_the_ID() ); ?>">回覆</a>
		<?php endif;?>
	</div>
</div>