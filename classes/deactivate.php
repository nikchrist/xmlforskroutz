<?php
/* @package NikSkroutzWP Plugin */

 namespace classes;

 class deactivate{
	public static function deactivate(){
		wp_delete_file("/wp-content/plugins/NikSkroutzWP/uploads/test.xml");
		flush_rewrite_rules();
	}
}

?>