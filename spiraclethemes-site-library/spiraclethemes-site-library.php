<?php
/**
 * Plugin Name:       Spiraclethemes Site Library
 * Plugin URI:        https://wordpress.org/plugins/spiraclethemes-site-library/
 * Description:       A plugin by Spiracle Themes that adds one-click demo import, theme customization, starter templates, and page builder support to its free themes.
 * Version:           1.6.4
 * Author:            SpiracleThemes
 * Author URI:        https://spiraclethemes.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       spiraclethemes-site-library
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// Define constants.
$spir_constants = [
    'SPIR_SITE_LIBRARY_FILE'    => __FILE__,
    'SPIR_SITE_LIBRARY_URL'     => plugins_url( '/', __FILE__ ),
    'SPIR_SITE_LIBRARY_DIR_URL' => plugin_dir_url( __FILE__ ),
    'SPIR_SITE_LIBRARY_PATH'    => plugin_dir_path( __FILE__ ),
];

foreach ( $spir_constants as $spir_key => $spir_value ) { 
    if ( ! defined( $spir_key ) ) {
        define( $spir_key, $spir_value );
    }
}

use \YeEasyAdminNotices\V1\AdminNotice;

/**
 * Main plugin class.
 */
class Spiraclethemes_Site_Library {

    /**
     * Plugin version for cache busting.
     *
     * @var string
     */
    const VERSION = '1.6.2';

    /**
     * Allowed Spiraclethemes theme slugs.
     *
     * @var array
     */
    const ALLOWED_THEMES = [
        'own-shop',
        'purea-magazine',
        'colon',
        'somalite',
        'purea-fashion',
        'own-store',
        'colon-plus',
        'own-shop-lite',
        'mestore',
        'blogson',
        'blogson-child',
        'own-shope',
        'crater-free',
        'lawfiz',
        'legalblow',
        'own-shop-trend',
        'lawfiz-one',
        'krystal',
        'krystal-lawyer',
        'krystal-business',
        'krystal-shop',
        'shopnex',
        'pawwell',
    ];

    /**
     * Notice schedule for $49/year plan notices.
     * Shared across multiple methods to avoid duplication.
     *
     * @var array
     */
    const NOTICE_SCHEDULE = [
        [ 'days' => 0,  'key' => 'spiraclethemes_sitelib_49dollar_0day_notice' ],
        [ 'days' => 7,  'key' => 'spiraclethemes_sitelib_49dollar_7day_notice' ],
        [ 'days' => 14, 'key' => 'spiraclethemes_sitelib_49dollar_14day_notice' ],
        [ 'days' => 28, 'key' => 'spiraclethemes_sitelib_49dollar_28day_notice' ],
        [ 'days' => 60, 'key' => 'spiraclethemes_sitelib_49dollar_60day_notice' ],
    ];

    /**
     * Theme-specific pricing URLs.
     *
     * @var array
     */
    const PRICING_URLS = [
        'own-shop'         => 'https://spiraclethemes.com/own-shop-pro-addons/',
        'purea-magazine'   => 'https://spiraclethemes.com/purea-magazine-pro-addons',
        'colon'            => 'https://spiraclethemes.com/colon-pro-addons/',
        'somalite'         => 'https://spiraclethemes.com/soma-pro-addons/',
        'purea-fashion'    => 'https://spiraclethemes.com/purea-magazine-pro-addons/',
        'own-store'        => 'https://spiraclethemes.com/own-shop-pro-addons/',
        'colon-plus'       => 'https://spiraclethemes.com/colon-pro-addons/',
        'own-shop-lite'    => 'https://spiraclethemes.com/own-shop-lite-pro-addons/',
        'mestore'          => 'https://spiraclethemes.com/mestore-pro-addons',
        'blogson'          => 'https://spiraclethemes.com/blogson-pro-addons/',
        'blogson-child'    => 'https://spiraclethemes.com/blogson-pro-addons/',
        'own-shope'        => 'https://spiraclethemes.com/own-shope-free-wordpress-theme/#pricing',
        'crater-free'      => 'https://spiraclethemes.com/crater-pro-addons/',
        'lawfiz'           => 'https://spiraclethemes.com/lawfiz-theme/#pricing',
        'legalblow'        => 'https://spiraclethemes.com/legalblow-theme/#pricing',
        'own-shop-trend'   => 'https://spiraclethemes.com/own-shop-pro-addons/',
        'lawfiz-one'       => 'https://spiraclethemes.com/lawfiz-one-theme/#pricing',
        'krystal'          => 'https://spiraclethemes.com/krystal-pro-addons/',
        'krystal-lawyer'   => 'https://spiraclethemes.com/krystal-pro-addons/',
        'krystal-business' => 'https://spiraclethemes.com/krystal-pro-addons/',
        'krystal-shop'     => 'https://spiraclethemes.com/krystal-pro-addons/',
        'shopnex'          => 'https://spiraclethemes.com/shopnex-pro-addons/',
        'pawwell'          => 'https://spiraclethemes.com/pawwell-pro-addons/',
    ];

