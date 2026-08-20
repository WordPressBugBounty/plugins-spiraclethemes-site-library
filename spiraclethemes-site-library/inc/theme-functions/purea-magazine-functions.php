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

if ( ! function_exists( 'spiraclethemes_site_library_purea_magazine_set_import_files' ) ) :
function spiraclethemes_site_library_purea_magazine_set_import_files() {

    $returnArray = array();
    for ($i = 1; $i <= 2; $i++) {
        $customizer_pureamagazine_demo[$i] = spiraclethemes_site_library_api_data('pureamagazine', 'demo'.$i, 'customizer');
        $widgets_pureamagazine_demo[$i] = spiraclethemes_site_library_api_data('pureamagazine', 'demo'.$i, 'widgets');
        $content_pureamagazine_demo[$i] = spiraclethemes_site_library_api_data('pureamagazine', 'demo'.$i, 'content');
        $image_pureamagazine_demo[$i] = spiraclethemes_site_library_api_data('pureamagazine', 'demo'.$i, 'image');

        $returnArray[] = array(
            'import_file_name'           => esc_html(sprintf( /* translators: %d: Demo number */ __('Demo %d', 'spiraclethemes-site-library'), $i)),
            'import_file_url'            => $content_pureamagazine_demo[$i],
            'import_widget_file_url'     => $widgets_pureamagazine_demo[$i],
            'import_customizer_file_url' => $customizer_pureamagazine_demo[$i],    
            'import_preview_image_url'   => $image_pureamagazine_demo[$i],
            'import_notice'              => esc_html__( 'After you import this demo, you will have to change some menu links. Please check documentation for more information', 'spiraclethemes-site-library' ),
            'preview_url'                => 'https://pureamagwp.spiraclethemes.com/demo'.$i,
        );
    }
    return $returnArray;
}
endif;
add_filter( 'pt-ocdi/import_files', 'spiraclethemes_site_library_purea_magazine_set_import_files' );



if ( ! function_exists( 'spiraclethemes_site_library_purea_magazine_after_import_setup' ) ) :
function spiraclethemes_site_library_purea_magazine_after_import_setup( $selected_import ) {
	//Assign menus to their locations
	$main_menu = get_term_by( 'name', 'Primary', 'nav_menu' );
	$footer_menu = get_term_by( 'name', 'Footer', 'nav_menu' );
	$sidebar_social_menu = get_term_by( 'name', 'Social Menu', 'nav_menu' );

	$menu_locations = array();
	if ( $main_menu instanceof WP_Term ) {
		$menu_locations['primary'] = $main_menu->term_id;
	}
	if ( $footer_menu instanceof WP_Term ) {
		$menu_locations['footer'] = $footer_menu->term_id;
	}
	if ( $sidebar_social_menu instanceof WP_Term ) {
		$menu_locations['social'] = $sidebar_social_menu->term_id;
	}
	if ( ! empty( $menu_locations ) ) {
		set_theme_mod( 'nav_menu_locations', $menu_locations );
	}

    //Assign front & blog page
    $front_page_query = new WP_Query( array(
        'post_type'              => 'page',
        'title'                  => 'Home',
        'post_status'            => 'all',
        'posts_per_page'         => 1,
        'no_found_rows'          => true,
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
    ) );
    $front_page = ! empty( $front_page_query->posts ) ? $front_page_query->posts[0] : null;

    if ( $front_page instanceof WP_Post ) {
    	update_option( 'show_on_front', 'page' );
    	update_option( 'page_on_front', $front_page->ID );
    }
    
}
endif;
add_action( 'pt-ocdi/after_import', 'spiraclethemes_site_library_purea_magazine_after_import_setup' );