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
if ( ! defined( 'SPIRACLETHEMES_POSTS_PER_PAGE' ) ) {
    define( 'SPIRACLETHEMES_POSTS_PER_PAGE', 3 );
}
if ( ! defined( 'SPIRACLETHEMES_NEW_POST_DAYS' ) ) {
    define( 'SPIRACLETHEMES_NEW_POST_DAYS', 7 );
}
if ( ! defined( 'HOUR_IN_SECONDS' ) ) {
    define( 'HOUR_IN_SECONDS', 3600 );
}

/**
 * Add dashboard widget.
 */
function spiraclethemes_site_library_add_dashboard_widgets() {
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
    $theme_slug = sanitize_key( wp_get_theme()->get( 'TextDomain' ) );
    $theme_name = esc_html( wp_get_theme()->get( 'Name' ) );

    echo '<div class="ssl-dashboard-widget">';
    spiraclethemes_site_library_render_discount_section( $theme_slug, $theme_name );
    spiraclethemes_site_library_render_services_section();
    spiraclethemes_site_library_render_news_section( $theme_slug );
    spiraclethemes_site_library_render_footer_links();
    echo '</div>';
}

/**
 * Render discount section if enabled.
 *
 * @param string $theme_slug Current theme slug.
 * @param string $theme_name Current theme name.
 */
