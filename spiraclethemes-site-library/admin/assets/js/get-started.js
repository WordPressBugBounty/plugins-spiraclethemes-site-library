/**
 * Load wordpress.org theme screenshots and handle one-click theme install for the Get Started page.
 */

( function( $ ) {
    'use strict';

    $( function() {
        var $adminWrap = $('.ssl-admin-wrap');
        if ( $adminWrap.length ) {
            var $notices = $('#wpbody-content').children('.notice, .updated, .error, .update-nag, .ssl-notice, .ssl-pro-upgrade-notice');
            $notices = $notices.add(
                $adminWrap.find('.notice, .updated, .error, .update-nag, .ssl-notice, .ssl-pro-upgrade-notice').not('.response-wrap .notice')
            );
            if ( $notices.length ) {
                $('<div class="ssl-external-notices" />').insertBefore( $adminWrap ).append( $notices );
            }
        }

        // Load missing theme screenshots from wordpress.org.
        $( '.ssl-theme-card-thumb' ).each( function() {
            var $thumb = $( this );
            var slug   = $thumb.data( 'theme-slug' );

            if ( ! slug || $thumb.find( 'img' ).length ) {
                return;
            }

            $.post(
                ssl_get_started.ajax_url,
                {
                    action: 'ssl_get_theme_screenshot',
                    nonce:  ssl_get_started.nonce,
                    slug:   slug
                }
            ).done( function( response ) {
                if ( response && response.success && response.data && response.data.screenshot ) {
                    $thumb.empty().append(
                        $( '<img>' ).attr( 'src', response.data.screenshot ).attr( 'alt', slug )
                    );
                }
            } );
        } );

        // One-click install + activate a theme.
        $( document ).on( 'click', '.ssl-theme-install-btn', function() {
            var $btn  = $( this );
            var slug  = $btn.data( 'theme-slug' );
            var $card = $btn.closest( '.ssl-theme-card' );

            if ( ! slug || $btn.hasClass( 'ssl-installing' ) ) {
                return;
            }

            $btn.addClass( 'ssl-installing' )
                .prop( 'disabled', true )
                .text( 'Installing…' );

            $.post(
                ssl_get_started.ajax_url,
                {
                    action: 'ssl_install_theme',
                    nonce:  ssl_get_started.nonce,
                    slug:   slug
                }
            ).done( function( response ) {
                if ( response && response.success ) {
                    $btn.removeClass( 'ssl-theme-card-cta-ghost ssl-theme-install-btn ssl-installing' )
                        .addClass( 'ssl-theme-card-badge' )
                        .prop( 'disabled', false )
                        .text( 'Active' );
                    $card.addClass( 'ssl-theme-card-active' );

                    // Redirect to the dashboard so the theme's welcome
                    window.setTimeout( function() {
                        window.location.href = response.data && response.data.redirect ? response.data.redirect : ssl_get_started.dashboard_url;
                    }, 800 );
                } else {
                    $btn.removeClass( 'ssl-installing' ).prop( 'disabled', false ).text( 'Install' );
                    window.alert( response && response.data && response.data.message ? response.data.message : 'Install failed.' );
                }
            } ).fail( function() {
                $btn.removeClass( 'ssl-installing' ).prop( 'disabled', false ).text( 'Install' );
                window.alert( 'Install failed. Please try again.' );
            } );
        } );
    } );
} )( jQuery );
