<?php
/**
 * Allowed themes list and pricing URLs.
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
 * Get the theme-specific pricing URLs.
 *
 * @return array
 */
function spiraclethemes_site_library_get_pricing_urls() {
	return array(
		'somalite'         => 'https://spiraclethemes.com/soma-pro-addons/',
		'purea-fashion'    => 'https://spiraclethemes.com/purea-magazine-pro-addons/',
		'colon-plus'       => 'https://spiraclethemes.com/colon-pro-addons/',
		'own-shop-lite'    => 'https://spiraclethemes.com/own-shop-lite-pro-addons/',
		'blogson-child'    => 'https://spiraclethemes.com/blogson-pro-addons/',
		'own-shope'        => 'https://spiraclethemes.com/own-shope-free-wordpress-theme/#pricing',
		'crater-free'      => 'https://spiraclethemes.com/crater-pro-addons/',
		'own-shop-trend'   => 'https://spiraclethemes.com/own-shop-pro-addons/',
		'lawfiz-one'       => 'https://spiraclethemes.com/lawfiz-one-theme/#pricing',
		'krystal-lawyer'   => 'https://spiraclethemes.com/krystal-pro-addons/',
		'krystal-business' => 'https://spiraclethemes.com/krystal-pro-addons/',
		'krystal-shop'     => 'https://spiraclethemes.com/krystal-pro-addons/',
		'krystal'          => 'https://spiraclethemes.com/krystal-pro-addons/',
		'own-store'        => 'https://spiraclethemes.com/own-shop-pro-addons/',
		'colon'            => 'https://spiraclethemes.com/colon-pro-addons/',
		'purea-magazine'   => 'https://spiraclethemes.com/purea-magazine-pro-addons',
		'mestore'          => 'https://spiraclethemes.com/mestore-pro-addons',
		'blogson'          => 'https://spiraclethemes.com/blogson-pro-addons/',
		'lawfiz'           => 'https://spiraclethemes.com/lawfiz-theme/#pricing',
		'legalblow'        => 'https://spiraclethemes.com/legalblow-theme/#pricing',
		'own-shop'         => 'https://spiraclethemes.com/own-shop-pro-addons/',
		'shopnex'          => 'https://spiraclethemes.com/shopnex-pro-addons/',
		'pawwell'          => 'https://spiraclethemes.com/pawwell-pro-addons/',
		'shop-zen'         => 'https://spiraclethemes.com/shop-zen-pro-addons/',
		'shopbar'          => 'https://spiraclethemes.com/shopbar-pro-addons/',
	);
}

/**
 * Get the premium "Pro Addons" product name for a theme slug.
 *
 * @param string $theme_slug Theme text-domain slug.
 * @return string Product name, or the theme slug when it cannot be derived.
 */
function spiraclethemes_site_library_get_theme_product_name( $theme_slug ) {
	// Standalone Pro theme names for free themes without a Pro Addons plugin.
	$pro_theme_names = [
		'own-shope' => 'Own Shop Pro Addons',
		'lawfiz'    => 'Lawfiz Pro Addons',
		'lawfiz-one' => 'Lawfiz Pro Addons',
		'legalblow' => 'Legalblow Pro Addons',
	];

	if ( isset( $pro_theme_names[ $theme_slug ] ) ) {
		return $pro_theme_names[ $theme_slug ];
	}

	$pricing_urls = spiraclethemes_site_library_get_pricing_urls();
	$pricing_url  = isset( $pricing_urls[ $theme_slug ] ) ? $pricing_urls[ $theme_slug ] : '';
	$product      = $theme_slug;

	if ( preg_match( '~/([^/]+)/?(?:#.*)?$~', $pricing_url, $matches ) ) {
		$product = ucwords( str_replace( '-', ' ', rtrim( $matches[1], '/' ) ) );
	}

	return $product;
}

