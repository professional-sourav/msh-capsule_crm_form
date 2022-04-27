(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(document).on("submit", "#msh-capsule-integration-form > #mshcp_form", function(event) {

		event.preventDefault();

		console.log("Submit the form");

		const formData = {
			action: "mshcp_form_submit_callback",
			data: {
				first_name: $(this).find("#mshcp_first_name").val(),
				last_name: $(this).find("#mshcp_last_name").val(),
				job_title: $(this).find("#mshcp_job_title").val(),
				company: $(this).find("#mshcp_company").val(),
				email: $(this).find("#mshcp_email").val(),
				phone_number: $(this).find("#mshcp_phone_number").val(),
				interested_in: $(this).find("#mshcp_interested_in").val()
			}
		}; //$(this).serialze();

		const submitButton = $(this).find("button[type=submit]");

		jQuery.ajax({
			type: "post",
			dataType: "json",
			url: msh_capsule_integration_form_ajax.ajaxurl,
			data: formData,
			beforeSend: function() {
				$(submitButton).addClass("loading");
			},
			success: function(msg){
				console.log(msg);
				
				$(submitButton).removeClass("loading");
			}
		});
	});

})( jQuery );