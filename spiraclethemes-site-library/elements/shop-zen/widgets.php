<?php


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Widgets
 *
 *
 * @since 1.0.0
 */
class Shop_Zen_Add_Widgets {

	public function get_widgets() {
		// Include Widget files
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shop-zen/home-hero/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shop-zen/features/template/config.php';
		   require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shop-zen/categories/template/config.php';
		   require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shop-zen/products-grid/template/config.php';
		   require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shop-zen/stats/template/config.php';
		   require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shop-zen/testimonials/template/config.php';
		   require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shop-zen/cta-lite/template/config.php';
		   require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shop-zen/page-title/template/config.php';
		   require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shop-zen/our-story/template/config.php';
		   require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shop-zen/timeline/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shop-zen/cta-large/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shop-zen/contact-wrap/template/config.php';

	       // Register widgets
	       \Elementor\Plugin::instance()->widgets_manager->register( new Shop_Zen_HomeHero() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Shop_Zen_Features() );
		   \Elementor\Plugin::instance()->widgets_manager->register( new Shop_Zen_Categories() );
		   \Elementor\Plugin::instance()->widgets_manager->register( new Shop_Zen_Products_Grid() );
		   \Elementor\Plugin::instance()->widgets_manager->register( new Shop_Zen_Stats() );
		   \Elementor\Plugin::instance()->widgets_manager->register( new Shop_Zen_Testimonials() );
		   \Elementor\Plugin::instance()->widgets_manager->register( new Shop_Zen_CTA_Lite() );
		   \Elementor\Plugin::instance()->widgets_manager->register( new Shop_Zen_Page_Title() );
		   \Elementor\Plugin::instance()->widgets_manager->register( new Shop_Zen_Our_Story() );
		   \Elementor\Plugin::instance()->widgets_manager->register( new Shop_Zen_Timeline() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Shop_Zen_CTA_Large() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Shop_Zen_Contact_Wrap() );
	}
}
