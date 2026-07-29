<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Shop_Zen_Stats extends Widget_Base {

	public function get_name() {
		return 'shopzen-elementor-stats';
	}

	public function get_title() {
		return __( 'Stats', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-counter';
	}

	public function get_categories() {
		return [ 'shopzen-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'stats', 'counters', 'numbers', 'metrics', 'shop', 'zen' ];
	}

	protected function register_controls() {

		// ─── Content: Stats Items ───────────────────────────────────
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Stats', 'spiraclethemes-site-library' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'stat_value',
			[
				'label' => esc_html__( 'Value', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '50K+', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'e.g. 50K+', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'stat_label',
			[
				'label' => esc_html__( 'Label', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Happy Customers', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'Enter label', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'stat_footer_type',
			[
				'label' => esc_html__( 'Footer Element', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'avatars',
				'options' => [
					'avatars' => esc_html__( 'Customer Avatars', 'spiraclethemes-site-library' ),
					'stars'   => esc_html__( 'Star Rating', 'spiraclethemes-site-library' ),
					'icon'    => esc_html__( 'Icon Badge', 'spiraclethemes-site-library' ),
					'none'    => esc_html__( 'None', 'spiraclethemes-site-library' ),
				],
			]
		);

		// Avatars
		$repeater->add_control(
			'stat_avatars',
			[
				'label' => esc_html__( 'Customer Avatars', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::GALLERY,
				'description' => esc_html__( 'Add customer avatar images. Falls back to generated avatars if empty.', 'spiraclethemes-site-library' ),
				'condition' => [
					'stat_footer_type' => 'avatars',
				],
			]
		);

		$repeater->add_control(
			'stat_avatar_count',
			[
				'label' => esc_html__( 'Fallback Avatar Count', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 10,
				'step' => 1,
				'default' => 5,
				'condition' => [
					'stat_footer_type' => 'avatars',
				],
			]
		);

		// Stars
		$repeater->add_control(
			'stat_stars',
			[
				'label' => esc_html__( 'Star Rating (0-5)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'default' => 5.0,
				'condition' => [
					'stat_footer_type' => 'stars',
				],
			]
		);

		// Icon
		$repeater->add_control(
			'stat_icon',
			[
				'label' => esc_html__( 'Icon', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-shopping-cart',
					'library' => 'fa-solid',
				],
				'condition' => [
					'stat_footer_type' => 'icon',
				],
			]
		);

		$this->add_control(
			'stats',
			[
				'label' => esc_html__( 'Stat Items', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'stat_value' => esc_html__( '50K+', 'spiraclethemes-site-library' ),
						'stat_label' => esc_html__( 'Happy Customers', 'spiraclethemes-site-library' ),
						'stat_footer_type' => 'avatars',
						'stat_avatar_count' => 5,
					],
					[
						'stat_value' => esc_html__( '4.8/5', 'spiraclethemes-site-library' ),
						'stat_label' => esc_html__( 'Average Rating', 'spiraclethemes-site-library' ),
						'stat_footer_type' => 'stars',
						'stat_stars' => 5.0,
					],
					[
						'stat_value' => esc_html__( '1000+', 'spiraclethemes-site-library' ),
						'stat_label' => esc_html__( 'Daily Orders', 'spiraclethemes-site-library' ),
						'stat_footer_type' => 'icon',
						'stat_icon' => [ 'value' => 'fas fa-shopping-cart', 'library' => 'fa-solid' ],
					],
					[
						'stat_value' => esc_html__( '7 Days', 'spiraclethemes-site-library' ),
						'stat_label' => esc_html__( 'Fast Delivery', 'spiraclethemes-site-library' ),
						'stat_footer_type' => 'icon',
						'stat_icon' => [ 'value' => 'fas fa-truck', 'library' => 'fa-solid' ],
					],
				],
				'title_field' => '{{{ stat_value }}} — {{{ stat_label }}}',
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

		$this->add_responsive_control(
			'columns',
			[
				'label' => esc_html__( 'Columns', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 6,
				'step' => 1,
				'default' => 4,
				'tablet_default' => 2,
				'mobile_default' => 1,
				'selectors' => [
					'{{WRAPPER}} .shopzen-stats-inner' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label' => esc_html__( 'Row Gap (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default' => [ 'unit' => 'px', 'size' => 0 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-stats-inner' => 'row-gap: {{SIZE}}{{UNIT}};',
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
					'top' => 32, 'right' => 0, 'bottom' => 32, 'left' => 0,
					'unit' => 'px', 'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopzen-stats' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'section_margin_top',
			[
				'label' => esc_html__( 'Margin Top (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
				'default' => [ 'unit' => 'px', 'size' => 40 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-stats' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'section_bg',
			[
				'label' => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F0F7F2',
				'selectors' => [
					'{{WRAPPER}} .shopzen-stats' => 'background-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'border_top_color',
			[
				'label' => esc_html__( 'Top Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#D1E7D6',
				'selectors' => [
					'{{WRAPPER}} .shopzen-stats' => 'border-top: 1px solid {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'border_bottom_color',
			[
				'label' => esc_html__( 'Bottom Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#D1E7D6',
				'selectors' => [
					'{{WRAPPER}} .shopzen-stats' => 'border-bottom: 1px solid {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'divider_show',
			[
				'label' => esc_html__( 'Item Dividers', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'divider_color',
			[
				'label' => esc_html__( 'Divider Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#D1E7D6',
				'selectors' => [
					'{{WRAPPER}} .shopzen-stat-item' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'divider_show' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'item_padding',
			[
				'label' => esc_html__( 'Item Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 0, 'right' => 20, 'bottom' => 0, 'left' => 20,
					'unit' => 'px', 'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopzen-stat-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Value & Label ───────────────────────────────────
		$this->start_controls_section(
			'section_value_style',
			[
				'label' => esc_html__( 'Value & Label', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'value_typography',
				'label' => esc_html__( 'Value Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-stat-value',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Outfit' ],
					'font_size' => [ 'default' => [ 'size' => 32 ] ],
					'font_weight' => [ 'default' => 700 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1 ] ],
				],
			]
		);

		$this->add_control(
			'value_color',
			[
				'label' => esc_html__( 'Value Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1F2937',
				'selectors' => [
					'{{WRAPPER}} .shopzen-stat-value' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'label' => esc_html__( 'Label Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-stat-label',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Inter' ],
					'font_size' => [ 'default' => [ 'size' => 14 ] ],
					'font_weight' => [ 'default' => 500 ],
				],
			]
		);

		$this->add_control(
			'label_color',
			[
				'label' => esc_html__( 'Label Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#6B7280',
				'selectors' => [
					'{{WRAPPER}} .shopzen-stat-label' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'label_margin',
			[
				'label' => esc_html__( 'Label Bottom Margin (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default' => [ 'unit' => 'px', 'size' => 12 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-stat-label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Footer Elements ─────────────────────────────────
		$this->start_controls_section(
			'section_footer_style',
			[
				'label' => esc_html__( 'Footer Elements', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'stars_color',
			[
				'label' => esc_html__( 'Stars Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F59E0B',
				'selectors' => [
					'{{WRAPPER}} .shopzen-stat-stars' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'stars_size',
			[
				'label' => esc_html__( 'Stars Size (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 10, 'max' => 32 ] ],
				'default' => [ 'unit' => 'px', 'size' => 16 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-stat-stars' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_badge_heading',
			[
				'label' => esc_html__( 'Icon Badge', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon_badge_bg',
			[
				'label' => esc_html__( 'Icon Badge Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .shopzen-stat-badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_badge_color',
			[
				'label' => esc_html__( 'Icon Badge Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopzen-stat-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_badge_size',
			[
				'label' => esc_html__( 'Icon Badge Size (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 24, 'max' => 80 ] ],
				'default' => [ 'unit' => 'px', 'size' => 36 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-stat-badge' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_badge_radius',
			[
				'label' => esc_html__( 'Icon Badge Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 999 ] ],
				'default' => [ 'unit' => 'px', 'size' => 999 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-stat-badge' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'avatars_heading',
			[
				'label' => esc_html__( 'Customer Avatars', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'avatar_size',
			[
				'label' => esc_html__( 'Avatar Size (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 16, 'max' => 64 ] ],
				'default' => [ 'unit' => 'px', 'size' => 28 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-stat-avatar' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'avatar_border_color',
			[
				'label' => esc_html__( 'Avatar Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopzen-stat-avatar' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'avatar_overlap',
			[
				'label' => esc_html__( 'Avatar Overlap (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => -20, 'max' => 0 ] ],
				'default' => [ 'unit' => 'px', 'size' => -8 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-stat-avatar' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .shopzen-stat-avatar:first-child' => 'margin-left: 0;',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		require SPIR_SITE_LIBRARY_PATH . '/elements/shop-zen/stats/template/view.php';
	}
}
