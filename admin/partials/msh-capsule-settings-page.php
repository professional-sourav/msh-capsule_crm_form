<div class="wrap">
			<h2>Capsule CRM Form</h2>
			<p>Capsule CRM Form</p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'capsule_crm_form_option_group' );
					do_settings_sections( 'capsule-crm-form-admin' );
					submit_button();
				?>
			</form>
		</div>