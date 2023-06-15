(function ($) {
    "use strict";

	/**
	 * Hide toast on click button or after 5 seconds
	 * 
	 * @since 1.0.0
	 */
	jQuery( function($) {
		$('.hide-toast').click( function() {
			$('.update-notice-spm-wp').fadeOut('fast');
		});

		setTimeout( function() {
			$('.update-notice-spm-wp').fadeOut('fast');
		}, 5000);
	});

	/**
	 * Display loader and hide span on click
	 * 
	 * @since 1.0.0
	 */
	jQuery( function($) {
		$('.button-loading').on('click', function() {
			let $btn = $(this);
			let originalText = $btn.text();
			let btnWidth = $btn.width();
			let btnHeight = $btn.height();

			// keep original width and height
			$btn.width(btnWidth);
			$btn.height(btnHeight);

			// Add spinner inside button
			$btn.html('<span class="spinner-border spinner-border-sm"></span>');
		
			setTimeout(function() {
			// Remove spinner
			$btn.html(originalText);
			
			}, 15000);
		});

		// Prevent keypress enter
		$('.form-control').keypress(function(event) {
			if (event.keyCode === 13) {
			event.preventDefault();
			}
		});
	});


	/**
	 * Check elements if has class pro-version
	 * 
	 * @since 1.0.0
	 */
	jQuery( function($) {
		$('.pro-version').prop('disabled', true);
	});


	/**
	 * Disable save options button if options are not different
	 * 
	 * @since 1.0.0
	 */
	jQuery( function($) {
		let saveButton = $('#save_settings');
		let settingsForm = $('form[name="wp-smart-plugin-manager"]');

		// get original values of options in the data base wordpress
		let originalValues = settingsForm.serialize();

		// disable button if options are not different
		if (settingsForm.serialize() === originalValues) {
			saveButton.prop('disabled', true);
		} else {
			saveButton.prop('disabled', false);
		}

		// Records a change event on form fields
		settingsForm.on('change', function() {
			// Verifica se houve mudanças nos valores dos campos
			if (settingsForm.serialize() === originalValues) {
				// If the values are the same, disable the save button
				saveButton.prop('disabled', true);
			} else {
				// If the values are different, enable the save button
				saveButton.prop('disabled', false);
			}
		});
	});

})(jQuery);