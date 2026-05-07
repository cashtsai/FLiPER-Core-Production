<?php get_header(); ?>

<style>
.readmore-articles {
	padding-bottom:70px;
}

.readmore-articles .more-title {
    text-align: center;
    line-height: 26px;
    font-size: 14px;
    font-family: "Noto Sans TC";
    font-weight: 600;
    letter-spacing: 1.4px;
}

.readmore-articles .more-title-en {
    text-align: center;
    position: relative;
    margin-bottom: 36px;
}

.readmore-articles .more-title-en hr {
    position: absolute;
    top: 22px;
    left: 0px;
    width: 100%;
    z-index: -1;
}

.readmore-articles .more-title-en h2 {
    line-height: 46px;
    font-size: 22px;
    font-family: "Roboto Slab";
    font-weight: 400;
    letter-spacing: 2.2px;
    display: inline-block;
    padding: 0px 16px;
    background: #fff;
}

.article-comment-wrapper {
	margin-bottom:100px;
	padding-top:36px;
	padding-bottom:80px;
	background-color: #f7f7f7;
}

.article-comment-wrapper .article-comment-title {
	font-family: "Roboto Slab";
	font-weight: 400;
	font-size:20px;
	line-height: 50px;
	letter-spacing: 1px;
}

.article-comment-wrapper .article-comment-wrapper-inner {
	margin:0 20px;
}

.article-comment-wrapper .comment-input-wrapper {
	margin-bottom:36px;
}

.article-comment-wrapper .comment-input {
	font-family: 'notoserifcjktc';
	font-weight: 400;
	font-size:16px;
	line-height: 24px;
	color:#1a1a1a;
    padding: 28px 20px;
    background: #fff;
    position: relative;
}

.article-comment-wrapper .comment-input.expand {
	padding-bottom:72px;
}

.article-comment-wrapper .comment-input:hover {
	cursor:text;
}

.article-comment-wrapper .comment-input .input,
.article-comment-wrapper button {
	outline: none !important;	
}

.article-comment-wrapper .comment-input .input .comment-not-login-placeholder {
	color:#8c8c8c;
}

.article-comment-wrapper .comment-input .placeholder {
	position: absolute;
	left:20px;
	top:28px;
	color:#8c8c8c;
}

.article-comment-wrapper .comment-input.expand .placeholder {
	display: none;
}

.article-comment-wrapper .comment-input .submit {
	font-family: "Noto Sans TC";
	font-weight: 500;
	font-size:12px;
	line-height: 21px;
	color:#1f7ba1;
	background:transparent;
	position: absolute;
	bottom:28px;
    right: 20px;
    display: none;
    padding:0px;
    border:none;
    border-bottom: 1px solid #1f7ba1;
    cursor:pointer;
}

.article-comment-wrapper .comment-input.expand .submit {
	display: block;
}

.article-comment-wrapper .comment-wrapper {
    margin-bottom: 24px;
    background: #fff;
    padding: 20px;
}

.article-comment-wrapper .comment-wrapper.replied,
.article-comment-wrapper .comment-input-wrapper.replied {
	margin-left:40px;
}

.article-comment-wrapper .comment-input-wrapper.replied {
	display: none;
}

.article-comment-wrapper .comment-wrapper .comment-meta {
    margin-bottom: 12px;
}

.article-comment-wrapper .comment-wrapper .comment-meta > .avatar {
    float: left;
    width: 40px;
    height: 40px;
}

.article-comment-wrapper .comment-wrapper .comment-meta > .avatar a,
.article-comment-wrapper .comment-wrapper .comment-meta > .avatar a img {
    display: block;
    border-radius: 40px;
}

.article-comment-wrapper .comment-wrapper .comment-meta .comment-meta-inner {
    padding-left: 56px;
}

.article-comment-wrapper .comment-wrapper .comment-meta .comment-meta-inner .user-name {
    font-family: 'notoserifcjktc';
    font-weight: 500;
    font-size: 12px;
    line-height: 22px;
}

.article-comment-wrapper .comment-wrapper .comment-meta .comment-meta-inner .user-name a {
    color: #1f7ba1;
}

