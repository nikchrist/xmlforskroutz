<?php
	/* @package NikSkroutzWP Plugin */

 namespace classes;
 use classes\createXML;
 class activate{
	public static function activate(){

		flush_rewrite_rules();
	}
}
?>