    /**
     * Current theme name.
     *
     * @var string
     */
    private $theme_name;

    /**
     * Current theme slug (text domain).
     *
     * @var string
     */
    private $theme_slug;

    /**
     * Current theme version.
     *
     * @var string
     */
    private $theme_version;

    /**
     * Admin notification HTML.
     *
     * @var string
     */
    private $notification;

    /**
     * Activate plugin.
     */
    public function activate() {
        add_option( 'spiraclethemes_sitelib_install_date', current_time( 'mysql' ), '', 'yes' );
    }

    /**
     * Deactivate plugin.
     */
    public function deactivate() {
        $user_id = get_current_user_id();
        AdminNotice::cleanUpDatabase( 'spiraclethemes-site-library-' );
        delete_option( 'spiraclethemes_sitelib_install_date' );
        delete_user_meta( $user_id, 'spiraclethemes_sitelib_rating_ignore_notice' );
        delete_user_meta( $user_id, 'spiraclethemes_sitelib_training_ignore_notice' );
        delete_user_meta( $user_id, 'spiraclethemes_sitelib_custom_dev_ignore_notice' );
        delete_user_meta( $user_id, 'spiraclethemes_sitelib_welcome_ignore_notice' );

        // Clean up plan notice meta keys.
        foreach ( self::NOTICE_SCHEDULE as $notice ) {
            delete_user_meta( $user_id, $notice['key'] );
        }
    }

    /**
     * Constructor.
     */
    public function __construct() {
        // Load translations immediately to prevent "too early" notices in WP 6.7+.
        $this->spiraclethemes_site_library_load_plugin_textdomain();

        if ( '1' === get_option( 'ssl_enable_demo_import' ) ) {
            require_once SPIR_SITE_LIBRARY_PATH . 'inc/demo-importer/demo-importer.php';
        }
        require_once SPIR_SITE_LIBRARY_PATH . 'vendor/admin-notices/AdminNotice.php';

        $theme              = wp_get_theme();
        $this->theme_name   = $theme->get( 'Name' );
        $this->theme_slug   = $theme->get( 'TextDomain' );
        $this->theme_version = $theme->get( 'Version' );

        if ( is_admin() && in_array( $this->theme_slug, self::ALLOWED_THEMES, true ) ) {
            add_action( 'admin_init', [ $this, 'spiraclethemes_site_library_set_notification' ] );
            add_action( 'admin_notices', [ $this, 'spiraclethemes_site_library_display_welcome_notice' ] );
            add_action( 'admin_notices', [ $this, 'spiraclethemes_site_library_display_49dollar_notices' ] );
            add_action( 'admin_notices', [ $this, 'spiraclethemes_site_library_display_custom_dev_notice' ] );
            add_action( 'admin_init', [ $this, 'spiraclethemes_site_library_ignore_rating_notice' ] );
            add_action( 'admin_init', [ $this, 'spiraclethemes_site_library_ignore_49dollar_notices' ] );
            add_action( 'admin_init', [ $this, 'spiraclethemes_site_library_ignore_custom_dev_notice' ] );
            add_action( 'wp_ajax_spiraclethemes_sitelib_dismiss_welcome', [ $this, 'spiraclethemes_site_library_dismiss_welcome_notice' ] );
            add_action( 'admin_print_footer_scripts', [ $this, 'spiraclethemes_site_library_welcome_dismiss_script' ] );
        }
    }

