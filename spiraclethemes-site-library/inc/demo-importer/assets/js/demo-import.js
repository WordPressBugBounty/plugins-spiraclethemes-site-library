/**
 * Spiraclethemes Site Library - Demo Import Admin JavaScript
 *
 * Handles the AJAX-based step-by-step import process including
 * plugin installation, content, widgets, customizer, and after-import setup.
 *
 * @package spiraclethemes-site-library
 * @subpackage inc/demo-importer
 */

(function ($) {
	'use strict';

	// Import steps in order (plugins first, then content).
	var steps = ['plugins', 'content', 'widgets', 'customizer', 'after_import'];
	var progressMap = {
		'plugins':      10,
		'content':      30,
		'widgets':      55,
		'customizer':   80,
		'after_import': 100
	};

	/**
	 * Run the full import process for a given demo.
	 *
	 * @param {string} demoIndex The demo index.
	 * @param {number} stepIndex The current step index.
	 */
	function runImport(demoIndex, stepIndex) {
		if (stepIndex >= steps.length) {
			// All steps complete — mark any remaining steps as done.
			$('.spiracle-step-item').each(function () {
				var $item = $(this);
				if (!$item.hasClass('spiracle-step-done')) {
					$item.removeClass('spiracle-step-active').addClass('spiracle-step-done');
					$item.find('.spiracle-step-status').removeClass('spiracle-spinner').addClass('spiracle-check');
				}
			});

			addLog(spiracleDemoImport.strings.success, 'success');

			// Update modal title to show success.
			$('#spiracle-modal-title').text(spiracleDemoImport.strings.success);

			// Show the Visit Website and Close buttons.
			$('#spiracle-modal-actions').show();
			$('#spiracle-modal-close-btn').show();

			return;
		}

		var step = steps[stepIndex];
		var progress = progressMap[step] || 0;

		// Update progress bar.
		$('#spiracle-progress-fill').css('width', progress + '%');

		// Mark previous step as done (with check icon).
		if (stepIndex > 0) {
			var prevStep = steps[stepIndex - 1];
			var $prevItem = $('.spiracle-step-item[data-step="' + prevStep + '"]');
			$prevItem.removeClass('spiracle-step-active').addClass('spiracle-step-done');
			$prevItem.find('.spiracle-step-status').removeClass('spiracle-spinner').addClass('spiracle-check');
		}

		// Mark current step as active (with spinner).
		var $currentItem = $('.spiracle-step-item[data-step="' + step + '"]');
		$currentItem.addClass('spiracle-step-active');
		$currentItem.find('.spiracle-step-status').addClass('spiracle-spinner');

		// Get step label for the log.
		var stepLabel = '';
		switch (step) {
			case 'plugins':
				stepLabel = spiracleDemoImport.strings.step_plugins;
				break;
			case 'content':
				stepLabel = spiracleDemoImport.strings.step_content;
				break;
			case 'widgets':
				stepLabel = spiracleDemoImport.strings.step_widgets;
				break;
			case 'customizer':
				stepLabel = spiracleDemoImport.strings.step_customizer;
				break;
			case 'after_import':
				stepLabel = spiracleDemoImport.strings.step_after;
				break;
		}
		addLog(stepLabel, 'info');

		// Make AJAX request.
		$.ajax({
			url: spiracleDemoImport.ajaxUrl,
			type: 'POST',
			data: {
				action: 'spiracle_demo_import',
				nonce: spiracleDemoImport.nonce,
				demo: demoIndex,
				step: step
			},
			dataType: 'json',
			success: function (response) {
				if (response.success) {
					addLog(response.data.message, 'success');
					// Proceed to next step.
					runImport(demoIndex, stepIndex + 1);
				} else {
					// Error in this step.
					var errorMsg = response.data && response.data.message
						? response.data.message
						: spiracleDemoImport.strings.error;

					// Mark current step as error.
					$currentItem.removeClass('spiracle-step-active').addClass('spiracle-step-error');
					$currentItem.find('.spiracle-step-status').removeClass('spiracle-spinner').addClass('spiracle-error-icon');

					addLog(errorMsg, 'error');
					// Show close button on error.
					$('#spiracle-modal-close-btn').show();
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				var errorMsg = spiracleDemoImport.strings.error + ' ' + errorThrown;

				// Mark current step as error.
				$currentItem.removeClass('spiracle-step-active').addClass('spiracle-step-error');
				$currentItem.find('.spiracle-step-status').removeClass('spiracle-spinner').addClass('spiracle-error-icon');

				addLog(errorMsg, 'error');
				// Show close button on error.
				$('#spiracle-modal-close-btn').show();
			}
		});
	}

	/**
	 * Add a log entry to the import log.
	 *
	 * @param {string} message The log message.
	 * @param {string} type    The log type (info, success, error).
	 */
	function addLog(message, type) {
		var cssClass = 'log-entry';
		if (type) {
			cssClass += ' log-' + type;
		}
		var $entry = $('<p class="' + cssClass + '"></p>').text(message);
		$('#spiracle-import-log').append($entry);

		// Auto-scroll to bottom.
		var $log = $('#spiracle-import-log');
		$log.scrollTop($log[0].scrollHeight);
	}

	/**
	 * Update a plugin item's UI to reflect a new status.
	 *
	 * @param {jQuery} $item    The plugin item element.
	 * @param {string} status   The new status (active, inactive, not_installed).
	 * @param {string} badgeText The text for the status badge.
	 */
	function updatePluginItemUI($item, status, badgeText) {
		// Update indicator class.
		$item.find('.spiracle-plugin-status-indicator')
			.removeClass('spiracle-plugin-active spiracle-plugin-inactive spiracle-plugin-not_installed')
			.addClass('spiracle-plugin-' + status);

		// Update indicator icon.
		var $icon = $item.find('.spiracle-plugin-status-indicator .dashicons');
		$icon.removeClass('dashicons-yes-alt dashicons-marker dashicons-warning');
		switch (status) {
			case 'active':
				$icon.addClass('dashicons-yes-alt');
				break;
			case 'inactive':
				$icon.addClass('dashicons-marker');
				break;
			default:
				$icon.addClass('dashicons-warning');
		}

		// Update badge.
		var $badge = $item.find('.spiracle-plugin-badge');
		$badge
			.removeClass('spiracle-badge-active spiracle-badge-inactive spiracle-badge-not_installed')
			.addClass('spiracle-badge-' + status)
			.text(badgeText);
	}

	// Bind click event on import buttons.
	$(document).on('click', '.spiracle-import-btn', function (e) {
		e.preventDefault();

		var $btn = $(this);
		var demoIndex = $btn.data('demo');

		if (!demoIndex && demoIndex !== 0) {
			return;
		}

		// Confirm before importing.
		if (!confirm(spiracleDemoImport.strings.confirm)) {
			return;
		}

		// Disable button.
		$btn.prop('disabled', true);

		// Show overlay.
		$('#spiracle-import-overlay').show();
		$('#spiracle-progress-fill').css('width', '0%');
		$('#spiracle-import-log').empty();
		$('#spiracle-modal-actions').hide();
		$('#spiracle-modal-close-btn').hide();
		$('#spiracle-modal-title').text(spiracleDemoImport.strings.importing);

		// Reset all step items.
		$('.spiracle-step-item').each(function () {
			$(this).removeClass('spiracle-step-active spiracle-step-done spiracle-step-error');
			$(this).find('.spiracle-step-status').removeClass('spiracle-spinner spiracle-check spiracle-error-icon');
		});

		// Start import (from step 0 = plugins).
		runImport(demoIndex, 0);
	});

	// Bind click event on individual plugin install/activate buttons.
	$(document).on('click', '.spiracle-plugin-install-btn', function (e) {
		e.preventDefault();

		var $btn = $(this);
		var slug = $btn.data('slug');
		var action = $btn.data('action'); // 'install' or 'activate'

		if (!slug || !action) {
			return;
		}

		// Disable button and show loading state.
		$btn.prop('disabled', true).text(action === 'install' ? 'Installing…' : 'Activating…');

		$.ajax({
			url: spiracleDemoImport.ajaxUrl,
			type: 'POST',
			data: {
				action: action === 'install' ? 'spiracle_install_plugin' : 'spiracle_activate_plugin',
				nonce: spiracleDemoImport.nonce,
				slug: slug
			},
			success: function (response) {
				if (response.success) {
					// Update the plugin item UI to show active status.
					var $item = $btn.closest('.spiracle-plugin-item');
					updatePluginItemUI($item, 'active', spiracleDemoImport.strings.plugin_active);

					// Remove the action button.
					$btn.remove();
				} else {
					var errorMsg = response.data && response.data.message
						? response.data.message
						: 'Operation failed.';
					alert(errorMsg);
					$btn.prop('disabled', false).text(action === 'install' ? 'Install & Activate' : 'Activate');
				}
			},
			error: function () {
				alert('Request failed. Please try again.');
				$btn.prop('disabled', false).text(action === 'install' ? 'Install & Activate' : 'Activate');
			}
		});
	});

	// Close overlay on clicking outside the modal.
	$(document).on('click', '#spiracle-import-overlay', function (e) {
		if ($(e.target).is('#spiracle-import-overlay')) {
			// Don't close during import — only after all done or error.
			var allDone = $('.spiracle-step-item.spiracle-step-done').length === steps.length;
			var hasError = $('.spiracle-step-item.spiracle-step-error').length > 0;
			if (allDone || hasError) {
				closeModal();
			}
		}
	});

	/**
	 * Close the import modal and restore the page state.
	 */
	function closeModal() {
		var allDone = $('.spiracle-step-item.spiracle-step-done').length === steps.length;
		var isSuccess = allDone;

		$('#spiracle-import-overlay').hide();

		// Re-enable buttons.
		$('.spiracle-import-btn').prop('disabled', false);

		// Reload page on success to reflect changes.
		if (isSuccess) {
			location.reload();
		}
	}

	// Close button (X) in modal header.
	$(document).on('click', '#spiracle-modal-close-btn', function (e) {
		e.stopPropagation();
		closeModal();
	});

	// Close button at the bottom of the modal.
	$(document).on('click', '#spiracle-close-popup-btn', function (e) {
		e.stopPropagation();
		closeModal();
	});

	// Store original button text.
	$('.spiracle-import-btn').each(function () {
		var $btn = $(this);
		$btn.data('original-text', $btn.text());
	});

})(jQuery);