.article-comment-wrapper .comment-wrapper .comment-meta .comment-meta-inner .time {
    font-family: "Roboto Slab";
    font-weight: 400;
    font-size: 12px;
    line-height: 18px;
    letter-spacing: 1.2px;
    color: #8c8c8c;
}

.article-comment-wrapper .comment-wrapper .comment-body {
	font-family: 'notoserifcjktc';
	font-weight: 400;
	font-size:16px;
	line-height: 24px;
	color:#1a1a1a;
}

.article-comment-wrapper .comment-wrapper .reply-wrapper {
	text-align: right;
}

.article-comment-wrapper .comment-wrapper.replied .reply-wrapper {
	display: none;
}

.article-comment-wrapper .comment-wrapper .reply,
.article-comment-wrapper .comment-wrapper .reply-not-login {
	font-family: "Noto Sans TC";
	font-weight: 500;
	font-size:12px;
	line-height: 21px;
	color:#1f7ba1;
	background:transparent;
    padding:0px;
    border:none;
    border-bottom: 1px solid #1f7ba1;
    cursor:pointer;
}

.full-article .editors-note {
    line-height: 24px;
    font-size: 14px;
    font-family: "Noto Sans TC";
    font-weight: 400;
    color: #8C8C8C;
    margin: 0 30px 40px;
    padding: 10px 20px;
    border-left: 1px solid #1F7BA1;
    border-right: 1px solid #1F7BA1;
    box-sizing: border-box;
}

.full-article .editors-note .label {
    font-family: "Roboto Slab";
    font-size: 17px;
    line-height: 22px;
    color: #1F7BA1;
    margin-bottom: 20px;
}

.full-article .article-copyright {
    padding-top: 20px;
    margin: 20px;
    font-family: "PingFang TC", "Noto Sans TC";
    font-size: 14px;
    line-height: 24px;
    color: #8c8c8c;
}

@media screen and (min-width: 1100px) {
	.more-title-wrap {
		border-top: 2px solid #1a1a1a;
		padding:50px 104px;
		display: flex;
	}

	.readmore-articles {
		padding-bottom:50px;
	}

	.readmore-articles .more-title {
	    text-align: left;
	    line-height: 16px;
	    font-size: 16px;
	    font-family: "notoserifcjktc";
	    letter-spacing: 1.6px;
	    margin-right:16px;
	}
	
	.readmore-articles .more-title-en {
    	line-height: 16px;
    	font-size: 16px;
    	font-family: "Roboto Slab";
    	font-weight: 400;
    	letter-spacing: 1.6px;
    	margin-bottom:0px;
    }

    .readmore-articles .list-articles-wrap {
    	width:924px;
    	margin:0px auto;
    }

    .article-comment-wrapper {
    	padding-top:50px;
	}

    .article-comment-wrapper .article-comment-wrapper-inner {
    	max-width: 624px;
    	margin: 0 auto;
    }

    .article-comment-wrapper .article-comment-title {
		font-size:16px;
		line-height: 42px;
		letter-spacing: 1.6px;
	}

	.article-comment-wrapper .comment-input {
		font-size:14px;
		line-height: 24px;
	}

	.article-comment-wrapper .comment-input .submit {
		line-height: 24px;
		letter-spacing: 1.2px;
	}

	.article-comment-wrapper .comment-wrapper {
		position: relative;
    	margin-bottom: 20px;
    	padding-right: 80px;
	}

	.article-comment-wrapper .comment-wrapper.replied,
	.article-comment-wrapper .comment-input-wrapper.replied {
		margin-left:68px;
	}

	.article-comment-wrapper .comment-wrapper .comment-meta > .avatar {
    	width: 36px;
    	height: 36px;
	}

	.article-comment-wrapper .comment-wrapper .comment-meta .comment-meta-inner {
    	padding-left: 52px;
	}

	.article-comment-wrapper .comment-wrapper .comment-meta .comment-meta-inner .user-name {
    	line-height: 20px;
    	letter-spacing: 1.2px;
	}

	.article-comment-wrapper .comment-wrapper .comment-meta .comment-meta-inner .time {
    	line-height: 16px;
    	letter-spacing: 1.2px;
	}

	.article-comment-wrapper .comment-wrapper .comment-body {
		font-size:14px;
	}

	.article-comment-wrapper .comment-wrapper .reply-wrapper {
	
	}

	.article-comment-wrapper .comment-wrapper .reply,
	.article-comment-wrapper .comment-wrapper .reply-not-login {
		position:absolute;
		margin:-10px 16px 0px 16px;
		top:50%;
		right:0px;
		line-height: 20px;
		letter-spacing: 1.2px;
	}    

	.full-article .editors-note {
    	width: 524px;
    	margin: 0px auto 50px;
    	padding-left: 45px;
    	padding-right: 45px;
	}

	.full-article .editors-note .label {
    	float: left;
    	width: 84px;
	}

	.full-article .editors-note .note {
		padding-left: 84px;
	}

	.full-article .article-copyright {
    	margin: 0px;
    	font-size: 16px;
	}

}