    /**
     * Set notification after init.
     */
    public function spiraclethemes_site_library_set_notification() {
        $raw_html = sprintf(
            '<div class="ssl-welcome-inner">' .
                '<div class="ssl-welcome-icon">' .
                    '<img src="%1$s" alt="" />' .
                '</div>' .
                '<div class="ssl-welcome-text">' .
                    '<h3>%2$s</h3>' .
                    '<p>%3$s</p>' .
                    '<a href="%4$s" class="ssl-welcome-cta">%5$s</a>' .
                '</div>' .
            '</div>',
            esc_url( SPIR_SITE_LIBRARY_URL . 'img/rocket.svg' ),
            esc_html__( 'Ready to Launch Your Site?', 'spiraclethemes-site-library' ),
            esc_html__( 'Kickstart your WordPress website with our free demo starter templates, tailored for this theme. Pick a design, import it, and make it yours — in minutes.', 'spiraclethemes-site-library' ),
            esc_url( admin_url( 'themes.php?page=one-click-demo-import' ) ),
            esc_html__( 'Start Importing Templates', 'spiraclethemes-site-library' )
        );

        $this->notification = wp_kses( $raw_html, [
            'div' => [
                'class' => [],
            ],
            'h3'  => [],
            'p'   => [],
            'a'   => [
                'href'  => [],
                'class' => [],
                'target' => [],
                'rel'   => [],
            ],
            'img' => [
                'src' => [],
                'alt' => [],
            ],
        ] );
    }

    /**
     * Load plugin function files.
     */
    public function spiraclethemes_site_library_functions() {
        if ( '1' === get_option( 'ssl_enable_demo_import' ) ) {
            require_once SPIR_SITE_LIBRARY_PATH . '/inc/themes.php';
        }
        require_once SPIR_SITE_LIBRARY_PATH . '/inc/widget/widget.php';
        require_once SPIR_SITE_LIBRARY_PATH . '/admin/admin-init.php';
        require_once SPIR_SITE_LIBRARY_PATH . '/admin/includes/system-info.php';
        require_once SPIR_SITE_LIBRARY_PATH . '/admin/includes/system-settings.php';
    }

    /**
     * Register admin styles.
     */
    public function spiraclethemes_site_library_register_styles() {
        add_action( 'admin_enqueue_scripts', [ $this, 'spiraclethemes_site_library_admin_styles' ], 0 );
    }

    /**
     * Enqueue admin styles.
     */
    public function spiraclethemes_site_library_admin_styles() {
        wp_enqueue_style(
            'spiraclethemes-site-library-main',
            plugins_url( '/css/main.css', __FILE__ ),
            [],
            self::VERSION
        );
    }

    /**
     * Load plugin text domain.
     */
    public function spiraclethemes_site_library_load_plugin_textdomain() {
    }

    /**
     * Get days since plugin installation.
     *
     * @return float Number of days since installation.
     */
    private function spiraclethemes_site_library_get_days_since_install() {
        $install_date = get_option( 'spiraclethemes_sitelib_install_date' );
        if ( ! $install_date ) {
            return 0;
        }

        return ( time() - strtotime( $install_date ) ) / DAY_IN_SECONDS;
    }

    /**
     * Check if a notice should be displayed.
     *
     * @param string $ignore_key        User meta key for dismissal.
     * @param int    $days_after_install Minimum days after install to show.
     * @return bool
     */
    private function spiraclethemes_site_library_should_display_notice( $ignore_key, $days_after_install ) {
        $install_date = get_option( 'spiraclethemes_sitelib_install_date' );
        if ( ! $install_date || strtotime( "+$days_after_install days", strtotime( $install_date ) ) > time() ) {
            return false;
        }

        return ! get_user_meta( get_current_user_id(), $ignore_key, true );
    }

