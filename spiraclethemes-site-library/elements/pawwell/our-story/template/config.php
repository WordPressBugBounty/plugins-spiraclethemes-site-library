<?php


use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Pawwell_OurStory extends Widget_Base {

	public function get_name() {
		return 'pawwell-elementor-our-story';
	}

	public function get_title() {
		return __( 'Our Story', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-post-content';
	}

	public function get_categories() {
		return [ 'pawwell-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'story', 'about', 'brand', 'founder', 'mission', 'pawwell' ];
	}

	protected function register_controls() {

		// ─── Content Section ────────────────────────────────────────
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'eyebrow',
			[
				'label' => esc_html__( 'Eyebrow', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'How It All Began', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Born From Love for Pets', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'description',
			[
				'label' => esc_html__( 'Description', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => '<p>PawWell started in 2018 with a simple frustration: finding trustworthy, vet-approved pet products shouldn\'t be so difficult. Our founder, Dr. Maya Chen, spent hours researching every supplement and food brand for her rescue dog, Bruno — only to realize most pet parents didn\'t have the time or expertise to do the same.</p><p>So she assembled a team of veterinarians, pet nutritionists, and fellow animal lovers to curate a collection where every product meets the highest standards of quality, safety, and effectiveness. No fillers, no gimmicks — just products we\'d give our own pets.</p>',
			]
		);

		$this->add_control(
			'layout',
			[
				'label' => esc_html__( 'Image Position', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'spiraclethemes-site-library' ),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'spiraclethemes-site-library' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'left',
				'toggle' => false,
			]
		);

		$this->end_controls_section();


		// ─── Image Section ──────────────────────────────────────────
		$this->start_controls_section(
			'section_image',
			[
				'label' => esc_html__( 'Image', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose Image', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image',
				'default' => 'large',
				'exclude' => [ 'custom' ],
			]
		);

		$this->end_controls_section();


		// ─── Badge Section ──────────────────────────────────────────
		$this->start_controls_section(
			'section_badge',
			[
				'label' => esc_html__( 'Badge', 'spiraclethemes-site-library' ),
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

		$this->add_control(
			'badge_icon',
			[
				'label' => esc_html__( 'Badge Icon', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-paw',
					'library' => 'fa-solid',
				],
				'condition' => [
					'show_badge' => 'yes',
				],
			]
		);

		$this->add_control(
			'badge_value',
			[
				'label' => esc_html__( 'Badge Value', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '7+ Years', 'spiraclethemes-site-library' ),
				'condition' => [
					'show_badge' => 'yes',
				],
			]
		);

		$this->add_control(
			'badge_label',
			[
				'label' => esc_html__( 'Badge Label', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Of trusted pet care', 'spiraclethemes-site-library' ),
				'condition' => [
					'show_badge' => 'yes',
				],
			]
		);

		$this->end_controls_section();


		// ─── Quote Section ──────────────────────────────────────────
		$this->start_controls_section(
			'section_quote',
			[
				'label' => esc_html__( 'Quote', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'show_quote',
			[
				'label' => esc_html__( 'Show Quote', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'quote_text',
			[
				'label' => esc_html__( 'Quote', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'We don\'t just sell pet products. We help families give their pets the longest, healthiest, happiest lives possible.', 'spiraclethemes-site-library' ),
				'condition' => [
					'show_quote' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_signature',
			[
				'label' => esc_html__( 'Show Signature', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'show_quote' => 'yes',
				],
			]
		);

		$this->add_control(
			'sig_avatar_text',
			[
				'label' => esc_html__( 'Avatar Initials', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'M', 'spiraclethemes-site-library' ),
				'condition' => [
					'show_quote' => 'yes',
					'show_signature' => 'yes',
				],
			]
		);

		$this->add_control(
			'sig_name',
			[
				'label' => esc_html__( 'Name', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Dr. Maya Chen', 'spiraclethemes-site-library' ),
				'condition' => [
					'show_quote' => 'yes',
					'show_signature' => 'yes',
				],
			]
		);

		$this->add_control(
			'sig_role',
			[
				'label' => esc_html__( 'Role', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Founder & Chief Veterinarian', 'spiraclethemes-site-library' ),
				'condition' => [
					'show_quote' => 'yes',
					'show_signature' => 'yes',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Section ─────────────────────────────────────────
		$this->start_controls_section(
			'section_section_style',
			[
				'label' => esc_html__( 'Section', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'section_padding',
			[
				'label' => esc_html__( 'Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 100, 'right' => 0, 'bottom' => 100, 'left' => 0,
					'unit' => 'px', 'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .pawwell-os' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'section_bg',
			[
				'label' => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pawwell-os' => 'background: {{VALUE}};',
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
				'default' => 'no',
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
				'default' => 'no',
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

		$this->add_control(
			'max_width',
			[
				'label' => esc_html__( 'Container Max Width (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 960, 'max' => 1600 ] ],
				'default' => [ 'unit' => 'px', 'size' => 1380 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-os-inner' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'grid_gap',
			[
				'label' => esc_html__( 'Column Gap (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
				'default' => [ 'unit' => 'px', 'size' => 60 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-os-grid' => 'gap: {{SIZE}}{{UNIT}};',
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

		$this->add_control(
			'image_radius',
			[
				'label' => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 20 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-os-image-main' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Badge ───────────────────────────────────────────
		$this->start_controls_section(
			'section_badge_style',
			[
				'label' => esc_html__( 'Badge', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'badge_bg',
			[
				'label' => esc_html__( 'Badge Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E1E1E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-os-badge' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_icon_bg',
			[
				'label' => esc_html__( 'Icon Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C45B3E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-os-badge-icon' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_text_color',
			[
				'label' => esc_html__( 'Badge Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .pawwell-os-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Heading ─────────────────────────────────────────
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
				'name' => 'eyebrow_typography',
				'label' => esc_html__( 'Eyebrow Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-os-eyebrow',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 13 ] ],
					'font_weight' => [ 'default' => 700 ],
					'text_transform' => [ 'default' => 'uppercase' ],
					'letter_spacing' => [ 'default' => [ 'size' => 1.5 ] ],
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
					'{{WRAPPER}} .pawwell-os-eyebrow' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Title Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-os-title',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 44 ] ],
					'font_weight' => [ 'default' => 400 ],
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
					'{{WRAPPER}} .pawwell-os-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typography',
				'label' => esc_html__( 'Description Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-os-desc',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 16 ] ],
					'font_weight' => [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label' => esc_html__( 'Description Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#2D2D2D',
				'selectors' => [
					'{{WRAPPER}} .pawwell-os-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Quote ───────────────────────────────────────────
		$this->start_controls_section(
			'section_quote_style',
			[
				'label' => esc_html__( 'Quote', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'quote_typography',
				'label' => esc_html__( 'Quote Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-os-quote',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 20 ] ],
					'font_weight' => [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'quote_color',
			[
				'label' => esc_html__( 'Quote Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E1E1E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-os-quote' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'quote_border_color',
			[
				'label' => esc_html__( 'Quote Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C45B3E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-os-quote' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sig_name_color',
			[
				'label' => esc_html__( 'Signature Name Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E1E1E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-os-sig-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sig_role_color',
			[
				'label' => esc_html__( 'Signature Role Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#8A8A8A',
				'selectors' => [
					'{{WRAPPER}} .pawwell-os-sig-role' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sig_avatar_bg',
			[
				'label' => esc_html__( 'Avatar Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C45B3E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-os-sig-avatar' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		require SPIR_SITE_LIBRARY_PATH . '/elements/pawwell/our-story/template/view.php';
	}
}
