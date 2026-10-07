<?php
/* Template Name: Creators 2026 */

/**
 * FLiPER 4.0 · 創作者入口(Proposal 05)。
 * 「以人為出發點」的結構性入口:圓形頭像(封面同款細環)+ serif 名字 +
 * 專欄名 + mono「城市 · 領域」。排序=最近發文優先(活躍者前,頁面常新)。
 * 城市/領域:作者自填 user meta(creator_city / creator_field),領域缺值時
 * fallback 到最近五篇最常見的分類;城市缺值不顯示。
 */

get_header();

// 最近發文優先的作者清單(只收有已發佈文章者)。頁面本身吃 WP-Optimize
// 頁面快取(1hr),這裡的查詢成本可接受。
global $wpdb;
$creator_rows = $wpdb->get_results(
	"SELECT post_author AS uid, MAX(post_date) AS latest, COUNT(*) AS cnt
	 FROM {$wpdb->posts}
	 WHERE post_type = 'post' AND post_status = 'publish'
	 GROUP BY post_author
	 ORDER BY latest DESC, cnt DESC
	 LIMIT 60"
);

if ( ! function_exists( 'fliper_creator_field_fallback' ) ) {
	function fliper_creator_field_fallback( $uid ) {
		$recent = get_posts( array( 'author' => $uid, 'posts_per_page' => 5, 'fields' => 'ids', 'no_found_rows' => true ) );
		$tally  = array();
		foreach ( $recent as $pid ) {
			foreach ( wp_get_post_categories( $pid, array( 'fields' => 'names' ) ) as $name ) {
				$tally[ $name ] = ( $tally[ $name ] ?? 0 ) + 1;
			}
		}
		if ( ! $tally ) return '';
		arsort( $tally );
		return strtoupper( (string) array_key_first( $tally ) );
	}
}
?>

<style>
#creators-2026 { max-width: 1060px; margin: 0 auto 70px; padding: 0 20px; }
#creators-2026 .cr40-head { text-align: center; margin: 36px 0 10px; }
#creators-2026 .cr40-head h1 { font-family: "Noto Serif","notoserifcjktc",serif; font-size: 26px; font-weight: 700; letter-spacing: 2px; margin: 0 0 8px; color: #1A1A1A; }
#creators-2026 .cr40-head .hl { width: 110px; height: 1px; background: #1A1A1A; margin: 0 auto 10px; }
#creators-2026 .cr40-head .sub { font: 700 10px/1 "Roboto Slab"; letter-spacing: 4px; color: #8C8C8C; }
#creators-2026 .cr40-lede { max-width: 480px; margin: 14px auto 34px; text-align: center; font-size: 13.5px; line-height: 1.9; color: #777; }
#creators-2026 .cr40-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 6px 24px; }
#creators-2026 .cr40-card { text-align: center; padding: 24px 8px; text-decoration: none; display: block; }
#creators-2026 .cr40-ava { width: 76px; height: 76px; border-radius: 50%; margin: 0 auto 12px; border: 1px solid #C9C2B4; padding: 3px; }
#creators-2026 .cr40-ava img { width: 100%; height: 100%; border-radius: 50%; display: block; object-fit: cover; }
#creators-2026 .cr40-nm { font-family: "Noto Serif","notoserifcjktc",serif; font-size: 16px; font-weight: 700; color: #1A1A1A; }
#creators-2026 .cr40-col { font-size: 11.5px; color: #8C8C8C; letter-spacing: 1px; margin-top: 4px; }
#creators-2026 .cr40-geo { font: 700 9.5px/1 "Roboto Slab"; letter-spacing: 2px; color: #B3AB9D; margin-top: 8px; }
@media screen and (max-width: 1000px) { #creators-2026 .cr40-grid { grid-template-columns: repeat(3, 1fr); } }
@media screen and (max-width: 640px)  { #creators-2026 .cr40-grid { grid-template-columns: repeat(2, 1fr); } }
</style>

<div id="creators-2026">
	<div class="cr40-head">
		<h1>創作者</h1>
		<div class="hl"></div>
		<div class="sub">CREATORS</div>
	</div>
	<p class="cr40-lede">一件作品背後，有一個人的經歷。從創作走近一個人，再透過這個人，認識更廣大的世界。</p>

	<div class="cr40-grid">
	<?php foreach ( $creator_rows as $row ) :
		$uid  = (int) $row->uid;
		$user = get_userdata( $uid );
		if ( ! $user ) continue;
		$column = trim( (string) get_user_meta( $uid, 'column_name', true ) );
		$city   = strtoupper( trim( (string) get_user_meta( $uid, 'creator_city', true ) ) );
		$field  = strtoupper( trim( (string) get_user_meta( $uid, 'creator_field', true ) ) );
		if ( '' === $field ) $field = fliper_creator_field_fallback( $uid );
		$geo = trim( implode( ' · ', array_filter( array( $city, $field ) ) ) );
	?>
		<a class="cr40-card" href="<?php echo esc_url( get_author_posts_url( $uid ) ); ?>">
			<span class="cr40-ava"><?php echo get_avatar( $user->user_email, 300 ); ?></span>
			<span class="cr40-nm"><?php echo esc_html( $user->display_name ); ?></span>
			<?php if ( $column ) : ?><span class="cr40-col" style="display:block;"><?php echo esc_html( $column ); ?></span><?php endif; ?>
			<?php if ( $geo ) : ?><span class="cr40-geo" style="display:block;"><?php echo esc_html( $geo ); ?></span><?php endif; ?>
		</a>
	<?php endforeach; ?>
	</div>
</div>

<?php get_footer(); ?>
