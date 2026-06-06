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
    const VERSION = '1.6.1';

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
    }

    /**
     * Enqueue scripts and styles.
     *
     * @param string $hook The current admin page hook.
     */
    public function spiraclethemes_site_library_enqueue_scripts( $hook ) {
        if ( 'toplevel_page_ssl-settings' !== $hook ) {
            return;
        }

        wp_enqueue_style(
            'ssl-admin',
            plugins_url( '/assets/css/admin.css', __FILE__ ),
            [],
            self::VERSION
        );
        wp_enqueue_style(
            'ssl-toggle-switch',
            plugins_url( '/assets/css/toggle-switch.css', __FILE__ ),
            [],
            self::VERSION
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
     * Uses WordPress API functions only — no direct DB manipulation needed.
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

                <!-- Hero Header -->
                <div class="ssl-hero-header">
                    <div class="ssl-hero-inner">
                        <div class="ssl-hero-icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                                <path d="M2 17l10 5 10-5"/>
                                <path d="M2 12l10 5 10-5"/>
                            </svg>
                        </div>
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
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                                <?php esc_html_e( 'About', 'spiraclethemes-site-library' ); ?>
                            </a>
                        </li>
                        <li>
                            <a class="ssl-tab-list-item" href="#ssl-info">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                                <?php esc_html_e( 'System Info', 'spiraclethemes-site-library' ); ?>
                            </a>
                        </li>
                        <li>
                            <a class="ssl-tab-list-item" href="#ssl-settings-panel">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
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
                                <p><?php esc_html_e( 'Seamless integration with Elementor and other popular page builders.', 'spiraclethemes-site-library' ); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- System Info Tab -->
                    <div id="ssl-info" class="ssl-settings-tab">
                        <div class="ssl-section-header">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
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
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
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
