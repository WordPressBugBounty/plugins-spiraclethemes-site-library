<?php
/**
 * Page Title Widget for Shopnex Theme
 *
 * A reusable page title widget with heading and subtitle,
 * perfect for page headers like "Get in touch" sections.
 *
 * @package SpiracleThemes_Site_Library
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Shopnex_PageTitle extends \Elementor\Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'shopnex-elementor-page-title';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return esc_html__( 'Page Title', 'spiraclethemes-site-library' );
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-site-title';
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
        return array( 'page title', 'heading', 'header', 'page header', 'subtitle', 'shopnex' );
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
            'title',
            array(
                'label'       => esc_html__( 'Title', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Get in touch', 'spiraclethemes-site-library' ),
                'label_block' => true,
            )
        );

        $this->add_control(
            'title_tag',
            array(
                'label'   => esc_html__( 'Title HTML Tag', 'spiraclethemes-site-library' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'h1',
                'options' => array(
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'p'  => 'P',
                ),
            )
        );

        $this->add_control(
            'subtitle',
            array(
                'label'       => esc_html__( 'Subtitle', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'Have a question about our products, need design advice, or want to collaborate? We\'d love to hear from you.', 'spiraclethemes-site-library' ),
                'label_block' => true,
                'rows'        => 4,
            )
        );

        $this->add_control(
            'show_subtitle',
            array(
                'label'        => esc_html__( 'Show Subtitle', 'spiraclethemes-site-library' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
                'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
                'return_value' => 'yes',
                'default'      => 'yes',
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
                'default'            => 'left',
                'selectors'          => array(
                    '{{WRAPPER}} .shopnex-page-title-wrapper' => 'text-align: {{VALUE}};',
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
                    'right'  => '0',
                    'bottom' => '0',
                    'left'   => '0',
                    'unit'   => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-page-title-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'content_max_width',
            array(
                'label'      => esc_html__( 'Subtitle Max Width', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%' ),
                'range'      => array(
                    'px' => array(
                        'min' => 200,
                        'max' => 1200,
                    ),
                ),
                'default'    => array(
                    'size' => 520,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-page-title-subtitle' => 'max-width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'section_margin_bottom',
            array(
                'label'      => esc_html__( 'Bottom Margin', 'spiraclethemes-site-library' ),
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
                    '{{WRAPPER}} .shopnex-page-title-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .shopnex-page-title-heading',
                'default'  => array(
                    'font_size'      => array( 'size' => 44, 'unit' => 'px' ),
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
                    '{{WRAPPER}} .shopnex-page-title-heading' => 'color: {{VALUE}};',
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
                    'size' => 8,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-page-title-heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Subtitle Style ───
        $this->start_controls_section(
            'section_subtitle_style',
            array(
                'label'     => esc_html__( 'Subtitle', 'spiraclethemes-site-library' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'show_subtitle' => 'yes',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'subtitle_typography',
                'selector' => '{{WRAPPER}} .shopnex-page-title-subtitle',
                'default'  => array(
                    'font_size'   => array( 'size' => 15, 'unit' => 'px' ),
                    'font_weight' => '400',
                    'line_height' => array( 'size' => 1.6, 'unit' => '' ),
                ),
            )
        );

        $this->add_control(
            'subtitle_color',
            array(
                'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#6B6560',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-page-title-subtitle' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Separator Style ───
        $this->start_controls_section(
            'section_separator_style',
            array(
                'label'     => esc_html__( 'Separator', 'spiraclethemes-site-library' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'show_separator' => 'yes',
                ),
            )
        );

        $this->add_control(
            'show_separator',
            array(
                'label'        => esc_html__( 'Show Separator', 'spiraclethemes-site-library' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
                'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
                'return_value' => 'yes',
                'default'      => '',
            )
        );

        $this->add_control(
            'separator_color',
            array(
                'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#B8977E',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-page-title-separator' => 'background-color: {{VALUE}};',
                ),
                'condition' => array(
                    'show_separator' => 'yes',
                ),
            )
        );

        $this->add_responsive_control(
            'separator_width',
            array(
                'label'      => esc_html__( 'Width', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 10,
                        'max' => 200,
                    ),
                ),
                'default'    => array(
                    'size' => 40,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-page-title-separator' => 'width: {{SIZE}}{{UNIT}};',
                ),
                'condition'  => array(
                    'show_separator' => 'yes',
                ),
            )
        );

        $this->add_responsive_control(
            'separator_height',
            array(
                'label'      => esc_html__( 'Height', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 1,
                        'max' => 10,
                    ),
                ),
                'default'    => array(
                    'size' => 2,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-page-title-separator' => 'height: {{SIZE}}{{UNIT}};',
                ),
                'condition'  => array(
                    'show_separator' => 'yes',
                ),
            )
        );

        $this->add_responsive_control(
            'separator_spacing',
            array(
                'label'      => esc_html__( 'Top Spacing', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 40,
                    ),
                ),
                'default'    => array(
                    'size' => 16,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-page-title-separator' => 'margin-top: {{SIZE}}{{UNIT}};',
                ),
                'condition'  => array(
                    'show_separator' => 'yes',
                ),
            )
        );

        $this->add_control(
            'separator_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 20,
                    ),
                ),
                'default'    => array(
                    'size' => 2,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-page-title-separator' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
                'condition'  => array(
                    'show_separator' => 'yes',
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

        include SPIR_SITE_LIBRARY_PATH . '/elements/shopnex/page-title/template/view.php';
    }
}
