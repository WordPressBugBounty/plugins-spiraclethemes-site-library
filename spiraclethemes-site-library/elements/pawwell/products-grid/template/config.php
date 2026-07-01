<?php


use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Pawwell_ProductsGrid extends Widget_Base {

	public function get_name() {
		return 'pawwell-elementor-products-grid';
	}

	public function get_title() {
		return __( 'Products Grid', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-products';
	}

	public function get_categories() {
		return [ 'pawwell-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'product', 'featured', 'bestseller', 'recent', 'top rated', 'shop', 'pawwell', 'grid', 'woocommerce' ];
	}

	protected function register_controls() {

		// ─── Section Heading ────────────────────────────────────────
		$this->start_controls_section(
			'section_heading',
			[
				'label' => esc_html__( 'Section Heading', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'eyebrow',
			[
				'label' => esc_html__( 'Eyebrow Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Handpicked for you', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Featured Products', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'show_view_all',
			[
				'label' => esc_html__( 'Show View All Button', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'view_all_text',
			[
				'label' => esc_html__( 'View All Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'View All Products', 'spiraclethemes-site-library' ),
				'condition' => [
					'show_view_all' => 'yes',
				],
			]
		);

		$this->add_control(
			'view_all_url',
			[
				'label' => esc_html__( 'View All URL', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'spiraclethemes-site-library' ),
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => false,
					'nofollow' => false,
				],
				'condition' => [
					'show_view_all' => 'yes',
				],
			]
		);

		$this->end_controls_section();


		// ─── Product Query ─────────────────────────────────────────
		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Product Query', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'product_source',
			[
				'label' => esc_html__( 'Product Source', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'featured',
				'options' => [
					'featured'    => esc_html__( 'Featured Products', 'spiraclethemes-site-library' ),
					'best_selling'=> esc_html__( 'Best Sellers', 'spiraclethemes-site-library' ),
					'recent'      => esc_html__( 'Recent Products', 'spiraclethemes-site-library' ),
					'top_rated'   => esc_html__( 'Top Rated Products', 'spiraclethemes-site-library' ),
					'on_sale'     => esc_html__( 'On Sale Products', 'spiraclethemes-site-library' ),
					'price'       => esc_html__( 'Price: Low to High', 'spiraclethemes-site-library' ),
					'price-desc'  => esc_html__( 'Price: High to Low', 'spiraclethemes-site-library' ),
					'rand'        => esc_html__( 'Random Products', 'spiraclethemes-site-library' ),
					'title'       => esc_html__( 'Title (A-Z)', 'spiraclethemes-site-library' ),
				],
				'description' => esc_html__( 'Choose which products to display. WooCommerce must be active.', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'prod_count',
			[
				'label' => esc_html__( 'Number of Products', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 4,
				'min' => 1,
				'max' => 24,
			]
		);

		$this->add_control(
			'prod_categories',
			[
				'label' => esc_html__( 'Product Categories', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter category slugs separated by comma. Leave empty for all categories.', 'spiraclethemes-site-library' ),
				'default' => '',
				'placeholder' => esc_html__( 'e.g. dog-food, toys', 'spiraclethemes-site-library' ),
			]
		);

		$this->end_controls_section();


		// ─── Card Options ──────────────────────────────────────────
		$this->start_controls_section(
			'section_card_options',
			[
				'label' => esc_html__( 'Card Options', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'show_badge',
			[
				'label' => esc_html__( 'Show Badge', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		// Wishlist (only when PawWell Pro is active + feature enabled).
		if ( function_exists( 'pwpa_is_feature_enabled' ) && pwpa_is_feature_enabled( 'wishlist' ) ) {
			$this->add_control(
				'show_wishlist',
				[
					'label' => esc_html__( 'Show Wishlist Button', 'spiraclethemes-site-library' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
					'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);
		}

		// Quick View (only when PawWell Pro is active + feature enabled).
		if ( function_exists( 'pwpa_is_feature_enabled' ) && pwpa_is_feature_enabled( 'quick_view' ) ) {
			$this->add_control(
				'show_quick_view',
				[
					'label' => esc_html__( 'Show Quick View Icon', 'spiraclethemes-site-library' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
					'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);
		}

		// Compare (only when PawWell Pro is active + feature enabled).
		if ( function_exists( 'pwpa_is_feature_enabled' ) && pwpa_is_feature_enabled( 'compare' ) ) {
			$this->add_control(
				'show_compare',
				[
					'label' => esc_html__( 'Show Compare Icon', 'spiraclethemes-site-library' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
					'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);
		}

		$this->add_control(
			'show_quick_add',
			[
				'label' => esc_html__( 'Show Quick Add Bar', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'quick_add_text',
			[
				'label' => esc_html__( 'Quick Add Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Quick Add to Cart', 'spiraclethemes-site-library' ),
				'condition' => [
					'show_quick_add' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_category',
			[
				'label' => esc_html__( 'Show Category', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_rating',
			[
				'label' => esc_html__( 'Show Rating', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'image_ratio',
			[
				'label' => esc_html__( 'Image Ratio', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1 / 1',
				'options' => [
					'1 / 1' => esc_html__( 'Square (1:1)', 'spiraclethemes-site-library' ),
					'4 / 3' => esc_html__( 'Landscape (4:3)', 'spiraclethemes-site-library' ),
					'3 / 4' => esc_html__( 'Portrait (3:4)', 'spiraclethemes-site-library' ),
					'16 / 9' => esc_html__( 'Wide (16:9)', 'spiraclethemes-site-library' ),
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Layout ─────────────────────────────────────────
		$this->start_controls_section(
			'section_layout_style',
			[
				'label' => esc_html__( 'Layout', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'section_bg',
			[
				'label' => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .pawwell-pg' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'show_border_top',
			[
				'label' => esc_html__( 'Top Border', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_border_bottom',
			[
				'label' => esc_html__( 'Bottom Border', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'full_width_border',
			[
				'label' => esc_html__( 'Full Width Border', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'no',
				'description' => esc_html__( 'Stretch the borders edge-to-edge across the full section. Off = borders span the content width only.', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'border_color',
			[
				'label' => esc_html__( 'Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E8E2DA',
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[ 'name' => 'show_border_top', 'operator' => '===', 'value' => 'yes' ],
						[ 'name' => 'show_border_bottom', 'operator' => '===', 'value' => 'yes' ],
					],
				],
			]
		);

		$this->add_control(
			'border_width',
			[
				'label' => esc_html__( 'Border Width (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 1, 'max' => 10 ] ],
				'default' => [ 'unit' => 'px', 'size' => 1 ],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[ 'name' => 'show_border_top', 'operator' => '===', 'value' => 'yes' ],
						[ 'name' => 'show_border_bottom', 'operator' => '===', 'value' => 'yes' ],
					],
				],
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => esc_html__( 'Columns', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SELECT,
				'default' => '4',
				'options' => [
					'2' => '2',
					'3' => '3',
					'4' => '4',
				],
				'selectors' => [
					'{{WRAPPER}} .pawwell-pg-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				],
			]
		);

		$this->add_responsive_control(
			'grid_gap',
			[
				'label' => esc_html__( 'Gap (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default' => [ 'unit' => 'px', 'size' => 24 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-pg-grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'section_padding',
			[
				'label' => esc_html__( 'Section Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 160 ] ],
				'default' => [ 'unit' => 'px', 'size' => 100 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-pg-inner' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Card ───────────────────────────────────────────
		$this->start_controls_section(
			'section_card_style',
			[
				'label' => esc_html__( 'Card', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'card_bg',
			[
				'label' => esc_html__( 'Card Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .pawwell-pg-card' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_border_color',
			[
				'label' => esc_html__( 'Card Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E8E2DA',
				'selectors' => [
					'{{WRAPPER}} .pawwell-pg-card' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_radius',
			[
				'label' => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 20 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-pg-card' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'card_body_padding',
			[
				'label' => esc_html__( 'Body Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 20,
					'right' => 20,
					'bottom' => 20,
					'left' => 20,
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .pawwell-pg-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Badge ──────────────────────────────────────────
		$this->start_controls_section(
			'section_badge_style',
			[
				'label' => esc_html__( 'Badge', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'badge_bg_default',
			[
				'label' => esc_html__( 'Badge Background (Terracotta)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C45B3E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-pg-badge--default' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_bg_sale',
			[
				'label' => esc_html__( 'Badge Background (Sale)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#D65A5A',
				'selectors' => [
					'{{WRAPPER}} .pawwell-pg-badge--sale' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_bg_new',
			[
				'label' => esc_html__( 'Badge Background (New)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#7B8F6B',
				'selectors' => [
					'{{WRAPPER}} .pawwell-pg-badge--new' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_color',
			[
				'label' => esc_html__( 'Badge Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .pawwell-pg-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Quick Add Bar ──────────────────────────────────
		$this->start_controls_section(
			'section_quick_add_style',
			[
				'label' => esc_html__( 'Quick Add Bar', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'quick_add_bg',
			[
				'label' => esc_html__( 'Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E1E1E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-pg-quick-add' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'quick_add_bg_hover',
			[
				'label' => esc_html__( 'Hover Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C45B3E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-pg-quick-add:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'quick_add_color',
			[
				'label' => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .pawwell-pg-quick-add' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Heading ────────────────────────────────────────
		$this->start_controls_section(
			'section_heading_style',
			[
				'label' => esc_html__( 'Heading', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Title Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-pg-title',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 44 ] ],
					'font_weight' => [ 'default' => 400 ],
				],
			]
		);

		$this->add_responsive_control(
			'heading_align',
			[
				'label' => esc_html__( 'Heading Alignment', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'spiraclethemes-site-library' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'spiraclethemes-site-library' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'spiraclethemes-site-library' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pawwell-pg-heading' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E1E1E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-pg-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'eyebrow_color',
			[
				'label' => esc_html__( 'Eyebrow Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C45B3E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-pg-eyebrow' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'view_all_color',
			[
				'label' => esc_html__( 'View All Button Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E1E1E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-pg-viewall' => 'border-color: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'view_all_hover_bg',
			[
				'label' => esc_html__( 'View All Hover Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E1E1E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-pg-viewall:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'view_all_hover_color',
			[
				'label' => esc_html__( 'View All Hover Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'description' => esc_html__( 'Overrides the base text color on hover. Needed so the text stays visible over the dark hover background.', 'spiraclethemes-site-library' ),
				'selectors' => [
					'{{WRAPPER}} .pawwell-pg-viewall:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Product Text ───────────────────────────────────
		$this->start_controls_section(
			'section_text_style',
			[
				'label' => esc_html__( 'Product Text', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'name_typography',
				'label' => esc_html__( 'Name Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-pg-name',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 15 ] ],
					'font_weight' => [ 'default' => 700 ],
				],
			]
		);

		$this->add_control(
			'name_color',
			[
				'label' => esc_html__( 'Name Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E1E1E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-pg-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'category_color',
			[
				'label' => esc_html__( 'Category Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#8A8A8A',
				'selectors' => [
					'{{WRAPPER}} .pawwell-pg-category' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'rating_color',
			[
				'label' => esc_html__( 'Star / Rating Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#D4A853',
				'selectors' => [
					'{{WRAPPER}} .pawwell-pg-stars' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'price_color',
			[
				'label' => esc_html__( 'Price Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E1E1E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-pg-price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'old_price_color',
			[
				'label' => esc_html__( 'Old Price Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#8A8A8A',
				'selectors' => [
					'{{WRAPPER}} .pawwell-pg-price del' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pawwell-pg-price-old' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Build the WooCommerce product query args based on the chosen source.
	 *
	 * @param array $settings Widget settings.
	 * @return array Query args for wc_get_products().
	 */
	private function get_product_query_args( $settings ) {
		$source      = $settings['product_source'] ?? 'featured';
		$count       = absint( $settings['prod_count'] ?? 4 );
		$categories  = ! empty( $settings['prod_categories'] ) ? $settings['prod_categories'] : '';

		$args = [
			'status'   => 'publish',
			'limit'    => $count,
			'paginate' => false,
			'orderby'  => 'popularity',
			'order'    => 'desc',
		];

		switch ( $source ) {
			case 'featured':
				$args['featured'] = true;
				$args['orderby']  = 'date';
				$args['order']    = 'desc';
				break;
			case 'best_selling':
				$args['orderby'] = 'popularity';
				$args['order']   = 'desc';
				break;
			case 'recent':
				$args['orderby'] = 'date';
				$args['order']   = 'desc';
				break;
			case 'top_rated':
				$args['orderby'] = 'rating';
				$args['order']   = 'desc';
				break;
			case 'on_sale':
				$args['orderby'] = 'popularity';
				$args['order']   = 'desc';
				$args['on_sale'] = true;
				break;
			case 'price':
				$args['orderby'] = 'price';
				$args['order']   = 'asc';
				break;
			case 'price-desc':
				$args['orderby'] = 'price';
				$args['order']   = 'desc';
				break;
			case 'rand':
				$args['orderby'] = 'rand';
				unset( $args['order'] );
				break;
			case 'title':
				$args['orderby'] = 'title';
				$args['order']   = 'asc';
				break;
		}

		if ( ! empty( $categories ) ) {
			$args['category'] = array_map( 'trim', explode( ',', $categories ) );
		}

		return $args;
	}

	/**
	 * Get products array for the current source.
	 *
	 * @param array $settings Widget settings.
	 * @return \WC_Product[]|false Products, or false if WooCommerce is unavailable.
	 */
	private function get_products( $settings ) {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return false;
		}

		return wc_get_products( $this->get_product_query_args( $settings ) );
	}

	/**
	 * Check if product is new (published within last 30 days).
	 *
	 * @param \WC_Product $product WooCommerce product object.
	 * @return bool
	 */
	private function is_product_new( $product ) {
		$created = get_the_date( 'U', $product->get_id() );
		$now     = current_time( 'U' );
		return ( $now - $created ) <= ( 30 * DAY_IN_SECONDS );
	}

	protected function render() {
		$settings = $this->get_settings();
		$products = $this->get_products( $settings );
		require SPIR_SITE_LIBRARY_PATH . '/elements/pawwell/products-grid/template/view.php';
	}
}
