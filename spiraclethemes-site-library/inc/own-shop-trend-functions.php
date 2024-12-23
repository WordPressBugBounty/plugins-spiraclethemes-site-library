<?php
/**
 *
 * @package spiraclethemes-site-library
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) :
    die;
endif;


/**
 *  Set Import files
 */

if ( ! function_exists( 'spiraclethemes_site_library_own_shop_trend_set_import_files' ) ) :
function spiraclethemes_site_library_own_shop_trend_set_import_files() {

    $customizer_ownshoptrend_demo1 = spiraclethemes_site_library_api_data('ownshoptrend', 'demo1', 'customizer');
    $widgets_ownshoptren_demo1 = spiraclethemes_site_library_api_data('ownshoptrend', 'demo1', 'widgets');
    $content_ownshoptren_demo1 = spiraclethemes_site_library_api_data('ownshoptrend', 'demo1', 'content');
    $image_ownshoptren_demo1 = spiraclethemes_site_library_api_data('ownshoptrend', 'demo1', 'image');

	return array(
        array(
            'import_file_name'           => esc_html__('Own Shop Trend Demo', 'spiraclethemes-site-library'),
            'import_file_url'          => $content_ownshoptren_demo1,
            'import_widget_file_url'   => $widgets_ownshoptren_demo1,
            'import_customizer_file_url' => $customizer_ownshoptrend_demo1,
            'import_preview_image_url'     => $image_ownshoptren_demo1,
            'import_notice'              => esc_html__( '', 'spiraclethemes-site-library' ),
            'preview_url'                  => 'https://ownshop.spiraclethemes.com/ownshoptrend/',
        ),
    );
}
endif;
add_filter( 'pt-ocdi/import_files', 'spiraclethemes_site_library_own_shop_trend_set_import_files' );


/**
 *  After Import
 */

if ( ! function_exists( 'spiraclethemes_site_library_own_shop_trend_after_import_setup' ) ) :
function spiraclethemes_site_library_own_shop_trend_after_import_setup( $selected_import ) {
	//Assign menus to their locations
	$main_menu = get_term_by( 'name', 'Primary', 'nav_menu' );
	$category_menu = get_term_by( 'name', 'Category Menu', 'nav_menu' );

	set_theme_mod( 'nav_menu_locations', array(
	      'primary' => $main_menu->term_id,
	      'categorymenu' => $category_menu->term_id,
	    )
	);

    //Assign front & blog page
    $front_page = get_page_by_title( 'Home' );  
    $blog_page = get_page_by_title( 'Blog' );  

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page -> ID );    
    update_option( 'page_for_posts', $blog_page -> ID ); 
    
}
endif;
add_action( 'pt-ocdi/after_import', 'spiraclethemes_site_library_own_shop_trend_after_import_setup' );


function spiraclethemes_site_library_own_shop_trend_check_pro_plugin() {
    if ( ! function_exists( 'ocdi_register_plugins' ) ) :
        function ocdi_register_plugins( $plugins ) {
         
            // List of plugins used by all theme demos.
            $theme_plugins = [
                [ 
                  'name'     => 'Elementor Website Builder',
                  'slug'     => 'elementor',
                  'required' => true,
                ],
                [ 
                  'name'     => 'WooCommerce',
                  'slug'     => 'woocommerce',
                  'required' => true,
                ],
                [ 
                  'name'     => 'YITH WooCommerce Quick View',
                  'slug'     => 'yith-woocommerce-quick-view',
                  'required' => true,
                ],
                [ 
                  'name'     => 'Contact Form 7',
                  'slug'     => 'contact-form-7',
                  'required' => true,
                ],
            ];
         
            return array_merge( $plugins, $theme_plugins );
        }
    endif;
    add_filter( 'ocdi/register_plugins', 'ocdi_register_plugins' );
}
add_action( 'admin_init', 'spiraclethemes_site_library_own_shop_trend_check_pro_plugin' );