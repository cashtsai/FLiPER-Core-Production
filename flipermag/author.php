<?php
get_header();

$author_id = (int) get_queried_object_id();
$author = $author_id ? get_userdata( $author_id ) : null;

if ( ! function_exists( 'fliper_author_avatar_src' ) ) {
	function fliper_author_avatar_src( $user_id ) {
		if ( function_exists( 'get_wp_user_avatar_src' ) ) {
			$src = get_wp_user_avatar_src( $user_id, [ 300, 300 ] );
			if ( $src ) {
				return $src;
			}
		}

		return get_avatar_url( $user_id, [ 'size' => 300 ] );
	}
}

if ( ! function_exists( 'fliper_author_social_fields' ) ) {
	function fliper_author_social_fields() {
		return [
			'instagram' => 'Instagram',
			'threads'   => 'Threads',
			'facebook'  => 'Facebook',
			'tiktok'    => 'TikTok',
			'line'      => 'LINE',
			'wechat'    => 'WeChat',
			'website'   => 'Website',
		];
	}
}

if ( ! function_exists( 'fliper_author_social_url' ) ) {
	function fliper_author_social_url( $key, $value ) {
		$value = trim( (string) $value );

		if ( '' === $value ) {
			return '';
		}

		if ( false !== strpos( $value, '://' ) ) {
			return esc_url_raw( $value );
		}

		$handle = ltrim( $value, '@' );
		$map = [
			'facebook'  => 'https://www.facebook.com/',
			'instagram' => 'https://www.instagram.com/',
			'threads'   => 'https://www.threads.net/@',
			'tiktok'    => 'https://www.tiktok.com/@',
		];

		if ( isset( $map[ $key ] ) ) {
			return esc_url_raw( $map[ $key ] . $handle );
		}

		if ( 'website' === $key ) {
			return esc_url_raw( 'https://' . $value );
		}

		return '';
	}
}

if ( ! function_exists( 'fliper_author_public_social_links' ) ) {
	function fliper_author_public_social_links( $user_id ) {
		$links = [];

		foreach ( fliper_author_social_fields() as $key => $label ) {
			$value = get_user_meta( $user_id, 'fliper_social_' . $key, true );

			if ( '' === $value ) {
				if ( 'facebook' === $key ) {
					$value = get_the_author_meta( 'facebook', $user_id );
				} elseif ( 'instagram' === $key ) {
					$value = get_the_author_meta( 'instagram', $user_id );
				} elseif ( 'website' === $key ) {
					$user = get_userdata( $user_id );
					$value = $user ? $user->user_url : '';
				}
			}

			$value = trim( (string) $value );
			if ( '' === $value ) {
				continue;
			}

			$public = get_user_meta( $user_id, 'fliper_public_social_' . $key, true );
			if ( '0' === $public ) {
				continue;
			}

			$links[] = [
				'key'   => $key,
				'label' => $label,
				'value' => $value,
				'url'   => fliper_author_social_url( $key, $value ),
			];
		}

		return $links;
	}
}

$display_name = $author ? $author->display_name : '';
$description = $author ? get_the_author_meta( 'description', $author_id ) : '';
$column_name = $author_id ? get_user_meta( $author_id, 'column_name', true ) : '';
$column_intro = $author_id ? get_user_meta( $author_id, 'fliper_column_intro', true ) : '';
$social_links = $author_id ? fliper_author_public_social_links( $author_id ) : [];

global $wp_query;
?>

<style>
.author-archive {
	margin-top:30px;
}

.author-card {
	box-sizing:border-box;
	min-height:calc(100vh - 112px);
	min-height:calc(100svh - 112px);
	margin:0 auto 56px;
	padding:30px 22px 28px;
	border:1px solid #ddd6cd;
	background:#fff;
	display:flex;
	flex-direction:column;
}

.author-archive .hero-title {
	margin:0 0 28px;
	padding:0;
}

