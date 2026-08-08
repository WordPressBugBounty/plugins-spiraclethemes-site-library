<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Stats
 *
 * A centered metrics band for the Shopbar theme: a row of big Fraunces
 * numbers each with a short label, on a warm cream surface. Mirrors the
 * stats-band of the Shopbar design spec.
 *
 * @since 1.0.0
 */
class Shopbar_Stats extends Widget_Base {

	public function get_name() {
		return 'shopbar-elementor-stats';
	}

	public function get_title() {
		return __( 'Stats', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-counter';
	}

	public function get_categories() {
		return [ 'shopbar-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'stats', 'counters', 'numbers', 'metrics', 'band', 'shopbar' ];
	}

	protected function register_controls() {

		// ─── Content: Stats ───────────────────────────────────────────
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Stats', 'spiraclethemes-site-library' ),
			]
		);

		$repeater = new Repeater();
		$repeater->add_control(
			'value',
			[
				'label'       => esc_html__( 'Value', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '50K+', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'label',
			[
				'label'       => esc_html__( 'Label', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Happy Customers', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'stats',
			[
				'label'       => esc_html__( 'Items', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[ 'value' => '50K+', 'label' => 'Happy Customers' ],
					[ 'value' => '10K+', 'label' => 'Quality Products' ],
					[ 'value' => '120+', 'label' => 'Trusted Brands' ],
					[ 'value' => '15+',  'label' => 'Countries Served' ],
				],
				'title_field' => '{{{ value }}}',
			]
		);

		$this->end_controls_section();


		// ─── Content: Layout ──────────────────────────────────────────
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'           => esc_html__( 'Columns', 'spiraclethemes-site-library' ),
				'type'            => Controls_Manager::NUMBER,
				'min'             => 1,
				'max'             => 6,
				'default'         => 4,
				'desktop_default' => 4,
				'tablet_default'  => 2,
				'mobile_default'  => 1,
				'selectors'       => [
					'{{WRAPPER}} .shopbar-st-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'label'      => esc_html__( 'Column Gap (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-st-grid' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label'      => esc_html__( 'Row Gap (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-st-grid' => 'row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_align',
			[
				'label'         => esc_html__( 'Alignment', 'spiraclethemes-site-library' ),
				'type'          => Controls_Manager::CHOOSE,
				'default'       => 'center',
				'options'       => [
					'left'   => [ 'title' => esc_html__( 'Left', 'spiraclethemes-site-library' ),   'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'spiraclethemes-site-library' ), 'icon' => 'eicon-text-align-center' ],
					'right'  => [ 'title' => esc_html__( 'Right', 'spiraclethemes-site-library' ),  'icon' => 'eicon-text-align-right' ],
				],
				'prefix_class'  => 'shopbar-st-align-',
				'toggle'        => false,
			]
		);

		$this->end_controls_section();


		// ─── Style: Band ──────────────────────────────────────────────
		$this->start_controls_section(
			'section_style_band',
			[
				'label' => esc_html__( 'Band', 'spiraclethemes-site-library' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'band_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .shopbar-st-inner',
				'fields_options' => [
					'background' => [ 'default' => 'classic' ],
					'color'      => [ 'default' => '#F3EFEA' ],
				],
			]
		);

		$this->add_responsive_control(
			'band_padding',
			[
				'label'      => esc_html__( 'Padding (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top' => 48, 'right' => 40, 'bottom' => 48, 'left' => 40, 'unit' => 'px', 'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-st-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'band_radius',
			[
				'label'      => esc_html__( 'Radius (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 0 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-st-inner' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'band_border',
				'selector' => '{{WRAPPER}} .shopbar-st-inner',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'band_shadow',
				'selector' => '{{WRAPPER}} .shopbar-st-inner',
			]
		);

		$this->add_control(
			'band_max_width',
			[
				'label'        => esc_html__( 'Full Width', 'spiraclethemes-site-library' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'full',
				'default'      => 'full',
				'separator'    => 'before',
				'description'  => esc_html__( 'Stretch the band edge-to-edge. Off to contain it within the 1350px content width.', 'spiraclethemes-site-library' ),
			]
		);

		$this->end_controls_section();


		// ─── Style: Number ────────────────────────────────────────────
		$this->start_controls_section(
			'section_style_number',
			[
				'label' => esc_html__( 'Number', 'spiraclethemes-site-library' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'number_typography',
				'label'          => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector'       => '{{WRAPPER}} .shopbar-st-value',
				'fields_options' => [
					'typography'  => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Fraunces' ],
					'font_size'   => [ 'default' => [ 'size' => 40 ] ],
					'font_weight' => [ 'default' => 600 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.1 ] ],
				],
			]
		);

		$this->add_control(
			'number_color',
			[
				'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-st-value' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'number_accent',
			[
				'label'     => esc_html__( 'Accent (symbol)', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#B8977E',
				'description' => esc_html__( 'Applied to the trailing symbol (+, K, etc.) for a warm highlight.', 'spiraclethemes-site-library' ),
				'selectors' => [
					'{{WRAPPER}} .shopbar-st-value-accent' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'number_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 6 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-st-value' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Label ─────────────────────────────────────────────
		$this->start_controls_section(
			'section_style_label',
			[
				'label' => esc_html__( 'Label', 'spiraclethemes-site-library' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'label_typography',
				'label'          => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector'       => '{{WRAPPER}} .shopbar-st-label',
				'fields_options' => [
					'typography'  => [ 'default' => 'yes' ],
					'font_size'   => [ 'default' => [ 'size' => 14 ] ],
					'font_weight' => [ 'default' => 500 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.4 ] ],
				],
			]
		);

		$this->add_control(
			'label_color',
			[
				'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6B6560',
				'selectors' => [
					'{{WRAPPER}} .shopbar-st-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Divider ───────────────────────────────────────────
		$this->start_controls_section(
			'section_style_divider',
			[
				'label' => esc_html__( 'Divider', 'spiraclethemes-site-library' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'show_divider',
			[
				'label'        => esc_html__( 'Show Dividers', 'spiraclethemes-site-library' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default'      => '',
				'selectors_dictionary' => [
					'yes' => '1px',
					''    => '0',
				],
				'selectors' => [
					'{{WRAPPER}} .shopbar-st-item' => 'border-left-width: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'divider_color',
			[
				'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#E8E4DF',
				'condition' => [ 'show_divider' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-st-item' => 'border-left-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'divider_padding',
			[
				'label'      => esc_html__( 'Side Padding (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 48 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 20 ],
				'condition'  => [ 'show_divider' => 'yes' ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-st-item' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		require __DIR__ . '/view.php';
	}

	protected function content_template() {}
}
