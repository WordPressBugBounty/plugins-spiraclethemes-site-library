<?php
/**
 * Page Hero Widget for Shopnex Theme
 *
 * A full-width hero section with background image, gradient overlay,
 * tag label, heading, and description — based on the about-hero-overlay design.
 *
 * @package SpiracleThemes_Site_Library
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Shopnex_PageHero extends \Elementor\Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'shopnex-elementor-page-hero';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return esc_html__( 'Page Hero', 'spiraclethemes-site-library' );
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-image-rollover';
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
        return array( 'hero', 'page hero', 'banner', 'overlay', 'about hero', 'shopnex' );
    }

    /**
     * Register widget controls
     */
    protected function register_controls() {

        // ─── Background Image ───
        $this->start_controls_section(
            'section_background',
            array(
                'label' => esc_html__( 'Background Image', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'background_image',
            array(
                'label'   => esc_html__( 'Choose Image', 'spiraclethemes-site-library' ),
                'type'    => \Elementor\Controls_Manager::MEDIA,
                'default' => array(
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ),
            )
        );

        $this->add_responsive_control(
            'min_height',
            array(
                'label'      => esc_html__( 'Min Height', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px', 'vh' ),
                'range'      => array(
                    'px' => array(
                        'min' => 200,
                        'max' => 1000,
                    ),
                    'vh' => array(
                        'min' => 20,
                        'max' => 100,
                    ),
                ),
                'default'    => array(
                    'size' => 480,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-page-hero' => 'min-height: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'enable_zoom_effect',
            array(
                'label'        => esc_html__( 'Enable Hover Zoom', 'spiraclethemes-site-library' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
                'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->end_controls_section();

        // ─── Overlay ───
        $this->start_controls_section(
            'section_overlay',
            array(
                'label' => esc_html__( 'Overlay', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'show_overlay',
            array(
                'label'        => esc_html__( 'Show Overlay', 'spiraclethemes-site-library' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
                'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->add_control(
            'overlay_color',
            array(
                'label'     => esc_html__( 'Overlay Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => 'rgba(28,28,28,0.55)',
                'condition' => array(
                    'show_overlay' => 'yes',
                ),
            )
        );

        $this->add_control(
            'overlay_color_to',
            array(
                'label'     => esc_html__( 'Overlay Color (Top)', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => 'rgba(28,28,28,0)',
                'condition' => array(
                    'show_overlay' => 'yes',
                ),
            )
        );

        $this->add_responsive_control(
            'overlay_stop',
            array(
                'label'      => esc_html__( 'Gradient Stop Position', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( '%' ),
                'range'      => array(
                    '%' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'default'    => array(
                    'size' => 55,
                    'unit' => '%',
                ),
                'condition'  => array(
                    'show_overlay' => 'yes',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Content ───
        $this->start_controls_section(
            'section_content',
            array(
                'label' => esc_html__( 'Content', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'tag_text',
            array(
                'label'       => esc_html__( 'Tag Text', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'New Season · SS25 Collection', 'spiraclethemes-site-library' ),
                'label_block' => true,
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
            'title',
            array(
                'label'       => esc_html__( 'Title', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Designed for quiet living', 'spiraclethemes-site-library' ),
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
            'description',
            array(
                'label'       => esc_html__( 'Description', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'Discover curated collections that blend contemporary fashion with timeless elegance. From runway-inspired silhouettes to everyday essentials, find pieces that speak to your unique sense of style.', 'spiraclethemes-site-library' ),
                'label_block' => true,
                'rows'        => 4,
            )
        );

        $this->add_control(
            'show_description',
            array(
                'label'        => esc_html__( 'Show Description', 'spiraclethemes-site-library' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
                'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->add_responsive_control(
            'content_alignment',
            array(
                'label'              => esc_html__( 'Content Alignment', 'spiraclethemes-site-library' ),
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
                    '{{WRAPPER}} .shopnex-page-hero-content' => 'text-align: {{VALUE}};',
                ),
                'frontend_available' => true,
            )
        );

        $this->add_responsive_control(
            'vertical_position',
            array(
                'label'                => esc_html__( 'Vertical Position', 'spiraclethemes-site-library' ),
                'type'                 => \Elementor\Controls_Manager::CHOOSE,
                'options'              => array(
                    'top'    => array(
                        'title' => esc_html__( 'Top', 'spiraclethemes-site-library' ),
                        'icon'  => 'eicon-v-align-top',
                    ),
                    'middle' => array(
                        'title' => esc_html__( 'Middle', 'spiraclethemes-site-library' ),
                        'icon'  => 'eicon-v-align-middle',
                    ),
                    'bottom' => array(
                        'title' => esc_html__( 'Bottom', 'spiraclethemes-site-library' ),
                        'icon'  => 'eicon-v-align-bottom',
                    ),
                ),
                'default'              => 'bottom',
                'selectors_dictionary' => array(
                    'top'    => 'flex-start',
                    'middle' => 'center',
                    'bottom' => 'flex-end',
                ),
                'selectors'            => array(
                    '{{WRAPPER}} .shopnex-page-hero' => 'align-items: {{VALUE}};',
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
            'content_padding',
            array(
                'label'      => esc_html__( 'Content Padding', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'default'    => array(
                    'top'    => '50',
                    'right'  => '60',
                    'bottom' => '50',
                    'left'   => '60',
                    'unit'   => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-page-hero-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                        'min' => 200,
                        'max' => 1200,
                    ),
                ),
                'default'    => array(
                    'size' => 600,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-page-hero-content' => 'max-width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'default'    => array(
                    'top'    => '16',
                    'right'  => '16',
                    'bottom' => '16',
                    'left'   => '16',
                    'unit'   => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-page-hero' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .shopnex-page-hero' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .shopnex-page-hero-tag',
                'default'  => array(
                    'font_size'      => array( 'size' => 11, 'unit' => 'px' ),
                    'font_weight'    => '500',
                    'letter_spacing' => array( 'size' => 0.1, 'unit' => 'em' ),
                    'text_transform' => 'uppercase',
                ),
            )
        );

        $this->add_control(
            'tag_color',
            array(
                'label'     => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-page-hero-tag' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'tag_bg_color',
            array(
                'label'     => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => 'rgba(255,255,255,0.18)',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-page-hero-tag' => 'background: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'tag_border_color',
            array(
                'label'     => esc_html__( 'Border Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => 'rgba(255,255,255,0.3)',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-page-hero-tag' => 'border-color: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'tag_padding',
            array(
                'label'      => esc_html__( 'Padding', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px' ),
                'default'    => array(
                    'top'    => '8',
                    'right'  => '16',
                    'bottom' => '8',
                    'left'   => '16',
                    'unit'   => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-page-hero-tag' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    'size' => 20,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-page-hero-tag' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'tag_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%' ),
                'default'    => array(
                    'size' => 50,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-page-hero-tag' => 'border-radius: {{SIZE}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .shopnex-page-hero-title',
                'default'  => array(
                    'font_size'      => array( 'size' => 52, 'unit' => 'px' ),
                    'font_weight'    => '500',
                    'letter_spacing' => array( 'size' => -0.3, 'unit' => 'px' ),
                    'font_family'    => 'Playfair Display',
                    'line_height'    => array( 'size' => 1.15, 'unit' => '' ),
                ),
            )
        );

        $this->add_control(
            'title_color',
            array(
                'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-page-hero-title' => 'color: {{VALUE}};',
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
                    'size' => 14,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-page-hero-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Description Style ───
        $this->start_controls_section(
            'section_description_style',
            array(
                'label'     => esc_html__( 'Description', 'spiraclethemes-site-library' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'show_description' => 'yes',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'description_typography',
                'selector' => '{{WRAPPER}} .shopnex-page-hero-desc',
                'default'  => array(
                    'font_size'   => array( 'size' => 16, 'unit' => 'px' ),
                    'font_weight' => '350',
                    'line_height' => array( 'size' => 1.6, 'unit' => '' ),
                ),
            )
        );

        $this->add_control(
            'description_color',
            array(
                'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => 'rgba(255,255,255,0.85)',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-page-hero-desc' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'description_max_width',
            array(
                'label'      => esc_html__( 'Max Width', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%' ),
                'range'      => array(
                    'px' => array(
                        'min' => 100,
                        'max' => 800,
                    ),
                ),
                'default'    => array(
                    'size' => 440,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-page-hero-desc' => 'max-width: {{SIZE}}{{UNIT}};',
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

        include SPIR_SITE_LIBRARY_PATH . '/elements/shopnex/page-hero/template/view.php';
    }
}
