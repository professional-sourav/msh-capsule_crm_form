<div class="wrap">
	<h2><?php echo __("Capsule CRM Form", $this->plugin_name) ?></h2>
	<p><?php echo __("Capsule CRM Form", $this->plugin_name) ?></p>
	<?php settings_errors(); ?>

	<form method="post" action="options.php">
		<?php
			settings_fields( 'capsule_crm_form_option_group' );
			do_settings_sections( 'capsule-crm-form-admin' );
		?>		

		<!-- Media selection buttion -->
		<button id="capsule_crm_form_upload_image_button" class="button" type="button">
			<?php echo __("Select PDF Files", $this->plugin_name) ?>
		</button>

		<!-- Submit button -->
		<?php submit_button(); ?>
	</form>
</div>