    /**
     * Display a styled upgrade notice.
     *
     * @param string $message Notice HTML content.
     */
    private function spiraclethemes_site_library_display_custom_notice( $message ) {
        echo '<div class="notice updated ssl-pro-upgrade-notice">';
        echo '<div class="ssl-upgrade-inner">';
        echo '<div class="ssl-upgrade-badge">' . esc_html__( 'PRO', 'spiraclethemes-site-library' ) . '</div>';
        echo '<div class="ssl-upgrade-content">' . wp_kses_post( $message ) . '</div>';
        echo '</div>';
        echo '</div>';
    }

    /**
     * Get theme-specific pricing URL.
     *
     * @return string
     */
    private function spiraclethemes_site_library_get_theme_pricing_url() {
        return isset( self::PRICING_URLS[ $this->theme_slug ] )
            ? esc_url( self::PRICING_URLS[ $this->theme_slug ] )
            : esc_url( 'https://spiraclethemes.com/pricing/' );
    }

    /**
     * Build the upgrade notice message with professional layout.
     *
     * @param int    $days        Days after install for this notice.
     * @param string $ignore_param URL parameter for dismissal.
     * @param string $theme_name  Theme name for display.
     * @return string
     */
    private function spiraclethemes_site_library_build_49dollar_notice( $days, $ignore_param, $theme_name ) {
        $pricing_url    = $this->spiraclethemes_site_library_get_theme_pricing_url();
        $theme_pro_name = ucwords( $theme_name ) . ' Pro';
        $ignore_url     = esc_url( wp_nonce_url( admin_url( 'themes.php?' . $ignore_param . '=0' ), $ignore_param . '_nonce' ) );

        $raw_html = sprintf(
            '<div class="ssl-upgrade-text">' .
                '<h3>%1$s</h3>' .
                '<p>%2$s</p>' .
            '</div>' .
            '<div class="ssl-upgrade-actions">' .
                '<div class="ssl-upgrade-price">' .
                    '<span class="ssl-price-current">%3$s</span>' .
                    '<span class="ssl-price-original">%4$s</span>' .
                    '<span class="ssl-price-period">%5$s</span>' .
                '</div>' .
                '<a href="%6$s" target="_blank" rel="noopener" class="ssl-upgrade-cta">%7$s</a>' .
                '<a href="%8$s" class="ssl-remind-later">%9$s</a>' .
            '</div>',
            esc_html( sprintf(
                /* translators: %s: Theme Pro name */
                __( 'Unlock the Full Power of %s', 'spiraclethemes-site-library' ),
                $theme_pro_name
            ) ),
            esc_html__( 'Take your website to the next level with advanced customization options, premium layouts, priority support, and exclusive features designed to help you stand out.', 'spiraclethemes-site-library' ),
            esc_html__( '$49', 'spiraclethemes-site-library' ),
            esc_html__( '$59', 'spiraclethemes-site-library' ),
            esc_html__( '/year', 'spiraclethemes-site-library' ),
            esc_url( $pricing_url ),
            esc_html__( 'Explore Pro Features', 'spiraclethemes-site-library' ),
            esc_url( $ignore_url ),
            esc_html__( 'Remind me later', 'spiraclethemes-site-library' )
        );

        return wp_kses( $raw_html, [
            'div' => [
                'class' => [],
            ],
            'h3'  => [],
            'p'   => [],
            'a'   => [
                'href'   => [],
                'class'  => [],
                'target' => [],
                'rel'    => [],
            ],
            'span' => [
                'class' => [],
            ],
        ] );
    }

