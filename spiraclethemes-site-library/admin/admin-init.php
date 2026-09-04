<?php
/**
 * Admin functionality for Spiraclethemes Site Library plugin.
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Spiraclethemes_site_library_Admin
 *
 * Handles admin settings page, asset loading, and AJAX save functionality.
 */
class Spiraclethemes_site_library_Admin {

    /**
     * Nonce name for AJAX and form security.
     *
     * @var string
     */
    const NONCE_NAME = 'ssl_settings_nonce';

    /**
     * Plugin version for cache busting.
     *
     * @var string
     */
    const VERSION = '1.6.2';

    /**
     * Default settings for the plugin.
     *
     * @var array
     */
    private $default_settings;

    /**
     * Constructor.
     */
    public function __construct() {
        $this->default_settings = [
            'ssl_enable_demo_import'    => 1,
        ];

        // Migrate old option name to new option name.
        $old_option = get_option( 'ssl_disable_demo_import', null );
        if ( null !== $old_option && false === get_option( 'ssl_enable_demo_import' ) ) {
            update_option( 'ssl_enable_demo_import', $old_option );
            delete_option( 'ssl_disable_demo_import' );
        }

        // Initialize settings with defaults if not set.
        foreach ( $this->default_settings as $key => $value ) {
            if ( false === get_option( $key ) ) {
                update_option( $key, $value );
            }
        }

        $this->spiraclethemes_site_library_init_hooks();
    }

    /**
     * Initialize hooks.
     */
    public function spiraclethemes_site_library_init_hooks() {
        add_action( 'admin_menu', [ $this, 'spiraclethemes_site_library_register_admin_menu' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'spiraclethemes_site_library_enqueue_scripts' ] );
        add_action( 'wp_ajax_ssl_save_settings', [ $this, 'spiraclethemes_site_library_save_settings' ] );
        add_action( 'wp_ajax_ssl_get_theme_screenshot', [ $this, 'spiraclethemes_site_library_get_theme_screenshot_ajax' ] );
        add_action( 'wp_ajax_ssl_install_theme', [ $this, 'spiraclethemes_site_library_install_theme_ajax' ] );
    }

    /**
     * Register admin menu.
     */
    public function spiraclethemes_site_library_register_admin_menu() {
        add_menu_page(
            esc_html__( 'Spiraclethemes Site Library', 'spiraclethemes-site-library' ),
            esc_html__( 'Spiraclethemes Site Library', 'spiraclethemes-site-library' ),
            'manage_options',
            'ssl-settings',
            [ $this, 'spiraclethemes_site_library_display_settings_pages' ],
            'dashicons-art'
        );

        add_submenu_page(
            'ssl-settings',
            esc_html__( 'Get Started', 'spiraclethemes-site-library' ),
            esc_html__( 'Get Started', 'spiraclethemes-site-library' ),
            'manage_options',
            'ssl-get-started',
            [ $this, 'spiraclethemes_site_library_display_get_started_page' ]
        );
    }

