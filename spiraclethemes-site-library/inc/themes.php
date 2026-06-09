<?php
/**
 * Theme file loading and API data functions.
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Theme files mapping.
 *
 * Maps theme slugs to their corresponding function and element files.
 */
$spir_theme_files = [
    'own-shop'         => [
        SPIR_SITE_LIBRARY_PATH . '/inc/theme-functions/own-shop-functions.php',
        SPIR_SITE_LIBRARY_PATH . '/elements/own-shop/helper-functions.php',
        SPIR_SITE_LIBRARY_PATH . '/elements/own-shop/widget-category.php',
    ],
    'purea-magazine'   => [
        SPIR_SITE_LIBRARY_PATH . '/inc/theme-functions/purea-magazine-functions.php',
    ],
    'colon'            => [
        SPIR_SITE_LIBRARY_PATH . '/inc/theme-functions/colon-functions.php',
    ],
    'somalite'         => [
        SPIR_SITE_LIBRARY_PATH . '/inc/theme-functions/somalite-functions.php',
    ],
    'purea-fashion'    => [
        SPIR_SITE_LIBRARY_PATH . '/inc/theme-functions/purea-fashion-functions.php',
    ],
    'own-store'        => [
        SPIR_SITE_LIBRARY_PATH . '/inc/theme-functions/own-store-functions.php',
        SPIR_SITE_LIBRARY_PATH . '/elements/own-shop/helper-functions.php',
        SPIR_SITE_LIBRARY_PATH . '/elements/own-shop/widget-category.php',
    ],
    'colon-plus'       => [
        SPIR_SITE_LIBRARY_PATH . '/inc/theme-functions/colon-plus-functions.php',
    ],
    'own-shop-lite'    => [
        SPIR_SITE_LIBRARY_PATH . '/inc/theme-functions/own-shop-lite-functions.php',
        SPIR_SITE_LIBRARY_PATH . '/elements/own-shop/helper-functions.php',
        SPIR_SITE_LIBRARY_PATH . '/elements/own-shop/widget-category.php',
    ],
    'mestore'          => [
        SPIR_SITE_LIBRARY_PATH . '/inc/theme-functions/mestore-functions.php',
    ],
    'blogson'          => [
        SPIR_SITE_LIBRARY_PATH . '/inc/theme-functions/blogson-functions.php',
        SPIR_SITE_LIBRARY_PATH . '/elements/blogson/helper-functions.php',
        SPIR_SITE_LIBRARY_PATH . '/elements/blogson/widget-category.php',
    ],
    'blogson-child'    => [
        SPIR_SITE_LIBRARY_PATH . '/inc/theme-functions/blogson-functions.php',
        SPIR_SITE_LIBRARY_PATH . '/elements/blogson/helper-functions.php',
        SPIR_SITE_LIBRARY_PATH . '/elements/blogson/widget-category.php',
    ],
    'own-shope'        => [
        SPIR_SITE_LIBRARY_PATH . '/inc/theme-functions/own-shope-functions.php',
        SPIR_SITE_LIBRARY_PATH . '/elements/own-shop/helper-functions.php',
        SPIR_SITE_LIBRARY_PATH . '/elements/own-shop/widget-category.php',
    ],
    'crater-free'      => [
        SPIR_SITE_LIBRARY_PATH . '/inc/theme-functions/crater-free-functions.php',
    ],
    'lawfiz'           => [
        SPIR_SITE_LIBRARY_PATH . '/inc/theme-functions/lawfiz-functions.php',
    ],
    'legalblow'        => [
        SPIR_SITE_LIBRARY_PATH . '/inc/theme-functions/legalblow-functions.php',
    ],
    'own-shop-trend'   => [
        SPIR_SITE_LIBRARY_PATH . '/inc/theme-functions/own-shop-trend-functions.php',
    ],
    'lawfiz-one'       => [
        SPIR_SITE_LIBRARY_PATH . '/inc/theme-functions/lawfiz-one-functions.php',
    ],
    'krystal'          => [
        SPIR_SITE_LIBRARY_PATH . '/inc/theme-functions/krystal-functions.php',
    ],
    'krystal-lawyer'   => [
        SPIR_SITE_LIBRARY_PATH . '/inc/theme-functions/krystal-lawyer-functions.php',
    ],
    'krystal-business' => [
        SPIR_SITE_LIBRARY_PATH . '/inc/theme-functions/krystal-business-functions.php',
    ],
    'krystal-shop'     => [
        SPIR_SITE_LIBRARY_PATH . '/inc/theme-functions/krystal-shop-functions.php',
    ],
    'shopnex'          => [
        SPIR_SITE_LIBRARY_PATH . '/inc/theme-functions/shopnex-functions.php',
        SPIR_SITE_LIBRARY_PATH . '/elements/shopnex/helper-functions.php',
        SPIR_SITE_LIBRARY_PATH . '/elements/shopnex/widget-category.php',
    ],
];

