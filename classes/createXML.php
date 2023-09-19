<?php 
/*
	@package NikSkroutzWP Plugin 
*/

namespace classes;
use \WC_Product_Query;
use \DOMDocument;
use \WP_Term_Query;
use \WP_Term;
use \WP_Query;
use admin\adminCallbacks;
class createXML extends Product{
	private $xml;
	public function register(){
		$this->produceXML();
	}
	
	public static function getProductObj(){
		$args = array(
				"limit" => -1,
				"order" => "Desc",
				"orderby" => "date",
				"status" => "publish",
				"stock_status" => "instock"
			);
		return wc_get_products($args);
	}
	
	public function getProductvariations($product){
		$args = array(
			"post_type" => "product_variation",
			"post_status" => array("public","publish"),
			"number_posts" => -1,
			"order" => "Desc",
			"post_parent" => $this->getProductId($product)
		);
		
		return get_posts($args);
		
	}
	
	public function produceXML(){
		if(  get_option('enablevars') == false){
			
			$this->products = self::getProductObj();
			header('Content-Type: text/xml; charset=utf-8');
			//root
			$this->xml = new DOMDocument('1.0','UTF-8');
			$webroot = $this->xml->createElement('webroot');
			$this->xml->appendChild($webroot);
			//date created
			$date_created = $this->xml->createElement('created_at',date('Y-m-d h:i:sa'));
			$webroot->appendChild($date_created);
			//products
			$productsxml = $this->xml->createElement('products');
			$webroot->appendChild($productsxml);
			//loop products
			foreach($this->products as $product){
				//CREATE ELEMENTS
				// <product>
				$productxml = $this->xml->createElement('product');
				// <id>
				$product_id = $this->xml->createElement('id',$this->getProductId($product) );
				// <name>
				$product_name = $this->xml->createElement('name');
				// <link>
				$product_url = $this->xml->createElement('link');
				// <image>
				$product_imageurl = $this->xml->createElement('image');
				// <additional_images>
				$product_additional_images = $this->xml->createElement('additional_images');
				//<price>
				$product_price = $this->xml->createElement('price_with_vat',$this->getProductPrice($product));
				//<category path>
				$product_categories = $this->xml->createElement('category_path');
				//<color>
				$product_color = $this->xml->createElement('color',$this->getProductColor($product));
				//<size>
				$product_size =  $this->xml->createElement('size',$this->getProductSize($product));
				//<manufacturer>
				$product_brand = $this->xml->createElement('manufacturer');
				//sku
				$product_mpn = $this->xml->createElement('mpn',$this->getMPN($product));
				//stockstatus
				$product_stock = $this->xml->createElement('instock',$this->getStockStatus($product) );
				//weight
				$product_weight = $this->xml->createElement('weight',$this->getWeight($product));
				//availabillity
				$product_avail = $this->xml->createElement('availability',$this->getProductAvailabillity($product));
				
				//CREATE CDATA SECTIONS
				// <name>
				$product_name_cdata = $this->xml->createCDATAsection($this->getProductName($product));
				// <link>
				$urlcdata = $this->xml->createCDATAsection($this->getProductUrl($product));
				// <image>
				$product_imageurlcdata = $this->xml->createCDATAsection( $this->getProductImage($product));
				//<category_path>
				$product_categories_cdata = $this->xml->createCDATAsection( $this->getProductCategories($product));
				//<manufacturer>
				$product_brand_cdata = $this->xml->createCDATAsection( $this->getProductBrand($product));

				//APPEND ELEMENTS
				//product
				$productsxml->appendChild($productxml); 
				// <id>
				$productxml->appendChild($product_id);
				//<name>
				$product_name->appendChild($product_name_cdata);
				$productxml->appendChild($product_name);
				//<link>
				$product_url->appendChild($urlcdata); 
				$productxml->appendChild($product_url);
				//<image>
				$product_imageurl->appendChild($product_imageurlcdata);
				$productxml->appendChild($product_imageurl);
				//get all <additional_images> of each product
				foreach($this->getProductImages($product) as $product_additional_img)
				{
					$product_additional_images = $this->xml->createElement('additional_images');
					$product_additional_images_cdata = $this->xml->createCDATAsection( $product_additional_img );
					$product_additional_images->appendChild($product_additional_images_cdata);
					$productxml->appendChild($product_additional_images);
				}
				//categories
				$product_categories->appendChild($product_categories_cdata);
				$productxml->appendChild($product_categories);
				//<price>
				$productxml->appendChild($product_price);
				//color
				$productxml->appendChild($product_color);
				//size
				$productxml->appendChild($product_size);

				//categories
				$product_brand->appendChild($product_brand_cdata);
				$productxml->appendChild($product_brand);
				//sku
				$productxml->appendChild($product_mpn);
				//stockstatus
				$productxml->appendChild($product_stock);
				//weight
				$productxml->appendChild($product_weight);
				//availability
				$productxml->appendChild($product_avail);
			}
		} else if( get_option('enablevars') == true) { // product variations
			
			$this->products = self::getProductObj();
			header('Content-Type: text/xml; charset=utf-8');
			//root
			$this->xml = new DOMDocument('1.0','UTF-8');
			$webroot = $this->xml->createElement('webroot');
			$this->xml->appendChild($webroot);
			//date created
			$date_created = $this->xml->createElement('created_at',date('Y-m-d h:i:sa'));
			$webroot->appendChild($date_created);
			//products
			$productsxml = $this->xml->createElement('products');
			$webroot->appendChild($productsxml);
			//loop product variations
			foreach($this->products as $product)
			{
				$variations = $this->getProductvariations($product);
				foreach($variations as $variation)
				{
					//CREATE ELEMENTS
					// < product >
					$productxml = $this->xml->createElement('product');
					// <id>
					$product_var_id = $this->xml->createElement('id', $this->getProductVarId($variation) );
					// <name>
					$product_name = $this->xml->createElement('name');
					//<size>
					$product_size =  $this->xml->createElement('size',$this->getVarProductSize($variation));
					//price
					$product_price = $this->xml->createElement('price',$this->getProductVarPrice($variation));
					//image
					$product_imageurl = $this->xml->createElement('image');
					
					//CREATE CDATA SECTIONS
					// <name>
					$product_name_cdata = $this->xml->createCDATAsection($this->getProductVarName($variation,$product));
					//<image>
					$product_imageurlcdata = $this->xml->createCDATAsection( $this->getVarProductImage($variation,$product));
					
					//APPEND ELEMENTS
					//product
					$productsxml->appendChild($productxml); 
					// <id>
					$productxml->appendChild($product_var_id);
					//<name>
					$product_name->appendChild($product_name_cdata);
					$productxml->appendChild($product_name);
					//size
					$productxml->appendChild($product_size);
					//price
					$productxml->appendChild($product_price);
					//<image>
					$product_imageurl->appendChild($product_imageurlcdata);
					$productxml->appendChild($product_imageurl);
			
				}
			}
			
		}
			//end loop products		
			//SAVE XML
			$this->xml->formatOutput = true;
			$this->saveXML();
		
		
	}


	public function saveXML(){
		if( !is_writable(plugin_dir_path(dirname(__FILE__)).'uploads') )
		{
			chmod(plugin_dir_path(dirname(__FILE__)).'uploads',0755);
		}
		$this->xml->save(plugin_dir_path(dirname(__FILE__)).'uploads/test.xml');
		$this->xml->saveXML();
	}
	
	
}


?>