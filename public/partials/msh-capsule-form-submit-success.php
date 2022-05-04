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

<div id="mshcp_form_after_submit_attachments">
<?php
if ( !empty( $capsule_crm_form_options["attachment_ids"] ) ):

    $attachment_id_arr = explode( ",", $capsule_crm_form_options["attachment_ids"] );
    ?>
    <ul class="mshcp-list-attachments">
    <?php
    foreach ( $attachment_id_arr as $index=>$attachment_id ) :

        $attachment = wp_get_attachment_image( $attachment_id, $index ? 'thumbnail' : 'large' );

        if ( $attachment ) :
            $attachment_download_url = wp_get_attachment_url( $attachment_id );
            ?>
                <li>
                    <a href="<?php echo $attachment_download_url ?>"
                        alt="<?php echo __("Download the PDF", $this->plugin_name) ?>"
                        title="<?php echo __("Download the PDF", $this->plugin_name) ?>"
                        class="mshcp-button-download" 
                        data-attachment-id="<?php echo $attachment_id ?>"
                        target="_blank">
                        <img src="<?php echo plugin_dir_url(__FILE__) . '../images/download-24.png' ?>">
                    </a>
                    <?php echo $attachment ?>
                </li>
            <?php
        endif;

    endforeach;
    ?>
    </ul>
    <?php

endif;
?>
</div>