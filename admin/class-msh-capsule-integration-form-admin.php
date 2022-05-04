<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://awesome.com
 * @since      1.0.0
 *
 * @package    Msh_Capsule_Integration_Form
 * @subpackage Msh_Capsule_Integration_Form/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Msh_Capsule_Integration_Form
 * @subpackage Msh_Capsule_Integration_Form/admin
 * @author     Msh <awsome@gmail.com>
 */
class Msh_Capsule_Integration_Form_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	private $capsule_crm_form_options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_action( 'admin_menu', array( $this, 'capsule_crm_form_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'capsule_crm_form_page_init' ) );

		add_action('wp_ajax_msh_cif_settings_remove_attachment_callback', [ $this, 'msh_cif_settings_remove_attachment_callback' ]); // wp_ajax_{ACTION HERE} 
		add_action('wp_ajax_nopriv_msh_cif_settings_remove_attachment_callback', [ $this, 'msh_cif_settings_remove_attachment_callback' ]);		
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Msh_Capsule_Integration_Form_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Msh_Capsule_Integration_Form_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/msh-capsule-integration-form-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Msh_Capsule_Integration_Form_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Msh_Capsule_Integration_Form_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_media();

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/msh-capsule-integration-form-admin.js', array( 'jquery' ), $this->version, false );

		wp_localize_script( 
			$this->plugin_name, 
			sprintf( "%s_%s", str_replace( "-", "_", $this->plugin_name ), "ajax" ), 
			array( 'ajaxurl' => admin_url( 'admin-ajax.php' ))
		);
	}


	public function capsule_crm_form_add_plugin_page() {
		add_menu_page(
			'Capsule CRM Form', // page_title
			'Capsule CRM Form', // menu_title
			'manage_options', // capability
			'capsule-crm-form', // menu_slug
			array( $this, 'capsule_crm_form_create_admin_page' ), // function
			'dashicons-admin-generic', // icon_url
			2 // position
		);
	}

	public function capsule_crm_form_create_admin_page() {

		$this->capsule_crm_form_options = get_option( 'capsule_crm_form_option_name' );	
		
		// print_r($this->capsule_crm_form_options); die;

		include_once plugin_dir_path(__FILE__) .  "/partials/msh-capsule-settings-page.php";
	}

	public function capsule_crm_form_page_init() {

		register_setting(
			'capsule_crm_form_option_group', // option_group
			'capsule_crm_form_option_name', // option_name
			array( $this, 'capsule_crm_form_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'capsule_crm_form_setting_section', // id
			'Settings', // title
			array( $this, 'capsule_crm_form_section_info' ), // callback
			'capsule-crm-form-admin' // page
		);

		add_settings_field(
			'api_token_0', // id
			'API Token', // title
			array( $this, 'settings_token_callback' ), // callback
			'capsule-crm-form-admin', // page
			'capsule_crm_form_setting_section' // section
		);

		add_settings_field(
			'message_to_be_display_after_successfull_submission_1', // id
			'Message to be display after successfull submission', // title
			array( $this, 'settings_message_to_be_display_after_successfull_submission_callback' ), // callback
			'capsule-crm-form-admin', // page
			'capsule_crm_form_setting_section' // section
		);

		add_settings_field(
			"capsule_crm_form_setting_pdf_upload", 
			"Upload PDFs", 
			array( $this, 'capsule_crm_form_section_pdf_upload' ), 
			"capsule-crm-form-admin", 
			"capsule_crm_form_setting_section"
		);  
	}

	public function capsule_crm_form_sanitize($input) {

		// print_r($input); echo "<pre>'"; die;

		$sanitary_values = array();
		if ( isset( $input['msh_cif_settings_token'] ) ) {
			$sanitary_values['msh_cif_settings_token'] = sanitize_text_field( $input['msh_cif_settings_token'] );
		}

		if ( isset( $input['msh_cif_settings_after_successfull_submit_message'] ) ) {
			$sanitary_values['msh_cif_settings_after_successfull_submit_message'] = esc_textarea( $input['msh_cif_settings_after_successfull_submit_message'] );
		}

		if ( isset( $input['attachment_ids'] ) ) {
			$sanitary_values['attachment_ids'] = sanitize_text_field( $input['attachment_ids'] );
		}

		return $sanitary_values;
	}

	public function capsule_crm_form_section_info() {
		
	}

	public function settings_token_callback() {
		printf(
			'<input class="regular-text" type="text" name="capsule_crm_form_option_name[msh_cif_settings_token]" id="msh_cif_settings_token" value="%s">',
			isset( $this->capsule_crm_form_options['msh_cif_settings_token'] ) ? esc_attr( $this->capsule_crm_form_options['msh_cif_settings_token']) : ''
		);
	}

	public function settings_message_to_be_display_after_successfull_submission_callback() {

		$options = get_option( 'capsule_crm_form_option_name' );

		$content = isset( $options['msh_cif_settings_after_successfull_submit_message'] ) 
		?  html_entity_decode($options['msh_cif_settings_after_successfull_submit_message']) 
		: false;

		wp_editor( 
			$content, 
			'msh_cif_settings_after_successfull_submit_message', 
			array( 
				'textarea_name' => 'capsule_crm_form_option_name[msh_cif_settings_after_successfull_submit_message]',
				'media_buttons' => false,			
			) 
		);
	}

	public function capsule_crm_form_section_pdf_upload() {

		if ( !empty( $this->capsule_crm_form_options['attachment_ids'] ) ) {

			$attachment_id_str = $this->capsule_crm_form_options['attachment_ids'];
			$attachment_id_arr = explode( ",", $attachment_id_str );
			$html = "<ul id='msh_cif_settings_attachments'>";
			$id_str = "";

			foreach ( $attachment_id_arr as $attachment_id ) {

				if ( wp_get_attachment_image( $attachment_id ) ) {

					$id_str .= $attachment_id . ",";

					$html .= '<li>
						<div class="msh-cif-settings-attachment-overlay"></div>
						<button type="button" class="msh_cif_settings_attachment_remove" data-attachment-id="'. $attachment_id .'">Remove</button>
						'. wp_get_attachment_image( $attachment_id ) .'
					</li>';
				}
			}

			$html .= '<input type="hidden" id="_hidden_capsule_crm_form_option_name_attachment_ids" name="capsule_crm_form_option_name[attachment_ids]" value="'. rtrim($id_str, ",") .'" />';

			$html .= "</ul>";

			echo $html;
		}
	}


	public function msh_cif_settings_remove_attachment_callback() {

		$this->capsule_crm_form_options = get_option( 'capsule_crm_form_option_name' );	

		if ( !empty( $_POST["data"]["attachment_id"] ) ) {

			$attachment_ids = $this->capsule_crm_form_options['attachment_ids'];
			$attachment_ids_arr = explode(",", $attachment_ids);

			if (($key = array_search($_POST["data"]["attachment_id"], $attachment_ids_arr)) !== false) {
				unset($attachment_ids_arr[$key]);
			}

			$this->capsule_crm_form_options['attachment_ids'] = trim( implode( ",", $attachment_ids_arr ), ",");

			// echo "<pre>" . print_r($this->capsule_crm_form_options); die;

			update_option( "capsule_crm_form_option_name", $this->capsule_crm_form_options );

			// if ( wp_delete_attachment( intval( $_POST["data"]["attachment_id"] ) ) )
			// 	return wp_send_json_success([
			// 		"message"	=> __("The attachment has been deleted successfully!", $this->plugin_name)
			// 	]);
		}

		return wp_send_json_error([
			"message"	=> __("Something is wrong! Please try after sometime", $this->plugin_name)
		]);
	}
}