    /**
     * Display welcome notice and rating notice.
     */
    public function spiraclethemes_site_library_display_welcome_notice() {
        $days_since = $this->spiraclethemes_site_library_get_days_since_install();
        $user_id    = get_current_user_id();

        // Show Import CTA during first 7 days.
        if ( $days_since < 7 && ! empty( $this->notification ) && ! get_user_meta( $user_id, 'spiraclethemes_sitelib_welcome_ignore_notice', true ) ) {
            printf(
                '<div id="spiraclethemes-site-library-notice" class="notice notice-success is-dismissible" data-nonce="%1$s">%2$s</div>',
                esc_attr( wp_create_nonce( 'spiraclethemes_sitelib_welcome_dismiss' ) ),
                $this->notification // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            );
        }

        // Check if any $49/year notices have been shown.
        $should_show_rating = true;
        foreach ( self::NOTICE_SCHEDULE as $notice ) {
            if ( $days_since >= $notice['days'] ) {
                $dismissal_data = get_user_meta( $user_id, $notice['key'], true );
                if ( ! empty( $dismissal_data ) ) {
                    $should_show_rating = false;
                    break;
                }
            }
        }

        // Show rating notice after 7 days if no $49/year notices have been shown.
        if ( $should_show_rating && $days_since >= 7 && $this->spiraclethemes_site_library_should_display_notice( 'spiraclethemes_sitelib_rating_ignore_notice', 7 ) ) {
            $theme_info_url = esc_url( admin_url( 'themes.php' ) );
            $rating_url     = esc_url( 'https://wordpress.org/support/theme/' . $this->theme_slug . '/reviews/' );
            $ignore_url     = esc_url( wp_nonce_url( admin_url( 'themes.php?wp_spiraclethemes_sitelib_rating_ignore=0' ), 'wp_spiraclethemes_sitelib_rating_ignore_nonce' ) );

            echo '<div class="notice updated ssl-notice">';
            printf(
                /* translators: 1: Theme name with link, 2: Rating URL, 3: Rating link text, 4: Ignore URL, 5: Ignore link text */
                esc_html__( 'Awesome, you\'ve been using %s for over a week! Please consider giving us a 5-star review.', 'spiraclethemes-site-library' ) .
                ' <a href="%s" target="_blank">%s</a> | <a href="%s">%s</a>',
                '<a href="' . esc_url( $theme_info_url ) . '">' . esc_html( $this->theme_name ) . '</a>',
                esc_url( $rating_url ),
                esc_html__( 'Ok, you deserved it!', 'spiraclethemes-site-library' ),
                esc_url( $ignore_url ),
                esc_html__( 'No, thanks', 'spiraclethemes-site-library' )
            );
            echo '</div>';
        }
    }

    /**
     * Display $49/year plan notices based on schedule.
     */
    public function spiraclethemes_site_library_display_49dollar_notices() {
        $days_since = $this->spiraclethemes_site_library_get_days_since_install();
        $user_id    = get_current_user_id();

        // Find the most recent applicable notice that hasn't been permanently dismissed.
        $notice_to_show = null;

        for ( $i = count( self::NOTICE_SCHEDULE ) - 1; $i >= 0; $i-- ) {
            $notice = self::NOTICE_SCHEDULE[ $i ];

            if ( $days_since < $notice['days'] ) {
                continue;
            }

            $dismissal_data = get_user_meta( $user_id, $notice['key'], true );

            // No dismissal data — show this notice.
            if ( empty( $dismissal_data ) ) {
                $notice_to_show = $notice;
                break;
            }

            // Temporary dismissal — check if it's time to remind.
            if ( is_numeric( $dismissal_data ) && time() >= intval( $dismissal_data ) ) {
                $notice_to_show = $notice;
                break;
            }
        }

        if ( $notice_to_show ) {
            $message = $this->spiraclethemes_site_library_build_49dollar_notice(
                $notice_to_show['days'],
                'wp_spiraclethemes_sitelib_49dollar_ignore',
                $this->theme_name
            );
            $this->spiraclethemes_site_library_display_custom_notice( $message );
        }
    }

    /**
     * Handle dismissal of $49/year plan notices.
     */
    public function spiraclethemes_site_library_ignore_49dollar_notices() {
        if ( ! current_user_can( 'manage_options' ) || ! isset( $_GET['wp_spiraclethemes_sitelib_49dollar_ignore'] ) || ! isset( $_GET['_wpnonce'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'wp_spiraclethemes_sitelib_49dollar_ignore_nonce' ) ) {
            return;
        }

        $user_id    = get_current_user_id();
        $days_since = $this->spiraclethemes_site_library_get_days_since_install();

        // Find which notice was dismissed based on days since install.
        $dismissed_notice = null;
        for ( $i = count( self::NOTICE_SCHEDULE ) - 1; $i >= 0; $i-- ) {
            if ( $days_since >= self::NOTICE_SCHEDULE[ $i ]['days'] ) {
                $dismissed_notice = self::NOTICE_SCHEDULE[ $i ];
                break;
            }
        }

        if ( $dismissed_notice ) {
            $reminder_days = $this->get_reminder_days_for_notice( $dismissed_notice['days'] );
            update_user_meta( $user_id, $dismissed_notice['key'], time() + ( $reminder_days * DAY_IN_SECONDS ) );
        }

        wp_safe_redirect( wp_get_referer() ? wp_get_referer() : admin_url() );
        exit;
    }

    /**
     * Get reminder days based on notice type.
     *
     * @param int $notice_days The notice schedule days value.
     * @return int Number of days before reminding again.
     */
    private function get_reminder_days_for_notice( $notice_days ) {
        $reminder_map = [
            0  => 7,
            7  => 7,
            14 => 14,
            28 => 32,
            60 => 365,
        ];

        return isset( $reminder_map[ $notice_days ] ) ? $reminder_map[ $notice_days ] : 365;
    }

    /**
     * Generic ignore handler for notices.
     *
     * @param string $param    URL parameter to check.
     * @param string $meta_key User meta key for dismissal.
     */
    private function spiraclethemes_site_library_handle_ignore_notice( $param, $meta_key ) {
        if ( ! current_user_can( 'manage_options' ) || ! isset( $_GET[ $param ] ) || ! isset( $_GET['_wpnonce'] ) ) {
            return;
        }

        if ( wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), $param . '_nonce' ) ) {
            add_user_meta( get_current_user_id(), sanitize_key( $meta_key ), true, true );
        }
    }

