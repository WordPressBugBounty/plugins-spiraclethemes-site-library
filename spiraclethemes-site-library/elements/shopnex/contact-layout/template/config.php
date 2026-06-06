<?php
/**
 * Contact Layout Widget for Shopnex Theme
 *
 * @package SpiracleThemes_Site_Library
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Shopnex_ContactLayout extends \Elementor\Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'shopnex-elementor-contact-layout';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return esc_html__( 'Contact Layout', 'spiraclethemes-site-library' );
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-email-field';
    }

    /**
     * Get widget categories
     */
    public function get_categories() {
        return array( 'shopnex-elementor' );
    }

    /**
     * Get widget keywords
     */
    public function get_keywords() {
        return array( 'contact', 'form', 'layout', 'info', 'hours', 'address', 'shopnex' );
    }

    /**
     * Register widget controls
     */
    protected function register_controls() {

        // ─── Form Content Section ───
        $this->start_controls_section(
            'section_form_content',
            array(
                'label' => esc_html__( 'Contact Form', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'form_heading',
            array(
                'label'       => esc_html__( 'Form Heading', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Send us a message', 'spiraclethemes-site-library' ),
                'label_block' => true,
            )
        );

        $this->add_control(
            'form_subheading',
            array(
                'label'       => esc_html__( 'Form Subheading', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__( "Fill out the form below and we'll get back to you within 24 hours.", 'spiraclethemes-site-library' ),
                'label_block' => true,
                'rows'        => 2,
            )
        );

        $this->add_control(
            'form_shortcode',
            array(
                'label'       => esc_html__( 'Contact Form Shortcode', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( '[contact-form-7 id="123"]', 'spiraclethemes-site-library' ),
                'label_block' => true,
                'description' => esc_html__( 'Enter a contact form shortcode (e.g. Contact Form 7, WPForms). Leave empty to show a placeholder form.', 'spiraclethemes-site-library' ),
            )
        );

        $this->add_control(
            'submit_button_text',
            array(
                'label'       => esc_html__( 'Submit Button Text', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Send Message', 'spiraclethemes-site-library' ),
                'label_block' => true,
            )
        );

        $this->add_control(
            'form_note',
            array(
                'label'       => esc_html__( 'Form Note', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'We typically respond within one business day. For urgent inquiries, please call us directly.', 'spiraclethemes-site-library' ),
                'label_block' => true,
                'rows'        => 2,
            )
        );

        $this->end_controls_section();

        // ─── Card 1: Visit Us ───
        $this->start_controls_section(
            'section_card_visit',
            array(
                'label' => esc_html__( 'Card: Visit Us', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'show_card_visit',
            array(
                'label'        => esc_html__( 'Show Card', 'spiraclethemes-site-library' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
                'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->add_control(
            'card_visit_icon',
            array(
                'label'            => esc_html__( 'Icon', 'spiraclethemes-site-library' ),
                'type'             => \Elementor\Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default'          => array(
                    'value' => 'fas fa-map-marker-alt',
                    'library' => 'fa-solid',
                ),
                'condition'        => array(
                    'show_card_visit' => 'yes',
                ),
            )
        );

        $this->add_control(
            'card_visit_title',
            array(
                'label'       => esc_html__( 'Title', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Visit our studio', 'spiraclethemes-site-library' ),
                'label_block' => true,
                'condition'   => array(
                    'show_card_visit' => 'yes',
                ),
            )
        );

        $this->add_control(
            'card_visit_address',
            array(
                'label'       => esc_html__( 'Address', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__( "NORD. Headquarters\n47 Viktoria Street\nStockholm, Sweden 114 55", 'spiraclethemes-site-library' ),
                'label_block' => true,
                'rows'        => 4,
                'condition'   => array(
                    'show_card_visit' => 'yes',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Card 2: Contact Us ───
        $this->start_controls_section(
            'section_card_contact',
            array(
                'label' => esc_html__( 'Card: Contact Us', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'show_card_contact',
            array(
                'label'        => esc_html__( 'Show Card', 'spiraclethemes-site-library' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
                'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->add_control(
            'card_contact_icon',
            array(
                'label'            => esc_html__( 'Icon', 'spiraclethemes-site-library' ),
                'type'             => \Elementor\Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default'          => array(
                    'value' => 'fas fa-envelope',
                    'library' => 'fa-solid',
                ),
                'condition'        => array(
                    'show_card_contact' => 'yes',
                ),
            )
        );

        $this->add_control(
            'card_contact_title',
            array(
                'label'       => esc_html__( 'Title', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Contact us', 'spiraclethemes-site-library' ),
                'label_block' => true,
                'condition'   => array(
                    'show_card_contact' => 'yes',
                ),
            )
        );

        $this->add_control(
            'card_contact_email',
            array(
                'label'       => esc_html__( 'Email Address', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'hello@nord.com', 'spiraclethemes-site-library' ),
                'label_block' => true,
                'condition'   => array(
                    'show_card_contact' => 'yes',
                ),
            )
        );

        $this->add_control(
            'card_contact_phone',
            array(
                'label'       => esc_html__( 'Phone Number', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( '+46 8 123 456 78', 'spiraclethemes-site-library' ),
                'label_block' => true,
                'condition'   => array(
                    'show_card_contact' => 'yes',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Card 3: Studio Hours ───
        $this->start_controls_section(
            'section_card_hours',
            array(
                'label' => esc_html__( 'Card: Studio Hours', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'show_card_hours',
            array(
                'label'        => esc_html__( 'Show Card', 'spiraclethemes-site-library' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
                'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->add_control(
            'card_hours_icon',
            array(
                'label'            => esc_html__( 'Icon', 'spiraclethemes-site-library' ),
                'type'             => \Elementor\Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default'          => array(
                    'value' => 'fas fa-clock',
                    'library' => 'fa-solid',
                ),
                'condition'        => array(
                    'show_card_hours' => 'yes',
                ),
            )
        );

        $this->add_control(
            'card_hours_title',
            array(
                'label'       => esc_html__( 'Title', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Studio hours', 'spiraclethemes-site-library' ),
                'label_block' => true,
                'condition'   => array(
                    'show_card_hours' => 'yes',
                ),
            )
        );

        $this->add_control(
            'card_hours_items',
            array(
                'label'       => esc_html__( 'Hours', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'description' => esc_html__( 'One item per line. Use format: Day | Hours (e.g., Mon — Fri | 10:00 — 18:00)', 'spiraclethemes-site-library' ),
                'default'     => "Mon — Fri | 10:00 — 18:00\nSaturday | 11:00 — 16:00\nSunday | Closed",
                'rows'        => 5,
                'condition'   => array(
                    'show_card_hours' => 'yes',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Layout Section ───
        $this->start_controls_section(
            'section_layout',
            array(
                'label' => esc_html__( 'Layout', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_responsive_control(
            'layout_gap',
            array(
                'label'      => esc_html__( 'Gap', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'default'    => array(
                    'size' => 56,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-contact-layout' => 'gap: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'sidebar_width',
            array(
                'label'      => esc_html__( 'Sidebar Width', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%' ),
                'range'      => array(
                    'px' => array(
                        'min' => 200,
                        'max' => 600,
                    ),
                    '%'  => array(
                        'min' => 20,
                        'max' => 50,
                    ),
                ),
                'default'    => array(
                    'size' => 400,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-contact-layout' => 'grid-template-columns: 1fr {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'section_margin_bottom',
            array(
                'label'      => esc_html__( 'Margin Bottom', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 120,
                    ),
                ),
                'default'    => array(
                    'size' => 0,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-contact-layout' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Form Wrapper Style ───
        $this->start_controls_section(
            'section_form_style',
            array(
                'label' => esc_html__( 'Form Wrapper', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'form_bg_color',
            array(
                'label'     => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-contact-form-wrapper' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            array(
                'name'     => 'form_border',
                'selector' => '{{WRAPPER}} .shopnex-contact-form-wrapper',
                'default'  => array(
                    'border' => '1px solid #F0EDE9',
                ),
            )
        );

        $this->add_control(
            'form_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 50,
                    ),
                ),
                'default'    => array(
                    'size' => 16,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-contact-form-wrapper' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'form_padding',
            array(
                'label'      => esc_html__( 'Padding', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'default'    => array(
                    'top'    => '40',
                    'right'  => '40',
                    'bottom' => '40',
                    'left'   => '40',
                    'unit'   => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-contact-form-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Form Heading Style ───
        $this->start_controls_section(
            'section_form_heading_style',
            array(
                'label' => esc_html__( 'Form Heading', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'form_heading_typography',
                'selector' => '{{WRAPPER}} .shopnex-contact-form-heading',
                'default'  => array(
                    'font_size'   => array( 'size' => 24, 'unit' => 'px' ),
                    'font_weight' => '500',
                    'font_family' => 'Playfair Display',
                ),
            )
        );

        $this->add_control(
            'form_heading_color',
            array(
                'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#1C1C1C',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-contact-form-heading' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Form Subheading Style ───
        $this->start_controls_section(
            'section_form_subheading_style',
            array(
                'label' => esc_html__( 'Form Subheading', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'form_subheading_typography',
                'selector' => '{{WRAPPER}} .shopnex-contact-form-subheading',
                'default'  => array(
                    'font_size'   => array( 'size' => 14, 'unit' => 'px' ),
                    'font_weight' => '400',
                    'line_height' => array( 'size' => 1.5, 'unit' => '' ),
                ),
            )
        );

        $this->add_control(
            'form_subheading_color',
            array(
                'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#6B6560',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-contact-form-subheading' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Info Card Style ───
        $this->start_controls_section(
            'section_card_style',
            array(
                'label' => esc_html__( 'Info Cards', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'card_bg_color',
            array(
                'label'     => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-contact-info-card' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'card_border_color',
            array(
                'label'     => esc_html__( 'Border Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#F0EDE9',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-contact-info-card' => 'border-color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'card_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 30,
                    ),
                ),
                'default'    => array(
                    'size' => 10,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-contact-info-card' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'card_padding',
            array(
                'label'      => esc_html__( 'Padding', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em' ),
                'default'    => array(
                    'top'    => '28',
                    'right'  => '28',
                    'bottom' => '28',
                    'left'   => '28',
                    'unit'   => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-contact-info-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'card_spacing',
            array(
                'label'      => esc_html__( 'Card Gap', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 48,
                    ),
                ),
                'default'    => array(
                    'size' => 24,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-contact-sidebar' => 'gap: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Card Icon Style ───
        $this->start_controls_section(
            'section_card_icon_style',
            array(
                'label' => esc_html__( 'Card Icon', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'card_icon_bg_color',
            array(
                'label'     => esc_html__( 'Icon Background Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#F3EFEA',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-contact-info-icon' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'card_icon_color',
            array(
                'label'     => esc_html__( 'Icon Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#B8977E',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-contact-info-icon' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'card_icon_size',
            array(
                'label'      => esc_html__( 'Icon Size', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 20,
                        'max' => 60,
                    ),
                ),
                'default'    => array(
                    'size' => 44,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-contact-info-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'card_icon_font_size',
            array(
                'label'      => esc_html__( 'Icon Font Size', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 10,
                        'max' => 30,
                    ),
                ),
                'default'    => array(
                    'size' => 18,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-contact-info-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .shopnex-contact-info-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Card Title Style ───
        $this->start_controls_section(
            'section_card_title_style',
            array(
                'label' => esc_html__( 'Card Title', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'card_title_typography',
                'selector' => '{{WRAPPER}} .shopnex-contact-info-card h4',
                'default'  => array(
                    'font_size'   => array( 'size' => 18, 'unit' => 'px' ),
                    'font_weight' => '500',
                    'font_family' => 'Playfair Display',
                ),
            )
        );

        $this->add_control(
            'card_title_color',
            array(
                'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#1C1C1C',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-contact-info-card h4' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Card Text Style ───
        $this->start_controls_section(
            'section_card_text_style',
            array(
                'label' => esc_html__( 'Card Text', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'card_text_typography',
                'selector' => '{{WRAPPER}} .shopnex-contact-info-card p, {{WRAPPER}} .shopnex-contact-info-card a',
                'default'  => array(
                    'font_size'   => array( 'size' => 14, 'unit' => 'px' ),
                    'font_weight' => '400',
                    'line_height' => array( 'size' => 1.6, 'unit' => '' ),
                ),
            )
        );

        $this->add_control(
            'card_text_color',
            array(
                'label'     => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#6B6560',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-contact-info-card p' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .shopnex-contact-info-card a' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'card_link_hover_color',
            array(
                'label'     => esc_html__( 'Link Hover Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#1C1C1C',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-contact-info-card a:hover' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Button Style ───
        $this->start_controls_section(
            'section_button_style',
            array(
                'label' => esc_html__( 'Button', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'button_typography',
                'selector' => '{{WRAPPER}} .shopnex-contact-submit-btn',
                'default'  => array(
                    'font_size'      => array( 'size' => 14, 'unit' => 'px' ),
                    'font_weight'    => '500',
                    'letter_spacing' => array( 'size' => 0.4, 'unit' => 'px' ),
                ),
            )
        );

        $this->add_responsive_control(
            'button_padding',
            array(
                'label'      => esc_html__( 'Padding', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em' ),
                'default'    => array(
                    'top'    => '14',
                    'right'  => '32',
                    'bottom' => '14',
                    'left'   => '32',
                    'unit'   => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-contact-submit-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'button_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 50,
                    ),
                ),
                'default'    => array(
                    'size' => 50,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-contact-submit-btn' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->start_controls_tabs( 'button_style_tabs' );

        $this->start_controls_tab(
            'button_style_normal',
            array(
                'label' => esc_html__( 'Normal', 'spiraclethemes-site-library' ),
            )
        );

        $this->add_control(
            'button_bg_color',
            array(
                'label'     => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#1C1C1C',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-contact-submit-btn' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'button_text_color',
            array(
                'label'     => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-contact-submit-btn' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_style_hover',
            array(
                'label' => esc_html__( 'Hover', 'spiraclethemes-site-library' ),
            )
        );

        $this->add_control(
            'button_bg_color_hover',
            array(
                'label'     => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#333333',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-contact-submit-btn:hover' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'button_text_color_hover',
            array(
                'label'     => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-contact-submit-btn:hover' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        // ─── Form Note Style ───
        $this->start_controls_section(
            'section_form_note_style',
            array(
                'label' => esc_html__( 'Form Note', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'form_note_typography',
                'selector' => '{{WRAPPER}} .shopnex-contact-form-note',
                'default'  => array(
                    'font_size'   => array( 'size' => 12, 'unit' => 'px' ),
                    'font_weight' => '400',
                    'line_height' => array( 'size' => 1.5, 'unit' => '' ),
                ),
            )
        );

        $this->add_control(
            'form_note_color',
            array(
                'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#9C9792',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-contact-form-note' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $widget_id = $this->get_id();

        include SPIR_SITE_LIBRARY_PATH . '/elements/shopnex/contact-layout/template/view.php';
    }
}
