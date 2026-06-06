<?php
/**
 * System settings display for Spiraclethemes Site Library plugin.
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get system settings as HTML form table.
 *
 * @return string HTML output of settings form.
 */
function spiraclethemes_site_library_get_syssettings() {
    ob_start();
    ?>
    <div class="ssl-settings-grid">
        <div class="ssl-setting-card">
            <div class="ssl-setting-card-header">
                <div class="ssl-setting-icon ssl-setting-icon-import">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                </div>
                <div class="ssl-setting-info">
                    <h4><?php esc_html_e( 'Demo Import', 'spiraclethemes-site-library' ); ?></h4>
                    <p><?php esc_html_e( 'Enable or disable the one-click demo import feature for your theme.', 'spiraclethemes-site-library' ); ?></p>
                </div>
            </div>
            <div class="ssl-setting-card-control">
                <label class="ssl-toggle-switch" for="ssl_enable_demo_import">
                    <input type="checkbox" id="ssl_enable_demo_import" name="ssl_enable_demo_import" value="1" <?php checked( 1, get_option( 'ssl_enable_demo_import', 1 ), true ); ?> />
                    <span class="ssl-toggle-slider"></span>
                </label>
                <span class="ssl-toggle-label" data-on="<?php esc_attr_e( 'Enabled', 'spiraclethemes-site-library' ); ?>" data-off="<?php esc_attr_e( 'Disabled', 'spiraclethemes-site-library' ); ?>"></span>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
