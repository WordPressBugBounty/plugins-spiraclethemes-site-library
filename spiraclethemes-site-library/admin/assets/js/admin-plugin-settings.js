/**
 * Admin plugin settings for Spiraclethemes Site Library.
 */
jQuery(document).ready(function($) {
    'use strict';

    // Move WordPress admin notices above the plugin section to prevent
    // them from appearing inside the Spiraclethemes Site Library card.
    var $adminWrap = $('.ssl-admin-wrap');
    if ($adminWrap.length) {
        // Collect notices from #wpbody-content direct children (outside .ssl-admin-wrap).
        var $notices = $('#wpbody-content').children('.notice, .updated, .error, .update-nag, .ssl-notice, .ssl-pro-upgrade-notice');
        // Also find notices deeply nested inside .ssl-admin-wrap, but NOT inside .response-wrap
        // (response-wrap notices are AJAX feedback that should remain inside the plugin section).
        $notices = $notices.add(
            $adminWrap.find('.notice, .updated, .error, .update-nag, .ssl-notice, .ssl-pro-upgrade-notice').not('.response-wrap .notice')
        );
        if ($notices.length) {
            $('<div class="ssl-external-notices" />').insertBefore($adminWrap).append($notices);
        }
    }

    // Initialize jQuery UI tabs with fade effect.
    $('.ssl-settings-tabs').tabs({
        activate: function(event, ui) {
            // Animate the new tab content.
            ui.newPanel.css({ opacity: 0, transform: 'translateY(4px)' });
            ui.newPanel.animate({ opacity: 1 }, 250);
            ui.newPanel.css({ transform: 'translateY(0)', transition: 'transform 0.25s ease-out' });
        }
    });

    // Click handler for toggle slider — ensures the checkbox toggles
    // even if CSS-only label association fails.
    $('.ssl-toggle-slider').on('click', function(e) {
        var $input = $(this).siblings('input[type="checkbox"]');
        if ($input.length && !$input.prop('disabled')) {
            e.preventDefault();
            $input.prop('checked', !$input.prop('checked')).trigger('change');
        }
    });

    // Update toggle labels on load.
    $('.ssl-toggle-switch input').each(function() {
        updateToggleLabel($(this));
    });

    // Update toggle labels on change.
    $('.ssl-toggle-switch input').on('change', function() {
        updateToggleLabel($(this));
    });

    /**
     * Update the toggle label text based on checked state.
     *
     * @param {jQuery} $input The toggle checkbox input.
     */
    function updateToggleLabel($input) {
        var $label = $input.closest('.ssl-setting-card-control').find('.ssl-toggle-label');
        if ($label.length) {
            var isOn = $input.is(':checked');
            $label.text(isOn ? $label.data('on') : $label.data('off'));
            $label.css('color', isOn ? '#10b981' : '#94a3b8');
        }
    }

    // Handle form submission.
    $('#ssl-settings').on('submit', function(e) {
        e.preventDefault();

        var $form = $(this);
        var $responseWrap = $('.response-wrap');
        var $saveBtn = $form.find('.ssl-save-btn');

        // Get toggle states.
        var demoImport = $form.find('input[name="ssl_enable_demo_import"]').is(':checked') ? 1 : 0;

        // Loading state.
        $saveBtn.prop('disabled', true).addClass('ssl-saving');

        $.ajax({
            url: ssl_ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'ssl_save_settings',
                nonce: ssl_ajax_object.nonce,
                ssl_enable_demo_import: demoImport
            },
            success: function(response) {
                if (response.success) {
                    $responseWrap.html(
                        $('<div>')
                            .addClass('notice notice-success is-dismissible')
                            .css({ opacity: 0 })
                            .append($('<p>').text(response.data.message))
                            .animate({ opacity: 1 }, 300)
                    );
                    // Reload the page after a short delay so the demo importer
                    // module is loaded (or unloaded) based on the new setting.
                    setTimeout(function() {
                        window.location.reload();
                    }, 1200);
                } else {
                    $responseWrap.html(
                        $('<div>')
                            .addClass('notice notice-error is-dismissible')
                            .css({ opacity: 0 })
                            .append($('<p>').text(response.data.message || 'An error occurred while saving settings'))
                            .animate({ opacity: 1 }, 300)
                    );
                }
            },
            error: function(xhr) {
                var errorMessage = 'An error occurred while saving settings';
                if (xhr.responseJSON && xhr.responseJSON.data && xhr.responseJSON.data.message) {
                    errorMessage = xhr.responseJSON.data.message;
                }
                $responseWrap.html(
                    $('<div>')
                        .addClass('notice notice-error is-dismissible')
                        .css({ opacity: 0 })
                        .append($('<p>').text(errorMessage))
                        .animate({ opacity: 1 }, 300)
                );
            },
            complete: function() {
                $saveBtn.prop('disabled', false).removeClass('ssl-saving');
                // Scroll to top to show notice.
                $('html, body').animate({ scrollTop: 0 }, 300);
            }
        });
    });
});