    /**
     * Handle rating notice dismissal.
     */
    public function spiraclethemes_site_library_ignore_rating_notice() {
        $this->spiraclethemes_site_library_handle_ignore_notice( 'wp_spiraclethemes_sitelib_rating_ignore', 'spiraclethemes_sitelib_rating_ignore_notice' );
    }

    /**
     * Handle AJAX dismissal of the welcome notice.
     */
    public function spiraclethemes_site_library_dismiss_welcome_notice() {
        check_ajax_referer( 'spiraclethemes_sitelib_welcome_dismiss' );

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( -1 );
        }

        add_user_meta( get_current_user_id(), 'spiraclethemes_sitelib_welcome_ignore_notice', true, true );
        wp_die( 1 );
    }

    /**
     * Output inline script to persistently dismiss the welcome notice.
     */
    public function spiraclethemes_site_library_welcome_dismiss_script() {
        if ( get_user_meta( get_current_user_id(), 'spiraclethemes_sitelib_welcome_ignore_notice', true ) ) {
            return;
        }
        ?>
        <script>
        (function(){
            var notice = document.getElementById('spiraclethemes-site-library-notice');
            if (!notice) { return; }
            notice.addEventListener('click', function(e){
                if (!e.target.classList.contains('notice-dismiss') && !e.target.closest('.notice-dismiss')) { return; }
                var data = new FormData();
                data.append('action', 'spiraclethemes_sitelib_dismiss_welcome');
                data.append('_ajax_nonce', notice.getAttribute('data-nonce'));
                navigator.sendBeacon && navigator.sendBeacon(ajaxurl, data) || fetch(ajaxurl, { method: 'POST', body: data, credentials: 'same-origin' });
            });
        })();
        </script>
        <?php
    }

    /**
     * Display the custom development service notice banner.
     * Shows a compact, eye-catching banner promoting the custom website service.
     */
    public function spiraclethemes_site_library_display_custom_dev_notice() {
        $user_id = get_current_user_id();

        // Check if dismissed by this user.
        if ( get_user_meta( $user_id, 'spiraclethemes_sitelib_custom_dev_ignore_notice', true ) ) {
            return;
        }

        $ignore_url = esc_url( wp_nonce_url( admin_url( 'themes.php?wp_spiraclethemes_sitelib_custom_dev_ignore=0' ), 'wp_spiraclethemes_sitelib_custom_dev_ignore_nonce' ) );
        $cta_url    = esc_url( 'mailto:support@spiraclethemes.com?subject=' . rawurlencode( __( 'Custom Website Design Service Inquiry', 'spiraclethemes-site-library' ) ) );

        $raw_html = sprintf(
            '<div class="ssl-custom-dev-inner">' .
                '<div class="ssl-custom-dev-icon-wrap">' .
                    '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">' .
                        '<path d="M12 2L2 7l10 5 10-5-10-5z"/>' .
                        '<path d="M2 17l10 5 10-5"/>' .
                        '<path d="M2 12l10 5 10-5"/>' .
                    '</svg>' .
                '</div>' .
                '<div class="ssl-custom-dev-content">' .
                    '<p class="ssl-custom-dev-headline">%1$s</p>' .
                    '<p class="ssl-custom-dev-sub">%2$s</p>' .
                '</div>' .
                '<div class="ssl-custom-dev-actions">' .
                    '<a href="%3$s" class="ssl-custom-dev-cta">%4$s</a>' .
                    '<a href="%5$s" class="ssl-custom-dev-dismiss">%6$s</a>' .
                '</div>' .
            '</div>',
            esc_html__( 'Your Website, Designed & Launched in 7 Days', 'spiraclethemes-site-library' ),
            esc_html__( 'No templates. No hassle. We design and set everything up for you — up to 5 custom pages for just $399. Limited to 3 clients per week.', 'spiraclethemes-site-library' ),
            esc_url( $cta_url ),
            esc_html__( 'Get Started →', 'spiraclethemes-site-library' ),
            esc_url( $ignore_url ),
            esc_html__( 'Dismiss', 'spiraclethemes-site-library' )
        );

        $allowed_html = [
            'div' => [ 'class' => [] ],
            'p'   => [ 'class' => [] ],
            'a'   => [ 'href' => [], 'class' => [], 'target' => [], 'rel' => [] ],
            'svg' => [ 'width' => [], 'height' => [], 'viewbox' => [], 'viewBox' => [], 'fill' => [], 'stroke' => [], 'stroke-width' => [], 'stroke-linecap' => [], 'stroke-linejoin' => [], 'xmlns' => [] ],
            'path' => [ 'd' => [], 'fill' => [], 'stroke' => [] ],
        ];

        echo '<div class="notice ssl-custom-dev-notice">';
        echo wp_kses( $raw_html, $allowed_html );
        echo '</div>';
    }

    /**
     * Handle dismissal of the custom development service notice.
     */
    public function spiraclethemes_site_library_ignore_custom_dev_notice() {
        $this->spiraclethemes_site_library_handle_ignore_notice( 'wp_spiraclethemes_sitelib_custom_dev_ignore', 'spiraclethemes_sitelib_custom_dev_ignore_notice' );
    }
}

// Initialize plugin.
if ( class_exists( 'Spiraclethemes_Site_Library' ) ) :
    $spiraclethemes_site_library = new Spiraclethemes_Site_Library();
    $spiraclethemes_site_library->spiraclethemes_site_library_register_styles();
    $spiraclethemes_site_library->spiraclethemes_site_library_functions();
endif;

// Activation and deactivation hooks.
register_activation_hook( __FILE__, [ $spiraclethemes_site_library, 'activate' ] );
register_deactivation_hook( __FILE__, [ $spiraclethemes_site_library, 'deactivate' ] );
