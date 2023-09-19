<?php 
/*
	@package NikSkroutzWP Plugin 
*/

	namespace admin;
	use admin\adminCallbacks;
	class admin extends adminCallbacks{
	public  $pages = array();
	 public function register(){
	 	$this->setPages();
	 	add_action('admin_menu',array($this,'AddMenu'));
		add_action('admin_init',array($this,'registerFields'));
	 }
	 	
	 public function setPages(){
		$this->pages = array(
				'page_title' => 'NikSkroutzWP Plugin',
				'menu_title' => 'NikSkroutzWP',
				'capabillity' => 'manage_options',
				'menu_slug' => 'nikskroutzwp_plugin',
				'callback' => array($this,'adminDashboard'),
				'icon_url' => 'dashicons-vault',
				'position' => 110
		);
	}

	public function AddMenu(){
		add_menu_page($this->pages["page_title"],$this->pages["menu_title"],$this->pages["capabillity"],$this->pages["menu_slug"],
	 								$this->pages["callback"],$this->pages["icon_url"],$this->pages["position"]);
	 }
	

	public function adminDashboard(){
		return require_once(plugin_dir_path( dirname( __FILE__) )).'templates/admintemplate.php';
	}
		
	public function setSettings(){
		$args = array(
			array(
				'option_group' => 'NikSkroutz_options_group',
				'option_name' => 'color',
				'callback' => array($this,'NikSkroutzoptionsgroup')

			),

			array(
				'option_group' => 'NikSkroutz_options_group',
				'option_name' => 'size',
				'callback' => array($this,'NikSkroutzoptionsgroup')
			),
			
			array(
				'option_group' => 'NikSkroutz_options_group',
				'option_name' => 'manufacturer',
				'callback' => array($this,'NikSkroutzoptionsgroup')
			),
			
			array(
				'option_group' => 'NikSkroutz_options_group',
				'option_name' => 'availabillity',
				'callback' => array($this,'NikSkroutzoptionsgroup')
			),
			array(
				'option_group' => 'NikSkroutz_options_group',
				'option_name' => 'enablevars',
				'callback' => array($this,'NikSkroutzoptionsgroup')
			)
		);
		return $args;
	}
		
	public function setSections(){
		$args = array(
			array(
				'id' => 'NikSkroutz_admin_index',
				'title' => 'Settings',
				'callback' => array($this,'NikSkroutzAdminSection'),
				'page' => 'nikskroutzwp_plugin'
			)
		);
		return $args;
	}
		
	public function setFields(){
		$args = array(
			array(
				'id' => 'color',
				'title' => 'Color',
				'callback' => array($this,'NikSkroutzColorOptions'),
				'section' => 'NikSkroutz_admin_index',
				'page' => 'nikskroutzwp_plugin',
				'args' => array(
					'label_for' => 'color',
					'class' => 'color-class'
				)
			),
			
			array(
				'id' => 'size',
				'title' => 'Size',
				'callback' => array($this,'NikSkroutzSizeOptions'),
				'section' => 'NikSkroutz_admin_index',
				'page' => 'nikskroutzwp_plugin',
				'args' => array(
					'label_for' => 'size',
					'class' => 'size-class'
				)
			),
			
			array(
				'id' => 'manufacturer',
				'title' => 'Manufacturer',
				'callback' => array($this,'NikSkroutzBrandOptions'),
				'section' => 'NikSkroutz_admin_index',
				'page' => 'nikskroutzwp_plugin',
				'args' => array(
					'label_for' => 'manufacturer',
					'class' => 'manufacturer-class'
				)
			),
			
			array(
				'id' => 'availabillity',
				'title' => 'Availabillity',
				'callback' => array($this,'NikSkroutzAvailabilityText'),
				'section' => 'NikSkroutz_admin_index',
				'page' => 'nikskroutzwp_plugin',
				'args' => array(
					'label_for' => 'availabillity',
					'class' => 'availabillity-class'
				)
			),
			
			array(
				'id' => 'enablevars',
				'title' => 'Enable Variations',
				'callback' => array($this,'EnableVariations'),
				'section' => 'NikSkroutz_admin_index',
				'page' => 'nikskroutzwp_plugin',
				'args' => array(
					'label_for' => 'enablevars',
					'class' => 'availabillity-class'
				)
			),
		);
		
		return $args;
	}
		
	public function registerFields(){
		foreach($this->setSettings() as $setting )
		{
			register_setting($setting["option_group"],$setting["option_name"],array(isset($setting["callback"])?$setting["callback"]:""));
		}
		
		foreach($this->setSections() as $section )
		{
			add_settings_section($section["id"],$section["title"],isset($section["callback"])?$section["callback"]:"",$section["page"]);
		}
		
		foreach($this->setFields() as $field )
		{
			add_settings_field($field["id"], $field["title"], ( isset($field["callback"])? $field["callback"]:""),
											$field["page"],$field["section"],( isset($field["args"])? $field["args"]:""));
		}
	}
		
}

?>