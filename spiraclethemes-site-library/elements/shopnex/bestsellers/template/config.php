<?php


use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Shopnex_Bestsellers extends Widget_Base {

	public function get_name() {
		return 'shopnex-elementor-bestsellers';
	} 

	public function get_title() {
		return __( 'Bestsellers', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-products';
	}

	public function get_categories() {
		return [ 'shopnex-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	protected function register_controls() {

		// ─── Section Header ────────────────────────────────────────
		$this->start_controls_section(
			'section_header',
			[
				'label' => esc_html__( 'Section Header', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'section_tag',
			[
				'label' => esc_html__( 'Tag Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Bestsellers', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'Enter tag text', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'section_title',
			[
				'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Trending Now', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'Enter title', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'section_subtitle',
			[
				'label' => esc_html__( 'Subtitle', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'The styles our community loves to wear - shop the favorites.', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'Enter subtitle', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'show_section_header',
			[
				'label' => esc_html__( 'Show Section Header', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
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
			'prod_count',
			[
				'label' => esc_html__( 'Number of Products', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 6,
				'min' => 1,
				'max' => 24,
			]
		);

		$this->add_control(
			'prod_orderby',
			[
				'label' => esc_html__( 'Order By', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'popularity',
				'options' => [
					'popularity' => esc_html__( 'Popularity (Best Sellers)', 'spiraclethemes-site-library' ),
					'date' => esc_html__( 'Newest First', 'spiraclethemes-site-library' ),
					'price' => esc_html__( 'Price: Low to High', 'spiraclethemes-site-library' ),
					'price-desc' => esc_html__( 'Price: High to Low', 'spiraclethemes-site-library' ),
					'rating' => esc_html__( 'Top Rated', 'spiraclethemes-site-library' ),
					'rand' => esc_html__( 'Random', 'spiraclethemes-site-library' ),
					'title' => esc_html__( 'Title (A-Z)', 'spiraclethemes-site-library' ),
				],
			]
		);

		$this->add_control(
			'prod_categories',
			[
				'label' => esc_html__( 'Product Categories', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter category slugs separated by comma. Leave empty for all categories.', 'spiraclethemes-site-library' ),
				'default' => '',
				'placeholder' => esc_html__( 'e.g. furniture, lighting', 'spiraclethemes-site-library' ),
			]
		);

		$this->end_controls_section();


		// ─── Product Elements ──────────────────────────────────────
		$this->start_controls_section(
			'section_elements',
			[
				'label' => esc_html__( 'Product Elements', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'show_badge',
			[
				'label' => esc_html__( 'Show Product Badge', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_add_to_cart',
			[
				'label' => esc_html__( 'Show Add to Cart Button', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_wishlist',
			[
				'label' => esc_html__( 'Show Wishlist Button', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'description' => esc_html__( 'Note: Wishlist functionality will only work when Shopnex Pro Addons plugin is active.', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'show_category',
			[
				'label' => esc_html__( 'Show Product Category', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_price',
			[
				'label' => esc_html__( 'Show Price', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();


		// ─── Grid Settings ─────────────────────────────────────────
		$this->start_controls_section(
			'section_grid',
			[
				'label' => esc_html__( 'Grid Settings', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'columns',
			[
				'label' => esc_html__( 'Columns', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'options' => [
					'2' => esc_html__( '2 Columns', 'spiraclethemes-site-library' ),
					'3' => esc_html__( '3 Columns', 'spiraclethemes-site-library' ),
					'4' => esc_html__( '4 Columns', 'spiraclethemes-site-library' ),
				],
			]
		);

		$this->add_control(
			'grid_gap',
			[
				'label' => esc_html__( 'Grid Gap (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 60,
						'step' => 2,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 28,
				],
				'selectors' => [
					'{{WRAPPER}} .shopnex-products-grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'card_border_radius',
			[
				'label' => esc_html__( 'Card Border Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 30,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .shopnex-product-card' => 'border-radius: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .shopnex-product-image-wrapper' => 'border-radius: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0;',
				],
			]
		);

		$this->add_responsive_control(
			'section_padding',
			[
				'label' => esc_html__( 'Section Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopnex-bestsellers-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Section Header Style ──────────────────────────────────
		$this->start_controls_section(
			'section_header_style',
			[
				'label' => esc_html__( 'Section Header', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'header_alignment',
			[
				'label' => esc_html__( 'Alignment', 'spiraclethemes-site-library' ),
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
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .shopnex-section-header' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'header_margin_bottom',
			[
				'label' => esc_html__( 'Header Bottom Spacing (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .shopnex-section-header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Tag Style ─────────────────────────────────────────────
		$this->start_controls_section(
			'section_tag_style',
			[
				'label' => esc_html__( 'Tag', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tag_typography',
				'label' => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopnex-section-tag',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 11 ] ],
					'font_weight' => [ 'default' => 600 ],
					'text_transform' => [ 'default' => 'uppercase' ],
					'letter_spacing' => [ 'default' => [ 'size' => 1 ] ],
				],
			]
		);

		$this->add_control(
			'tag_color',
			[
				'label' => esc_html__( 'Tag Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#B8977E',
				'selectors' => [
					'{{WRAPPER}} .shopnex-section-tag' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Title Style ───────────────────────────────────────────
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopnex-section-title',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 40 ] ],
					'font_weight' => [ 'default' => 500 ],
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopnex-section-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Subtitle Style ────────────────────────────────────────
		$this->start_controls_section(
			'section_subtitle_style',
			[
				'label' => esc_html__( 'Subtitle', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'label' => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopnex-section-subtitle',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 15 ] ],
					'font_weight' => [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label' => esc_html__( 'Subtitle Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#6B6560',
				'selectors' => [
					'{{WRAPPER}} .shopnex-section-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Product Badge Style ───────────────────────────────────
		$this->start_controls_section(
			'section_badge_style',
			[
				'label' => esc_html__( 'Product Badge', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'badge_typography',
				'label' => esc_html__( 'Badge Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopnex-product-badge',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 10 ] ],
					'font_weight' => [ 'default' => 500 ],
					'text_transform' => [ 'default' => 'uppercase' ],
					'letter_spacing' => [ 'default' => [ 'size' => 0.7 ] ],
				],
			]
		);

		$this->add_control(
			'badge_bg_color',
			[
				'label' => esc_html__( 'Badge Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopnex-product-badge' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_text_color',
			[
				'label' => esc_html__( 'Badge Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .shopnex-product-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_new_bg_color',
			[
				'label' => esc_html__( '"New" Badge Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#B8977E',
				'selectors' => [
					'{{WRAPPER}} .shopnex-product-badge.badge-new' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_sale_bg_color',
			[
				'label' => esc_html__( '"Sale" Badge Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopnex-product-badge.badge-sale' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Product Card Style ────────────────────────────────────
		$this->start_controls_section(
			'section_product_card_style',
			[
				'label' => esc_html__( 'Product Card', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'card_bg_color',
			[
				'label' => esc_html__( 'Card Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopnex-product-card' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'product_name_typography',
				'label' => esc_html__( 'Product Name Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopnex-product-name',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 15 ] ],
					'font_weight' => [ 'default' => 500 ],
				],
			]
		);

		$this->add_control(
			'product_name_color',
			[
				'label' => esc_html__( 'Product Name Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopnex-product-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_name_hover_color',
			[
				'label' => esc_html__( 'Product Name Hover Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#B8977E',
				'selectors' => [
					'{{WRAPPER}} .shopnex-product-card:hover .shopnex-product-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'product_category_typography',
				'label' => esc_html__( 'Product Category Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopnex-product-category',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 12 ] ],
					'font_weight' => [ 'default' => 400 ],
					'letter_spacing' => [ 'default' => [ 'size' => 0.2 ] ],
				],
			]
		);

		$this->add_control(
			'product_category_color',
			[
				'label' => esc_html__( 'Product Category Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#9C9792',
				'selectors' => [
					'{{WRAPPER}} .shopnex-product-category' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'product_price_typography',
				'label' => esc_html__( 'Price Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopnex-product-price',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 15 ] ],
					'font_weight' => [ 'default' => 600 ],
				],
			]
		);

		$this->add_control(
			'product_price_color',
			[
				'label' => esc_html__( 'Price Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopnex-product-price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_old_price_color',
			[
				'label' => esc_html__( 'Old Price Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#9C9792',
				'selectors' => [
					'{{WRAPPER}} .shopnex-product-price .old-price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_info_padding',
			[
				'label' => esc_html__( 'Product Info Padding', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 18,
					'right' => 16,
					'bottom' => 18,
					'left' => 16,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopnex-product-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Action Buttons Style ──────────────────────────────────
		$this->start_controls_section(
			'section_actions_style',
			[
				'label' => esc_html__( 'Action Buttons', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'action_button_size',
			[
				'label' => esc_html__( 'Button Size (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 28,
						'max' => 56,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 40,
				],
				'selectors' => [
					'{{WRAPPER}} .shopnex-product-actions button' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'action_button_bg',
			[
				'label' => esc_html__( 'Button Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopnex-product-actions button' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'action_button_color',
			[
				'label' => esc_html__( 'Button Icon Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopnex-product-actions button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'action_button_hover_bg',
			[
				'label' => esc_html__( 'Button Hover Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopnex-product-actions button:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'action_button_hover_color',
			[
				'label' => esc_html__( 'Button Hover Icon Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopnex-product-actions button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Check if product is new (published within last 30 days).
	 *
	 * @param WC_Product $product WooCommerce product object.
	 * @return bool
	 */
	private function is_product_new( $product ) {
		$created = get_the_date( 'U', $product->get_id() );
		$now     = current_time( 'U' );
		$days    = 30;
		return ( $now - $created ) <= ( $days * DAY_IN_SECONDS );
	}

	protected function render() {
		require SPIR_SITE_LIBRARY_PATH . '/elements/shopnex/bestsellers/template/view.php';
	}
}