function spiraclethemes_site_library_render_discount_section( $theme_slug, $theme_name ) {
    if ( ! current_user_can( 'manage_options' ) ) {
        echo '<p>' . esc_html__( 'You do not have permission to view this content.', 'spiraclethemes-site-library' ) . '</p>';
        return;
    }

    $cache_key = 'spiraclethemes_discount_data';
    $xml_body  = get_transient( $cache_key );

    if ( false === $xml_body || ! is_string( $xml_body ) || empty( $xml_body ) ) {
        $api_url = esc_url_raw( 'https://api.spiraclethemes.com/discounts/disapi.php' );
        $response = wp_safe_remote_get( $api_url, [
            'timeout'   => 10,
            'sslverify' => true,
        ] );

        if ( is_wp_error( $response ) ) {
            echo '<div class="ssl-widget-section ssl-discount-section">';
            echo '<div class="ssl-discount-header"><span class="ssl-discount-icon">%</span>';
            echo '<h3>' . esc_html__( 'Special Discount', 'spiraclethemes-site-library' ) . '</h3></div>';
            echo '<p class="ssl-discount-error">' . esc_html__( 'Unable to load discount info. Please try again later.', 'spiraclethemes-site-library' ) . '</p>';
            echo '</div>';
            return;
        }

        $response_code = wp_remote_retrieve_response_code( $response );
        if ( 200 !== $response_code ) {
            echo '<div class="ssl-widget-section ssl-discount-section">';
            echo '<div class="ssl-discount-header"><span class="ssl-discount-icon">%</span>';
            echo '<h3>' . esc_html__( 'Special Discount', 'spiraclethemes-site-library' ) . '</h3></div>';
            echo '<p class="ssl-discount-error">' . esc_html__( 'Unable to load discount info. Please try again later.', 'spiraclethemes-site-library' ) . '</p>';
            echo '</div>';
            return;
        }

        $xml_body = wp_remote_retrieve_body( $response );
        set_transient( $cache_key, $xml_body, HOUR_IN_SECONDS * 24 );
    }

    if ( version_compare( PHP_VERSION, '8.0.0', '<' ) ) {
        libxml_disable_entity_loader( true );
    }
    libxml_use_internal_errors( true );
    $xml = simplexml_load_string( $xml_body, 'SimpleXMLElement', LIBXML_NOCDATA );

    if ( false === $xml ) {
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            error_log( 'Spiraclethemes Site Library: XML parsing errors: ' . print_r( libxml_get_errors(), true ) );
        }
        echo '<div class="ssl-widget-section ssl-discount-section">';
        echo '<div class="ssl-discount-header"><span class="ssl-discount-icon">%</span>';
        echo '<h3>' . esc_html__( 'Special Discount', 'spiraclethemes-site-library' ) . '</h3></div>';
        echo '<p class="ssl-discount-error">' . esc_html__( 'Unable to load discount info.', 'spiraclethemes-site-library' ) . '</p>';
        echo '</div>';
        libxml_clear_errors();
        return;
    }

    $theme_discount = null;
    $theme_url      = null;
    foreach ( $xml->theme as $theme ) {
        if ( (string) $theme->slug === $theme_slug ) {
            $theme_discount = ! empty( $theme->sale ) ? (string) $theme->sale : null;
            $theme_url      = ! empty( $theme->purchase_url ) ? (string) $theme->purchase_url : null;
            break;
        }
    }

    echo '<div class="ssl-widget-section ssl-discount-section">';
    echo '<div class="ssl-discount-header">';
    echo '<span class="ssl-discount-icon">&#37;</span>';
    echo '<h3>' . esc_html__( 'Special Discount', 'spiraclethemes-site-library' ) . '</h3>';
    echo '</div>';

    if ( $theme_discount && $theme_url ) {
        echo '<div class="ssl-discount-body">';
        echo '<div class="ssl-discount-offer">';
        echo '<span class="ssl-discount-badge">' . esc_html__( 'LIMITED TIME', 'spiraclethemes-site-library' ) . '</span>';
        echo '<p class="ssl-discount-text">';
        printf(
            esc_html__( 'Unlock the Pro version for just $%1$s! Take advantage of our limited-time discount on %2$s.', 'spiraclethemes-site-library' ),
            esc_html( $theme_discount ),
            esc_html( $theme_name )
        );
        echo '</p>';
        echo '<a href="' . esc_url( $theme_url ) . '" target="_blank" class="ssl-discount-cta">';
        echo '<span>' . esc_html__( 'Get Pro Now', 'spiraclethemes-site-library' ) . '</span>';
        echo '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>';
        echo '</a>';
        echo '</div>';
        echo '</div>';
    } else {
        echo '<div class="ssl-discount-body">';
        echo '<div class="ssl-discount-empty">';
        echo '<p>' . esc_html__( 'No special discount currently available.', 'spiraclethemes-site-library' ) . '</p>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';

    libxml_clear_errors();
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
        [
            'title'   => __( 'Stunning Custom Design', 'spiraclethemes-site-library' ),
            'desc'    => __( 'Make a lasting impression with a beautiful, modern website or redesign.', 'spiraclethemes-site-library' ),
            'icon'    => 'design',
        ],
        [
            'title'   => __( 'Tailor-Made Features', 'spiraclethemes-site-library' ),
            'desc'    => __( 'We build exactly what your business needs – no fluff, just functionality.', 'spiraclethemes-site-library' ),
            'icon'    => 'features',
        ],
        [
            'title'   => __( 'SEO-Optimized', 'spiraclethemes-site-library' ),
            'desc'    => __( 'Climb the search rankings and get discovered faster on Google.', 'spiraclethemes-site-library' ),
            'icon'    => 'seo',
        ],
        [
            'title'   => __( 'Blazing-Fast Speed', 'spiraclethemes-site-library' ),
            'desc'    => __( 'Say goodbye to slow loading. We make your site lightning quick!', 'spiraclethemes-site-library' ),
            'icon'    => 'speed',
        ],
        [
            'title'   => __( 'Rock-Solid Security', 'spiraclethemes-site-library' ),
            'desc'    => __( 'Sleep easy knowing your website is shielded with top-notch protection.', 'spiraclethemes-site-library' ),
            'icon'    => 'security',
        ],
        [
            'title'   => __( '100% Mobile-Responsive', 'spiraclethemes-site-library' ),
            'desc'    => __( 'Your site will look perfect on every screen – phones, tablets, and desktops.', 'spiraclethemes-site-library' ),
            'icon'    => 'mobile',
        ],
        [
            'title'   => __( 'Google Analytics Ready', 'spiraclethemes-site-library' ),
            'desc'    => __( 'Gain powerful insights and track every visitor with ease.', 'spiraclethemes-site-library' ),
            'icon'    => 'analytics',
        ],
        [
            'title'   => __( 'Live Chat Integration', 'spiraclethemes-site-library' ),
            'desc'    => __( 'Connect instantly with your visitors and turn chats into conversions.', 'spiraclethemes-site-library' ),
            'icon'    => 'chat',
        ],
        [
            'title'   => __( 'SSL Renewal Support', 'spiraclethemes-site-library' ),
            'desc'    => __( 'We help you stay secure, always – no more expired certificates.', 'spiraclethemes-site-library' ),
            'icon'    => 'ssl',
        ],
        [
            'title'   => __( 'Spam Shield Setup', 'spiraclethemes-site-library' ),
            'desc'    => __( 'Keep your site clean and junk-free with robust spam protection.', 'spiraclethemes-site-library' ),
            'icon'    => 'spam',
        ],
        [
            'title'   => __( '30 Days Free Expert Support', 'spiraclethemes-site-library' ),
            'desc'    => __( 'We\'ve got your back, even after launch – no extra cost!', 'spiraclethemes-site-library' ),
            'icon'    => 'support',
        ],
    ];

    echo '<div class="ssl-widget-section ssl-services-section">';

    // Header.
    echo '<div class="ssl-services-header">';
    echo '<div class="ssl-services-header-icon"><img src="' . esc_url( $rocket_img ) . '" alt="' . esc_attr__( 'Rocket', 'spiraclethemes-site-library' ) . '" /></div>';
    echo '<div class="ssl-services-header-text">';
    echo '<h3>' . esc_html__( 'Design, Build or Revamp Your WordPress Website', 'spiraclethemes-site-library' ) . '</h3>';
    echo '<span class="ssl-services-price">' . esc_html__( 'Starting from', 'spiraclethemes-site-library' ) . ' <strong>$299</strong></span>';
    echo '</div>';
    echo '</div>';

    // Services grid.
    echo '<div class="ssl-services-grid">';
    foreach ( $services as $service ) {
        echo '<div class="ssl-service-item">';
        echo '<span class="ssl-service-check">';
        echo '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
        echo '</span>';
        echo '<div class="ssl-service-text">';
        echo '<strong>' . esc_html( $service['title'] ) . '</strong>';
        echo '<span>' . esc_html( $service['desc'] ) . '</span>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';

    // CTA.
    echo '<div class="ssl-services-cta-wrap">';
    echo '<a href="mailto:support@spiraclethemes.com?subject=' . rawurlencode( sprintf( __( 'Website Design/Revamp Inquiry - %s', 'spiraclethemes-site-library' ), SPIR_SITE_LIBRARY_THEME_NAME ) ) . '" class="ssl-services-cta">';
    echo '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>';
    echo '<span>' . esc_html__( 'Email Us to Get Started — $299', 'spiraclethemes-site-library' ) . '</span>';
    echo '</a>';
    echo '<span class="ssl-services-limited">' . esc_html__( 'Limited Time Offer', 'spiraclethemes-site-library' ) . '</span>';
    echo '</div>';

    echo '</div>';
}

