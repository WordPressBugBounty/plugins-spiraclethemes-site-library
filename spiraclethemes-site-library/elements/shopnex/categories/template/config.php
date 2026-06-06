<?php


use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Shopnex_Categories extends Widget_Base {

	public function get_name() {
		return 'shopnex-elementor-categories';
	} 

	public function get_title() {
		return __( 'Shop by Category', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-product-categories';
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
				'default' => esc_html__( 'Shop by Category', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'Enter tag text', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'section_title',
			[
				'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Curated Styles', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'Enter title', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'section_subtitle',
			[
				'label' => esc_html__( 'Subtitle', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'From everyday essentials to statement pieces — find your perfect fit.', 'spiraclethemes-site-library' ),
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


		// ─── Category Cards ────────────────────────────────────────
		$this->start_controls_section(
			'section_categories',
			[
				'label' => esc_html__( 'Categories', 'spiraclethemes-site-library' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'category_image',
			[
				'label' => esc_html__( 'Choose Image', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'category_title',
			[
				'label' => esc_html__( 'Category Name', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Dresses', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'Enter category name', 'spiraclethemes-site-library' ),
			]
		);

		$repeater->add_control(
			'category_count',
			[
				'label' => esc_html__( 'Item Count Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '48 pieces', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'e.g. 48 pieces', 'spiraclethemes-site-library' ),
			]
		);

		$repeater->add_control(
			'category_link',
			[
				'label' => esc_html__( 'Link URL', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'spiraclethemes-site-library' ),
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => false,
					'nofollow' => false,
				],
			]
		);

		$this->add_control(
			'category_list',
			[
				'label' => esc_html__( 'Category Cards', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'category_title' => esc_html__( 'Dresses', 'spiraclethemes-site-library' ),
						'category_count' => esc_html__( '48 items', 'spiraclethemes-site-library' ),
					],
					[
						'category_title' => esc_html__( 'Tops & Blouses', 'spiraclethemes-site-library' ),
						'category_count' => esc_html__( '32 items', 'spiraclethemes-site-library' ),
					],
					[
						'category_title' => esc_html__( 'Accessories', 'spiraclethemes-site-library' ),
						'category_count' => esc_html__( '56 items', 'spiraclethemes-site-library' ),
					],
				],
				'title_field' => '{{{ category_title }}}',
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
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .shopnex-categories-grid' => 'gap: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .shopnex-category-card' => 'border-radius: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .shopnex-categories-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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


		// ─── Card Overlay ──────────────────────────────────────────
		$this->start_controls_section(
			'section_overlay_style',
			[
				'label' => esc_html__( 'Card Overlay', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'overlay_color',
			[
				'label' => esc_html__( 'Overlay Gradient Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(28, 28, 28, 0.5)',
				'selectors' => [
					'{{WRAPPER}} .shopnex-category-card-overlay' => 'background: linear-gradient(to top, {{VALUE}} 0%, rgba(28, 28, 28, 0) 50%);',
				],
			]
		);

		$this->end_controls_section();


		// ─── Card Content Style ────────────────────────────────────
		$this->start_controls_section(
			'section_card_content_style',
			[
				'label' => esc_html__( 'Card Content', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'card_title_typography',
				'label' => esc_html__( 'Category Title Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopnex-category-card-title',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 22 ] ],
					'font_weight' => [ 'default' => 500 ],
				],
			]
		);

		$this->add_control(
			'card_title_color',
			[
				'label' => esc_html__( 'Category Title Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .shopnex-category-card-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'card_count_typography',
				'label' => esc_html__( 'Item Count Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopnex-category-card-count',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 12 ] ],
				],
			]
		);

		$this->add_control(
			'card_count_color',
			[
				'label' => esc_html__( 'Item Count Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(255, 255, 255, 0.7)',
				'selectors' => [
					'{{WRAPPER}} .shopnex-category-card-count' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_content_padding',
			[
				'label' => esc_html__( 'Content Padding', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 20,
					'left' => 20,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopnex-category-card-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_content_margin',
			[
				'label' => esc_html__( 'Content Margin', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '',
					'right' => '',
					'bottom' => '',
					'left' => '',
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopnex-category-card-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		require SPIR_SITE_LIBRARY_PATH . '/elements/shopnex/categories/template/view.php';
	}
}
