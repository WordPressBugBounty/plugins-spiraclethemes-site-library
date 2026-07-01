<?php


use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Pawwell_ContactForm extends Widget_Base {

	public function get_name() {
		return 'pawwell-elementor-contact-form';
	}

	public function get_title() {
		return __( 'Contact Form', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-mail';
	}

	public function get_categories() {
		return [ 'pawwell-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'contact', 'form', 'email', 'cf7', 'message', 'get in touch', 'pawwell' ];
	}

	protected function register_controls() {

		// ─── Intro Section ──────────────────────────────────────────
		$this->start_controls_section(
			'section_intro',
			[
				'label' => esc_html__( 'Intro', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'info_title',
			[
				'label' => esc_html__( 'Info Title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Reach Out, Any Way You Like', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'info_desc',
			[
				'label' => esc_html__( 'Info Description', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( "Whether you prefer a quick call, a detailed email, or a real-time chat, we've made it easy to get the answers you and your pet deserve.", 'spiraclethemes-site-library' ),
			]
		);

		$this->end_controls_section();


		// ─── Contact Methods Section ───────────────────────────────
		$this->start_controls_section(
			'section_methods',
			[
				'label' => esc_html__( 'Contact Methods', 'spiraclethemes-site-library' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'method_icon',
			[
				'label' => esc_html__( 'Icon', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-phone',
					'library' => 'fa-solid',
				],
				'recommended' => [ 'fa-solid' => [ 'phone', 'envelope', 'comment', 'location-dot', 'headset', 'mobile' ] ],
			]
		);

		$repeater->add_control(
			'method_icon_bg',
			[
				'label' => esc_html__( 'Icon Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F4E0DA',
			]
		);

		$repeater->add_control(
			'method_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C45B3E',
			]
		);

		$repeater->add_control(
			'method_label',
			[
				'label' => esc_html__( 'Label', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Call Us', 'spiraclethemes-site-library' ),
			]
		);

		$repeater->add_control(
			'method_value',
			[
				'label' => esc_html__( 'Value', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '1-800-PAW-WELL', 'spiraclethemes-site-library' ),
			]
		);

		$repeater->add_control(
			'method_url',
			[
				'label' => esc_html__( 'Link URL', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'tel:18007292273', 'spiraclethemes-site-library' ),
				'dynamic' => [ 'active' => true ],
				'default' => [ 'url' => '', 'is_external' => false ],
			]
		);

		$this->add_control(
			'methods',
			[
				'label' => esc_html__( 'Methods', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'method_label' => esc_html__( 'Call Us', 'spiraclethemes-site-library' ),
						'method_value' => esc_html__( '1-800-PAW-WELL', 'spiraclethemes-site-library' ),
						'method_url'   => [ 'url' => 'tel:18007292273', 'is_external' => false ],
						'method_icon'  => [ 'value' => 'fas fa-phone', 'library' => 'fa-solid' ],
						'method_icon_bg' => '#F4E0DA',
						'method_icon_color' => '#C45B3E',
					],
					[
						'method_label' => esc_html__( 'Email Us', 'spiraclethemes-site-library' ),
						'method_value' => esc_html__( 'hello@pawwell.com', 'spiraclethemes-site-library' ),
						'method_url'   => [ 'url' => 'mailto:hello@pawwell.com', 'is_external' => false ],
						'method_icon'  => [ 'value' => 'fas fa-envelope', 'library' => 'fa-solid' ],
						'method_icon_bg' => '#E8F0E4',
						'method_icon_color' => '#5E7350',
					],
					[
						'method_label' => esc_html__( 'Live Chat', 'spiraclethemes-site-library' ),
						'method_value' => esc_html__( 'Chat with a Pet Advisor', 'spiraclethemes-site-library' ),
						'method_url'   => [ 'url' => '#', 'is_external' => false ],
						'method_icon'  => [ 'value' => 'fas fa-comment', 'library' => 'fa-solid' ],
						'method_icon_bg' => '#FBF1DC',
						'method_icon_color' => '#C99A2E',
					],
					[
						'method_label' => esc_html__( 'Visit the Store', 'spiraclethemes-site-library' ),
						'method_value' => esc_html__( '123 PawWell Ave, San Francisco, CA', 'spiraclethemes-site-library' ),
						'method_url'   => [ 'url' => '', 'is_external' => false ],
						'method_icon'  => [ 'value' => 'fas fa-location-dot', 'library' => 'fa-solid' ],
						'method_icon_bg' => '#E8F0FE',
						'method_icon_color' => '#3B6DB4',
					],
				],
				'title_field' => '{{{ method_label }}}',
			]
		);

		$this->end_controls_section();


		// ─── Social Links Section ───────────────────────────────────
		$this->start_controls_section(
			'section_socials',
			[
				'label' => esc_html__( 'Social Links', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'socials_label',
			[
				'label' => esc_html__( 'Label', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Follow Along', 'spiraclethemes-site-library' ),
			]
		);

		$social_repeater = new Repeater();

		$social_repeater->add_control(
			'network',
			[
				'label' => esc_html__( 'Network', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'x',
				'options' => [
					'x'         => esc_html__( 'X (Twitter)', 'spiraclethemes-site-library' ),
					'facebook'  => esc_html__( 'Facebook', 'spiraclethemes-site-library' ),
					'instagram' => esc_html__( 'Instagram', 'spiraclethemes-site-library' ),
					'youtube'   => esc_html__( 'YouTube', 'spiraclethemes-site-library' ),
					'whatsapp'  => esc_html__( 'WhatsApp', 'spiraclethemes-site-library' ),
					'tiktok'    => esc_html__( 'TikTok', 'spiraclethemes-site-library' ),
				],
			]
		);

		$social_repeater->add_control(
			'url',
			[
				'label' => esc_html__( 'Profile URL', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://x.com/username', 'spiraclethemes-site-library' ),
				'dynamic' => [ 'active' => true ],
				'show_external' => true,
				'default' => [ 'url' => '', 'is_external' => true ],
			]
		);

		$this->add_control(
			'socials',
			[
				'label' => esc_html__( 'Social Networks', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $social_repeater->get_controls(),
				'title_field' => '{{{ network }}}',
				'prevent_empty' => false,
			]
		);

		$this->end_controls_section();


		// ─── Form Section ───────────────────────────────────────────
		$this->start_controls_section(
			'section_form',
			[
				'label' => esc_html__( 'Form', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'form_eyebrow',
			[
				'label' => esc_html__( 'Form Eyebrow', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Send a Message', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'form_title',
			[
				'label' => esc_html__( 'Form Title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'How Can We Help?', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'form_desc',
			[
				'label' => esc_html__( 'Form Description', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( "Fill out the form below and we'll get back to you within one business day.", 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'cf7_shortcode',
			[
				'label' => esc_html__( 'Contact Form 7 Shortcode', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'description' => esc_html__( 'Paste your Contact Form 7 shortcode here, e.g. [contact-form-7 id="123" title="Contact form"]', 'spiraclethemes-site-library' ),
				'placeholder' => '[contact-form-7 id="123" title="Contact form"]',
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'form_note',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => esc_html__( 'If no shortcode is provided, a friendly placeholder will show instead. The form will not appear in the editor preview.', 'spiraclethemes-site-library' ),
				'content_classes' => 'elementor-descriptor',
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
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .pawwell-cf' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'form_card_bg',
			[
				'label' => esc_html__( 'Form Card Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .pawwell-cf-form-wrap' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'method_card_bg',
			[
				'label' => esc_html__( 'Method Card Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .pawwell-cf-method' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'accent_color',
			[
				'label' => esc_html__( 'Form Accent Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C45B3E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-cf-form-wrap' => '--pawwell-cf-accent: {{VALUE}};',
					'{{WRAPPER}} .pawwell-cf-form-wrap .wpcf7-form-control.wpcf7-submit' => 'background: {{VALUE}};border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'layout',
			[
				'label' => esc_html__( 'Layout', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => '2col',
				'options' => [
					'2col' => [ 'title' => esc_html__( 'Two Columns', 'spiraclethemes-site-library' ), 'icon' => 'eicon-columns' ],
					'1col' => [ 'title' => esc_html__( 'Form Only', 'spiraclethemes-site-library' ), 'icon' => 'eicon-single-post' ],
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
					'{{WRAPPER}} .pawwell-cf-inner' => 'max-width: {{SIZE}}{{UNIT}};',
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
				'label' => esc_html__( 'Info Title Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-cf-info-title',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'form_title_typo',
				'label' => esc_html__( 'Form Title Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-cf-form-title',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 28 ] ],
					'font_weight' => [ 'default' => 700 ],
				],
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label' => esc_html__( 'Headings Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E1E1E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-cf-info-title' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pawwell-cf-form-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#8A8A8A',
				'selectors' => [
					'{{WRAPPER}} .pawwell-cf-info-desc' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pawwell-cf-form-desc' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .pawwell-cf-eyebrow' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'eyebrow_typo',
				'label' => esc_html__( 'Form Eyebrow Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-cf-eyebrow',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 13 ] ],
					'font_weight' => [ 'default' => 700 ],
					'text_transform' => [ 'default' => 'uppercase' ],
					'letter_spacing' => [ 'default' => [ 'size' => 1.5 ] ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'info_desc_typo',
				'label' => esc_html__( 'Info Description Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-cf-info-desc',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 16 ] ],
					'font_weight' => [ 'default' => 400 ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'form_desc_typo',
				'label' => esc_html__( 'Form Description Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-cf-form-desc',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 15 ] ],
					'font_weight' => [ 'default' => 400 ],
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$template = SPIR_SITE_LIBRARY_PATH . '/elements/pawwell/contact-form/template/view.php';
		if ( file_exists( $template ) ) {
			include $template;
		}
	}
}
