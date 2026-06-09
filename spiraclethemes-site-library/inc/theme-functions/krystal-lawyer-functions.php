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

if ( ! function_exists( 'spiraclethemes_site_library_krystal_lawyer_set_import_files' ) ) :
function spiraclethemes_site_library_krystal_lawyer_set_import_files() {

    $customizer_krystal_lawyer_demo1 = spiraclethemes_site_library_api_data('krystallawyer', 'demo1', 'customizer');
    $widgets_krystal_lawyer_demo1 = spiraclethemes_site_library_api_data('krystallawyer', 'demo1', 'widgets');
    $content_krystal_lawyer_demo1 = spiraclethemes_site_library_api_data('krystallawyer', 'demo1', 'content');
    $image_krystal_lawyer_demo1 = spiraclethemes_site_library_api_data('krystallawyer', 'demo1', 'image');

    return array(
        array(
            'import_file_name'           => esc_html__('Krystal Lawyer Demo', 'spiraclethemes-site-library'),
           'import_file_url'          => $content_krystal_lawyer_demo1,
            'import_widget_file_url'   => $widgets_krystal_lawyer_demo1,
            'import_customizer_file_url' => $customizer_krystal_lawyer_demo1,
            'import_preview_image_url'     => $image_krystal_lawyer_demo1,
            'import_notice'              => esc_html__( 'After you import this demo, you will have to change some menu links. Please check documentation for more information', 'spiraclethemes-site-library' ),
            'preview_url'                  => 'https://krystalwp.spiraclethemes.com/demo13/',
        ),
    );
}
endif;
add_filter( 'pt-ocdi/import_files', 'spiraclethemes_site_library_krystal_lawyer_set_import_files' );


/**
 *  After Import
 */

if ( ! function_exists( 'spiraclethemes_site_library_krystal_lawyer_after_import_setup' ) ) :
function spiraclethemes_site_library_krystal_lawyer_after_import_setup( $selected_import ) {
    //Assign menus to their locations
    $main_menu = get_term_by( 'name', 'Primary', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
          'primary' => $main_menu->term_id,
        )
    );

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
    $blog_page_query = new WP_Query( array(
        'post_type'              => 'page',
        'title'                  => 'Blog',
        'post_status'            => 'all',
        'posts_per_page'         => 1,
        'no_found_rows'          => true,
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
    ) );
    $blog_page = ! empty( $blog_page_query->posts ) ? $blog_page_query->posts[0] : null;

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page->ID );    
    update_option( 'page_for_posts', $blog_page->ID ); 
    
}
endif;
add_action( 'pt-ocdi/after_import', 'spiraclethemes_site_library_krystal_lawyer_after_import_setup' );


function spiraclethemes_site_library_krystal_lawyer_check_pro_plugin() {
    if ( ! function_exists( 'ocdi_register_plugins' ) ) :
        // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound
        function ocdi_register_plugins( $plugins ) {
         
            // List of plugins used by all theme demos.
            $theme_plugins = [
                [ 
                  'name'     => 'Elementor Website Builder',
                  'slug'     => 'elementor',
                  'required' => true,
                ],
                [ 
                  'name'     => 'Contact Form 7',
                  'slug'     => 'contact-form-7',
                  'required' => true,
                ],
                [ 
                  'name'     => 'WooCommerce',
                  'slug'     => 'woocommerce',
                  'required' => true,
                ],
            ];
         
            return array_merge( $plugins, $theme_plugins );
        }
    endif;
    add_filter( 'ocdi/register_plugins', 'ocdi_register_plugins' );
}
add_action( 'admin_init', 'spiraclethemes_site_library_krystal_lawyer_check_pro_plugin' );