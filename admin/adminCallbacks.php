<?php
/*
	@package NikSkroutzWP Plugin 
*/
namespace admin;
use classes\createXML;
use \WC_Product_Attribute;
class adminCallbacks{
	private $productobj;
	public function NikSkroutzoptionsgroup($input){
		return $input;
	}
	
	
	
	public function NikSkroutzAdminSection(){
		
	}

	
	public function NikSkroutzColorOptions(){
		$attributes =  wc_get_attribute_taxonomies();
		$counter = 0;
		$values =array();
		foreach( $attributes as $attribute)
		{
			$term = wc_attribute_taxonomy_name($attribute->attribute_name);
			$values[$attribute->attribute_id] ='';
			if(taxonomy_exists($term))
				$values[$attribute->attribute_id] = $term;
			}
		
		echo '<select class="regular-text" name="color">';
		foreach( $attributes as $attribute ){
				$selected = false;
				if( $values[$attribute->attribute_id] == get_option('color') )
				{
					$selected = true;
				}
				echo "<option value='".$values[$attribute->attribute_id]."'".selected($selected,true,false).">".$attribute->attribute_name."</option>" ;
				$counter++;
		}
		echo '</select>';
		
	}

	
	public function NikSkroutzSizeOptions(){
		$attributes =  wc_get_attribute_taxonomies();
		$counter = 0;
		$values =array();
		foreach( $attributes as $attribute)
		{
			$term = wc_attribute_taxonomy_name($attribute->attribute_name);
			$values[$attribute->attribute_id] ='';
			if(taxonomy_exists($term))
				$values[$attribute->attribute_id] = $term;
			}
		
		echo '<select class="regular-text" name="size">';
		foreach( $attributes as $attribute ){
				$selected = false;
				if( $values[$attribute->attribute_id] == get_option('size') )
				{
					$selected = true;
				}
				echo "<option value='".$values[$attribute->attribute_id]."'".selected($selected,true,false).">".$attribute->attribute_name."</option>" ;
				$counter++;
		}
		echo '</select>';
		
	}
	
	public function NikSkroutzBrandOptions(){
		$attributes =  wc_get_attribute_taxonomies();
		$counter = 0;
		$values =array();
		foreach( $attributes as $attribute)
		{
			$term = wc_attribute_taxonomy_name($attribute->attribute_name);
			$values[$attribute->attribute_id] ='';
			if(taxonomy_exists($term))
				$values[$attribute->attribute_id] = $term;
			}
		
		echo '<select class="regular-text" name="manufacturer">';
		foreach( $attributes as $attribute ){
				$selected = false;
				if( $values[$attribute->attribute_id] == get_option('manufacturer') )
				{
					$selected = true;
				}
				echo "<option value='".$values[$attribute->attribute_id]."'".selected($selected,true,false).">".$attribute->attribute_name."</option>" ;
				$counter++;
		}
		echo '</select>';
		
	}
	
	public function NikSkroutzAvailabilityText(){
		echo '<input type="text" class="regular-text" name="availabillity" value="'.get_option('availabillity').'" />';
	}
	
	public function EnableVariations(){
			if(!null == get_option('enablevars'))
			{
				$enablevars = "true";
			} else {
				$enablevars = "false";
			}
			if($enablevars == "true")
			{
				echo '<input type="checkbox" class="regular-checkbox" name="enablevars" value="'.$enablevars.'" checked />';
			} else {
				echo '<input type="checkbox" class="regular-checkbox" name="enablevars" value="'.$enablevars.'" />';
			}
		
		return $enablevars;
	}
	
}
?>