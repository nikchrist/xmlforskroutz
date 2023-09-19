<?php
/*
	@package NikSkroutzWP Plugin 
*/
namespace classes;
use classes\createXML;
class Enqueue{
	public function register(){
		add_action('admin_enqueue_scripts',array($this,'enqueue'));
		add_action('init', array($this,'enqueueAjax') );
		add_action('admin_footer',array($this,'enqueueAjax') );
	}
	

	public function enqueue(){
		wp_enqueue_style('nikskroutzwpstyle',plugin_dir_url(dirname(__FILE__)).'style.css');
	}

		public function enqueueAjax(){

			wp_register_script('myjs',plugin_dir_url(dirname(__FILE__)).'assets/ajax.js');

			wp_localize_script(
				'myjs',
				'myjs_globals',
				array(
					'ajax_url' => admin_url('admin-ajax.php'),
					'nonce' => wp_create_nonce('skroutz_nonce')
				)
			);

			wp_enqueue_script('myjs',plugin_dir_url(dirname(__FILE__)).'assets/ajax.js' );

		}
		

		

	}

?>