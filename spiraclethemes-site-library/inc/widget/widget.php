<?php
/**
 * Dashboard widget for Spiraclethemes Site Library plugin.
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

// Define theme constants with prefixed names to avoid conflicts.
if ( ! defined( 'SPIR_SITE_LIBRARY_THEME_NAME' ) ) {
    define( 'SPIR_SITE_LIBRARY_THEME_NAME', wp_get_theme()->Name );
}
if ( ! defined( 'SPIR_SITE_LIBRARY_THEME_SLUG' ) ) {
    define( 'SPIR_SITE_LIBRARY_THEME_SLUG', wp_get_theme()->get( 'TextDomain' ) );
}
if ( ! defined( 'HOUR_IN_SECONDS' ) ) {
    define( 'HOUR_IN_SECONDS', 3600 );
}

/**
 * Add dashboard widget.
 */
function spiraclethemes_site_library_add_dashboard_widgets() {
    /* translators: %s: Theme name */
    $widget_title = sprintf( __( '%s Theme', 'spiraclethemes-site-library' ), SPIR_SITE_LIBRARY_THEME_NAME );

    wp_add_dashboard_widget(
        'spiraclethemes_site_library_dashboard_widget',
        $widget_title,
        'spiraclethemes_site_library_display_dashboard_widget'
    );
}

/**
 * Display dashboard widget content.
 */
function spiraclethemes_site_library_display_dashboard_widget() {
    echo '<div class="ssl-dashboard-widget">';
    echo '<div class="ssl-widget-card">';
    spiraclethemes_site_library_render_services_section();
    spiraclethemes_site_library_render_footer_links();
    echo '</div>';
    echo '</div>';
}

/**
 * Fetch and cache the remote discount XML, returning the parsed document.
 *
 * @return SimpleXMLElement|false Parsed XML document, or false on failure.
 */
function spiraclethemes_site_library_get_discount_xml() {
    $cache_key = 'spiraclethemes_discount_data';
    $xml_body  = get_transient( $cache_key );

    if ( false === $xml_body || ! is_string( $xml_body ) || empty( $xml_body ) ) {
        $api_url  = esc_url_raw( 'https://api.spiraclethemes.com/discounts/disapi.php' );
        $response = wp_safe_remote_get( $api_url, [
            'timeout'   => 10,
            'sslverify' => true,
        ] );

        if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
            return false;
        }

        $xml_body = wp_remote_retrieve_body( $response );
        set_transient( $cache_key, $xml_body, HOUR_IN_SECONDS * 24 );
    }

    libxml_use_internal_errors( true );
    $xml = simplexml_load_string( $xml_body, 'SimpleXMLElement', LIBXML_NOENT | LIBXML_NONET | LIBXML_NOCDATA );

    if ( false === $xml ) {
        libxml_clear_errors();
        return false;
    }

    libxml_clear_errors();
    return $xml;
}

/**
 * Fetch and cache discount data for a theme from the remote API.
 *
 * @param string $theme_slug Theme text-domain slug.
 * @return array {
 *     @type string|null $sale         Discount/sale value from the API.
 *     @type string|null $purchase_url Purchase URL from the API.
 * } Empty array when the API is unreachable, the XML is invalid, or the theme has no entry.
 */
function spiraclethemes_site_library_get_theme_discount( $theme_slug ) {
    if ( empty( $theme_slug ) ) {
        return [];
    }

    $xml = spiraclethemes_site_library_get_discount_xml();
    if ( false === $xml ) {
        return [];
    }

    foreach ( $xml->theme as $theme ) {
        if ( (string) $theme->slug === $theme_slug ) {
            return [
                'sale'         => ! empty( $theme->sale ) ? (string) $theme->sale : null,
                'purchase_url' => ! empty( $theme->purchase_url ) ? (string) $theme->purchase_url : null,
            ];
        }
    }

    return [];
}

/**
 * Fetch the global custom-development service offer from the remote API.
 *
 * Reads the optional top-level <service> node from the discount XML.
 *
 * @return array {
 *     @type string|null $headline    Service headline.
 *     @type string|null $description Service description.
 *     @type string|null $cta_url     Call-to-action URL.
 *     @type string|null $price       Starting price for the service section.
 * } Empty array when the API is unreachable, the XML is invalid, or no service entry exists.
 */
function spiraclethemes_site_library_get_service_offer() {
    $xml = spiraclethemes_site_library_get_discount_xml();
    if ( false === $xml || empty( $xml->service ) ) {
        return [];
    }

    $service = $xml->service;

    return [
        'headline'    => ! empty( $service->headline ) ? (string) $service->headline : null,
        'description' => ! empty( $service->description ) ? (string) $service->description : null,
        'cta_url'     => ! empty( $service->cta_url ) ? (string) $service->cta_url : null,
        'price'       => ! empty( $service->price ) ? (string) $service->price : null,
    ];
}

/**
 * Render services section.
 */
