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
    <?php echo html_entity_decode ( do_shortcode( $capsule_crm_form_options['msh_cif_settings_after_successfull_submit_message'] ) ) ?>
</div>