    /**
     * Render the "Get Started" page.
     *
     * Lists every theme supported by the plugin and lets the user activate
     * installed themes or install missing ones.
     */
    public function spiraclethemes_site_library_display_get_started_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die(
                esc_html__( 'You do not have permission to access this page.', 'spiraclethemes-site-library' ),
                esc_html__( 'Permission Denied', 'spiraclethemes-site-library' ),
                [ 'response' => 403 ]
            );
        }

        $supported_themes = spiraclethemes_site_library_get_live_themes();
        $installed_themes = wp_get_themes();
        $active_slug      = get_option( 'stylesheet' );

        // Reverse the list so newer themes appear first.
        $supported_themes = array_reverse( $supported_themes );

        $theme_cards = [];
        foreach ( $supported_themes as $slug ) {
            $is_installed = isset( $installed_themes[ $slug ] );
            $is_active    = ( $slug === $active_slug );

            if ( $is_installed ) {
                $theme_obj = $installed_themes[ $slug ];
                $name      = $theme_obj->get( 'Name' );
                $button    = $is_active
                    ? '<span class="ssl-theme-card-badge">' . esc_html__( 'Active', 'spiraclethemes-site-library' ) . '</span>'
                    : '<a href="' . esc_url( wp_nonce_url( admin_url( 'themes.php?action=activate&stylesheet=' . $slug ), 'switch-theme_' . $slug ) ) . '" class="ssl-theme-card-cta">' . esc_html__( 'Activate', 'spiraclethemes-site-library' ) . '</a>';
            } else {
                $name   = ucwords( str_replace( '-', ' ', $slug ) );
                $button = '<button type="button" class="ssl-theme-card-cta ssl-theme-card-cta-ghost ssl-theme-install-btn" data-theme-slug="' . esc_attr( $slug ) . '">' . esc_html__( 'Install', 'spiraclethemes-site-library' ) . '</button>';
            }

            $theme_cards[] = [
                'slug'   => $slug,
                'name'   => $name,
                'button' => $button,
            ];
        }
        ?>
        <div class="wrap ssl-admin-wrap">
            <div class="ssl-hero-header">
                <div class="ssl-hero-inner">
                    <div class="ssl-hero-icon">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                            <path d="M2 17l10 5 10-5"/>
                            <path d="M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                    <div class="ssl-hero-text">
                        <h1><?php esc_html_e( 'Get Started with Spiraclethemes Site Library', 'spiraclethemes-site-library' ); ?></h1>
                        <p><?php esc_html_e( 'Activate a compatible theme to unlock one-click demo import, starter templates, and theme customization.', 'spiraclethemes-site-library' ); ?></p>
                    </div>
                </div>
            </div>

            <div class="ssl-get-started-content">
                <h2><?php esc_html_e( 'Supported Themes', 'spiraclethemes-site-library' ); ?></h2>
                <p class="ssl-get-started-desc"><?php esc_html_e( 'This plugin supports all of the following themes. Activate one that is installed, or install one that is missing to get started.', 'spiraclethemes-site-library' ); ?></p>

                <div class="ssl-theme-grid">
                    <?php foreach ( $theme_cards as $card ) : ?>
                        <div class="ssl-theme-card <?php echo $card['slug'] === $active_slug ? 'ssl-theme-card-active' : ''; ?>">
                            <div class="ssl-theme-card-thumb" data-theme-slug="<?php echo esc_attr( $card['slug'] ); ?>">
                                <span class="ssl-theme-card-loader" aria-hidden="true"></span>
                                <span class="ssl-theme-card-name"><?php echo esc_html( $card['name'] ); ?></span>
                            </div>
                            <div class="ssl-theme-card-info">
                                <h3><?php echo esc_html( $card['name'] ); ?></h3>
                                <?php echo $card['button']; // phpcs:ignore WordPress.Security.EscapeOutput -- pre-escaped HTML. ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Enqueue scripts and styles.
     *
     * @param string $hook The current admin page hook.
     */
    public function spiraclethemes_site_library_enqueue_scripts( $hook ) {
        $allowed_hooks = [ 'toplevel_page_ssl-settings', 'spiraclethemes-site-library_page_ssl-get-started' ];
        if ( ! in_array( $hook, $allowed_hooks, true ) ) {
            return;
        }

        $admin_css_path = SPIR_SITE_LIBRARY_PATH . '/admin/assets/css/admin.css';
        wp_enqueue_style(
            'ssl-admin',
            plugins_url( '/assets/css/admin.css', __FILE__ ),
            [],
            (string) filemtime( $admin_css_path )
        );

        // Load the theme screenshot loader on the Get Started page.
        if ( 'spiraclethemes-site-library_page_ssl-get-started' === $hook ) {
            wp_enqueue_script(
                'ssl-get-started',
                plugins_url( '/assets/js/get-started.js', __FILE__ ),
                [ 'jquery' ],
                self::VERSION,
                true
            );
            wp_localize_script(
                'ssl-get-started',
                'ssl_get_started',
                [
                    'ajax_url'      => esc_url_raw( admin_url( 'admin-ajax.php' ) ),
                    'nonce'         => wp_create_nonce( 'ssl_get_theme_screenshot_nonce' ),
                    'install_nonce' => wp_create_nonce( 'ssl_install_theme_nonce' ),
                    'dashboard_url' => esc_url_raw( admin_url() ),
                ]
            );
            return;
        }

        $toggle_css_path = SPIR_SITE_LIBRARY_PATH . '/admin/assets/css/toggle-switch.css';
        wp_enqueue_style(
            'ssl-toggle-switch',
            plugins_url( '/assets/css/toggle-switch.css', __FILE__ ),
            [],
            (string) filemtime( $toggle_css_path )
        );
        wp_enqueue_script(
            'ssl-admin-plugin-settings-js',
            plugins_url( '/assets/js/admin-plugin-settings.js', __FILE__ ),
            [ 'jquery', 'jquery-ui-tabs' ],
            self::VERSION,
            true
        );
        wp_localize_script(
            'ssl-admin-plugin-settings-js',
            'ssl_ajax_object',
            [
                'ajax_url' => esc_url_raw( admin_url( 'admin-ajax.php' ) ),
                'nonce'    => wp_create_nonce( self::NONCE_NAME ),
            ]
        );
    }

    /**
     * Save settings via AJAX.
     *
     */
    public function spiraclethemes_site_library_save_settings() {
        // Verify nonce.
        if ( ! check_ajax_referer( self::NONCE_NAME, 'nonce', false ) ) {
            wp_send_json_error(
                [ 'message' => esc_html__( 'Invalid nonce', 'spiraclethemes-site-library' ), 'code' => 'invalid_nonce' ],
                403
            );
        }

        // Check user permissions.
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error(
                [ 'message' => esc_html__( 'Unauthorized user', 'spiraclethemes-site-library' ), 'code' => 'unauthorized' ],
                403
            );
        }

        // Validate and sanitize POST data.
        $demo_import      = isset( $_POST['ssl_enable_demo_import'] ) ? absint( $_POST['ssl_enable_demo_import'] ) : 0;

        // Ensure values are 0 or 1.
        $demo_import     = in_array( $demo_import, [ 0, 1 ], true ) ? $demo_import : 0;

        // Update options using WordPress API.
        update_option( 'ssl_enable_demo_import', $demo_import, true );

        // Verify saved values.
        $saved_demo_import     = (int) get_option( 'ssl_enable_demo_import', 1 );

        if ( $saved_demo_import === $demo_import ) {
            wp_send_json_success( [
                'message'         => esc_html__( 'Settings saved successfully', 'spiraclethemes-site-library' ),
                'demo_import'     => $demo_import,
            ] );
        } else {
            wp_send_json_error( [
                'message'  => esc_html__( 'Failed to verify saved settings', 'spiraclethemes-site-library' ),
                'code'     => 'verification_error',
                'expected' => [ 'demo_import' => $demo_import ],
                'actual'   => [ 'demo_import' => $saved_demo_import ],
            ], 500 );
        }
    }

    /**
     * AJAX handler that returns a theme's wordpress.org screenshot URL.
     *
     */
    public function spiraclethemes_site_library_get_theme_screenshot_ajax() {
        check_ajax_referer( 'ssl_get_theme_screenshot_nonce', 'nonce' );

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( [ 'message' => esc_html__( 'Unauthorized user', 'spiraclethemes-site-library' ) ], 403 );
        }

        $slug = isset( $_POST['slug'] ) ? sanitize_key( wp_unslash( $_POST['slug'] ) ) : '';
        if ( '' === $slug || ! in_array( $slug, spiraclethemes_site_library_get_allowed_themes(), true ) ) {
            wp_send_json_error( [ 'message' => esc_html__( 'Invalid theme slug', 'spiraclethemes-site-library' ) ], 400 );
        }

        $cache_key = 'ssl_theme_screenshot_' . $slug;
        $cached    = get_transient( $cache_key );

        if ( false !== $cached ) {
            wp_send_json_success( [ 'screenshot' => (string) $cached ] );
        }

        $response = wp_remote_get(
            'https://api.wordpress.org/themes/info/1.2/?action=theme_information&request[slug]=' . rawurlencode( $slug ),
            [ 'timeout' => 10 ]
        );

        $screenshot = '';
        if ( ! is_wp_error( $response ) && 200 === (int) wp_remote_retrieve_response_code( $response ) ) {
            $data = json_decode( wp_remote_retrieve_body( $response ), true );
            if ( ! empty( $data['screenshot_url'] ) ) {
                $screenshot = esc_url_raw( $data['screenshot_url'] );
            }
        }

        // Cache the result
        set_transient( $cache_key, $screenshot, DAY_IN_SECONDS );

        wp_send_json_success( [ 'screenshot' => $screenshot ] );
    }

    /**
     * AJAX handler that installs and activates a supported theme.
     */
    public function spiraclethemes_site_library_install_theme_ajax() {
        check_ajax_referer( 'ssl_install_theme_nonce', 'nonce' );

        if ( ! current_user_can( 'install_themes' ) || ! current_user_can( 'switch_themes' ) ) {
            wp_send_json_error( [ 'message' => esc_html__( 'Unauthorized user', 'spiraclethemes-site-library' ) ], 403 );
        }

        $slug = isset( $_POST['slug'] ) ? sanitize_key( wp_unslash( $_POST['slug'] ) ) : '';
        if ( '' === $slug || ! in_array( $slug, spiraclethemes_site_library_get_allowed_themes(), true ) ) {
            wp_send_json_error( [ 'message' => esc_html__( 'Invalid theme slug', 'spiraclethemes-site-library' ) ], 400 );
        }

        // Already installed — just activate it.
        if ( wp_get_theme( $slug )->exists() ) {
            switch_theme( $slug );
            wp_send_json_success( [
                'message'  => esc_html__( 'Theme activated', 'spiraclethemes-site-library' ),
                'redirect' => esc_url_raw( admin_url() ),
            ] );
        }

        // Load the upgrade/install API and dependencies.
        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        require_once ABSPATH . 'wp-admin/includes/theme.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';

        $skin     = new \WP_Ajax_Upgrader_Skin();
        $upgrader = new \Theme_Upgrader( $skin );
        $result   = $upgrader->install( 'https://downloads.wordpress.org/theme/' . $slug . '.zip' );

        if ( is_wp_error( $result ) ) {
            wp_send_json_error( [ 'message' => $result->get_error_message() ], 500 );
        }

        if ( ! $result ) {
            $error_message = $skin->get_upgrade_messages();
            wp_send_json_error(
                [ 'message' => ! empty( $error_message ) ? implode( ' ', $error_message ) : esc_html__( 'Theme installation failed', 'spiraclethemes-site-library' ) ],
                500
            );
        }

        // Activate the newly installed theme.
        switch_theme( $slug );
        wp_send_json_success( [
            'message'  => esc_html__( 'Theme installed and activated', 'spiraclethemes-site-library' ),
            'redirect' => esc_url_raw( admin_url() ),
        ] );
    }

    /**
     * Display settings pages.
     */
    public function spiraclethemes_site_library_display_settings_pages() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die(
                esc_html__( 'You do not have permission to access this page.', 'spiraclethemes-site-library' ),
                esc_html__( 'Permission Denied', 'spiraclethemes-site-library' ),
                [ 'response' => 403 ]
            );
        }

        $plugins        = get_plugins();
        $plugin_version = '';

        foreach ( $plugins as $plugin_info ) {
            if ( 'Spiraclethemes Site Library' === sanitize_text_field( $plugin_info['Name'] ) ) {
                $plugin_version = sanitize_text_field( $plugin_info['Version'] );
                break;
            }
        }
        ?>
        <div class="wrap ssl-admin-wrap">
            <div class="response-wrap"></div>
            <form action="" method="POST" id="ssl-settings" name="ssl-settings">
                <?php wp_nonce_field( self::NONCE_NAME, self::NONCE_NAME ); ?>

                <!-- Page Header -->
                <div class="ssl-hero-header">
                    <div class="ssl-hero-inner">
                        <div class="ssl-hero-text">
                            <h1><?php esc_html_e( 'Spiraclethemes Site Library', 'spiraclethemes-site-library' ); ?></h1>
                            <p><?php esc_html_e( 'One-click demo import, starter templates & theme customization', 'spiraclethemes-site-library' ); ?></p>
                        </div>
                        <div class="ssl-hero-version">
                            <span class="ssl-version-badge"><?php echo esc_html( $plugin_version ); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <div class="ssl-settings-tabs">
                    <ul class="ssl-settings-tabs-list">
                        <li>
                            <a class="ssl-tab-list-item" href="#ssl-about">
                                <?php esc_html_e( 'About', 'spiraclethemes-site-library' ); ?>
                            </a>
                        </li>
                        <li>
                            <a class="ssl-tab-list-item" href="#ssl-info">
                                <?php esc_html_e( 'System Info', 'spiraclethemes-site-library' ); ?>
                            </a>
                        </li>
                        <li>
                            <a class="ssl-tab-list-item" href="#ssl-settings-panel">
                                <?php esc_html_e( 'Settings', 'spiraclethemes-site-library' ); ?>
                            </a>
                        </li>
                    </ul>

                    <!-- About Tab -->
                    <div id="ssl-about" class="ssl-settings-tab">
                        <div class="ssl-about-grid">
                            <div class="ssl-about-card ssl-about-card-main">
                                <div class="ssl-about-card-icon">
                                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                                </div>
                                <h3><?php esc_html_e( 'Spiraclethemes Site Library', 'spiraclethemes-site-library' ); ?></h3>
                                <p><?php esc_html_e( 'A powerful plugin by Spiracle Themes that adds one-click demo import, theme customization, starter templates, and page builder support to its free themes.', 'spiraclethemes-site-library' ); ?></p>
                                <a href="<?php echo esc_url( 'https://spiraclethemes.com/' ); ?>" target="_blank" class="ssl-about-link">
                                    <?php esc_html_e( 'Visit Spiraclethemes', 'spiraclethemes-site-library' ); ?>
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17L17 7"/><path d="M7 7h10v10"/></svg>
                                </a>
                            </div>
                            <div class="ssl-about-card">
                                <div class="ssl-about-card-icon ssl-icon-import">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                </div>
                                <h4><?php esc_html_e( 'One-Click Demo Import', 'spiraclethemes-site-library' ); ?></h4>
                                <p><?php esc_html_e( 'Import complete theme demos with content, widgets, and settings in a single click.', 'spiraclethemes-site-library' ); ?></p>
                            </div>
                            <div class="ssl-about-card">
                                <div class="ssl-about-card-icon ssl-icon-templates">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                                </div>
                                <h4><?php esc_html_e( 'Starter Templates', 'spiraclethemes-site-library' ); ?></h4>
                                <p><?php esc_html_e( 'Ready-to-use templates for various niches — business, shop, blog, and more.', 'spiraclethemes-site-library' ); ?></p>
                            </div>
                            <div class="ssl-about-card">
                                <div class="ssl-about-card-icon ssl-icon-customize">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                                </div>
                                <h4><?php esc_html_e( 'Theme Customization', 'spiraclethemes-site-library' ); ?></h4>
                                <p><?php esc_html_e( 'Fine-tune every aspect of your theme with powerful customization options.', 'spiraclethemes-site-library' ); ?></p>
                            </div>
                            <div class="ssl-about-card">
                                <div class="ssl-about-card-icon ssl-icon-builder">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
                                </div>
                                <h4><?php esc_html_e( 'Page Builder Support', 'spiraclethemes-site-library' ); ?></h4>
                                <p><?php esc_html_e( 'Seamless integration with Elementor page builder.', 'spiraclethemes-site-library' ); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- System Info Tab -->
                    <div id="ssl-info" class="ssl-settings-tab">
                        <div class="ssl-section-header">
                            <div>
                                <h3><?php esc_html_e( 'System Information', 'spiraclethemes-site-library' ); ?></h3>
                                <p class="ssl-section-desc"><?php esc_html_e( 'System setup information useful for debugging purposes.', 'spiraclethemes-site-library' ); ?></p>
                            </div>
                        </div>
                        <?php echo wp_kses_post( spiraclethemes_site_library_get_sysinfo() ); ?>
                    </div>

                    <!-- Settings Tab -->
                    <div id="ssl-settings-panel" class="ssl-settings-tab">
                        <div class="ssl-section-header">
                            <div>
                                <h3><?php esc_html_e( 'Plugin Settings', 'spiraclethemes-site-library' ); ?></h3>
                                <p class="ssl-section-desc"><?php esc_html_e( 'Configure plugin features and behavior.', 'spiraclethemes-site-library' ); ?></p>
                            </div>
                        </div>
                        <div class="ssl-system-settings-container">
                            <?php
                            $ssl_settings_html = spiraclethemes_site_library_get_syssettings();
                            $ssl_allowed = array(
                                'div'    => array( 'class' => true, 'id' => true ),
                                'label'  => array( 'class' => true, 'for' => true, 'id' => true ),
                                'input'  => array(
                                    'type'    => true,
                                    'id'      => true,
                                    'name'    => true,
                                    'value'   => true,
                                    'checked' => true,
                                    'class'   => true,
                                    'disabled' => true,
                                ),
                                'span'   => array( 'class' => true, 'data-on' => true, 'data-off' => true ),
                                'h4'     => array( 'class' => true ),
                                'p'      => array( 'class' => true ),
                                'svg'    => array(
                                    'width' => true, 'height' => true,
                                    'viewbox' => true, 'viewBox' => true,
                                    'fill' => true, 'stroke' => true, 'stroke-width' => true,
                                    'stroke-linecap' => true, 'stroke-linejoin' => true,
                                    'class' => true,
                                    'xmlns' => true,
                                ),
                                'path'     => array( 'd' => true, 'fill' => true, 'stroke' => true ),
                                'polyline' => array( 'points' => true, 'fill' => true, 'stroke' => true ),
                                'line'     => array( 'x1' => true, 'y1' => true, 'x2' => true, 'y2' => true ),
                                'circle'   => array( 'cx' => true, 'cy' => true, 'r' => true ),
                                'rect'     => array( 'x' => true, 'y' => true, 'width' => true, 'height' => true, 'rx' => true, 'ry' => true ),
                                'polygon'  => array( 'points' => true, 'fill' => true, 'stroke' => true ),
                            );
                            echo wp_kses( $ssl_settings_html, $ssl_allowed );
                            ?>
                            <div class="ssl-save-settings-wrap">
                                <button type="submit" class="ssl-save-btn" id="submit" name="submit">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                                    <?php esc_html_e( 'Save Changes', 'spiraclethemes-site-library' ); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <?php
    }
}

new Spiraclethemes_site_library_Admin();
