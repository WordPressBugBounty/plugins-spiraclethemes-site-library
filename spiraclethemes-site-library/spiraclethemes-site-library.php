<?php
/**
 * Plugin Name:       Spiraclethemes Site Library
 * Plugin URI:        https://wordpress.org/plugins/spiraclethemes-site-library/
 * Description:       A plugin by Spiracle Themes that adds one-click demo import, theme customization, starter templates, and page builder support to its free themes.
 * Version:           1.7.0
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
    const VERSION = '1.7.0';

    /**
     * Notice schedule for plan notices.
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
        delete_user_meta( $user_id, 'spiraclethemes_sitelib_theme_required_ignore_notice' );

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
        require_once SPIR_SITE_LIBRARY_PATH . 'inc/themes-list.php';

        $theme              = wp_get_theme();
        $this->theme_name   = $theme->get( 'Name' );
        $this->theme_slug   = $theme->get( 'TextDomain' );
        $this->theme_version = $theme->get( 'Version' );

        if ( is_admin() ) {
            if ( in_array( $this->theme_slug, spiraclethemes_site_library_get_allowed_themes(), true ) ) {
                add_action( 'admin_notices', [ $this, 'spiraclethemes_site_library_display_welcome_notice' ] );
                add_action( 'admin_notices', [ $this, 'spiraclethemes_site_library_display_49dollar_notices' ] );
                add_action( 'admin_notices', [ $this, 'spiraclethemes_site_library_display_custom_dev_notice' ] );
                add_action( 'admin_init', [ $this, 'spiraclethemes_site_library_ignore_rating_notice' ] );
                add_action( 'admin_init', [ $this, 'spiraclethemes_site_library_ignore_49dollar_notices' ] );
                add_action( 'admin_init', [ $this, 'spiraclethemes_site_library_ignore_custom_dev_notice' ] );
            } else {
                add_action( 'admin_notices', [ $this, 'spiraclethemes_site_library_display_theme_required_notice' ] );
                add_action( 'admin_init', [ $this, 'spiraclethemes_site_library_ignore_theme_required_notice' ] );
            }
        }
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
        $pricing_urls = spiraclethemes_site_library_get_pricing_urls();

        if ( isset( $pricing_urls[ $this->theme_slug ] ) ) {
            return esc_url( $pricing_urls[ $this->theme_slug ] );
        }

        return '';
    }

    /**
     * Build the upgrade notice message with professional layout.
     *
     * @param int    $days        Days after install for this notice.
     * @param string $ignore_param URL parameter for dismissal.
     * @return string
     */
    private function spiraclethemes_site_library_build_49dollar_notice( $days, $ignore_param ) {
        $pricing_url = $this->spiraclethemes_site_library_get_theme_pricing_url();
        $ignore_url  = esc_url( wp_nonce_url( admin_url( 'themes.php?' . $ignore_param . '=0' ), $ignore_param . '_nonce' ) );

        // Pull the discount value dynamically from the remote API (cached).
        $discount = spiraclethemes_site_library_get_theme_discount( $this->theme_slug );

        // Prefer the API purchase URL when available, fall back to local pricing URL.
        if ( ! empty( $discount['purchase_url'] ) ) {
            $pricing_url = esc_url( $discount['purchase_url'] );
        }

        // Build the dynamic "% OFF" badge when a sale value is provided.
        $discount_html = '';
        if ( ! empty( $discount['sale'] ) ) {
            $discount_value = preg_replace( '/[^0-9]/', '', (string) $discount['sale'] );
            if ( '' !== $discount_value ) {
                $discount_html = sprintf(
                    '<div class="ssl-upgrade-discount">' .
                        '<span class="ssl-discount-percent">%1$s%%</span>' .
                        '<span class="ssl-discount-label">%2$s</span>' .
                    '</div>',
                    esc_html( $discount_value ),
                    esc_html__( 'OFF', 'spiraclethemes-site-library' )
                );
            }
        }

        $raw_html = sprintf(
            '<div class="ssl-upgrade-text">' .
                '<span class="ssl-upgrade-kicker">%1$s</span>' .
                '<h3>%2$s <span class="ssl-upgrade-product">%3$s</span></h3>' .
                '<p>%4$s</p>' .
            '</div>' .
            '<div class="ssl-upgrade-actions">' .
                '%5$s' .
                '<a href="%6$s" target="_blank" rel="noopener" class="ssl-upgrade-cta">%7$s</a>' .
                '<a href="%8$s" class="ssl-remind-later">%9$s</a>' .
            '</div>',
            esc_html__( 'Love building it yourself?', 'spiraclethemes-site-library' ),
            esc_html__( 'Your Website, Without Limits', 'spiraclethemes-site-library' ),
            esc_html( spiraclethemes_site_library_get_theme_product_name( $this->theme_slug ) ),
            esc_html__( 'Your vision deserves more than the ordinary. With premium layouts, advanced customization, and priority support, Pro gives you the freedom to craft something truly yours — and a website your visitors will never forget.', 'spiraclethemes-site-library' ),
            $discount_html,
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

            $message = sprintf(
                /* translators: %s: Theme name with link */
                esc_html__( 'It\'s been a week since you started building with %s. Behind it is a very small team who poured their heart into every detail — and your support means everything to us. If we\'ve made a difference, a 5-star review would make our day.', 'spiraclethemes-site-library' ),
                '<a href="' . esc_url( $theme_info_url ) . '">' . esc_html( $this->theme_name ) . '</a>'
            );

            $raw_html = sprintf(
                '<div class="ssl-rating-inner">' .
                    '<div class="ssl-rating-badge">' .
                        '<svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">' .
                            '<path d="M12 2l2.9 6.3 6.9.8-5.1 4.7 1.4 6.8L12 17.8 5.9 21.4l1.4-6.8L2.2 9.9l6.9-.8L12 2z"/>' .
                        '</svg>' .
                    '</div>' .
                    '<div class="ssl-rating-content">' .
                        '<p class="ssl-rating-headline">%1$s</p>' .
                        '<div class="ssl-rating-stars" aria-hidden="true">' .
                            '<span class="ssl-star">&#9733;</span><span class="ssl-star">&#9733;</span><span class="ssl-star">&#9733;</span><span class="ssl-star">&#9733;</span><span class="ssl-star">&#9733;</span>' .
                        '</div>' .
                    '</div>' .
                    '<div class="ssl-rating-actions">' .
                        '<a href="%2$s" target="_blank" rel="noopener noreferrer" class="ssl-rating-cta">%3$s</a>' .
                        '<a href="%4$s" class="ssl-rating-dismiss">%5$s</a>' .
                    '</div>' .
                '</div>',
                $message,
                esc_url( $rating_url ),
                esc_html__( 'Ok, you deserved it!', 'spiraclethemes-site-library' ),
                esc_url( $ignore_url ),
                esc_html__( 'No, thanks', 'spiraclethemes-site-library' )
            );

            $allowed_html = [
                'div'  => [ 'class' => [] ],
                'p'    => [ 'class' => [] ],
                'span' => [ 'class' => [] ],
                'a'    => [ 'href' => [], 'class' => [], 'target' => [], 'rel' => [] ],
                'svg'  => [ 'width' => [], 'height' => [], 'viewbox' => [], 'viewBox' => [], 'fill' => [], 'stroke' => [], 'stroke-width' => [], 'stroke-linecap' => [], 'stroke-linejoin' => [], 'aria-hidden' => [], 'xmlns' => [] ],
                'path' => [ 'd' => [], 'fill' => [], 'stroke' => [] ],
            ];

            echo '<div class="notice ssl-rating-notice">';
            echo wp_kses( $raw_html, $allowed_html );
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
                'wp_spiraclethemes_sitelib_49dollar_ignore'
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
     * Display the custom development service notice banner.
     */
    public function spiraclethemes_site_library_display_custom_dev_notice() {
        $user_id = get_current_user_id();

        // Check if dismissed by this user.
        if ( get_user_meta( $user_id, 'spiraclethemes_sitelib_custom_dev_ignore_notice', true ) ) {
            return;
        }

        $ignore_url = esc_url( wp_nonce_url( admin_url( 'themes.php?wp_spiraclethemes_sitelib_custom_dev_ignore=0' ), 'wp_spiraclethemes_sitelib_custom_dev_ignore_nonce' ) );

        // Pull service dynamically from the remote API, fall back to defaults.
        $service = spiraclethemes_site_library_get_service_offer();

        $headline = ! empty( $service['headline'] )
            ? $service['headline']
            : __( 'Your Website, Designed & Launched in 7 Days', 'spiraclethemes-site-library' );

        $description = ! empty( $service['description'] )
            ? $service['description']
            : __( 'No templates. No hassle. We design and set everything up for you — up to 5 custom pages for just $399. Limited to 3 clients per week.', 'spiraclethemes-site-library' );

        $cta_url = ! empty( $service['cta_url'] )
            ? esc_url( $service['cta_url'] )
            : esc_url( 'mailto:support@spiraclethemes.com?subject=' . rawurlencode( __( 'Custom Website Design Service Inquiry', 'spiraclethemes-site-library' ) ) );

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
            esc_html( $headline ),
            esc_html( $description ),
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

    /**
     * Display a notice guiding the user to install/activate a supported theme
     * when the plugin is active but no supported theme is running.
     */
    public function spiraclethemes_site_library_display_theme_required_notice() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        // Don't show on the Get Started page itself.
        if ( isset( $_GET['page'] ) && 'ssl-get-started' === sanitize_key( wp_unslash( $_GET['page'] ) ) ) {
            return;
        }

        // Don't nag if already dismissed.
        if ( get_user_meta( get_current_user_id(), 'spiraclethemes_sitelib_theme_required_ignore_notice', true ) ) {
            return;
        }

        $get_started_url = esc_url( admin_url( 'admin.php?page=ssl-get-started' ) );
        $ignore_url      = esc_url( wp_nonce_url( admin_url( 'themes.php?wp_spiraclethemes_sitelib_theme_required_ignore=0' ), 'wp_spiraclethemes_sitelib_theme_required_ignore_nonce' ) );

        $raw_html = sprintf(
            '<div class="ssl-theme-required-inner">' .
                '<div class="ssl-theme-required-icon">' .
                    '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">' .
                        '<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>' .
                        '<path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>' .
                    '</svg>' .
                '</div>' .
                '<div class="ssl-theme-required-content">' .
                    '<p class="ssl-theme-required-headline">%1$s</p>' .
                    '<p class="ssl-theme-required-sub">%2$s</p>' .
                '</div>' .
                '<div class="ssl-theme-required-actions">' .
                    '<a href="%3$s" class="ssl-theme-required-cta">%4$s</a>' .
                    '<a href="%5$s" class="ssl-theme-required-dismiss">%6$s</a>' .
                '</div>' .
            '</div>',
            esc_html__( 'Activate a compatible theme to get started with Spiraclethemes Site Library', 'spiraclethemes-site-library' ),
            esc_html__( 'This plugin adds one-click demo import, starter templates, and customization for Spiraclethemes themes. Head to the Get Started page to activate a compatible theme.', 'spiraclethemes-site-library' ),
            esc_url( $get_started_url ),
            esc_html__( 'Get Started', 'spiraclethemes-site-library' ),
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

        echo '<div class="notice ssl-theme-required-notice">';
        echo wp_kses( $raw_html, $allowed_html );
        echo '</div>';
    }

    /**
     * Handle dismissal of the "theme required" notice.
     */
    public function spiraclethemes_site_library_ignore_theme_required_notice() {
        $this->spiraclethemes_site_library_handle_ignore_notice( 'wp_spiraclethemes_sitelib_theme_required_ignore', 'spiraclethemes_sitelib_theme_required_ignore_notice' );
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
