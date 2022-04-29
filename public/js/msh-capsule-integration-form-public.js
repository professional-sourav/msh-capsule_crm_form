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
		const submitButtonText = $(submitButton).html();

		$(submitButton).prop("disabled", true);

		jQuery.ajax({
			type: "post",
			dataType: "json",
			url: msh_capsule_integration_form_ajax.ajaxurl,
			data: formData,
			beforeSend: function() {
				$(submitButton).addClass("loading");
				$(submitButton).html("Processing...");
			},
			success: function(response){
				console.log(response);
				$(submitButton).prop("disabled", false);
				
				$(submitButton).removeClass("loading");
				$(submitButton).html(submitButtonText)

				// display the success message and remove the form from the page
				if ( response["data"]['successful_message_html'] ) {
					
					$("#msh-capsule-integration-form").html( response["data"]['successful_message_html'] );
				}

				// download
				if ( response["data"]['redirect_url'] ) {

					location.href = response["data"]['redirect_url'];
				}
			}
		});
	});

})( jQuery );
