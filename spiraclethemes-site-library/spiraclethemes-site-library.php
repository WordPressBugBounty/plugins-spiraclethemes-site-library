<?php
/**
 * Plugin Name:       Spiraclethemes Site Library
 * Plugin URI:        https://wordpress.org/plugins/spiraclethemes-site-library/
 * Description:       A plugin by Spiracle Themes that adds one-click demo import, theme customization, starter templates, and page builder support to its free themes.
 * Version:           1.5.7
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

// Define constants
$constants = [
    'SPIR_SITE_LIBRARY_FILE'     => __FILE__,
    'SPIR_SITE_LIBRARY_URL'      => plugins_url( '/', __FILE__ ),
    'SPIR_SITE_LIBRARY_DIR_URL'  => plugin_dir_url( __FILE__ ),
    'SPIR_SITE_LIBRARY_PATH'     => plugin_dir_path( __FILE__ ),
];

foreach ( $constants as $key => $value ) {
    if ( ! defined( $key ) ) {
        define( $key, $value );
    }
}

use \YeEasyAdminNotices\V1\AdminNotice;

class Spiraclethemes_Site_Library {
    private $theme_name;
    private $theme_slug;
    private $theme_version;
    private $notification;

    // Activate
    public function activate() {
        add_option( 'spiraclethemes_sitelib_install_date', current_time( 'mysql' ), '', 'yes' );
    }

    // Deactivate
    public function deactivate() {
        global $current_user;
        $user_id = $current_user->ID;
        AdminNotice::cleanUpDatabase( 'spiraclethemes-site-library-' );
        delete_option( 'spiraclethemes_sitelib_install_date' );
        delete_user_meta( $user_id, 'spiraclethemes_sitelib_rating_ignore_notice' );
        delete_user_meta( $user_id, 'spiraclethemes_sitelib_training_ignore_notice' );
        // Clean up new $3/month plan notice meta keys
        delete_user_meta( $user_id, 'spiraclethemes_sitelib_3dollar_0day_notice' );
        delete_user_meta( $user_id, 'spiraclethemes_sitelib_3dollar_7day_notice' );
        delete_user_meta( $user_id, 'spiraclethemes_sitelib_3dollar_14day_notice' );
        delete_user_meta( $user_id, 'spiraclethemes_sitelib_3dollar_28day_notice' );
        delete_user_meta( $user_id, 'spiraclethemes_sitelib_3dollar_60day_notice' );
    }

    public function __construct() {
        
        if ("1" === get_option('ssl_disable_demo_import')) {
            require_once SPIR_SITE_LIBRARY_PATH . 'vendor/ocdi/one-click-demo-import.php';
        }
        require_once SPIR_SITE_LIBRARY_PATH . 'vendor/admin-notices/AdminNotice.php';

        $theme = wp_get_theme();
        $this->theme_name    = $theme->get( 'Name' );
        $this->theme_slug    = $theme->get( 'TextDomain' );
        $this->theme_version = $theme->get( 'Version' );

        // Define allowed Spiraclethemes theme slugs
        $allowed_themes = [
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
            'krystal-shop'
        ];

        if (is_admin() && in_array($this->theme_slug, $allowed_themes)) {
            add_action( 'admin_init', [ $this, 'spiraclethemes_site_library_set_notification' ] );
            add_action( 'admin_notices', [ $this, 'spiraclethemes_site_library_display_welcome_notice' ] );
            add_action( 'admin_notices', [ $this, 'spiraclethemes_site_library_display_3dollar_notices' ] );
            add_action( 'admin_init', [ $this, 'spiraclethemes_site_library_ignore_rating_notice' ] );
            add_action( 'admin_init', [ $this, 'spiraclethemes_site_library_ignore_3dollar_notices' ] );
        }
        add_action('init', [ $this, 'spiraclethemes_site_library_load_plugin_textdomain' ] );
    }

    // function to set notification after init
    public function spiraclethemes_site_library_set_notification() {
        $raw_html = sprintf(
            '<p>%1$s <a href="%2$s" class="button" style="text-decoration: none;">%3$s</a></p>',
            esc_html__( 'Kickstart your WordPress website with our free demo starter templates, tailored for this theme.', 'spiraclethemes-site-library' ),
            esc_url( admin_url( 'themes.php?page=one-click-demo-import' ) ),
            esc_html__( 'Start Importing Templates', 'spiraclethemes-site-library' )
        );

        $this->notification = wp_kses( $raw_html, [
            'p' => [],
            'a' => [
                'href' => [],
                'class' => [],
                'style' => [],
                'target' => [],
                'rel' => [],
            ]
        ]);
    }

    // spiraclethemes site library functions
    function spiraclethemes_site_library_functions() {
        if ("1" === get_option('ssl_disable_demo_import')) {
            require_once SPIR_SITE_LIBRARY_PATH . '/inc/themes.php';
        }
        require_once SPIR_SITE_LIBRARY_PATH . '/inc/widget/widget.php';
        //Admin init
        require_once SPIR_SITE_LIBRARY_PATH . '/admin/admin-init.php';
        // System Info
        require_once SPIR_SITE_LIBRARY_PATH . '/admin/includes/system-info.php';
        // System Settings
        require_once SPIR_SITE_LIBRARY_PATH . '/admin/includes/system-settings.php';
    }

    //register styles
    function spiraclethemes_site_library_register_styles() {
       add_action( 'admin_enqueue_scripts', array( $this, 'spiraclethemes_site_library_admin_styles' ), 0 );
    }

    // Admin styles include
    function spiraclethemes_site_library_admin_styles() {
        // Main css
        wp_enqueue_style( 'spiraclethemes-site-library-main', plugins_url( '/css/main.css', __FILE__ ) );
    }
    
    //Load plugin text domain
    function spiraclethemes_site_library_load_plugin_textdomain() {
        load_plugin_textdomain('spiraclethemes-site-library', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }

    private function spiraclethemes_site_library_get_days_since_install() {
        $install_date = get_option( 'spiraclethemes_sitelib_install_date' );
        if ( ! $install_date ) return 0;

        $install_timestamp = strtotime( $install_date );
        return ( time() - $install_timestamp ) / DAY_IN_SECONDS;
    }


    // Reusable method to check if notice should be shown
    private function spiraclethemes_site_library_should_display_notice( $ignore_key, $days_after_install ) {

        $install_date = get_option( 'spiraclethemes_sitelib_install_date' );
        if ( strtotime( "+$days_after_install days", strtotime( $install_date ) ) > time() ) {
            return false;
        }

        $user_id = get_current_user_id();
        return ! get_user_meta( $user_id, $ignore_key, true );
    }

    // Reusable method to display a notice
    private function spiraclethemes_site_library_display_custom_notice( $message ) {
        echo '<div class="notice updated ssl-pro-upgrade-notice">';
        // Generate 6 balloons for each of the 5 positions
        for ($pos = 1; $pos <= 5; $pos++) {
            for ($i = 0; $i < 6; $i++) {
                echo '<div class="balloon pos-' . $pos . '"></div>';
            }
        }
        echo '<div class="notice-content">' . wp_kses_post( $message ) . '</div>';
        echo '</div>';
    }

    // Reusable method to build $3/month plan notice message
    private function spiraclethemes_site_library_build_3dollar_notice( $days, $ignore_param, $theme_name ) {
        $pricing_url = esc_url( 'https://spiraclethemes.com/pricing/' );
        
        // Convert theme name to title case and append "Pro"
        $theme_pro_name = ucwords( $theme_name ) . ' Pro';
        
        // For all notices, use "Remind me later" option
        $ignore_url = esc_url( wp_nonce_url( admin_url( 'themes.php?' . $ignore_param . '=0' ), $ignore_param . '_nonce' ) );
        $message = __( '🎉 Special Offer! %3$s now at just <span style="background: #319942; padding: 4px 8px; border-radius: 25px; color: #fff;"><strong>$3/month</strong></span> <del>$5/month</del> – making Pro accessible to all! Visit <a href="%1$s" target="_blank">our pricing page</a> to learn more. <a href="%2$s">Remind me later</a>', 'spiraclethemes-site-library' );
        return sprintf( wp_kses_post( $message ), $pricing_url, $ignore_url, $theme_pro_name );
    }



    // Welcome notice
    public function spiraclethemes_site_library_display_welcome_notice() {
        $days_since = $this->spiraclethemes_site_library_get_days_since_install();
        $user_id = get_current_user_id();
        
        // Show Import CTA during first 7 days
        if ( $days_since < 7 && ! empty( $this->notification ) ) {
            AdminNotice::create( 'spiraclethemes-site-library-notice' )
                ->persistentlyDismissible( AdminNotice::DISMISS_PER_SITE )
                ->success( $this->notification )
                ->show();
        }
        
        // Show rating notice after 7 days, but only if $3/month notices haven't been shown
        $should_show_rating = true;
        $notice_schedule = [
            ['days' => 0, 'key' => 'spiraclethemes_sitelib_3dollar_0day_notice'],
            ['days' => 7, 'key' => 'spiraclethemes_sitelib_3dollar_7day_notice'],
            ['days' => 14, 'key' => 'spiraclethemes_sitelib_3dollar_14day_notice'],
            ['days' => 28, 'key' => 'spiraclethemes_sitelib_3dollar_28day_notice'],
            ['days' => 60, 'key' => 'spiraclethemes_sitelib_3dollar_60day_notice']
        ];
        
        // Check if any $3/month notices have been shown or should be shown
        foreach ($notice_schedule as $notice) {
            if ($days_since >= $notice['days']) {
                $dismissal_data = get_user_meta($user_id, $notice['key'], true);
                if (!empty($dismissal_data)) {
                    $should_show_rating = false;
                    break;
                }
            }
        }
        
        // Show rating notice after 7 days if no $3/month notices have been shown
        if ( $should_show_rating && $days_since >= 7 && $this->spiraclethemes_site_library_should_display_notice( 'spiraclethemes_sitelib_rating_ignore_notice', 7 ) ) {
            $theme_info_url = esc_url( admin_url( 'themes.php' ) );
            $rating_url = esc_url( 'https://wordpress.org/support/theme/' . $this->theme_slug . '/reviews/?filter=5' );
            $ignore_url = esc_url( wp_nonce_url( admin_url( 'themes.php?wp_spiraclethemes_sitelib_rating_ignore=0' ), 'wp_spiraclethemes_sitelib_rating_ignore_nonce' ) );

            echo '<div class="notice updated ssl-notice">';
            printf(
                esc_html__( 'Awesome, you\'ve been using %s for over a week! Please consider giving us a 5-star review.', 'spiraclethemes-site-library' ) .
                ' <a href="%s" target="_blank">%s</a> | <a href="%s">%s</a>',
                '<a href="' . $theme_info_url . '">' . esc_html( $this->theme_name ) . '</a>',
                $rating_url,
                esc_html__( 'Ok, you deserved it!', 'spiraclethemes-site-library' ),
                $ignore_url,
                esc_html__( 'No, thanks', 'spiraclethemes-site-library' )
            );
            echo '</div>';
        }
    }


    // Reusable method to check if $3/month plan notice should be shown
    private function spiraclethemes_site_library_should_display_3dollar_notice( $ignore_key, $days_after_install, $is_permanent = false ) {
        $install_date = get_option( 'spiraclethemes_sitelib_install_date' );
        if ( strtotime( "+$days_after_install days", strtotime( $install_date ) ) > time() ) {
            return false;
        }

        $user_id = get_current_user_id();
        $dismissal_data = get_user_meta( $user_id, $ignore_key, true );
        
        // If no dismissal data, show the notice
        if ( empty( $dismissal_data ) ) {
            return true;
        }
        
        // If permanent dismissal, never show again
        if ( $is_permanent ) {
            return false;
        }
        
        // For temporary dismissal, check if it's time to remind again
        $reminder_time = intval( $dismissal_data );
        return time() >= $reminder_time;
    }

    // $3/month plan notices - single function to determine which notice to show
    public function spiraclethemes_site_library_display_3dollar_notices() {
        $days_since = $this->spiraclethemes_site_library_get_days_since_install();
        $user_id = get_current_user_id();
        
        // Define notice schedule
        $notice_schedule = [
            ['days' => 0, 'key' => 'spiraclethemes_sitelib_3dollar_0day_notice'],
            ['days' => 7, 'key' => 'spiraclethemes_sitelib_3dollar_7day_notice'],
            ['days' => 14, 'key' => 'spiraclethemes_sitelib_3dollar_14day_notice'],
            ['days' => 28, 'key' => 'spiraclethemes_sitelib_3dollar_28day_notice'],
            ['days' => 60, 'key' => 'spiraclethemes_sitelib_3dollar_60day_notice']
        ];
        
        // Find the most recent applicable notice that hasn't been permanently dismissed
        $notice_to_show = null;
        $notice_index = -1;
        
        for ($i = count($notice_schedule) - 1; $i >= 0; $i--) {
            $notice = $notice_schedule[$i];
            if ($days_since >= $notice['days']) {
                $dismissal_data = get_user_meta($user_id, $notice['key'], true);
                
                // If no dismissal data, this is our notice to show
                if (empty($dismissal_data)) {
                    $notice_to_show = $notice;
                    $notice_index = $i;
                    break;
                }
                
                // If temporary dismissal, check if it's time to remind again
                if (is_numeric($dismissal_data)) {
                    $reminder_time = intval($dismissal_data);
                    if (time() >= $reminder_time) {
                        $notice_to_show = $notice;
                        $notice_index = $i;
                        break;
                    }
                }
                // If permanently dismissed (non-numeric), continue to next notice
            }
        }
        
        // Show the appropriate notice
        if ($notice_to_show) {
            $message = $this->spiraclethemes_site_library_build_3dollar_notice(
                $notice_to_show['days'],
                'wp_spiraclethemes_sitelib_3dollar_ignore',
                $this->theme_name
            );
            $this->spiraclethemes_site_library_display_custom_notice($message);
        }
    }


    // Public ignore handlers for $3/month plan notices
    public function spiraclethemes_site_library_ignore_3dollar_notices() {
        if ( current_user_can( 'manage_options' ) && isset( $_GET['wp_spiraclethemes_sitelib_3dollar_ignore'] ) && isset( $_GET['_wpnonce'] ) ) {
            if ( wp_verify_nonce( sanitize_text_field($_GET['_wpnonce']), 'wp_spiraclethemes_sitelib_3dollar_ignore_nonce' ) ) {
                $user_id = get_current_user_id();
                $days_since = $this->spiraclethemes_site_library_get_days_since_install();
                
                // Define notice schedule
                $notice_schedule = [
                    ['days' => 0, 'key' => 'spiraclethemes_sitelib_3dollar_0day_notice'],
                    ['days' => 7, 'key' => 'spiraclethemes_sitelib_3dollar_7day_notice'],
                    ['days' => 14, 'key' => 'spiraclethemes_sitelib_3dollar_14day_notice'],
                    ['days' => 28, 'key' => 'spiraclethemes_sitelib_3dollar_28day_notice'],
                    ['days' => 60, 'key' => 'spiraclethemes_sitelib_3dollar_60day_notice']
                ];
                
                // Find which notice was dismissed based on days since install
                $dismissed_notice = null;
                for ($i = count($notice_schedule) - 1; $i >= 0; $i--) {
                    if ($days_since >= $notice_schedule[$i]['days']) {
                        $dismissed_notice = $notice_schedule[$i];
                        break;
                    }
                }
                
                if ($dismissed_notice) {
                    // Set reminder time based on notice type
                    if ($dismissed_notice['days'] == 0) {
                        // 0-day notice - remind in 7 days
                        $reminder_time = time() + (7 * DAY_IN_SECONDS);
                    } elseif ($dismissed_notice['days'] == 7) {
                        // 7-day notice - remind in 7 days
                        $reminder_time = time() + (7 * DAY_IN_SECONDS);
                    } elseif ($dismissed_notice['days'] == 14) {
                        // 14-day notice - remind in 14 days
                        $reminder_time = time() + (14 * DAY_IN_SECONDS);
                    } elseif ($dismissed_notice['days'] == 28) {
                        // 28-day notice - remind in 32 days (to show at 60 days)
                        $reminder_time = time() + (32 * DAY_IN_SECONDS);
                    } else {
                        // 60-day notice - permanent dismissal
                        $reminder_time = time() + (365 * DAY_IN_SECONDS); // 1 year from now
                    }
                    
                    update_user_meta($user_id, $dismissed_notice['key'], $reminder_time);
                }
                
                // Redirect to referring page
                wp_safe_redirect( wp_get_referer() ? wp_get_referer() : admin_url() );
                exit;
            }
        }
    }


    // Generic ignore handler
    private function spiraclethemes_site_library_handle_ignore_notice( $param, $meta_key ) {
        if ( current_user_can( 'manage_options' ) && isset( $_GET[ $param ] ) && isset( $_GET['_wpnonce'] ) ) {
            if ( wp_verify_nonce( sanitize_text_field($_GET['_wpnonce']), $param . '_nonce' ) ) {
                $user_id = get_current_user_id();
                add_user_meta( $user_id, sanitize_key( $meta_key ), true, true );
            }
        }
    }

    // Public ignore handlers
    public function spiraclethemes_site_library_ignore_rating_notice() {
        $this->spiraclethemes_site_library_handle_ignore_notice( 'wp_spiraclethemes_sitelib_rating_ignore', 'spiraclethemes_sitelib_rating_ignore_notice' );
    }

}


// Class Register

if ( class_exists( 'Spiraclethemes_Site_Library' ) ) :
    $spiraclethemes_site_library = new Spiraclethemes_Site_Library();
    $spiraclethemes_site_library->spiraclethemes_site_library_register_styles();
    $spiraclethemes_site_library->spiraclethemes_site_library_functions();

endif;

// Activation
register_activation_hook( __FILE__, array( $spiraclethemes_site_library, 'activate' ) );
// Deactivation
register_deactivation_hook( __FILE__, array( $spiraclethemes_site_library, 'deactivate' ) );