</style>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<div class="full-article row">
	<?php if ( has_post_thumbnail () ) : ?>
	<div class="feature-image"><?php the_post_thumbnail( 'post-thumb' ); ?></div>
	<?php endif; ?>
	<div class="meta">
		<?php $categories = get_the_category(); 
			foreach ( $categories as $cat ) : ?>
		<div class="category"><a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>"><?php echo fp_get_category_name( $cat->term_id ); ?></a></div>
		<?php endforeach; ?>
		<div class="date"><?php echo date( 'M', get_the_time('U') ) . get_the_date('.d.Y'); ?></div>
		<div class="actions">
			<?php if ( ! is_user_logged_in() ) : ?>
			<a class="bookmark iconset go-login" href="<?php echo wp_login_url( get_permalink() ); ?>"></a>
			<?php elseif ( FP_Favorite::has_favorite( get_current_user_id(), get_the_ID(), 'post' ) ) : ?>
			<a class="bookmark iconset logged bookmarked" data-id="<?php the_ID(); ?>" href="#"></a>
			<?php else: ?>
			<a class="bookmark iconset logged" data-id="<?php the_ID(); ?>" href="#"></a>
			<?php endif; ?>
			<a class="share iconset" href="#" data-url="<?php the_permalink(); ?>"></a>
		</div>
	</div>
	<h1 class="title"><?php the_title(); ?></h1>

	<?php if ( '' != get_field( 'editors_note', get_the_ID() ) ) : ?>
	<div class="editors-note">
		<div class="label">Editor's Note</div>
		<div class="note"><?php echo nl2br( get_field( 'editors_note', get_the_ID() ) ); ?></div>
	</div>
	<?php endif; ?>

	<div class="content">
		<?php the_content(); ?>

		<?php if ( get_field( 'related_project', get_the_ID() ) ) : ?>

		<style>
		#post_bottom_crowdfunding_project_wrap {
			padding: 40px 20px;
			border: 1px solid #8C8C8C;
			margin-top: 36px;
			margin-bottom: 32px;
		}
		#post_bottom_crowdfunding_project_wrap h4 {
			font-family: '"Noto Sans TC";';
			font-weight: bold;
			font-size: 15px;
			line-height: 25px;
			color: #595959;
			margin: 0px 0px 20px;
		}
		#post_bottom_crowdfunding_project_wrap .info-text {
			font-family: '"Noto Sans TC";';
			font-size: 14px;
			line-height: 22px;
			color: #8C8C8C;
			margin-bottom: 20px;
		}
		#post_bottom_crowdfunding_project_wrap .progress-bar-wrap {
			padding: 7px 0px;
		}
		#post_bottom_crowdfunding_project_wrap .progress-bar {
			width: 100%;
			border-radius: 6px;
			background: #C4C4C4;
			height: 6px;
			position: relative;
		}
		#post_bottom_crowdfunding_project_wrap .progress-bar-full {
			max-width: 100%;
			width: 0%;
			background: #747474;
			height: 6px;
			content: '.';
			text-indent: -9999px;
			position: absolute;
			left: 0px;
			top: 0px;
			border-radius: 6px;
		}
		#post_bottom_crowdfunding_project_wrap .cover-link {
			display: block;
			width: 100%;
			margin-bottom: 20px;
		}
		#post_bottom_crowdfunding_project_wrap .cover-link img {
			display: block;
		}
		#post_bottom_crowdfunding_project_wrap .cover-link:hover img {
			opacity: 0.5;
		}
		#post_bottom_crowdfunding_project_wrap .go-support {
			width: 116px;
			height: 46px;
			display: block;
			margin: 0 auto;
			border: 1px solid #707070;
			border-radius: 23px;
			font-family: '"Noto Sans TC";';
			font-size: 14px;
			line-height: 46px;
			color: #8C8C8C;
			text-align: center;
			text-decoration: none;
		}
		#post_bottom_crowdfunding_project_wrap .go-support:hover {
			text-decoration: none;
			color: #C8C8C8;
			border-color: #C8C8C8;
		}
		#post_bottom_crowdfunding_project_wrap .left {
			float: left;
		}
		#post_bottom_crowdfunding_project_wrap .right {
			float: right;
		}

		@media screen and (min-width: 1100px) {
			#post_bottom_crowdfunding_project_wrap {
				width: 540px;
				padding: 40px 45px;
			}
			#post_bottom_crowdfunding_project_wrap h4 {
				width: 260px;
			}
			#post_bottom_crowdfunding_project_wrap .author {
				width: 260px;
			}
			#post_bottom_crowdfunding_project_wrap .cover-link {
				margin-bottom: 0px;
			}
		}
		</style>

		<div id="post_bottom_crowdfunding_project_wrap">
			<div class="clearfix" style="position: relative;">
				<h4>讀取中...</h4>
				<div class="author info-text">讀取中...</div>
				<a href="#" class="go-support hide-on-mobile" style="float:right;position: absolute;right:0px;top:0px;">我要支持</a>
			</div>
			<div class="progress-bar-wrap">
				<div class="progress-bar"><div class="progress-bar-full"></div></div>
			</div>
			<div class="left-and-right clearfix">
				<div class="left">
					<div class="day-left info-text"><span class="day">0</span> 天 <span class="hour">0</span> 小時 <span class="minute">0</span> 分鐘後結束</div>
				</div>
				<div class="right">
					<div class="performance info-text">讀取中...</div>
				</div>
			</div>
			<a href="#" class="cover-link"><img class="cover" src="" /></a>
			<a href="#" class="go-support hide-on-desktop">我要支持</a>
		</div>

		<script>
		jQuery('document').ready(function(){
			var url = 'https://publish.flipermag.com/wp-json/api/v2/projects/' + <?php echo get_field( 'related_project', get_the_ID() ); ?> + '?access_token=<?php echo esc_js( defined( 'FLIPER_LEGACY_API_TOKEN' ) ? FLIPER_LEGACY_API_TOKEN : '' ); ?>';
			var _this = jQuery('#post_bottom_crowdfunding_project_wrap');
			jQuery.getJSON(url, function(response){
				_this.find('a').attr('href', response.url);
				_this.find('.cover').attr('src', response.cover.o.source);
				_this.find('.author').text(response.author);
				_this.find('h4').text(response.book_name + response.book_type + '集資');
				_this.find('.performance').text(response.percentage + '% 完成') 
				_this.find('.progress-bar-full').css('width', response.percentage + '%')
				if ( response.is_available ) {
					_this.find('.day-left').html('<span class="day">' + response.day_left + '</span> 天 <span class="hour">' + response.hour_left + '</span> 小時 <span class="minute">' + response.minute_left + '</span> 分鐘後結束');
					var t = response.day_left * 1440 + response.hour_left * 60 + response.minute_left; // 以分鐘計算
					window.setInterval(function(){
						t = t - 1;
						var d = Math.floor(t/1440);
						var h = Math.floor(t/60) % 24;
						var m = Math.floor(t) % 60
						_this.find('.day-left .day').text(d);
						_this.find('.day-left .hour').text(h);
						_this.find('.day-left .minute').text(m);
					}, 60000);
				} else {
					_this.find('.day-left').text('已經結束')
				}
				_jf.flush();
			});
		});
		</script>

		<?php endif; ?>

		<div class="article-copyright"><?php $_ac = get_field( 'article_copyright', get_the_ID() ); echo is_array( $_ac ) ? $_ac['label'] : '不可轉載'; ?></div>

		<?php if ( ! wp_is_mobile() ) : if ( get_option( 'fliper_post_bottom_ad_banner_link' ) && get_option( 'fliper_post_bottom_ad_banner_img' ) ) : ?>
		<div class="" style="margin-bottom:-50px;margin-top:100px;"><a target="_blank" style="display:block;" href="<?php echo get_option( 'fliper_post_bottom_ad_banner_link' ); ?>"><img src="<?php echo get_option( 'fliper_post_bottom_ad_banner_img' ); ?>" /></a></div>
		<?php endif; else : if ( get_option( 'fliper_post_bottom_ad_banner_link' ) && get_option( 'fliper_post_bottom_ad_banner_img_mobile' ) ) : ?>
		<div class="" style="margin: 100px 20px -50px;"><a target="_blank" style="display:block;" href="<?php echo get_option( 'fliper_post_bottom_ad_banner_link' ); ?>"><img src="<?php echo get_option( 'fliper_post_bottom_ad_banner_img_mobile' ); ?>" /></a></div>
		<?php endif; endif; ?>
	</div>

	<div class="bottom-actions">
		<?php if ( ! is_user_logged_in() ) : ?>
		<a class="bookmark iconset go-login" href="<?php echo wp_login_url( get_permalink() ); ?>"></a>
		<?php elseif ( FP_Favorite::has_favorite( get_current_user_id(), get_the_ID(), 'post' ) ) : ?>
		<a class="bookmark iconset logged bookmarked" data-id="<?php the_ID(); ?>" href="#"></a>
		<?php else: ?>
		<a class="bookmark iconset logged" data-id="<?php the_ID(); ?>" href="#"></a>
		<?php endif; ?>
		<a class="share iconset" href="#" data-url="<?php the_permalink(); ?>"></a>
	</div>
	<div class="author-wrap">
		<div class="author">
			<a class="avatar" href="<?php echo get_author_posts_url( get_the_author_meta('ID') ); ?>"><?php echo get_avatar( get_the_author_meta('email'), '300' ); ?></a>
			<div class="author-meta">
				<h2 class="name"><?php the_author_posts_link(); ?></h2>
			</div>
			<div class="description hide-on-mobile"><?php echo get_the_author_meta( 'description' ); ?></div>
		</div>
		<div class="description hide-on-desktop"><?php echo get_the_author_meta( 'description' ); ?></div>
	</div>

	<!-- FB share count. TODO: remove -->
	<div id="facebook-share-count" style="display:none;" data-count="<?php echo FLiPER_get_facebook_share_count( get_the_ID() ); ?>" data-url="<?php the_permalink(); ?>"></div>
