<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Schemes\Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Shop_Zen_Our_Story extends Widget_Base {

	public function get_name() {
		return 'shopzen-elementor-our-story';
	}

	public function get_title() {
		return __( 'Our Story', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-post-content';
	}

	public function get_categories() {
		return [ 'shopzen-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'our story', 'about', 'history', 'image', 'text', 'shop', 'zen' ];
	}

	protected function register_controls() {

		// ─── Content: Story ─────────────────────────────────────────
		$this->start_controls_section(
			'section_story',
			[
				'label' => esc_html__( 'Story', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'image',
			[
				'label' => esc_html__( 'Image', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1200&auto=format&fit=crop',
				],
			]
		);

		$this->add_control(
			'image_position',
			[
				'label' => esc_html__( 'Image Position', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'  => [ 'title' => esc_html__( 'Left', 'spiraclethemes-site-library' ), 'icon' => 'eicon-h-align-left' ],
					'right' => [ 'title' => esc_html__( 'Right', 'spiraclethemes-site-library' ), 'icon' => 'eicon-h-align-right' ],
				],
				'default' => 'left',
				'toggle' => false,
			]
		);

		$this->add_control(
			'heading',
			[
				'label' => esc_html__( 'Heading', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'We started with a simple question', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'paragraphs',
			[
				'label' => esc_html__( 'Paragraphs', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => [
					[
						'name' => 'para_text',
						'label' => esc_html__( 'Text', 'spiraclethemes-site-library' ),
						'type' => Controls_Manager::TEXTAREA,
						'label_block' => true,
						'dynamic' => [ 'active' => true ],
					],
				],
				'default' => [
					[
						'para_text' => esc_html__( "Why should you choose between quality, sustainability, and design? In our small studio in Portland, we began prototyping products we'd actually want to live with — durable water bottles, organic cotton basics, and home goods made from recycled materials.", 'spiraclethemes-site-library' ),
					],
					[
						'para_text' => esc_html__( "Today, Natura serves over 50,000 customers worldwide, but our process hasn't changed. We still test every product for 100+ days, work directly with ethical makers, and plant a tree for every order.", 'spiraclethemes-site-library' ),
					],
				],
				'title_field' => '{{{ para_text }}}',
			]
		);

		$this->end_controls_section();


		// ─── Content: Inline Stats ─────────────────────────────────
		$this->start_controls_section(
			'section_stats',
			[
				'label' => esc_html__( 'Inline Stats', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'show_stats',
			[
				'label' => esc_html__( 'Show Inline Stats', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$stat_repeater = new Repeater();

		$stat_repeater->add_control(
			'stat_value',
			[
				'label' => esc_html__( 'Value', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '50K+', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
			]
		);

		$stat_repeater->add_control(
			'stat_label',
			[
				'label' => esc_html__( 'Label', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Happy Customers', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'story_stats',
			[
				'label' => esc_html__( 'Stats', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $stat_repeater->get_controls(),
				'default' => [
					[
						'stat_value' => esc_html__( '50K+', 'spiraclethemes-site-library' ),
						'stat_label' => esc_html__( 'Happy Customers', 'spiraclethemes-site-library' ),
					],
					[
						'stat_value' => esc_html__( '127', 'spiraclethemes-site-library' ),
						'stat_label' => esc_html__( 'Trees Planted Daily', 'spiraclethemes-site-library' ),
					],
					[
						'stat_value' => esc_html__( '100%', 'spiraclethemes-site-library' ),
						'stat_label' => esc_html__( 'Carbon Neutral', 'spiraclethemes-site-library' ),
					],
				],
				'title_field' => '{{{ stat_value }}} — {{{ stat_label }}}',
				'condition' => [
					'show_stats' => 'yes',
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

		$this->add_responsive_control(
			'section_padding',
			[
				'label' => esc_html__( 'Section Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 64, 'right' => 0, 'bottom' => 64, 'left' => 0,
					'unit' => 'px', 'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopzen-story' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'wrap_max_width',
			[
				'label' => esc_html__( 'Container Max Width (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 600, 'max' => 1600 ] ],
				'default' => [ 'unit' => 'px', 'size' => 1240 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-story-wrap' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'columns_gap',
			[
				'label' => esc_html__( 'Column Gap (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default' => [ 'unit' => 'px', 'size' => 48 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-story-wrap' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Image ───────────────────────────────────────────
		$this->start_controls_section(
			'section_image_style',
			[
				'label' => esc_html__( 'Image', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_height',
			[
				'label' => esc_html__( 'Image Height (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 200, 'max' => 800 ] ],
				'default' => [ 'unit' => 'px', 'size' => 520 ],
				'tablet_default' => [ 'unit' => 'px', 'size' => 400 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-story-img img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_radius',
			[
				'label' => esc_html__( 'Image Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 14 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-story-img' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_border_color',
			[
				'label' => esc_html__( 'Image Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E5E7EB',
				'selectors' => [
					'{{WRAPPER}} .shopzen-story-img' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'image_shadow',
				'label' => esc_html__( 'Image Shadow', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-story-img',
			]
		);

		$this->add_control(
			'image_corner_accent',
			[
				'label' => esc_html__( 'Show Corner Accent', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'selectors' => [
					'{{WRAPPER}} .shopzen-story-img' => 'display: {{VALUE}};',
				],
				'selectors_dictionary' => [
					'yes' => 'block',
					'' => 'none',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Content ────────────────────────────────────────
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'heading_typography',
				'label' => esc_html__( 'Heading Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-story-heading',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Outfit' ],
					'font_size' => [ 'default' => [ 'size' => 28 ] ],
					'font_weight' => [ 'default' => 800 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.2 ] ],
				],
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label' => esc_html__( 'Heading Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1A202C',
				'selectors' => [
					'{{WRAPPER}} .shopzen-story-heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'heading_spacing',
			[
				'label' => esc_html__( 'Heading Bottom Spacing (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 14 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-story-heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'para_typography',
				'label' => esc_html__( 'Paragraph Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-story-para',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Inter' ],
					'font_size' => [ 'default' => [ 'size' => 15 ] ],
					'font_weight' => [ 'default' => 500 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.7 ] ],
				],
			]
		);

		$this->add_control(
			'para_color',
			[
				'label' => esc_html__( 'Paragraph Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#4B5563',
				'selectors' => [
					'{{WRAPPER}} .shopzen-story-para' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'para_spacing',
			[
				'label' => esc_html__( 'Paragraph Bottom Spacing (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default' => [ 'unit' => 'px', 'size' => 14 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-story-para' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Stats ───────────────────────────────────────────
		$this->start_controls_section(
			'section_stats_style',
			[
				'label' => esc_html__( 'Inline Stats', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_stats' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'stat_value_typography',
				'label' => esc_html__( 'Value Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-story-stat strong',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Outfit' ],
					'font_size' => [ 'default' => [ 'size' => 24 ] ],
					'font_weight' => [ 'default' => 800 ],
				],
			]
		);

		$this->add_control(
			'stat_value_color',
			[
				'label' => esc_html__( 'Value Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E3F2A',
				'selectors' => [
					'{{WRAPPER}} .shopzen-story-stat strong' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'stat_label_typography',
				'label' => esc_html__( 'Label Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-story-stat span',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Inter' ],
					'font_size' => [ 'default' => [ 'size' => 12 ] ],
					'font_weight' => [ 'default' => 600 ],
					'text_transform' => [ 'default' => 'uppercase' ],
					'letter_spacing' => [ 'default' => [ 'unit' => 'px', 'size' => 0.4 ] ],
				],
			]
		);

		$this->add_control(
			'stat_label_color',
			[
				'label' => esc_html__( 'Label Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#6B7280',
				'selectors' => [
					'{{WRAPPER}} .shopzen-story-stat span' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'stats_divider_color',
			[
				'label' => esc_html__( 'Top Divider Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E5E7EB',
				'selectors' => [
					'{{WRAPPER}} .shopzen-story-stats' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'stats_gap',
			[
				'label' => esc_html__( 'Stats Gap (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default' => [ 'unit' => 'px', 'size' => 24 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-story-stats' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		require SPIR_SITE_LIBRARY_PATH . '/elements/shop-zen/our-story/template/view.php';
	}
}
