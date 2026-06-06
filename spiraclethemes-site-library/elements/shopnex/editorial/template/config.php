<?php
/**
 * Editorial Widget for Shopnex Theme
 *
 * @package Spiracle Themes Site Library
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Shopnex_Editorial extends \Elementor\Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'shopnex-elementor-editorial';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return esc_html__( 'Editorial', 'spiraclethemes-site-library' );
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-image-before-after';
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
        return array( 'editorial', 'image', 'content', 'story', 'about', 'shopnex' );
    }

    /**
     * Register widget controls
     */
    protected function register_controls() {

        // ─── Layout Section ───
        $this->start_controls_section(
            'section_layout',
            array(
                'label' => esc_html__( 'Layout', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'layout_position',
            array(
                'label'   => esc_html__( 'Image Position', 'spiraclethemes-site-library' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => array(
                    'left'  => array(
                        'title' => esc_html__( 'Left', 'spiraclethemes-site-library' ),
                        'icon'  => 'eicon-h-align-left',
                    ),
                    'right' => array(
                        'title' => esc_html__( 'Right', 'spiraclethemes-site-library' ),
                        'icon'  => 'eicon-h-align-right',
                    ),
                ),
                'default' => 'left',
                'toggle'  => false,
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
                    '{{WRAPPER}} .shopnex-editorial-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'column_gap',
            array(
                'label'   => esc_html__( 'Column Gap', 'spiraclethemes-site-library' ),
                'type'    => \Elementor\Controls_Manager::SLIDER,
                'range'   => array(
                    'px' => array(
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 2,
                    ),
                ),
                'default' => array(
                    'size' => 40,
                    'unit' => 'px',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-editorial-grid' => 'gap: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Image Section ───
        $this->start_controls_section(
            'section_image',
            array(
                'label' => esc_html__( 'Image', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'editorial_image',
            array(
                'label'   => esc_html__( 'Choose Image', 'spiraclethemes-site-library' ),
                'type'    => \Elementor\Controls_Manager::MEDIA,
                'default' => array(
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ),
            )
        );

        $this->add_control(
            'image_aspect_ratio',
            array(
                'label'   => esc_html__( 'Aspect Ratio', 'spiraclethemes-site-library' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'options' => array(
                    '4/5'    => esc_html__( '4:5 (Portrait)', 'spiraclethemes-site-library' ),
                    '1/1'    => esc_html__( '1:1 (Square)', 'spiraclethemes-site-library' ),
                    '3/4'    => esc_html__( '3:4 (Portrait)', 'spiraclethemes-site-library' ),
                    '3/2'    => esc_html__( '3:2 (Landscape)', 'spiraclethemes-site-library' ),
                    '16/9'   => esc_html__( '16:9 (Wide)', 'spiraclethemes-site-library' ),
                    'auto'   => esc_html__( 'Auto (Original)', 'spiraclethemes-site-library' ),
                ),
                'default' => '4/5',
            )
        );

        $this->add_control(
            'image_border_radius',
            array(
                'label'   => esc_html__( 'Border Radius', 'spiraclethemes-site-library' ),
                'type'    => \Elementor\Controls_Manager::SLIDER,
                'range'   => array(
                    'px' => array(
                        'min'  => 0,
                        'max'  => 50,
                        'step' => 1,
                    ),
                ),
                'default' => array(
                    'size' => 16,
                    'unit' => 'px',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-editorial-image' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'image_link',
            array(
                'label'       => esc_html__( 'Image Link', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'spiraclethemes-site-library' ),
                'options'     => array( 'url', 'is_external', 'nofollow' ),
            )
        );

        $this->end_controls_section();

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
                'label'   => esc_html__( 'Show Tag', 'spiraclethemes-site-library' ),
                'type'    => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->add_control(
            'tag_text',
            array(
                'label'   => esc_html__( 'Tag Text', 'spiraclethemes-site-library' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Behind the Collection', 'spiraclethemes-site-library' ),
            )
        );

        $this->add_control(
            'title_text',
            array(
                'label'   => esc_html__( 'Title', 'spiraclethemes-site-library' ),
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Fashion with intention', 'spiraclethemes-site-library' ),
            )
        );

        $this->add_control(
            'description_text',
            array(
                'label'   => esc_html__( 'Description', 'spiraclethemes-site-library' ),
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'We believe in quality over quantity. Every garment is designed to be worn, loved, and lived in — combining modern silhouettes with fabrics that feel as good as they look.', 'spiraclethemes-site-library' ),
            )
        );

        $this->add_control(
            'show_button',
            array(
                'label'   => esc_html__( 'Show Button', 'spiraclethemes-site-library' ),
                'type'    => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->add_control(
            'button_text',
            array(
                'label'   => esc_html__( 'Button Text', 'spiraclethemes-site-library' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Read Our Story', 'spiraclethemes-site-library' ),
            )
        );

        $this->add_control(
            'button_link',
            array(
                'label'       => esc_html__( 'Button Link', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'spiraclethemes-site-library' ),
                'default'     => array(
                    'url' => '#',
                ),
            )
        );

        $this->add_control(
            'content_vertical_alignment',
            array(
                'label'   => esc_html__( 'Vertical Alignment', 'spiraclethemes-site-library' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => array(
                    'flex-start' => array(
                        'title' => esc_html__( 'Top', 'spiraclethemes-site-library' ),
                        'icon'  => 'eicon-v-align-top',
                    ),
                    'center'     => array(
                        'title' => esc_html__( 'Middle', 'spiraclethemes-site-library' ),
                        'icon'  => 'eicon-v-align-middle',
                    ),
                    'flex-end'   => array(
                        'title' => esc_html__( 'Bottom', 'spiraclethemes-site-library' ),
                        'icon'  => 'eicon-v-align-bottom',
                    ),
                ),
                'default'   => 'center',
                'toggle'    => false,
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-editorial-grid' => 'align-items: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Image Style Section ───
        $this->start_controls_section(
            'section_image_style',
            array(
                'label' => esc_html__( 'Image', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'image_hover_zoom',
            array(
                'label'   => esc_html__( 'Hover Zoom', 'spiraclethemes-site-library' ),
                'type'    => \Elementor\Controls_Manager::SLIDER,
                'range'   => array(
                    'px' => array(
                        'min'  => 1,
                        'max'  => 1.2,
                        'step' => 0.01,
                    ),
                ),
                'default' => array(
                    'size' => 1.04,
                ),
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-editorial-image:hover img' => 'transform: scale({{SIZE}});',
                ),
            )
        );

        $this->add_control(
            'image_bg_color',
            array(
                'label'     => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#F3EFEA',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-editorial-image' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Tag Style Section ───
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
                'label'    => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
                'selector' => '{{WRAPPER}} .shopnex-editorial-tag',
            )
        );

        $this->add_control(
            'tag_color',
            array(
                'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#B8977E',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-editorial-tag' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'tag_spacing',
            array(
                'label'     => esc_html__( 'Bottom Spacing', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'range'     => array(
                    'px' => array(
                        'min'  => 0,
                        'max'  => 40,
                        'step' => 1,
                    ),
                ),
                'default'   => array(
                    'size' => 12,
                    'unit' => 'px',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-editorial-tag' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Title Style Section ───
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
                'label'    => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
                'selector' => '{{WRAPPER}} .shopnex-editorial-title',
            )
        );

        $this->add_control(
            'title_color',
            array(
                'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#1C1C1C',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-editorial-title' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'title_spacing',
            array(
                'label'     => esc_html__( 'Bottom Spacing', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'range'     => array(
                    'px' => array(
                        'min'  => 0,
                        'max'  => 40,
                        'step' => 1,
                    ),
                ),
                'default'   => array(
                    'size' => 16,
                    'unit' => 'px',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-editorial-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Description Style Section ───
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
                'label'    => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
                'selector' => '{{WRAPPER}} .shopnex-editorial-description',
            )
        );

        $this->add_control(
            'description_color',
            array(
                'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#6B6560',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-editorial-description' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'description_max_width',
            array(
                'label'     => esc_html__( 'Max Width', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'range'     => array(
                    'px' => array(
                        'min'  => 200,
                        'max'  => 800,
                        'step' => 10,
                    ),
                ),
                'default'   => array(
                    'size' => 440,
                    'unit' => 'px',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-editorial-description' => 'max-width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'description_spacing',
            array(
                'label'     => esc_html__( 'Bottom Spacing', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'range'     => array(
                    'px' => array(
                        'min'  => 0,
                        'max'  => 60,
                        'step' => 1,
                    ),
                ),
                'default'   => array(
                    'size' => 24,
                    'unit' => 'px',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-editorial-description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Button Style Section ───
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
                'label'    => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
                'selector' => '{{WRAPPER}} .shopnex-editorial-btn',
            )
        );

        $this->add_control(
            'button_padding',
            array(
                'label'      => esc_html__( 'Padding', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'default'    => array(
                    'top'    => '13',
                    'right'  => '28',
                    'bottom' => '13',
                    'left'   => '28',
                    'unit'   => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-editorial-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'button_border_radius',
            array(
                'label'     => esc_html__( 'Border Radius', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'range'     => array(
                    'px' => array(
                        'min'  => 0,
                        'max'  => 50,
                        'step' => 1,
                    ),
                ),
                'default'   => array(
                    'size' => 50,
                    'unit' => 'px',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-editorial-btn' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->start_controls_tabs( 'button_style_tabs' );

        $this->start_controls_tab(
            'button_normal_tab',
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
                    '{{WRAPPER}} .shopnex-editorial-btn' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'button_text_color',
            array(
                'label'     => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-editorial-btn' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_hover_tab',
            array(
                'label' => esc_html__( 'Hover', 'spiraclethemes-site-library' ),
            )
        );

        $this->add_control(
            'button_bg_hover_color',
            array(
                'label'     => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#333333',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-editorial-btn:hover' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'button_text_hover_color',
            array(
                'label'     => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-editorial-btn:hover' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        // ─── Content Wrapper Style ───
        $this->start_controls_section(
            'section_content_wrapper_style',
            array(
                'label' => esc_html__( 'Content Wrapper', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_responsive_control(
            'content_padding',
            array(
                'label'      => esc_html__( 'Padding', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'default'    => array(
                    'top'    => '20',
                    'right'  => '0',
                    'bottom' => '20',
                    'left'   => '0',
                    'unit'   => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-editorial-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        require SPIR_SITE_LIBRARY_PATH . '/elements/shopnex/editorial/template/view.php';
    }
}