/**
 * Render news section if enabled.
 */
function spiraclethemes_site_library_render_news_section() {
    echo '<div class="ssl-widget-section ssl-news-section">';
    echo '<div class="ssl-news-header">';
    echo '<span class="ssl-news-icon">';
    echo '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>';
    echo '</span>';
    echo '<h3>' . esc_html__( 'News & Updates', 'spiraclethemes-site-library' ) . '</h3>';
    echo '</div>';

    $cache_key = 'spiraclethemes_news_posts';
    $posts     = get_transient( $cache_key );

    if ( false === $posts ) {
        $api_url       = esc_url_raw( 'https://spiraclethemes.com/wp-json/wp/v2/posts?per_page=' . SPIRACLETHEMES_POSTS_PER_PAGE );
        $response_posts = wp_safe_remote_get( $api_url, [
            'timeout'   => 10,
            'sslverify' => true,
        ] );

        if ( is_wp_error( $response_posts ) ) {
            echo '<div class="ssl-news-list"><p class="ssl-news-error">' . esc_html__( 'Unable to load news. Please try again later.', 'spiraclethemes-site-library' ) . '</p></div>';
            echo '</div>';
            return;
        }

        $response_code = wp_remote_retrieve_response_code( $response_posts );
        if ( 200 !== $response_code ) {
            echo '<div class="ssl-news-list"><p class="ssl-news-error">' . esc_html__( 'Unable to load news. Please try again later.', 'spiraclethemes-site-library' ) . '</p></div>';
            echo '</div>';
            return;
        }

        $posts = json_decode( wp_remote_retrieve_body( $response_posts ), true );
        if ( ! is_array( $posts ) ) {
            echo '<div class="ssl-news-list"><p class="ssl-news-error">' . esc_html__( 'Unable to load news.', 'spiraclethemes-site-library' ) . '</p></div>';
            echo '</div>';
            return;
        }

        set_transient( $cache_key, $posts, HOUR_IN_SECONDS * 24 );
    }

    echo '<div class="ssl-news-list">';
    if ( ! empty( $posts ) ) {
        $seven_days_ago = strtotime( '-' . SPIRACLETHEMES_NEW_POST_DAYS . ' days' );

        foreach ( $posts as $post ) {
            if ( ! isset( $post['date'], $post['link'], $post['title']['rendered'] ) ) {
                continue;
            }

            $post_date = strtotime( $post['date'] ?? '' );
            $is_new    = ( false !== $post_date ) && ( $post_date > $seven_days_ago );

            echo '<div class="ssl-news-item">';
            if ( $is_new ) {
                echo '<span class="ssl-news-badge">' . esc_html__( 'NEW', 'spiraclethemes-site-library' ) . '</span>';
            }
            echo '<a href="' . esc_url( $post['link'] ) . '" target="_blank">';
            echo esc_html( $post['title']['rendered'] );
            echo '<svg class="ssl-news-external" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>';
            echo '</a>';
            echo '</div>';
        }
    } else {
        echo '<p class="ssl-news-error">' . esc_html__( 'No recent posts found.', 'spiraclethemes-site-library' ) . '</p>';
    }
    echo '</div>';

    echo '</div>';
}

/**
 * Render footer links.
 */
function spiraclethemes_site_library_render_footer_links() {
    echo '<div class="ssl-widget-footer">';
    printf(
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