.author-archive .hero-title .zh {
	font-family:"Noto Sans TC";
	font-weight:600;
	font-size:28px;
	letter-spacing:1.4px;
	line-height:42px;
}

.author-archive .hero-title .en {
	margin-top:8px;
	font-family:"Roboto Slab";
	font-weight:400;
	font-size:12px;
	letter-spacing:1.2px;
	line-height:22px;
	color:#666;
	text-transform:uppercase;
}

.author-profile {
	box-sizing:border-box;
	margin:0;
	padding:0;
	border-bottom:0;
	flex:1;
	display:flex;
}

.author-profile-card {
	display:flex;
	flex-direction:column;
	gap:22px;
	flex:1;
}

.author-profile-avatar {
	width:112px;
	height:112px;
	border-radius:50%;
	overflow:hidden;
	background:#f4f4f4;
}

.author-profile-avatar img {
	display:block;
	width:100%;
	height:100%;
	object-fit:cover;
}

.author-profile-body {
	max-width:none;
	flex:1;
	display:flex;
	flex-direction:column;
}

.author-profile-kicker {
	margin-bottom:8px;
	font-family:"Roboto Slab";
	font-size:13px;
	line-height:22px;
	letter-spacing:1.3px;
	color:#1f7ba1;
	text-transform:uppercase;
}

.author-profile-title {
	margin-bottom:14px;
	font-family:"Noto Serif", "notoserifcjktc";
	font-weight:600;
	font-size:24px;
	line-height:38px;
	letter-spacing:1.2px;
}

.author-profile-text {
	margin-bottom:14px;
	font-family:"Noto Sans TC";
	font-weight:400;
	font-size:15px;
	line-height:29px;
	color:#555;
	white-space:pre-line;
}

.author-social-links {
	display:flex;
	flex-wrap:wrap;
	gap:8px;
	margin-top:auto;
	padding-top:24px;
}

.author-social-links a,
.author-social-links span {
	display:inline-flex;
	align-items:center;
	min-height:32px;
	padding:0 13px;
	border:1px solid #d9d2c8;
	border-radius:18px;
	font-family:"Roboto Slab", "Noto Sans TC";
	font-size:13px;
	line-height:20px;
	color:#1a1a1a;
	text-decoration:none;
}

.author-social-links a:hover {
	border-color:#1f7ba1;
	color:#1f7ba1;
}

.author-articles-heading {
	margin-bottom:32px;
	padding:0 20px;
	font-family:"Roboto Slab";
	font-weight:400;
	font-size:12px;
	line-height:22px;
	letter-spacing:1.2px;
	color:#666;
	text-transform:uppercase;
}

.author-empty {
	margin-bottom:80px;
	padding:0 20px;
	font-family:"Noto Sans TC";
	font-size:15px;
	line-height:28px;
	color:#777;
}

.author-archive .readmore img {
	display:block;
	width:120px;
	margin:0 auto 100px;
}

@media screen and (min-width:1100px) {
	.author-archive {
		margin-top:90px;
	}

	.author-card {
		width:1100px;
		min-height:0;
		margin-bottom:64px;
		padding:0 0 56px;
		border:0;
		border-bottom:1px solid #ddd6cd;
		display:block;
	}

	.author-archive .hero-title {
		margin-bottom:52px;
		padding:0;
	}

	.author-archive .hero-title .zh {
		font-family:"notoserifcjktc";
		font-size:48px;
		letter-spacing:2.4px;
		line-height:70px;
	}

	.author-archive .hero-title .en {
		font-size:14px;
		letter-spacing:1.4px;
		line-height:26px;
	}

	.author-profile-card {
		flex-direction:row;
		align-items:flex-start;
		gap:52px;
	}

	.author-profile {
		display:block;
	}

	.author-profile-body {
		display:block;
	}

	.author-profile-avatar {
		width:140px;
		height:140px;
		flex:0 0 140px;
	}

	.author-profile-title {
		font-size:30px;
		line-height:46px;
		letter-spacing:1.5px;
	}

	.author-profile-text {
		font-family:"Noto Serif", "notoserifcjktc";
		font-size:15px;
		line-height:32px;
	}

	.author-social-links {
		margin-top:26px;
		padding-top:0;
	}

	.author-articles-heading {
		margin-bottom:42px;
		padding:0;
		font-size:14px;
		letter-spacing:1.4px;
		line-height:26px;
	}

	.author-empty {
		padding:0;
	}
}
</style>

