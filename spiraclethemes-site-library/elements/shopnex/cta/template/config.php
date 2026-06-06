<?php
/**
 * CTA Widget for Shopnex Theme
 *
 * @package SpiracleThemes_Site_Library
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Shopnex_CTA extends \Elementor\Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'shopnex-elementor-cta';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return esc_html__( 'CTA', 'spiraclethemes-site-library' );
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-call-to-action';
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
        return array( 'cta', 'call to action', 'banner', 'newsletter', 'subscribe', 'shopnex' );
    }

    /**
     * Register widget controls
     */
    protected function register_controls() {

        // ─── Content Section ───
        $this->start_controls_section(
            'section_content',
            array(
                'label' => esc_html__( 'Content', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'show_tag',
            array(
                'label'        => esc_html__( 'Show Tag', 'spiraclethemes-site-library' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
                'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->add_control(
            'tag_text',
            array(
                'label'       => esc_html__( 'Tag Text', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Style Support', 'spiraclethemes-site-library' ),
                'label_block' => true,
                'condition'   => array(
                    'show_tag' => 'yes',
                ),
            )
        );

        $this->add_control(
            'title',
            array(
                'label'       => esc_html__( 'Title', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'Need help finding your look?', 'spiraclethemes-site-library' ),
                'label_block' => true,
                'rows'        => 3,
            )
        );

        $this->add_control(
            'description',
            array(
                'label'       => esc_html__( 'Description', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'From sizing advice to styling tips, our team is here to help you find the perfect fit and feel confident in every purchase.', 'spiraclethemes-site-library' ),
                'label_block' => true,
                'rows'        => 4,
            )
        );

        $this->add_control(
            'show_button',
            array(
                'label'        => esc_html__( 'Show Button', 'spiraclethemes-site-library' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
                'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->add_control(
            'button_text',
            array(
                'label'       => esc_html__( 'Button Text', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Visit FAQ', 'spiraclethemes-site-library' ),
                'label_block' => true,
                'condition'   => array(
                    'show_button' => 'yes',
                ),
            )
        );

        $this->add_control(
            'button_link',
            array(
                'label'       => esc_html__( 'Button Link', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'spiraclethemes-site-library' ),
                'options'     => false,
                'condition'   => array(
                    'show_button' => 'yes',
                ),
            )
        );

        $this->add_responsive_control(
            'text_alignment',
            array(
                'label'              => esc_html__( 'Text Alignment', 'spiraclethemes-site-library' ),
                'type'               => \Elementor\Controls_Manager::CHOOSE,
                'options'            => array(
                    'left'   => array(
                        'title' => esc_html__( 'Left', 'spiraclethemes-site-library' ),
                        'icon'  => 'eicon-text-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'spiraclethemes-site-library' ),
                        'icon'  => 'eicon-text-align-center',
                    ),
                    'right'  => array(
                        'title' => esc_html__( 'Right', 'spiraclethemes-site-library' ),
                        'icon'  => 'eicon-text-align-right',
                    ),
                ),
                'default'            => 'center',
                'selectors'          => array(
                    '{{WRAPPER}} .shopnex-cta-content' => 'text-align: {{VALUE}};',
                ),
                'frontend_available' => true,
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
            'section_padding',
            array(
                'label'      => esc_html__( 'Section Padding', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'default'    => array(
                    'top'    => '0',
                    'right'  => '40',
                    'bottom' => '0',
                    'left'   => '40',
                    'unit'   => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-cta-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'section_border_radius',
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
                    '{{WRAPPER}} .shopnex-cta-section' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'content_max_width',
            array(
                'label'      => esc_html__( 'Content Max Width', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%' ),
                'range'      => array(
                    'px' => array(
                        'min' => 300,
                        'max' => 1200,
                    ),
                ),
                'default'    => array(
                    'size' => 420,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-cta-content' => 'max-width: {{SIZE}}{{UNIT}};',
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
                        'max' => 100,
                    ),
                ),
                'default'    => array(
                    'size' => 0,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-cta-section' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Background Section ───
        $this->start_controls_section(
            'section_background',
            array(
                'label' => esc_html__( 'Background', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'bg_type',
            array(
                'label'   => esc_html__( 'Background Type', 'spiraclethemes-site-library' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'color',
                'options' => array(
                    'color'  => esc_html__( 'Color', 'spiraclethemes-site-library' ),
                    'image'  => esc_html__( 'Image', 'spiraclethemes-site-library' ),
                ),
            )
        );

        $this->add_control(
            'bg_color',
            array(
                'label'     => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#F3EFEA',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-cta-section' => 'background-color: {{VALUE}};',
                ),
                'condition' => array(
                    'bg_type' => 'color',
                ),
            )
        );

        $this->add_control(
            'bg_image',
            array(
                'label'     => esc_html__( 'Background Image', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::MEDIA,
                'condition' => array(
                    'bg_type' => 'image',
                ),
            )
        );

        $this->add_control(
            'bg_overlay_color',
            array(
                'label'     => esc_html__( 'Overlay Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => 'rgba(28, 28, 28, 0.45)',
                'condition' => array(
                    'bg_type' => 'image',
                ),
            )
        );

        $this->add_control(
            'bg_overlay_opacity',
            array(
                'label'      => esc_html__( 'Overlay Opacity', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( '' ),
                'range'      => array(
                    '' => array(
                        'min'  => 0,
                        'max'  => 1,
                        'step' => 0.05,
                    ),
                ),
                'default'    => array(
                    'size' => 0.45,
                ),
                'condition'  => array(
                    'bg_type' => 'image',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-cta-overlay' => 'opacity: {{SIZE}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Tag Style ───
        $this->start_controls_section(
            'section_tag_style',
            array(
                'label'     => esc_html__( 'Tag', 'spiraclethemes-site-library' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'show_tag' => 'yes',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'tag_typography',
                'selector' => '{{WRAPPER}} .shopnex-cta-tag',
                'default'  => array(
                    'font_size'      => array( 'size' => 11, 'unit' => 'px' ),
                    'font_weight'    => '600',
                    'letter_spacing' => array( 'size' => 1, 'unit' => 'px' ),
                    'text_transform' => 'uppercase',
                ),
            )
        );

        $this->add_control(
            'tag_color',
            array(
                'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#B8977E',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-cta-tag' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'tag_spacing',
            array(
                'label'      => esc_html__( 'Bottom Spacing', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 40,
                    ),
                ),
                'default'    => array(
                    'size' => 12,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-cta-tag' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Title Style ───
        $this->start_controls_section(
            'section_title_style',
            array(
                'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .shopnex-cta-title',
                'default'  => array(
                    'font_size'      => array( 'size' => 34, 'unit' => 'px' ),
                    'font_weight'    => '500',
                    'letter_spacing' => array( 'size' => -0.3, 'unit' => 'px' ),
                    'font_family'    => 'Playfair Display',
                ),
            )
        );

        $this->add_control(
            'title_color',
            array(
                'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#1C1C1C',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-cta-title' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'title_spacing',
            array(
                'label'      => esc_html__( 'Bottom Spacing', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 40,
                    ),
                ),
                'default'    => array(
                    'size' => 10,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-cta-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Description Style ───
        $this->start_controls_section(
            'section_description_style',
            array(
                'label' => esc_html__( 'Description', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'description_typography',
                'selector' => '{{WRAPPER}} .shopnex-cta-description',
                'default'  => array(
                    'font_size'   => array( 'size' => 14, 'unit' => 'px' ),
                    'font_weight' => '400',
                    'line_height' => array( 'size' => 1.5, 'unit' => '' ),
                ),
            )
        );

        $this->add_control(
            'description_color',
            array(
                'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#6B6560',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-cta-description' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'description_spacing',
            array(
                'label'      => esc_html__( 'Bottom Spacing', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 60,
                    ),
                ),
                'default'    => array(
                    'size' => 24,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-cta-description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Button Style ───
        $this->start_controls_section(
            'section_button_style',
            array(
                'label'     => esc_html__( 'Button', 'spiraclethemes-site-library' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'show_button' => 'yes',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'button_typography',
                'selector' => '{{WRAPPER}} .shopnex-cta-btn',
                'default'  => array(
                    'font_size'      => array( 'size' => 13, 'unit' => 'px' ),
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
                    'top'    => '13',
                    'right'  => '28',
                    'bottom' => '13',
                    'left'   => '28',
                    'unit'   => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-cta-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .shopnex-cta-btn' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->start_controls_tabs(
            'button_style_tabs'
        );

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
                    '{{WRAPPER}} .shopnex-cta-btn' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .shopnex-cta-btn' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .shopnex-cta-btn:hover' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .shopnex-cta-btn:hover' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $widget_id = $this->get_id();

        include SPIR_SITE_LIBRARY_PATH . '/elements/shopnex/cta/template/view.php';
    }
}
