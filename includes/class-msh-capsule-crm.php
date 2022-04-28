<?php

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Msh_Capsule_Integration_Form
 * @subpackage Msh_Capsule_Integration_Form/includes
 * @author     Msh <awsome@gmail.com>
 */
class Msh_Capsule_Crm {

	protected $url;
	protected $token;
	
	public function __construct() {
		
        $this->url = "https://api.capsulecrm.com/api/v2/parties";

        $this->token = "zJMHIO3iK3mieK7OAHhYOL/gHBZlW3OeQK7wH9alsBwlAY2B1gNWNUAuopKZv6dY";
	}

    public function add_parties( $post_data_arr ) {

		$data 								= [];
		$data["party"]["type"] 				= "person";
		$data["party"]["firstName"] 		= $post_data_arr["first_name"];
		$data["party"]["lastName"] 			= $post_data_arr["last_name"];
		$data["party"]["jobTitle"] 			= $post_data_arr["interested_in"];
		// $data["party"]["organisation"] 		= $post_data_arr["company"];
		$data["party"]["phoneNumbers"] 		= [ ["type" => null, "number" => $post_data_arr["phone_number"]] ];
		$data["party"]["emailAddresses"]	= [ ["type" => "Work", "address" => $post_data_arr["email"]] ];

		// return json_encode($data);

		$header = array(
			'Content-Type' 			=> 'application/json; charset=utf-8', 
			'Accept' 				=> 'application/json',
			'Authorization'			=>'Bearer ' . $this->token
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
	
		$response = wp_remote_post($this->url, $args);

		return wp_remote_retrieve_body($response);
    }
}