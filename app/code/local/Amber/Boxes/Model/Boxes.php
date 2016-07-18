<?php

/*

 * @category	EDPA

 * @package		EDPA_Browse

 * @author		ISP

 * @date        17-09-2015

 * @last edit   30-09-2015

 * @copyright	Copyright 2015 EDPA

 */

class Amber_Boxes_Model_Boxes extends Mage_Core_Model_Abstract {

	private $connection;
	//connecting to the database
	public function __construct(){
		$this-> connection = Mage::getSingleton('core/resource')->getConnection('core_read');
		}
	
	public function getPre($arr, $var = false){
		echo '<pre>';
		if ($var) {
			//var_dump($arr);
		} else {
			$arr = explode(',',$arr);
			var_dump($arr);
			print_r($arr);
			
		}
			echo '</pre>';
	}

	//getting brands from database 'edpa_product_collection'
	public function getBrands()
	{
		//returning brands to the content.phtml and create selection
		$brands = $this->connection->fetchAll('SELECT `manufacturer_id`, `manufacturer_name` FROM `edpa_product_collection` GROUP BY manufacturer_name');
		return $brands;
	}
		// returning product data to content based on brand selection 
	public function getProducts($manufacturer_id){
		$products = $this->connection->fetchAll("SELECT * FROM `edpa_product_collection` WHERE `manufacturer_id` = '{$manufacturer_id}'");
            $content ="<div class='ldiv'>";
			
		//create product boxes in content
		foreach($products as $product){
			$image = Mage::getModel('edpacatalog/product_image')->getImage($product['image']);
			$url = Mage::getUrl().$product['url_path'];
			//*****************************
			// PRODUCT BOX CONTENT
			//*****************************	
			$content .= "<div id='{$product['sku']}' value='{$product['sku']}' selected='false' class='pbox'>";
			$content .= "<input class='selector' type='button' value='' onclick='return change(this);' />";
			$content .= "<div id='ptitle' class='ptitle'>" . $product['name']."</div>";
            $content .= "<div><a href='{$url}'><img src='{$image}'/></a></div>";
            $content .= "<div>". number_format($product['price'],2)."</div>";
            $content .= "<div id='sku'>". $product['sku']."</div>";
            $content .= "</div>";
			}
			$content .= "</div>";
			$content .= "<div class='rdiv'><div class='section-title pbanner'>Compared Products</div>";
			$content .= "<div class='pban' id='update'>Compared Products</div>";
			$content .= "</div>";
		//returning data to content.phtml
		return $content;
		}
	
}

?>