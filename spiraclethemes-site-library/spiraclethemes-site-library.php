<?php
/**
 * Plugin Name:       Spiraclethemes Site Library
 * Plugin URI:        https://wordpress.org/plugins/spiraclethemes-site-library/
 * Description:       A plugin made by spiraclethemes.com to extends its free themes features by adding functionality to import demo data content in just a click.
 * Version:           1.3.8
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
    }

    public function __construct() {
        require_once SPIR_SITE_LIBRARY_PATH . 'vendor/admin-notices/AdminNotice.php';
        require_once SPIR_SITE_LIBRARY_PATH . 'vendor/ocdi/one-click-demo-import.php';

        $theme = wp_get_theme();
        $this->theme_name    = $theme->get( 'Name' );
        $this->theme_slug    = $theme->get( 'TextDomain' );
        $this->theme_version = $theme->get( 'Version' );
        $this->notification  = sprintf(
            '<p>%1$s <a href="%2$s" class="button" style="text-decoration: none;">%3$s</a></p>',
            esc_html__( 'Kickstart your WordPress website with our free demo starter templates, tailored for this theme.', 'spiraclethemes-site-library' ),
            esc_url( admin_url( 'themes.php?page=one-click-demo-import' ) ),
            esc_html__( 'Start Importing Templates', 'spiraclethemes-site-library' )
        );

        if ( is_admin() ) {
            add_action( 'admin_notices', [ $this, 'spiraclethemes_site_library_display_welcome_notice' ] );
            add_action( 'admin_notices', [ $this, 'spiraclethemes_site_library_display_training_notice' ] );
            add_action( 'admin_notices', [ $this, 'spiraclethemes_site_library_display_custom_website_notice' ] );
            add_action( 'admin_init', [ $this, 'spiraclethemes_site_library_ignore_rating_notice' ] );
            add_action( 'admin_init', [ $this, 'spiraclethemes_site_library_ignore_training_notice' ] );
            add_action( 'admin_init', [ $this, 'spiraclethemes_site_library_ignore_custom_website_notice' ] );
        }
    }

    // spiraclethemes site library functions
    function spiraclethemes_site_library_functions() {
        require_once SPIR_SITE_LIBRARY_PATH . '/inc/themes.php';
        require_once SPIR_SITE_LIBRARY_PATH . '/inc/widget/widget.php';
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

    // Display the welcome notice
    public function spiraclethemes_site_library_display_welcome_notice() {
        if ( ! empty( $this->notification ) ) {
            AdminNotice::create( 'spiraclethemes-site-library-notice' )
                ->persistentlyDismissible( AdminNotice::DISMISS_PER_SITE )
                ->success( $this->notification )
                ->show();
        }

        $install_date = get_option( 'spiraclethemes_sitelib_install_date' );
        if ( strtotime( '+7 days', strtotime( $install_date ) ) > time() ) {
            return;
        }

        global $current_user;
        $user_id = $current_user->ID;
        if ( ! get_user_meta( $user_id, 'spiraclethemes_sitelib_rating_ignore_notice' ) ) {
            $rating_url    = esc_url( 'https://wordpress.org/support/theme/' . $this->theme_slug . '/reviews/?filter=5' );
            $ignore_url    = esc_url( admin_url( 'themes.php?wp_spiraclethemes_sitelib_rating_ignore=0' ) );
            $theme_info_url = esc_url( admin_url( 'themes.php' ) );

            echo '<div class="notice updated" style="padding: 15px;">';
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

    // Display the training notice
    public function spiraclethemes_site_library_display_training_notice() {
        global $current_user;
        $user_id = $current_user->ID;

        if ( ! get_user_meta( $user_id, 'spiraclethemes_sitelib_training_ignore_notice' ) ) {
            $training_url = esc_url( 'https://livetrainingwp.com/contact/' );
            $ignore_url   = esc_url( admin_url( 'themes.php?wp_spiraclethemes_sitelib_training_ignore=0' ) );

            echo '<div class="notice updated" style="padding: 15px;">';
            printf(
                esc_html__( 'Welcome to WordPress and thanks for installing our theme! 🎉 New to WordPress? We offer 1-on-1 live training to guide you.', 'spiraclethemes-site-library' ) .
                ' <a href="%s" target="_blank">%s</a> | <a href="%s">%s</a>',
                $training_url,
                esc_html__( 'Yes, I’m interested!', 'spiraclethemes-site-library' ),
                $ignore_url,
                esc_html__( 'No, thanks', 'spiraclethemes-site-library' )
            );
            echo '</div>';
        }
    }

    // Display the custom website notice
    public function spiraclethemes_site_library_display_custom_website_notice() {
        global $current_user;
        $user_id = $current_user->ID;

        if ( ! get_user_meta( $user_id, 'spiraclethemes_sitelib_custom_website_ignore_notice' ) ) {
            $training_url = esc_url( 'https://spiraclethemes.com/custom-wp/' );
            $ignore_url   = esc_url( admin_url( 'themes.php?wp_spiraclethemes_sitelib_custom_website_ignore=0' ) );

            echo '<div class="notice updated" style="padding: 15px;">';
            printf(
                esc_html__( '✨ Looking someone to design, build, or revamp your WordPress website? 🚀 Get started now for just $299! 💻', 'spiraclethemes-site-library' ) .
                ' <a href="%s" target="_blank">%s</a> | <a href="%s">%s</a>',
                $training_url,
                esc_html__( 'Yes, I’m interested!', 'spiraclethemes-site-library' ),
                $ignore_url,
                esc_html__( 'No, thanks', 'spiraclethemes-site-library' )
            );
            echo '</div>';
        }
    }

    // Ignore the rating notice
    public function spiraclethemes_site_library_ignore_rating_notice() {
        global $current_user;
        $user_id = $current_user->ID;
        if ( isset( $_GET['wp_spiraclethemes_sitelib_rating_ignore'] ) ) {
            add_user_meta( $user_id, 'spiraclethemes_sitelib_rating_ignore_notice', true, true );
        }
    }

    // Ignore the training notice
    public function spiraclethemes_site_library_ignore_training_notice() {
        global $current_user;
        $user_id = $current_user->ID;
        if ( isset( $_GET['wp_spiraclethemes_sitelib_training_ignore'] ) ) {
            add_user_meta( $user_id, 'spiraclethemes_sitelib_training_ignore_notice', true, true );
        }
    }

    // Ignore the custom websit notice
    public function spiraclethemes_site_library_ignore_custom_website_notice() {
        global $current_user;
        $user_id = $current_user->ID;
        if ( isset( $_GET['wp_spiraclethemes_sitelib_custom_website_ignore'] ) ) {
            add_user_meta( $user_id, 'spiraclethemes_sitelib_custom_website_ignore_notice', true, true );
        }
    }
}


// Class Register

if ( class_exists( 'Spiraclethemes_Site_Library' ) ) :
    # code...
    $spiraclethemes_site_library = new Spiraclethemes_Site_Library();
    $spiraclethemes_site_library->spiraclethemes_site_library_register_styles();
    $spiraclethemes_site_library->spiraclethemes_site_library_functions();
    $spiraclethemes_site_library->spiraclethemes_site_library_load_plugin_textdomain();

endif;

// Activation
register_activation_hook( __FILE__, array( $spiraclethemes_site_library, 'activate' ) );
// Deactivation
register_deactivation_hook( __FILE__, array( $spiraclethemes_site_library, 'deactivate' ) );