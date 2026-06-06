/**
 * Admin scripts for Spiraclethemes Site Library.
 */
(function($) {
    'use strict';

    // Handle tab URL hash on click.
    $('a.ssl-tab-list-item').on('click', function() {
        var tabHref = $(this).attr('href');
        window.location.hash = tabHref;
        $('html, body').scrollTop(tabHref);
    });

    // Select all checkbox for elements table.
    $('.ssl-checkbox').on('click', function() {
        var isChecked = $(this).prop('checked');
        $('.ssl-elements-table input').prop('checked', isChecked);
    });

})(jQuery);
