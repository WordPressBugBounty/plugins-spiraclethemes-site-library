<?php
/**
 * Spiraclethemes Site Library - Demo Importer Module
 *
 * Custom demo import module that replaces OCDI dependency.
 *
 * @package spiraclethemes-site-library
 * @subpackage inc/demo-importer
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load dependencies.
require_once dirname( __FILE__ ) . '/class-spiracle-demo-import.php';
require_once dirname( __FILE__ ) . '/class-spiracle-content-importer.php';
require_once dirname( __FILE__ ) . '/class-spiracle-customizer-importer.php';
require_once dirname( __FILE__ ) . '/class-spiracle-widget-importer.php';
require_once dirname( __FILE__ ) . '/class-spiracle-plugin-installer.php';

/**
 * Automatically detect the active theme and load its corresponding files.
 *
 * @since 1.6.0
 */
function spiraclethemes_site_library_auto_load_theme_files() {
	// Get the active theme slug (stylesheet directory name — most reliable).
	$theme_slug  = get_option( 'stylesheet' );
	$theme       = wp_get_theme( $theme_slug );
	$parent_slug = $theme->parent() ? $theme->parent()->get_stylesheet() : '';

	// Build a list of slugs to check: child first, then parent.
	$slugs_to_check = array( $theme_slug );
	if ( ! empty( $parent_slug ) && $parent_slug !== $theme_slug ) {
		$slugs_to_check[] = $parent_slug;
	}

	// Sanitize: only allow lowercase alphanumeric + hyphen slugs to prevent
	// path traversal via a manipulated stylesheet option.
	$slugs_to_check = array_filter( $slugs_to_check, function ( $slug ) {
		return is_string( $slug ) && preg_match( '/^[a-z0-9-]+$/', $slug );
	} );

	foreach ( $slugs_to_check as $slug ) {
		// Load theme functions file: inc/theme-functions/{slug}-functions.php
		$functions_file = SPIR_SITE_LIBRARY_PATH . 'inc/theme-functions/' . $slug . '-functions.php';
		if ( file_exists( $functions_file ) ) {
			require_once $functions_file;
			break; // Stop after first match — parent is only a fallback.
		}
	}

	// Load element files for every matching slug (child AND parent can have elements).
	foreach ( $slugs_to_check as $slug ) {
		$element_dir = SPIR_SITE_LIBRARY_PATH . 'elements/' . $slug . '/';

		// Load helper functions: elements/{slug}/helper-functions.php
		$helper_file = $element_dir . 'helper-functions.php';
		if ( file_exists( $helper_file ) ) {
			require_once $helper_file;
		}

		// Load widget category: elements/{slug}/widget-category.php
		$widget_cat_file = $element_dir . 'widget-category.php';
		if ( file_exists( $widget_cat_file ) ) {
			require_once $widget_cat_file;
		}
	}
}

/**
 * Initialize the Demo Import module.
 *
 * Hooked to `init` to ensure translations are available before
 * any __() calls are made in demo collection filters.
 *
 * Theme-specific function files are loaded automatically before
 * the importer is instantiated so that pt-ocdi/import_files and
 * related filters are already registered.
 */
function spiraclethemes_site_library_init_demo_import() {
	if ( ! is_admin() ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Auto-detect and load theme-specific files for the active theme.
	spiraclethemes_site_library_auto_load_theme_files();

	new Spiracle_Demo_Import();
}
add_action( 'init', 'spiraclethemes_site_library_init_demo_import' );