</div>

<?php
	$categories = get_the_category();
	if ( $categories ) :
		$related_posts = get_category_related_posts( get_the_ID(), $categories[ 0 ]->term_id );
		if ( $related_posts ) : ?>
<div class="readmore-articles row">
	<h2 class="more-title hide-on-desktop">更多文章</h2>
	<div class="more-title-en hide-on-desktop">
		<hr/>
		<h2>READ MORE</h2>
	</div>
	<div class="more-title-wrap hide-on-mobile">
		<h2 class="more-title">更多文章</h2>
		<h2 class="more-title-en">READ MORE</h2>
	</div>
	<ul class="list-articles-wrap">
		<?php while ( $related_posts->have_posts() ) : $related_posts->the_post();
			$cat_id = get_field( 'main_category', get_the_ID() ); ?>
		<li class="article">
			<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-articles-thumb-2x'); ?></a></div>
			<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	<?php
		$main_category = get_category( $cat_id );
		$main_category_name = ( ! is_wp_error( $main_category ) && is_object( $main_category ) && ! empty( $main_category->name ) ) ? $main_category->name : '';
	?>
			<div class="article-info blue"><?php echo date( 'M', get_the_time('U') ) . get_the_date('.d.Y') . ( $main_category_name ? ' | ' . $main_category_name : '' ); ?></div>
			<div class="excerpt"><?php the_excerpt(); ?></div>
		</li>
		<?php endwhile; wp_reset_query(); ?>
	</ul>
