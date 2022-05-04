(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
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

	$(document).ready(function() {

		const wpOpenGallery = function(o, callback) {
		   const options = (typeof o === 'object') ? o : {};
  
		   // Predefined settings
		   const defaultOptions = {
			  title: 'Select Media',
			  fileType: 'application/pdf',
			  multiple: true,
			  currentValue: '',
		   };
  
		   const opt = {
			  ...defaultOptions,
			  ...options
		   };
  
		   let image_frame;
  
		   if (image_frame) {
			  image_frame.open();
		   }
  
		   // Define image_frame as wp.media object
		   image_frame = wp.media({
			  title: opt.title,
			  multiple: opt.multiple,
			  library: {
				 type: opt.fileType,
			  }
		   });
  
		   image_frame.on('open', function() {
			  // On open, get the id from the hidden input
			  // and select the appropiate images in the media manager
			  const selection = image_frame.state().get('selection');
			  const ids = opt.currentValue.split(',');
  
			  ids.forEach(function(id) {
				 const attachment = wp.media.attachment(id);
				 attachment.fetch();
				 selection.add(attachment ? [attachment] : []);
			  });
		   });
  
		   image_frame.on('close', function() {
			  // On close, get selections and save to the hidden input
			  // plus other AJAX stuff to refresh the image preview
			  const selection = image_frame.state().get('selection');
			  const files = [];
  
			  selection.each(function(attachment) {
				 files.push({
					id: attachment.attributes.id,
					filename: attachment.attributes.filename,
					url: attachment.attributes.url,
					type: attachment.attributes.type,
					subtype: attachment.attributes.subtype,
					sizes: attachment.attributes.sizes,
				 });
			  });
  
			  callback(files);
		   });
  
		   image_frame.open();
		}		

		// open the media library, and get the data from the selected files
		$(document).on('click', '#capsule_crm_form_upload_image_button', function(e) {
			e.preventDefault();

			const button_upload = $(this);
		   
		   	wpOpenGallery(null, function(attachments) {

				let attachment_ids 	= [];
				let file_names		= [];

			   	$.each(attachments, function (index, attachment) {

					console.log(attachment);

					attachment_ids.push( attachment['id'] );

					file_names.push( attachment['filename'] );
				});
					
				if ( $("#_hidden_capsule_crm_form_option_name_attachment_ids").length ) 
				$("#_hidden_capsule_crm_form_option_name_attachment_ids").val(
					$("#_hidden_capsule_crm_form_option_name_attachment_ids").val() + "," + attachment_ids
				);
				else
					$(button_upload).closest('form').append(
						`<input type="hidden" id="_hidden_capsule_crm_form_option_name_attachment_ids" name="capsule_crm_form_option_name[attachment_ids]" value="${attachment_ids}" />`
					);


				let html = "<ul class='msh-capsule-selected-files'>";

				$.each(file_names, function (index, file_name) {

					html += `<li>${file_name}</li>`;
				});

				html += "</ul>";

				// $(button_upload).after(`<ul>${file_names.join("").toString()}</ul>`);
				$(button_upload).after( html );
		   });
		});

		// remove the attachment by clicking the Remove button
		$(document).on("click", ".msh_cif_settings_attachment_remove", function() {

			const attachment_id = $(this).attr("data-attachment-id");
			const element		= $(this);
			const formData 		= {
				action: "msh_cif_settings_remove_attachment_callback",
				data: {
					attachment_id: attachment_id
				}
			}

			jQuery.ajax({
				type: "post",
				dataType: "json",
				url: msh_capsule_integration_form_ajax.ajaxurl,
				data: formData,
				beforeSend: function() {
					$(element).attr('disabled', true);
				},
				success: function(response){
					console.log(response);
					$(element).attr('disabled', false);
					$(element).parent().remove();
				}
			});
		});
	});

})( jQuery );