<div class="author-archive">
	<section class="author-card row">
		<h1 class="hero-title">
			<div class="zh"><?php echo esc_html( $display_name ); ?></div>
			<div class="en"><?php echo esc_html( $column_name ?: 'FLIPER AUTHOR' ); ?></div>
		</h1>

		<div class="author-profile">
			<div class="author-profile-card">
				<div class="author-profile-avatar">
					<img src="<?php echo esc_url( fliper_author_avatar_src( $author_id ) ); ?>" alt="<?php echo esc_attr( $display_name ); ?>">
				</div>
				<div class="author-profile-body">
					<?php if ( $column_name ) : ?>
						<?php if ( $column_intro ) : ?>
							<div class="author-profile-kicker">Column</div>
							<h2 class="author-profile-title"><?php echo esc_html( $column_name ); ?></h2>
						<?php endif; ?>
					<?php endif; ?>

					<?php if ( $description ) : ?>
						<?php if ( ! $column_intro ) : ?>
							<div class="author-profile-kicker">Profile</div>
						<?php endif; ?>
						<div class="author-profile-text"><?php echo esc_html( $description ); ?></div>
					<?php endif; ?>

					<?php if ( $column_intro ) : ?>
						<div class="author-profile-kicker">About This Column</div>
						<div class="author-profile-text"><?php echo esc_html( $column_intro ); ?></div>
					<?php endif; ?>

					<?php if ( ! empty( $social_links ) ) : ?>
						<div class="author-social-links">
							<?php foreach ( $social_links as $link ) : ?>
								<?php if ( $link['url'] ) : ?>
									<a href="<?php echo esc_url( $link['url'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $link['label'] ); ?></a>
								<?php else : ?>
									<span><?php echo esc_html( $link['label'] . ' ' . $link['value'] ); ?></span>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

	<div class="row">
		<div class="author-articles-heading">Articles</div>
	</div>

	<?php if ( have_posts() ) : ?>
		<?php
		$count = 0;
		while ( have_posts() ) :
			the_post();
			$cat_id = get_field( 'main_category', get_the_ID() );
			if ( 0 === $count % 3 ) :
				?>
	<ul class="list-articles-wrap row">
			<?php endif; ?>
		<li class="article">
			<div class="feature-image"><a class="block" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'list-articles-thumb-2x' ); ?></a></div>
			<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<?php
			$main_category = get_category( $cat_id );
			$main_category_name = ( ! is_wp_error( $main_category ) && is_object( $main_category ) && ! empty( $main_category->name ) ) ? $main_category->name : '';
			?>
			<div class="article-info blue"><?php echo esc_html( date( 'M', get_the_time( 'U' ) ) . get_the_date( '.d.Y' ) . ( $main_category_name ? ' | ' . $main_category_name : '' ) ); ?></div>
			<div class="excerpt"><?php the_excerpt(); ?></div>
		</li>
			<?php if ( 2 === $count % 3 || $count + 1 === $wp_query->post_count ) : ?>
	</ul>
			<?php endif; ?>
			<?php
			$count += 1;
		endwhile;
		?>
	<?php else : ?>
		<div class="author-empty row">目前還沒有文章。</div>
	<?php endif; ?>

	<?php if ( $wp_query->found_posts > get_option( 'posts_per_page' ) ) : ?>
	<div class="readmore row">
		<img id="infinite-readmore-icon" data-type="author" data-author-id="<?php echo esc_attr( $author_id ); ?>" data-page="2" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/loading.gif' ); ?>" />
	</div>
	<?php endif; ?>
</div>

<?php
get_footer();
