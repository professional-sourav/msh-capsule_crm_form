<?php
$attachment_id 	= get_option( "msh_capsule_integration_form_media_post_id" );
$attachment_url	= wp_get_attachment_url($attachment_id);
$download_url   = sprintf(
    $this->resource_download_url,
    home_url(),
    base64_encode( $attachment_url )
);
$capsule_crm_form_options = get_option( 'capsule_crm_form_option_name' );	
?>

<div id="mshcp_form_submit_success">
    <h5>
        <img src="<?php echo plugin_dir_url(__FILE__) . "../images/success-submit.svg" ?>" class="success-submit-icon">
        <?php echo __( $capsule_crm_form_options['msh_cif_settings_after_successfull_submit_message'], $this->plugin_name ) ?>
    </h5>
    <p>Your download is starting now.<br>
        Please <a href="<?php echo $download_url ?>" target="_blank">click here</a> to download if not started yet.
    </p>
</div>