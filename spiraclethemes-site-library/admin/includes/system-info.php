<?php
/**
 * System information display for Spiraclethemes Site Library plugin.
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get system information as HTML table.
 *
 * @return string HTML output of system info.
 */
function spiraclethemes_site_library_get_sysinfo() {
    global $wpdb;

    $theme_data = wp_get_theme();
    $theme      = esc_html( $theme_data->Name . ' ' . $theme_data->Version );

    ob_start();
    ?>
    <div class="ssl-system-info-container">
        <table class="ssl-system-info-table">
            <tr><th colspan="2"><?php esc_html_e( 'Begin System Info', 'spiraclethemes-site-library' ); ?></th></tr>

            <tr><td colspan="2"><strong><?php esc_html_e( '-- Site Info --', 'spiraclethemes-site-library' ); ?></strong></td></tr>
            <tr><td><?php esc_html_e( 'Site URL:', 'spiraclethemes-site-library' ); ?></td><td><?php echo esc_url( site_url() ); ?></td></tr>
            <tr><td><?php esc_html_e( 'Home URL:', 'spiraclethemes-site-library' ); ?></td><td><?php echo esc_url( home_url() ); ?></td></tr>
            <tr><td><?php esc_html_e( 'Multisite:', 'spiraclethemes-site-library' ); ?></td><td><?php echo esc_html( is_multisite() ? 'Yes' : 'No' ); ?></td></tr>

            <tr><td colspan="2"><strong><?php esc_html_e( '-- WordPress Configuration --', 'spiraclethemes-site-library' ); ?></strong></td></tr>
            <tr><td><?php esc_html_e( 'Version:', 'spiraclethemes-site-library' ); ?></td><td><?php echo esc_html( get_bloginfo( 'version' ) ); ?></td></tr>
            <tr><td><?php esc_html_e( 'Language:', 'spiraclethemes-site-library' ); ?></td><td><?php echo esc_html( get_bloginfo( 'language' ) ); ?></td></tr>
            <tr><td><?php esc_html_e( 'Permalink Structure:', 'spiraclethemes-site-library' ); ?></td><td><?php echo esc_html( get_option( 'permalink_structure', 'Default' ) ); ?></td></tr>
            <tr><td><?php esc_html_e( 'Active Theme:', 'spiraclethemes-site-library' ); ?></td><td><?php echo esc_html( $theme ); ?></td></tr>

            <tr><td colspan="2"><strong><?php esc_html_e( '-- WordPress Plugins --', 'spiraclethemes-site-library' ); ?></strong></td></tr>
            <?php
            $plugins = get_plugins();
            foreach ( $plugins as $plugin ) {
                echo '<tr><td>' . esc_html( $plugin['Name'] ) . ':</td><td>' . esc_html( $plugin['Version'] ) . '</td></tr>';
            }
            ?>

            <tr><td colspan="2"><strong><?php esc_html_e( '-- Webserver Configuration --', 'spiraclethemes-site-library' ); ?></strong></td></tr>
            <tr><td><?php esc_html_e( 'PHP Version:', 'spiraclethemes-site-library' ); ?></td><td><?php echo esc_html( PHP_VERSION ); ?></td></tr>
            <tr><td><?php esc_html_e( 'MySQL Version:', 'spiraclethemes-site-library' ); ?></td><td><?php echo esc_html( $wpdb->db_version() ); ?></td></tr>
            <tr>
                <td><?php esc_html_e( 'Webserver Info:', 'spiraclethemes-site-library' ); ?></td>
                <td><?php echo esc_html( isset( $_SERVER['SERVER_SOFTWARE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ) : 'N/A' ); ?></td>
            </tr>

            <tr><td colspan="2"><strong><?php esc_html_e( '-- PHP Configuration --', 'spiraclethemes-site-library' ); ?></strong></td></tr>
            <tr><td><?php esc_html_e( 'Memory Limit:', 'spiraclethemes-site-library' ); ?></td><td><?php echo esc_html( ini_get( 'memory_limit' ) ); ?></td></tr>
            <tr><td><?php esc_html_e( 'Upload Max Size:', 'spiraclethemes-site-library' ); ?></td><td><?php echo esc_html( ini_get( 'upload_max_filesize' ) ); ?></td></tr>
            <tr><td><?php esc_html_e( 'Post Max Size:', 'spiraclethemes-site-library' ); ?></td><td><?php echo esc_html( ini_get( 'post_max_size' ) ); ?></td></tr>
            <tr><td><?php esc_html_e( 'Time Limit:', 'spiraclethemes-site-library' ); ?></td><td><?php echo esc_html( ini_get( 'max_execution_time' ) ); ?></td></tr>
            <tr><td><?php esc_html_e( 'Max Input Vars:', 'spiraclethemes-site-library' ); ?></td><td><?php echo esc_html( ini_get( 'max_input_vars' ) ); ?></td></tr>
            <tr>
                <td><?php esc_html_e( 'Display Errors:', 'spiraclethemes-site-library' ); ?></td>
                <td><?php echo esc_html( ini_get( 'display_errors' ) ? 'On (' . ini_get( 'display_errors' ) . ')' : 'N/A' ); ?></td>
            </tr>

            <tr><td colspan="2"><strong><?php esc_html_e( '-- PHP Extensions --', 'spiraclethemes-site-library' ); ?></strong></td></tr>
            <tr><td><?php esc_html_e( 'cURL:', 'spiraclethemes-site-library' ); ?></td><td><?php echo esc_html( function_exists( 'curl_init' ) ? 'Supported' : 'Not Supported' ); ?></td></tr>
            <tr><td><?php esc_html_e( 'fsockopen:', 'spiraclethemes-site-library' ); ?></td><td><?php echo esc_html( function_exists( 'fsockopen' ) ? 'Supported' : 'Not Supported' ); ?></td></tr>
            <tr><td><?php esc_html_e( 'SOAP Client:', 'spiraclethemes-site-library' ); ?></td><td><?php echo esc_html( class_exists( 'SoapClient' ) ? 'Installed' : 'Not Installed' ); ?></td></tr>
            <tr><td><?php esc_html_e( 'Suhosin:', 'spiraclethemes-site-library' ); ?></td><td><?php echo esc_html( extension_loaded( 'suhosin' ) ? 'Installed' : 'Not Installed' ); ?></td></tr>

            <tr><th colspan="2"><?php esc_html_e( 'End System Info', 'spiraclethemes-site-library' ); ?></th></tr>
        </table>
    </div>
    <?php

    return ob_get_clean();
}
