<?php
/**
 * FLiPER frontend contact form.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class FP_Contact_Form {
    const SHORTCODE = 'fliper_contact_form';
    const NONCE_ACTION = 'fliper_contact_form_submit';
    const RATE_LIMIT_SECONDS = 60;

    public static function init() {
        add_shortcode( self::SHORTCODE, array( __CLASS__, 'render_shortcode' ) );
    }

    public static function render_shortcode() {
        self::enqueue_assets();

        if ( ! is_user_logged_in() ) {
            return self::render_login_required();
        }

        $message = '';
        $posted_type = self::posted_value( 'fliper_contact_type' );
        $posted_subject = self::posted_value( 'fliper_contact_subject' );
        $posted_body = self::posted_textarea_value( 'fliper_contact_message' );

        if ( 'POST' === ( $_SERVER['REQUEST_METHOD'] ?? '' ) && isset( $_POST['fliper_contact_submit'] ) ) {
            $result = self::handle_submit();

            if ( is_wp_error( $result ) ) {
                $message = '<div class="fliper-contact-alert fliper-contact-alert-error">' . esc_html( $result->get_error_message() ) . '</div>';
            } else {
                $message = '<div class="fliper-contact-alert fliper-contact-alert-success">已收到你的訊息，FLiPER 團隊會依照問題類型交由對應信箱處理。</div>';
                $posted_type = '';
                $posted_subject = '';
                $posted_body = '';
            }
        }

        ob_start();
        ?>
        <section class="fliper-contact-form-wrap">
            <?php echo $message; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            <form class="fliper-contact-form" method="post" action="<?php echo esc_url( get_permalink() ); ?>">
                <?php wp_nonce_field( self::NONCE_ACTION, 'fliper_contact_nonce' ); ?>
                <input type="text" name="fliper_contact_website" value="" class="fliper-contact-hp" tabindex="-1" autocomplete="off">

                <label>
                    <span>問題類型</span>
                    <select name="fliper_contact_type" required>
                        <option value="">請選擇問題類型</option>
                        <?php foreach ( self::get_type_options() as $key => $option ) : ?>
                            <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $posted_type, $key ); ?>>
                                <?php echo esc_html( $option['label'] ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <label>
                    <span>主旨</span>
                    <input type="text" name="fliper_contact_subject" value="<?php echo esc_attr( $posted_subject ); ?>" maxlength="120" required>
                </label>

                <label>
                    <span>內容</span>
                    <textarea name="fliper_contact_message" rows="8" maxlength="5000" required><?php echo esc_textarea( $posted_body ); ?></textarea>
                </label>

                <button type="submit" name="fliper_contact_submit" value="1">送出</button>
            </form>
        </section>
        <?php

        return ob_get_clean();
    }

    private static function enqueue_assets() {
        wp_enqueue_style(
            'fliper-contact-form',
            plugin_dir_url( dirname( __DIR__ ) . '/fliper.php' ) . 'assets/css/contact-form.css',
            array(),
            '0.1.1'
        );
    }

    private static function render_login_required() {
        $login_url = wp_login_url( get_permalink() );

        ob_start();
        ?>
        <section class="fliper-contact-form-wrap">
            <div class="fliper-contact-login">
                <h2>請先登入 FLiPER 帳號</h2>
                <p>登入後即可透過官網表單聯繫我們，系統會依照問題類型分流給對應團隊。</p>
                <a href="<?php echo esc_url( $login_url ); ?>">登入後填寫</a>
            </div>
        </section>
        <?php

        return ob_get_clean();
    }

    private static function handle_submit() {
        if ( empty( $_POST['fliper_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['fliper_contact_nonce'] ) ), self::NONCE_ACTION ) ) {
            return new WP_Error( 'bad_nonce', '表單驗證逾時，請重新整理頁面後再送出。' );
        }

        if ( ! empty( $_POST['fliper_contact_website'] ) ) {
            return new WP_Error( 'spam', '送出失敗，請重新整理頁面後再試一次。' );
        }

        $user = wp_get_current_user();
        if ( ! $user || ! $user->ID ) {
            return new WP_Error( 'not_logged_in', '請先登入後再送出表單。' );
        }

        $rate_key = 'fliper_contact_form_' . $user->ID;
        if ( get_transient( $rate_key ) ) {
            return new WP_Error( 'rate_limited', '你剛剛已經送出訊息，請稍候再試。' );
        }

        $type = self::posted_value( 'fliper_contact_type' );
        $subject = self::posted_value( 'fliper_contact_subject' );
        $content = self::posted_textarea_value( 'fliper_contact_message' );
        $options = self::get_type_options();

        if ( ! isset( $options[ $type ] ) ) {
            return new WP_Error( 'bad_type', '請選擇有效的問題類型。' );
        }

        if ( '' === trim( $subject ) ) {
            return new WP_Error( 'empty_subject', '請填寫主旨。' );
        }

        if ( '' === trim( $content ) ) {
            return new WP_Error( 'empty_message', '請填寫你想反應的內容。' );
        }

        $option = $options[ $type ];
        $mail_subject = sprintf( '[官網表單][%s] %s', $option['label'], $subject );
        $body = self::build_mail_body( $user, $option, $subject, $content );
        $headers = array(
            'From: FLiPER 官網表單 <noreply@flipermag.com>',
            'Reply-To: ' . self::format_reply_to( $user ),
            'Content-Type: text/plain; charset=UTF-8',
            'X-FLiPER-Source: 官網表單',
        );

        $sent = wp_mail( $option['email'], $mail_subject, $body, $headers );
        if ( ! $sent ) {
            return new WP_Error( 'mail_failed', '訊息暫時無法送出，請稍後再試。' );
        }

        set_transient( $rate_key, 1, self::RATE_LIMIT_SECONDS );

        return true;
    }

    private static function build_mail_body( WP_User $user, array $option, $subject, $content ) {
        $lines = array(
            '來源：官網表單',
            '問題類型：' . $option['label'],
            '收件信箱：' . $option['email'],
            '主旨：' . $subject,
            '',
            '使用者資訊',
            '顯示名稱：' . $user->display_name,
            '帳號：' . $user->user_login,
            'Email：' . $user->user_email,
            'User ID：' . $user->ID,
            '',
            '頁面：' . esc_url_raw( wp_get_referer() ?: get_permalink() ),
            'IP：' . sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ?? '' ) ),
            'User Agent：' . sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ?? '' ) ),
            '',
            '內容',
            $content,
        );

        return implode( "\n", $lines );
    }

    private static function get_type_options() {
        $options = array(
            'general' => array(
                'label' => '一般商務窗口',
                'email' => 'contact@flipermag.com',
            ),
            'service' => array(
                'label' => '一般客服',
                'email' => 'service@flipermag.com',
            ),
            'support' => array(
                'label' => '技術 / 帳號問題',
                'email' => 'support@flipermag.com',
            ),
            'editorial' => array(
                'label' => '編輯部、投稿、採訪、內容合作',
                'email' => 'FED@flipermag.com',
            ),
            'pr' => array(
                'label' => '公關、媒體邀請',
                'email' => 'pr@flipermag.com',
            ),
            'invoice' => array(
                'label' => '帳務與發票',
                'email' => 'invoice@flipermag.com',
            ),
        );

        return apply_filters( 'fliper_contact_form_type_options', $options );
    }

    private static function posted_value( $key ) {
        return isset( $_POST[ $key ] ) ? sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) : '';
    }

    private static function posted_textarea_value( $key ) {
        return isset( $_POST[ $key ] ) ? sanitize_textarea_field( wp_unslash( $_POST[ $key ] ) ) : '';
    }

    private static function format_reply_to( WP_User $user ) {
        $name = sanitize_text_field( trim( $user->display_name ) ?: $user->user_login );

        return sprintf( '%s <%s>', $name, $user->user_email );
    }
}