// Load the appropriate files based on the current theme slug.
if ( isset( $spir_theme_files[ $this->theme_slug ] ) ) {
    foreach ( $spir_theme_files[ $this->theme_slug ] as $spir_file ) {
        if ( file_exists( $spir_file ) ) {
            require_once $spir_file;
        }
    }
}

/**
 * Access API data for demo imports.
 *
 * @param string $theme_name Theme identifier for the API.
 * @param string $demo_name  Demo identifier (e.g., 'demo1').
 * @param string $file_type  File type to fetch ('customizer', 'widgets', 'content', 'image').
 * @return string|false File URL on success, false on failure.
 */
function spiraclethemes_site_library_api_data( $theme_name, $demo_name, $file_type ) {
    // Do not call the API if demo import is disabled.
    if ( '1' !== get_option( 'ssl_enable_demo_import', '1' ) ) {
        return false;
    }

    $api_url  = sprintf(
        'https://api.spiraclethemes.com/wp-json/custom/v1/files/%s/%s/%s/',
        rawurlencode( $file_type ),
        rawurlencode( $theme_name ),
        rawurlencode( $demo_name )
    );
    $response = wp_remote_get( $api_url, [ 'timeout' => 10, 'sslverify' => true ] );

    if ( is_wp_error( $response ) ) {
        return false;
    }

    $response_code = wp_remote_retrieve_response_code( $response );
    if ( 200 !== (int) $response_code ) {
        return false;
    }

    $api_data = wp_remote_retrieve_body( $response );
    if ( empty( $api_data ) ) {
        return false;
    }

    $api_data_array = json_decode( $api_data, true );
    if ( ! $api_data_array || ! isset( $api_data_array['file_path'] ) ) {
        return false;
    }

	$file_path_raw = trim( $api_data_array['file_path'] );

	if ( 0 === strpos( $file_path_raw, 'https://spiraclethemes.com/' ) ) {
		$file_url = $file_path_raw;
	} elseif ( 0 === strpos( $file_path_raw, '/' ) ) {
		$ocdi_pos = strpos( $file_path_raw, 'ocdi/' );
		if ( false !== $ocdi_pos ) {
			$relative_path = substr( $file_path_raw, $ocdi_pos );
			$file_url      = 'https://spiraclethemes.com/api/' . $relative_path;
		} else {
			$file_url = sprintf(
				'https://spiraclethemes.com/api/ocdi/%s/%s/%s',
				rawurlencode( $theme_name ),
				rawurlencode( $demo_name ),
				sanitize_file_name( basename( $file_path_raw ) )
			);
		}
	} else {
		return false;
	}

	$file_url = esc_url_raw( $file_url );

	if ( 0 !== strpos( $file_url, 'https://spiraclethemes.com/' ) ) {
		return false;
	}

	return $file_url;
}
