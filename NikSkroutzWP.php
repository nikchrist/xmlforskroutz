<?php 
/*
	@package NikSkroutzWP Plugin 
*/

/*
	Plugin Name: NikSkroutzWP Plugin
	Plugin URI: https://yourwebsite.gr/plugins
	Author Name: Nikos Christomanos
	Author URI: https://yourwebsite.gr
	Version: 1.0.0
	Licence: GPLV3
	Text Domain: NikSkroutzWP Plugin
*/ 

if(!defined('ABSPATH') || !function_exists('add_action'))
{
	die("sorry.you are not allowed to enter my plugin :)");
}

/* add_action('plugins_loaded','runPlugin');

function runPlugin(){ */

if( file_exists( dirname(__FILE__).'/vendor/autoload.php'))
{
	require_once dirname(__FILE__).'/vendor/autoload.php';
} else {
	
	echo "composer not found!";
}

if( class_exists('classes\\init'))
{
	$init = new classes\init;
	add_action('init',array($init,'create_obj'));
} else {
	die("error in initialization!!!!");
}


function activate_NikSkroutzWpPlugin(){

	if( class_exists('classes\\activate'))
	{
		classes\activate::activate();
	} else{
	die("cannot activate");
	}
}

register_activation_hook(__FILE__,'activate_NikSkroutzWpPlugin');

function deactivate_NikSkroutzWpPlugin(){
	if( class_exists('classes\\deactivate'))
	{
		classes\deactivate::deactivate();
	}
}

register_deactivation_hook(__FILE__,'deactivate_NikSkroutzWpPlugin');

function myjs_for_skroutz(){
		$nonce = $_REQUEST['_wpnonce'];
		if(wp_verify_nonce($nonce,'skroutz_nonce') )
		{
			$createxml = new classes\createXML;
			$response["custom"] = $createxml->produceXML();
			$response["success"] = true;
			$response["message"] = '';
			$response = json_encode($response);
			die();
		}
	}

		add_action('wp_ajax_myjs_for_skroutz','myjs_for_skroutz' );
		add_action('wp_ajax_nopriv_myjs_for_skroutz','myjs_for_skroutz');


/* } */
?>
