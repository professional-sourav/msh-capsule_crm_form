<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://awesome.com
 * @since      1.0.0
 *
 * @package    Msh_Capsule_Integration_Form
 * @subpackage Msh_Capsule_Integration_Form/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Msh_Capsule_Integration_Form
 * @subpackage Msh_Capsule_Integration_Form/public
 * @author     Msh <awsome@gmail.com>
 */
class Msh_Capsule_Integration_Form_Public {

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

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_shortcode( 'MSHCapsule_Form', [ $this, 'init_capsule_form_callback' ] );

		add_action('wp_ajax_mshcp_form_submit_callback', [ $this, 'mshcp_form_submit_callback' ]); // wp_ajax_{ACTION HERE} 
		add_action('wp_ajax_nopriv_mshcp_form_submit_callback', [ $this, 'mshcp_form_submit_callback' ]);
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/msh-capsule-integration-form-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/msh-capsule-integration-form-public.js', array( 'jquery' ), $this->version, false );

		wp_localize_script( 
			$this->plugin_name, 
			sprintf( "%s_%s", str_replace( "-", "_", $this->plugin_name ), "ajax" ), 
			array( 'ajaxurl' => admin_url( 'admin-ajax.php' ))
		);

	}


	public function init_capsule_form_callback() {

		ob_start();

		include_once plugin_dir_path(__FILE__) .  "/partials/msh-capsule-form.php";

		$output = ob_get_contents();

		ob_clean();

		return $output;
	}


	public function mshcp_form_submit_callback() {

		// echo json_encode($_POST['data']);

		echo $this->add_data_to_capsule( $_POST['data'] );

		exit();
	}


	private function add_data_to_capsule( $post_data_arr ) {

		$url 								= "https://api.capsulecrm.com/api/v2/parties";
		$data 								= [];
		$data["party"]["type"] 				= "person";
		$data["party"]["firstName"] 		= $post_data_arr["first_name"];
		$data["party"]["lastName"] 			= $post_data_arr["last_name"];
		$data["party"]["jobTitle"] 			= $post_data_arr["interested_in"];
		// $data["party"]["organisation"] 		= $post_data_arr["company"];
		$data["party"]["phoneNumbers"] 		= [ ["type" => null, "number" => $post_data_arr["phone_number"]] ];
		$data["party"]["emailAddresses"]	= [ ["type" => "Work", "address" => $post_data_arr["email"]] ];
		$token 			= "zJMHIO3iK3mieK7OAHhYOL/gHBZlW3OeQK7wH9alsBwlAY2B1gNWNUAuopKZv6dY";

		// return json_encode($data);

		$header = array(
			'Content-Type' 			=> 'application/json; charset=utf-8', 
			'Accept' 				=> 'application/json',
			'Authorization'			=>'Bearer ' . $token
		);
	
		$args = array(
			'headers'     	=> $header,
			'body'        	=> json_encode( $data ),
			'method'      	=> 'POST',
			'data_format' 	=> 'body',
			'timeout' 		=> 200,
		);
	
		// bypass SSL error
		// add_filter('https_ssl_verify', '__return_false');
	
		$response = wp_remote_post($url, $args);

		return wp_remote_retrieve_body($response);
	}
}
