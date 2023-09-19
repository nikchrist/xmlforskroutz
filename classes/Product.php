<?php 
/*
	@package NikSkroutzWP Plugin 
*/

namespace classes;
use \WC_Product_Variable;
use \WC_Product_Variation;
class Product{
	
	public  $products;
	public  $product_info = array(); 	
	public  $var_product_info = array();
	public  $variation_info = array();
	
	/*public function getVarMeta($variation,$meta ='',$trueorfalse)
	{
		return get_post_meta($variation->ID,$meta,$trueorfalse);
	} */

	
	public function getProductId($product){
	
			return esc_html($product->get_id());
	}
	
	//variation id
		
	public function getProductVarId($variation){
	
			return esc_html($variation->ID);
	}

	public function getProductName($product){
		return esc_html($product->get_name());
	}  
	
	//variation name
	public function getProductVarName($variation,$product){
	$croma = get_option('color');
	$testarray = array();	
	$variation_attributes = $product->get_variation_attributes();
	foreach( $variation_attributes as $attribute_slug => $attribute_slug_values)
	{
		$attribute_obj = get_taxonomy($attribute_slug);
		if( $attribute_slug == get_option('color'))
		{ 
		 foreach($attribute_slug_values as $attribute_slug_value){
		
            $attr_value_objs = get_term_by( 'slug', $attribute_slug_value, $attribute_slug );
			$testarray[$i] = $attr_value_objs->name;
		 } 
		}
	
	break;	
	}
	$symvolosira = array();
		$i = 0;
	 $availables = $product->get_available_variations();
		 /* foreach( get_post_meta($variation->ID) as $key => $value)
		{
			$symvolosira.=$key."|".$value."-";
			
		}  */
		
		 foreach( $availables as $available)
		{
			 
			//$symvolosira[$i] = $available->get_variation_attributes();
			//$i++;
		} 
		
		
		return esc_html($variation->post_name.implode("|",array_unique($testarray)) );
	} 
	
	public function createVarArray($variation)
	{
		$variation2  = new WC_Product_Variation($variation->ID);
		$vararray = array(
			"price" => number_format((float)get_post_meta($variation->ID,'_regular_price',true),2,",","."),
			"sale_price" => number_format((float)get_post_meta($variation->ID,'_sale_price',true),2,",","."),
			"color" => $variation2->get_attribute( get_option("color") ),
			"size" => $variation2->get_attribute( get_option("size") ),
		
		);
		
		
		foreach( $vararray  as $key => $value)
		{
			$this->var_product_info[$key] = $value; 
			
		}
	} 
	
	public function getVarSIzes($variation){
		$this->createVarArray($variation);
		
	}
	
	public function getProductVarSizes($variation){
		$this->createVarArray($variation);
		
	}
	
	public function getProductVarPrice($variation)
	{
		$this->createVarArray($variation);
		//return number_format(get_post_meta($variation->ID,'_regular_price',true),2,",",".");
		if(null == get_post_meta($variation->ID,'_sales',true))
		{ 
			//return number_format((float)get_post_meta($variation->ID,'_regular_price',true),2,",",".");
			return $this->var_product_info["price"];
		 } else{
			//return number_format((float)get_post_meta($variation->ID,'_sale_price',true),2,",",".");
			return $this->var_product_info["sale_price"];
		} 
	}

	public function getProductImage($product){
		if ( has_post_thumbnail( $product->get_id() ) ) {
        	$attachment_ids[0] = get_post_thumbnail_id( $product->get_id()  );
 					$attachment = wp_get_attachment_image_url($attachment_ids[0]);
 					return preg_replace("/^http:/i","https:",esc_html($attachment));
		}

	}
	
	public function getVarProductImage($variation,$product){
	
		if ( has_post_thumbnail( $variation->ID ) ) {
        	$attachment_ids[0] = get_post_thumbnail_id( $variation->ID   );
 					$attachment = wp_get_attachment_image_url($attachment_ids[0]);
 					return preg_replace("/^http:/i","https:",esc_html($attachment));
		} else {
			$this->getProductImage($product);
		}
	}

	public function getProductImages($product){
		$attachment_ids = $product->get_gallery_attachment_ids();

		$imageurls = array();
	
		foreach( $attachment_ids as $attachment_id)
		{
			 $imageurls[] = preg_replace("/^http:/i","https:",esc_html(wp_get_attachment_url($attachment_id)) );
			
		
		}

		return $imageurls;
	}

	public function getProductUrl($product){
		return preg_replace("/^http:/i","https:",get_permalink($product->get_id()) );
	}
	
	
	public function getProductCategories($product){
		$ancestor_list = [];
		$counter = 0;
		$product_last_child  = get_the_terms($product->get_id(),'product_cat');
		$product_last_child = array_reverse($product_last_child);
		$product_last_child = $product_last_child[0];
		$product_last_child_id = $product_last_child->term_id;
		$product_last_child_name = $product_last_child->name;
		$ancestor_cat_ids = array_reverse(get_ancestors($product_last_child_id,'product_cat') );
		foreach( $ancestor_cat_ids as $ancestor_id)
		{
			$anscestor_term = get_term($ancestor_id,'product_cat');
			$ancestor_list[$counter] = $anscestor_term->name;
			$counter++;
		}
		
		return implode(" - ",$ancestor_list)." - ".$product_last_child_name;
	}
	
	public function getProductColor($product)
	{
		$attribute = get_option('color');
		
		return $product->get_attribute($attribute);
	}
	
	
	public function getProductSize($product)
	{
		$attribute = get_option('size');
		
		return $product->get_attribute($attribute);
	}
	
	public function getVarProductSize($variation){
		$this->createVarArray($variation);
		return $this->var_product_info["size"];
	}
	
	public function getProductBrand($product)
	{
		$attribute = get_option('manufacturer');
		
		return $product->get_attribute($attribute);
	}
	
	public function getProductAvailabillity($product)
	{
		return get_option('availabillity');
		
	}
	
	
	
	public  function getVariations($product){

		/* $available_variations = $product->get_available_variations();
		return $available_variations; */

	}

	public function getProductPrice($product){
		if($product->is_on_sale())
		{
			return number_format((float)$product->get_sale_price(),2,",",".");
		}else{
		
			return number_format((float)$product->get_regular_price(),2,",",".");
		}

	}
	
	public function getMPN($product){
		return $product->get_sku();
	}
	
	public function getStockStatus($product)
	{
		$stock = '';
		if($product->managing_stock() && $product->get_stock_quantity() > 0)
		{
			$stock = 'Y';
		} else if( $product->managing_stock() && $product->get_stock_quantity() == 0)
		{
			$stock = 'N';
		} else {
			$stock = 'Y';
		}
			
		
		
		return $stock;
	}
	
	public function getWeight($product){
		return number_format((float)$product->get_weight(),2,",",".");
	}
	

}

?>