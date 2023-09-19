<?php
/*
	@package NikSkroutzWP Plugin 
*/
?>

<h1 id="nikchrist_main_title">NIK SKROUTZ PLUGIN</h1>
<?php 
settings_errors();

?>


<form method="post" action="options.php">
<?php settings_fields('NikSkroutz_options_group'); ?>
<?php do_settings_sections('nikskroutzwp_plugin'); ?>
<?php submit_button("Save Options","primary save-options-btn"); ?>
</form>
<div id="successmes2"></div>
<button type="submit" name="submitg456kyr"  class="runbtnclass" id="runbtn">CREATE XML</button>
----> <span id="sk-link"><a target="_blank" href="<?php echo get_site_url().'/wp-content/plugins/NikSkroutzWP/uploads/test.xml'?>">Open Skroutz Xml (<?php echo get_site_url()."/wp-content/plugins/NikSkroutzWP/uploads/test.xml"?>)</a></span>
<div id="successmes"></div>



