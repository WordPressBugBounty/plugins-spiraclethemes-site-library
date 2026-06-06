<?php
/**
 * Map Section Widget for Shopnex Theme
 *
 * @package SpiracleThemes_Site_Library
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Shopnex_MapSection extends \Elementor\Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'shopnex-elementor-map-section';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return esc_html__( 'Map Section', 'spiraclethemes-site-library' );
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-google-maps';
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
        return array( 'map', 'location', 'address', 'directions', 'google', 'shopnex' );
    }

    /**
     * Register widget controls
     */
    protected function register_controls() {

        // ─── Map Content Section ───
        $this->start_controls_section(
            'section_map_content',
            array(
                'label' => esc_html__( 'Map', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'map_type',
            array(
                'label'       => esc_html__( 'Map Type', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::SELECT,
                'default'     => 'placeholder',
                'options'     => array(
                    'placeholder' => esc_html__( 'Placeholder', 'spiraclethemes-site-library' ),
                    'embed'       => esc_html__( 'Google Maps Embed', 'spiraclethemes-site-library' ),
                ),
                'description' => esc_html__( 'Choose "Placeholder" for a static design preview or "Google Maps Embed" to display an actual map.', 'spiraclethemes-site-library' ),
            )
        );

        $this->add_control(
            'map_embed_url',
            array(
                'label'       => esc_html__( 'Google Maps Embed URL', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://www.google.com/maps/embed?pb=...', 'spiraclethemes-site-library' ),
                'description' => esc_html__( 'Paste the Google Maps embed URL or the full <iframe> embed code. Get it from Google Maps → Share → Embed a map.', 'spiraclethemes-site-library' ),
                'condition'   => array(
                    'map_type' => 'embed',
                ),
            )
        );

        $this->add_control(
            'placeholder_text',
            array(
                'label'       => esc_html__( 'Placeholder Text', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Interactive map placeholder', 'spiraclethemes-site-library' ),
                'label_block' => true,
                'condition'   => array(
                    'map_type' => 'placeholder',
                ),
            )
        );

        $this->add_responsive_control(
            'map_height',
            array(
                'label'      => esc_html__( 'Map Height', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px', 'vh' ),
                'range'      => array(
                    'px' => array(
                        'min' => 200,
                        'max' => 800,
                    ),
                    'vh' => array(
                        'min' => 20,
                        'max' => 80,
                    ),
                ),
                'default'    => array(
                    'size' => 400,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-map-section' => 'height: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'map_margin_bottom',
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
                    '{{WRAPPER}} .shopnex-map-section' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Overlay Card Section ───
        $this->start_controls_section(
            'section_overlay_card',
            array(
                'label' => esc_html__( 'Overlay Card', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'show_overlay_card',
            array(
                'label'        => esc_html__( 'Show Overlay Card', 'spiraclethemes-site-library' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
                'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->add_control(
            'card_title',
            array(
                'label'       => esc_html__( 'Title', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'NORD. Studio', 'spiraclethemes-site-library' ),
                'label_block' => true,
                'condition'   => array(
                    'show_overlay_card' => 'yes',
                ),
            )
        );

        $this->add_control(
            'card_address',
            array(
                'label'       => esc_html__( 'Address', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__( "47 Viktoria Street, Stockholm\nSweden 114 55", 'spiraclethemes-site-library' ),
                'label_block' => true,
                'rows'        => 3,
                'condition'   => array(
                    'show_overlay_card' => 'yes',
                ),
            )
        );

        $this->add_control(
            'directions_text',
            array(
                'label'       => esc_html__( 'Directions Link Text', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Get directions', 'spiraclethemes-site-library' ),
                'label_block' => true,
                'condition'   => array(
                    'show_overlay_card' => 'yes',
                ),
            )
        );

        $this->add_control(
            'directions_url',
            array(
                'label'         => esc_html__( 'Directions URL', 'spiraclethemes-site-library' ),
                'type'          => \Elementor\Controls_Manager::URL,
                'placeholder'   => esc_html__( 'https://maps.google.com/...', 'spiraclethemes-site-library' ),
                'show_external' => true,
                'default'       => array(
                    'url'         => '#',
                    'is_external' => true,
                ),
                'condition'     => array(
                    'show_overlay_card' => 'yes',
                ),
            )
        );

        $this->add_control(
            'show_directions_arrow',
            array(
                'label'        => esc_html__( 'Show Arrow Icon', 'spiraclethemes-site-library' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
                'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => array(
                    'show_overlay_card' => 'yes',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Map Background Style ───
        $this->start_controls_section(
            'section_map_style',
            array(
                'label' => esc_html__( 'Map', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'map_bg_color',
            array(
                'label'     => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#F3EFEA',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-map-section' => 'background-color: {{VALUE}};',
                ),
                'condition' => array(
                    'map_type' => 'placeholder',
                ),
            )
        );

        $this->add_control(
            'map_border_radius',
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
                    '{{WRAPPER}} .shopnex-map-section' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Placeholder Icon Style ───
        $this->start_controls_section(
            'section_placeholder_style',
            array(
                'label'     => esc_html__( 'Placeholder', 'spiraclethemes-site-library' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'map_type' => 'placeholder',
                ),
            )
        );

        $this->add_control(
            'placeholder_icon_color',
            array(
                'label'     => esc_html__( 'Icon Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#9C9792',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-map-placeholder' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'placeholder_icon_opacity',
            array(
                'label'      => esc_html__( 'Icon Opacity', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( '%' ),
                'range'      => array(
                    '%' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'default'    => array(
                    'size' => 40,
                    'unit' => '%',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-map-placeholder svg' => 'opacity: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'placeholder_icon_size',
            array(
                'label'      => esc_html__( 'Icon Size', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 24,
                        'max' => 96,
                    ),
                ),
                'default'    => array(
                    'size' => 48,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-map-placeholder svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'placeholder_text_typography',
                'selector' => '{{WRAPPER}} .shopnex-map-placeholder span',
                'default'  => array(
                    'font_size'      => array( 'size' => 13, 'unit' => 'px' ),
                    'font_weight'    => '400',
                    'letter_spacing' => array( 'size' => 0.04, 'unit' => 'em' ),
                ),
            )
        );

        $this->add_control(
            'placeholder_text_color',
            array(
                'label'     => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#9C9792',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-map-placeholder span' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Overlay Card Style ───
        $this->start_controls_section(
            'section_overlay_card_style',
            array(
                'label'     => esc_html__( 'Overlay Card', 'spiraclethemes-site-library' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'show_overlay_card' => 'yes',
                ),
            )
        );

        $this->add_control(
            'card_bg_color',
            array(
                'label'     => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-map-overlay-card' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .shopnex-map-overlay-card' => 'border-radius: {{SIZE}}{{UNIT}};',
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
                    'top'    => '20',
                    'right'  => '24',
                    'bottom' => '20',
                    'left'   => '24',
                    'unit'   => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-map-overlay-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'card_max_width',
            array(
                'label'      => esc_html__( 'Max Width', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 200,
                        'max' => 600,
                    ),
                ),
                'default'    => array(
                    'size' => 320,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-map-overlay-card' => 'max-width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'card_position_bottom',
            array(
                'label'      => esc_html__( 'Position Bottom', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 60,
                    ),
                ),
                'default'    => array(
                    'size' => 28,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-map-overlay-card' => 'bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'card_position_left',
            array(
                'label'      => esc_html__( 'Position Left', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 60,
                    ),
                ),
                'default'    => array(
                    'size' => 28,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-map-overlay-card' => 'left: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'card_box_shadow',
                'selector' => '{{WRAPPER}} .shopnex-map-overlay-card',
                'default'  => array(
                    'box_shadow' => '0 12px 40px rgba(28,28,28,0.08)',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Card Title Style ───
        $this->start_controls_section(
            'section_card_title_style',
            array(
                'label'     => esc_html__( 'Card Title', 'spiraclethemes-site-library' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'show_overlay_card' => 'yes',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'card_title_typography',
                'selector' => '{{WRAPPER}} .shopnex-map-overlay-card h4',
                'default'  => array(
                    'font_size'   => array( 'size' => 16, 'unit' => 'px' ),
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
                    '{{WRAPPER}} .shopnex-map-overlay-card h4' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Card Address Style ───
        $this->start_controls_section(
            'section_card_address_style',
            array(
                'label'     => esc_html__( 'Card Address', 'spiraclethemes-site-library' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'show_overlay_card' => 'yes',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'card_address_typography',
                'selector' => '{{WRAPPER}} .shopnex-map-overlay-card p',
                'default'  => array(
                    'font_size'   => array( 'size' => 13, 'unit' => 'px' ),
                    'font_weight' => '400',
                    'line_height' => array( 'size' => 1.5, 'unit' => '' ),
                ),
            )
        );

        $this->add_control(
            'card_address_color',
            array(
                'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#6B6560',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-map-overlay-card p' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Directions Link Style ───
        $this->start_controls_section(
            'section_directions_link_style',
            array(
                'label'     => esc_html__( 'Directions Link', 'spiraclethemes-site-library' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'show_overlay_card' => 'yes',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'directions_link_typography',
                'selector' => '{{WRAPPER}} .shopnex-map-directions-link',
                'default'  => array(
                    'font_size'      => array( 'size' => 12, 'unit' => 'px' ),
                    'font_weight'    => '500',
                    'letter_spacing' => array( 'size' => 0.06, 'unit' => 'em' ),
                ),
            )
        );

        $this->start_controls_tabs( 'directions_link_style_tabs' );

        $this->start_controls_tab(
            'directions_link_style_normal',
            array(
                'label' => esc_html__( 'Normal', 'spiraclethemes-site-library' ),
            )
        );

        $this->add_control(
            'directions_link_color',
            array(
                'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#1C1C1C',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-map-directions-link' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'directions_link_style_hover',
            array(
                'label' => esc_html__( 'Hover', 'spiraclethemes-site-library' ),
            )
        );

        $this->add_control(
            'directions_link_color_hover',
            array(
                'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#B8977E',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-map-directions-link:hover' => 'color: {{VALUE}};',
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

        include SPIR_SITE_LIBRARY_PATH . '/elements/shopnex/map-section/template/view.php';
    }
}
