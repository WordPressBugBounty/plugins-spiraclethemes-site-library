<?php


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Widgets
 *
 *
 * @since 1.0.0
 */
class Shopbar_Add_Widgets {

	public function get_widgets() {
		// Include Widget files
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shopbar/home-featured/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shopbar/features/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shopbar/categories/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shopbar/products-grid/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shopbar/cta/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shopbar/about/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shopbar/promo/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shopbar/our-story/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shopbar/stats/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shopbar/contact-info/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shopbar/contact-main/template/config.php';

	       // Register widgets
	       \Elementor\Plugin::instance()->widgets_manager->register( new Shopbar_Home_Featured() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Shopbar_Features() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Shopbar_Categories() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Shopbar_Products_Grid() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Shopbar_CTA() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Shopbar_About() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Shopbar_Promo() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Shopbar_Our_Story() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Shopbar_Stats() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Shopbar_Contact_Info() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Shopbar_Contact_Main() );
	}
}
