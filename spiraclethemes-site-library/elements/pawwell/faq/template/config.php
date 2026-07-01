<?php


use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Pawwell_FAQ extends Widget_Base {

	public function get_name() {
		return 'pawwell-elementor-faq';
	}

	public function get_title() {
		return __( 'FAQ', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-toggle';
	}

	public function get_categories() {
		return [ 'pawwell-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'faq', 'questions', 'accordion', 'help', 'answers', 'pawwell' ];
	}

	protected function register_controls() {

		// ─── Heading Section ────────────────────────────────────────
		$this->start_controls_section(
			'section_heading',
			[
				'label' => esc_html__( 'Heading', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'eyebrow',
			[
				'label' => esc_html__( 'Eyebrow', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Quick Answers', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Frequently Asked Questions', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'heading_align',
			[
				'label' => esc_html__( 'Heading Alignment', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'left',
				'options' => [
					'left'   => [ 'title' => esc_html__( 'Left', 'spiraclethemes-site-library' ), 'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'spiraclethemes-site-library' ), 'icon' => 'eicon-text-align-center' ],
				],
				'selectors' => [
					'{{WRAPPER}} .pawwell-faq-head' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── FAQ Items Section ──────────────────────────────────────
		$this->start_controls_section(
			'section_items',
			[
				'label' => esc_html__( 'FAQ Items', 'spiraclethemes-site-library' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'question',
			[
				'label' => esc_html__( 'Question', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'How fast will I get a response?', 'spiraclethemes-site-library' ),
			]
		);

		$repeater->add_control(
			'answer',
			[
				'label' => esc_html__( 'Answer', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Most messages are answered within a few hours during business days (Mon–Sat, 9AM–8PM PT). Urgent order or health questions are prioritized and typically handled within the hour.', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'items',
			[
				'label' => esc_html__( 'Items', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'question' => esc_html__( 'How fast will I get a response?', 'spiraclethemes-site-library' ),
						'answer'   => esc_html__( 'Most messages are answered within a few hours during business days (Mon–Sat, 9AM–8PM PT). Urgent order or health questions are prioritized and typically handled within the hour.', 'spiraclethemes-site-library' ),
					],
					[
						'question' => esc_html__( 'Can I change or cancel my order?', 'spiraclethemes-site-library' ),
						'answer'   => esc_html__( "Yes — orders can be changed or cancelled within 2 hours of placing them. Use the “Order Help” topic in the form above and include your order number, or call us directly for the fastest service.", 'spiraclethemes-site-library' ),
					],
					[
						'question' => esc_html__( 'Do you offer veterinary advice?', 'spiraclethemes-site-library' ),
						'answer'   => esc_html__( 'Our team includes licensed veterinary advisors who can help with general nutrition, product suitability, and care questions. For emergencies or diagnoses, always contact your local vet clinic immediately.', 'spiraclethemes-site-library' ),
					],
					[
						'question' => esc_html__( 'What is your return policy?', 'spiraclethemes-site-library' ),
						'answer'   => esc_html__( "We offer a 30-day money-back guarantee on unopened products. If something isn't right with your order, reach out and we'll make it right — no fuss, no paperwork headaches.", 'spiraclethemes-site-library' ),
					],
					[
						'question' => esc_html__( 'Do you ship internationally?', 'spiraclethemes-site-library' ),
						'answer'   => esc_html__( 'Currently we ship across the US and Canada, with free shipping on orders over $49. International expansion is on the way — follow us on social for launch announcements in your region.', 'spiraclethemes-site-library' ),
					],
					[
						'question' => esc_html__( 'Are your products vet-approved?', 'spiraclethemes-site-library' ),
						'answer'   => esc_html__( 'Every product is reviewed and approved by our team of licensed veterinarians before it reaches our shelves. No exceptions, no shortcuts.', 'spiraclethemes-site-library' ),
					],
				],
				'title_field' => '{{{ question }}}',
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => esc_html__( 'Columns', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SELECT,
				'default' => '2',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
				],
				'render_type' => 'template',
				'selectors' => [
					'{{WRAPPER}} .pawwell-faq-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				],
			]
		);

		$this->add_control(
			'open_first',
			[
				'label' => esc_html__( 'Open First Item by Default', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'single_open',
			[
				'label' => esc_html__( 'Close Others When Opening', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();


		// ─── Section Style ─────────────────────────────────────────
		$this->start_controls_section(
			'section_section_style',
			[
				'label' => esc_html__( 'Section', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'section_bg',
			[
				'label' => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FAF6F1',
				'selectors' => [
					'{{WRAPPER}} .pawwell-faq' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_bg',
			[
				'label' => esc_html__( 'Card Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .pawwell-faq-item' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_bg',
			[
				'label' => esc_html__( 'Icon Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FAF6F1',
				'selectors' => [
					'{{WRAPPER}} .pawwell-faq-ic' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C45B3E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-faq-ic' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'accent_color',
			[
				'label' => esc_html__( 'Open Icon Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C45B3E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-faq-item.open .pawwell-faq-ic' => 'background: {{VALUE}};',
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
					'{{WRAPPER}} .pawwell-faq-inner' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Text ────────────────────────────────────────────
		$this->start_controls_section(
			'section_text_style',
			[
				'label' => esc_html__( 'Text', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typo',
				'label' => esc_html__( 'Title Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-faq-title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E1E1E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-faq-title' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pawwell-faq-q' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .pawwell-faq-eyebrow' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'answer_color',
			[
				'label' => esc_html__( 'Answer Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#5A5A5A',
				'selectors' => [
					'{{WRAPPER}} .pawwell-faq-a-inner' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$template = SPIR_SITE_LIBRARY_PATH . '/elements/pawwell/faq/template/view.php';
		if ( file_exists( $template ) ) {
			include $template;
		}
	}
}
