<?php
/**
 * Allowed themes list and pricing page URL.
 *
 * @package Spiraclethemes_Site_Library
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Get the list of allowed Spiraclethemes theme slugs.
 *
 * @return array
 */
function spiraclethemes_site_library_get_allowed_themes() {
	return array(	
		'somalite',
		'purea-fashion',
		'colon-plus',
		'own-shop-lite',
		'blogson-child',
		'own-shope',
		'crater-free',
		'own-shop-trend',
		'lawfiz-one',
		'krystal-lawyer',
		'krystal-business',
		'krystal-shop',
		'krystal',
		'own-store',
		'colon',
		'purea-magazine',
		'mestore',
		'blogson',
		'lawfiz',
		'legalblow',
		'own-shop',
		'shopnex',
		'pawwell',
		'shop-zen',
		'shopbar',
	);
}

/**
 * Get the list of theme slugs that are live on wordpress.org.
 *
 * Slugs are verified against the wordpress.org Themes API and the result is
 * cached for a day. Slugs that were removed from the directory (e.g. child
 * themes or unlisted themes) are filtered out.
 *
 * @return array
 */
function spiraclethemes_site_library_get_live_themes() {
	$cache_key = 'ssl_live_themes';
	$cached    = get_transient( $cache_key );

	if ( is_array( $cached ) ) {
		return $cached;
	}

	$allowed_themes = spiraclethemes_site_library_get_allowed_themes();
	$live_themes    = array();

	foreach ( $allowed_themes as $slug ) {
		$response = wp_remote_get(
			'https://api.wordpress.org/themes/info/1.2/?action=theme_information&request[slug]=' . rawurlencode( $slug ),
			array( 'timeout' => 10 )
		);

		if ( is_wp_error( $response ) ) {
			continue;
		}

		$code = (int) wp_remote_retrieve_response_code( $response );
		if ( 200 !== $code ) {
			continue;
		}

		$data = json_decode( wp_remote_retrieve_body( $response ), true );
		if ( empty( $data['name'] ) ) {
			continue;
		}

		$live_themes[] = $slug;
	}

	set_transient( $cache_key, $live_themes, DAY_IN_SECONDS );

	return $live_themes;
}

/**
 * Get the Pro pricing page URL.
 *
 * @return string
 */
function spiraclethemes_site_library_get_pricing_url() {
	return 'https://spiraclethemes.com/pricing/';
}