</div>
<?php endif; endif; ?>

<div class="article-comment-wrapper">
	<div class="row">
		<div class="article-comment-wrapper-inner">
			<h2 class="article-comment-title">COMMENT</h2>
			<?php if ( is_user_logged_in() ) : ?>
			<div id="comment-input-wrapper-<?php the_ID(); ?>" class="comment-input-wrapper">
				<div class="comment-input logined">
					<div class="input" contenteditable="true"></div>
					<div class="placeholder"><?php echo esc_html( get_userdata( get_current_user_id() )->display_name ) . ' 說點什麼吧！'; ?></div>
					<button class="submit" data-id="<?php the_ID(); ?>">提交</button>
					<input type="hidden" class="user-name" value="<?php echo esc_attr( get_userdata( get_current_user_id() )->display_name ); ?>" />
					<input type="hidden" class="user-url" value="<?php echo get_author_posts_url( get_current_user_id() ); ?>" />
					<input type="hidden" class="user-avatar" value="<?php echo get_wp_user_avatar_src( get_current_user_id(), array( 300, 300 ) ); ?>" />
				</div>
			</div>
			<?php else : ?>
			<div class="comment-input-wrapper">
				<div class="comment-input">
					<div class="input">
						<a class="comment-not-login-placeholder" href="<?php echo wp_login_url( get_the_permalink() . '#comment-input-wrapper-' . get_the_ID() ); ?>">說點什麼吧！</a>
					</div>
				</div>
			</div>
			<?php endif; ?>
			<div class="comment-card" data-id="<?php the_ID(); ?>">
				<?php
					// 取出所有留言
					$comments = get_comments( array( 'post_id' => get_the_ID(), 'order' => 'DESC' ) );
					$date = '';

					// 若有留言，列舉出來
					$replied_comments = array();
					foreach ( $comments as $comment ) {
						// 若為回覆留言（第二層），則儲存起來先不印出
						if ( '0' != $comment->comment_parent ) {
							if ( array_key_exists( $comment->comment_parent, $replied_comments ) ) {
								array_push( $replied_comments[ $comment->comment_parent ], $comment );
							} else {
								$replied_comments[ $comment->comment_parent ] = array( $comment );
							}
						} else {
							// 列印留言（第一層）
							get_template_part( 'parts/comments' );

							$parent_comment_id = $comment->comment_ID;

							// 檢查是否有回覆留言（第二層），若有則依序印出
							if ( array_key_exists( $comment->comment_ID, $replied_comments ) ) {
								$r_comments = array_reverse( $replied_comments[ $comment->comment_ID ] );
								foreach ( $r_comments as $comment ) {
									get_template_part( 'parts/comments' );
								}
							}

							if ( is_user_logged_in() ) : ?>
								<div id="comment-input-wrapper-<?php echo $parent_comment_id; ?>" class="comment-input-wrapper replied">
									<div class="comment-input logined">
										<div class="input" contenteditable="true"></div>
										<div class="placeholder">回覆留言</div>
										<button class="submit" data-id="<?php the_ID(); ?>">提交</button>
										<input type="hidden" class="user-name" value="<?php echo esc_attr( get_userdata( get_current_user_id() )->display_name ); ?>" />
										<input type="hidden" class="user-url" value="<?php echo get_author_posts_url( get_current_user_id() ); ?>" />
										<input type="hidden" class="user-avatar" value="<?php echo get_wp_user_avatar_src( get_current_user_id(), array( 300, 300 ) ); ?>" />
										<input type="hidden" class="reply-comment-id" value="<?php echo $parent_comment_id; ?>" />
									</div>
								</div>
							<?php endif;
						}
					}
				?>
			</div>
		</div>
	</div>
</div>

<?php endwhile; endif; ?>


<?php get_footer(); ?>