function spiraclethemes_site_library_render_services_section() {
    $rocket_img = defined( 'SPIR_SITE_LIBRARY_URL' ) ? esc_url( SPIR_SITE_LIBRARY_URL . 'img/rocket.svg' ) : '';
    if ( empty( $rocket_img ) ) {
        return;
    }

    $services = [
        __( 'Stunning Custom Design', 'spiraclethemes-site-library' ),
        __( 'Tailor-Made Features', 'spiraclethemes-site-library' ),
        __( 'SEO-Optimized', 'spiraclethemes-site-library' ),
        __( 'Blazing-Fast Speed', 'spiraclethemes-site-library' ),
        __( 'Rock-Solid Security', 'spiraclethemes-site-library' ),
        __( '100% Mobile-Responsive', 'spiraclethemes-site-library' ),
        __( 'Google Analytics Ready', 'spiraclethemes-site-library' ),
        __( 'Live Chat Integration', 'spiraclethemes-site-library' ),
        __( 'SSL Renewal Support', 'spiraclethemes-site-library' ),
        __( 'Spam Shield Setup', 'spiraclethemes-site-library' ),
        __( '30 Days Free Expert Support', 'spiraclethemes-site-library' ),
    ];

    echo '<div class="ssl-widget-section ssl-services-section">';

    // Pull the starting price dynamically from the remote API, fall back to default.
    // Priority: explicit <price> node -> first $ amount in <description> -> default.
    $service = spiraclethemes_site_library_get_service_offer();
    $price   = '$399';
    if ( ! empty( $service['price'] ) ) {
        $price = $service['price'];
    } elseif ( ! empty( $service['description'] ) && preg_match( '/\$[\d.,]+/', $service['description'], $matches ) ) {
        $price = $matches[0];
    }

    // Header.
    echo '<div class="ssl-services-header">';
    echo '<div class="ssl-services-header-icon"><img src="' . esc_url( $rocket_img ) . '" alt="' . esc_attr__( 'Rocket', 'spiraclethemes-site-library' ) . '" /></div>';
    echo '<div class="ssl-services-header-text">';
    echo '<span class="ssl-services-kicker">' . esc_html__( 'From Idea to Live Site', 'spiraclethemes-site-library' ) . '</span>';
    echo '<h3>' . esc_html__( 'Design, Build or Revamp Your WordPress Website', 'spiraclethemes-site-library' ) . '</h3>';
    echo '<span class="ssl-services-price">' . esc_html__( 'Starting from', 'spiraclethemes-site-library' ) . ' <strong>' . esc_html( $price ) . '</strong></span>';
    echo '</div>';
    echo '</div>';

    // Services grid.
    echo '<div class="ssl-services-grid">';
    foreach ( $services as $service ) {
        echo '<div class="ssl-service-item">';
        echo '<span class="ssl-service-check">';
        echo '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
        echo '</span>';
        echo '<span class="ssl-service-text">' . esc_html( $service ) . '</span>';
        echo '</div>';
    }
    echo '</div>';

    // CTA.
    echo '<div class="ssl-services-cta-wrap">';
    /* translators: %s: Theme name */
    echo '<a href="mailto:support@spiraclethemes.com?subject=' . rawurlencode( sprintf( __( 'Website Design/Revamp Inquiry - %s', 'spiraclethemes-site-library' ), SPIR_SITE_LIBRARY_THEME_NAME ) ) . '" class="ssl-services-cta">';
    echo '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>';
    echo '<span>' . esc_html( sprintf(
        /* translators: %s: Starting price */
        __( 'Email Us to Get Started — %s', 'spiraclethemes-site-library' ),
        $price
    ) ) . '</span>';
    echo '</a>';
    echo '<span class="ssl-services-limited">' . esc_html__( 'Limited Time Offer', 'spiraclethemes-site-library' ) . '</span>';
    echo '</div>';

    echo '</div>';
}

/**
 * Render footer links.
 */
function spiraclethemes_site_library_render_footer_links() {
    echo '<div class="ssl-widget-footer">';
    printf(
        /* translators: 1: Translation URL, 2: Theme name */
        '<a href="%1$s" target="_blank">' . esc_html__( 'Help Us to Translate %2$s', 'spiraclethemes-site-library' ) . ' <span class="dashicons dashicons-external"></span></a>',
        esc_url( 'https://translate.wordpress.org/projects/wp-themes/' . SPIR_SITE_LIBRARY_THEME_SLUG . '/' ),
        esc_html( SPIR_SITE_LIBRARY_THEME_NAME )
    );
    echo '<span class="ssl-footer-divider">|</span>';
    printf(
        '<a href="%1$s" target="_blank">' . esc_html__( 'Write a Review', 'spiraclethemes-site-library' ) . ' <span class="dashicons dashicons-external"></span></a>',
        esc_url( 'https://wordpress.org/support/theme/' . SPIR_SITE_LIBRARY_THEME_SLUG . '/reviews/#new-post' )
    );
    echo '</div>';
}

// Hook into the dashboard setup action.
add_action( 'wp_dashboard_setup', 'spiraclethemes_site_library_add_dashboard_widgets' );

/**
 * Move our dashboard widget to the top.
 */
function spiraclethemes_site_library_move_widget_to_top() {
    if ( get_current_screen()->id !== 'dashboard' ) {
        return;
    }

    global $wp_meta_boxes;

    $widget_key = 'spiraclethemes_site_library_dashboard_widget';
    if ( isset( $wp_meta_boxes['dashboard']['normal']['core'][ $widget_key ] ) ) {
        $widget_backup = $wp_meta_boxes['dashboard']['normal']['core'][ $widget_key ];
        unset( $wp_meta_boxes['dashboard']['normal']['core'][ $widget_key ] );
        $wp_meta_boxes['dashboard']['normal']['core'] = array_merge(
            [ $widget_key => $widget_backup ],
            $wp_meta_boxes['dashboard']['normal']['core']
        );
    }
}
add_action( 'admin_head', 'spiraclethemes_site_library_move_widget_to_top' );
