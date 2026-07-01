<?php


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Widgets
 *
 *
 * @since 1.0.0
 */
class Pawwell_Add_Widgets {

	public function get_widgets() {
		// Include Widget files
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/pawwell/home-hero/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/pawwell/trust-strip/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/pawwell/browse-categories/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/pawwell/products-grid/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/pawwell/deal-of-the-day/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/pawwell/why-choose-us/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/pawwell/testimonials/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/pawwell/page-title/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/pawwell/our-story/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/pawwell/stats/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/pawwell/our-journey/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/pawwell/team-members/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/pawwell/cta/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/pawwell/contact-form/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/pawwell/faq/template/config.php';
	       require_once SPIR_SITE_LIBRARY_PATH  . '/elements/pawwell/visit-hours/template/config.php';

	       // Register widgets
	       \Elementor\Plugin::instance()->widgets_manager->register( new Pawwell_HomeHero() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Pawwell_TrustStrip() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Pawwell_BrowseCategories() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Pawwell_ProductsGrid() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Pawwell_DealOfDay() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Pawwell_WhyChooseUs() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Pawwell_Testimonials() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Pawwell_PageTitle() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Pawwell_OurStory() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Pawwell_Stats() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Pawwell_OurJourney() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Pawwell_TeamMembers() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Pawwell_CTA() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Pawwell_ContactForm() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Pawwell_FAQ() );
	       \Elementor\Plugin::instance()->widgets_manager->register( new Pawwell_VisitHours() );
	}
}
