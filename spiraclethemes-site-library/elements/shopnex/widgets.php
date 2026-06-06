<?php


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Widgets
 *
 *
 * @since 1.0.0
 */
class Shopnex_Add_Widgets {

	public function get_widgets() {
		// Include Widget files
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shopnex/home-featured/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shopnex/categories/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shopnex/bestsellers/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shopnex/editorial/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shopnex/cta/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shopnex/page-title/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shopnex/page-hero/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shopnex/contact-layout/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shopnex/map-section/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shopnex/our-story/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shopnex/stats-strip/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shopnex/values/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shopnex/team/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shopnex/journey/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/shopnex/info-boxes/template/config.php';

	       // Register widgets
	       \Elementor\Plugin::instance()->widgets_manager->register( new Shopnex_HomeFeatured() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Shopnex_Categories() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Shopnex_Bestsellers() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Shopnex_Editorial() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Shopnex_CTA() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Shopnex_PageTitle() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Shopnex_PageHero() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Shopnex_ContactLayout() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Shopnex_MapSection() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Shopnex_OurStory() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Shopnex_StatsStrip() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Shopnex_Values() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Shopnex_Team() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Shopnex_Journey() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Shopnex_InfoBoxes() );
	}
}
