<?php
/**
 *
 * @package spiraclethemes-site-library
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) :
    die;
endif;


$theme_files = [
    'own-shop' => [
        SPIR_SITE_LIBRARY_PATH . '/inc/own-shop-functions.php',
        SPIR_SITE_LIBRARY_PATH . '/elements/own-shop/helper-functions.php',
        SPIR_SITE_LIBRARY_PATH . '/elements/own-shop/widget-category.php',
    ],
    'purea-magazine' => [
        SPIR_SITE_LIBRARY_PATH . '/inc/purea-magazine-functions.php',
    ],
    'colon' => [
        SPIR_SITE_LIBRARY_PATH . '/inc/colon-functions.php',
    ],
    'somalite' => [
        SPIR_SITE_LIBRARY_PATH . '/inc/somalite-functions.php',
    ],
    'purea-fashion' => [
        SPIR_SITE_LIBRARY_PATH . '/inc/purea-fashion-functions.php',
    ],
    'own-store' => [
        SPIR_SITE_LIBRARY_PATH . '/inc/own-store-functions.php',
        SPIR_SITE_LIBRARY_PATH . '/elements/own-shop/helper-functions.php',
        SPIR_SITE_LIBRARY_PATH . '/elements/own-shop/widget-category.php',
    ],
    'colon-plus' => [
        SPIR_SITE_LIBRARY_PATH . '/inc/colon-plus-functions.php',
    ],
    'own-shop-lite' => [
        SPIR_SITE_LIBRARY_PATH . '/inc/own-shop-lite-functions.php',
        SPIR_SITE_LIBRARY_PATH . '/elements/own-shop/helper-functions.php',
        SPIR_SITE_LIBRARY_PATH . '/elements/own-shop/widget-category.php',
    ],
    'mestore' => [
        SPIR_SITE_LIBRARY_PATH . '/inc/mestore-functions.php',
    ],
    'blogson' => [
        SPIR_SITE_LIBRARY_PATH . '/inc/blogson-functions.php',
        SPIR_SITE_LIBRARY_PATH . '/elements/blogson/helper-functions.php',
        SPIR_SITE_LIBRARY_PATH . '/elements/blogson/widget-category.php',
    ],
    'blogson-child' => [
        SPIR_SITE_LIBRARY_PATH . '/inc/blogson-functions.php',
        SPIR_SITE_LIBRARY_PATH . '/elements/blogson/helper-functions.php',
        SPIR_SITE_LIBRARY_PATH . '/elements/blogson/widget-category.php',
    ],
    'own-shope' => [
        SPIR_SITE_LIBRARY_PATH . '/inc/own-shope-functions.php',
        SPIR_SITE_LIBRARY_PATH . '/elements/own-shop/helper-functions.php',
        SPIR_SITE_LIBRARY_PATH . '/elements/own-shop/widget-category.php',
    ],
    'crater-free' => [
        SPIR_SITE_LIBRARY_PATH . '/inc/crater-free-functions.php',
    ],
    'lawfiz' => [
        SPIR_SITE_LIBRARY_PATH . '/inc/lawfiz-functions.php',
    ],
    'legalblow' => [
        SPIR_SITE_LIBRARY_PATH . '/inc/legalblow-functions.php',
    ],
    'own-shop-trend' => [
        SPIR_SITE_LIBRARY_PATH . '/inc/own-shop-trend-functions.php',
    ],
    'lawfiz-one' => [
        SPIR_SITE_LIBRARY_PATH . '/inc/lawfiz-one-functions.php',
    ],
    'krystal' => [
        SPIR_SITE_LIBRARY_PATH . '/inc/krystal-functions.php',
    ],
    'krystal-lawyer' => [
        SPIR_SITE_LIBRARY_PATH . '/inc/krystal-lawyer-functions.php',
    ],
    'krystal-business' => [
        SPIR_SITE_LIBRARY_PATH . '/inc/krystal-business-functions.php',
    ],
    'krystal-shop' => [
        SPIR_SITE_LIBRARY_PATH . '/inc/krystal-shop-functions.php',
    ],
];

// Load the appropriate files based on the current theme slug
if ( isset( $theme_files[ $this->theme_slug ] ) ) {
    foreach ( $theme_files[ $this->theme_slug ] as $file ) {
        require_once $file;
    }
}


/*************************************************************/

// Function to access API data
function spiraclethemes_site_library_api_data($theme_name, $demo_name, $file_type) {
    // API URL for accessing files
    $api_url = "https://api.spiraclethemes.com/wp-json/custom/v1/files/$file_type/$theme_name/$demo_name/";

    // Send GET request to the API
    $response = wp_remote_get($api_url);

    // Check if the request was successful
    if (is_wp_error($response)) {
        // Log the error (optional, for debugging purposes)
        error_log('API Request Error: ' . $response->get_error_message());
        return false; // Return false to indicate API request failure
    }

    // Get the response code
    $response_code = wp_remote_retrieve_response_code($response);

    // Check if API returned a valid response (2xx status code)
    if (strpos((string) $response_code, '2') !== 0) {
        // Log the response code (optional, for debugging purposes)
        error_log('API Response Error: ' . $response_code);
        return false; // Return false to indicate API response error
    }

    // Get the response body
    $api_data = wp_remote_retrieve_body($response);

    // Check if API data is valid
    if (empty($api_data)) {
        error_log('Empty API Response');
        return false; // Return false for empty API response
    }

    // Convert JSON string to PHP array
    $api_data_array = json_decode($api_data, true);

    // Check if the data was successfully decoded and contains 'file_path'
    if ($api_data_array && isset($api_data_array['file_path'])) {
        // Construct the file URL
        $file = "https://spiraclethemes.com/" . implode('/', array_slice(explode('/', ltrim($api_data_array['file_path'])), 6));
        return $file;
    } else {
        // No file path found in API response
        error_log('No file path found in API response');
        return false; // Return false for missing file path
    }
}

