<?php

/*

 * @category	EDPA

 * @package		EDPA_Browse

 * @author		ROA

 * @date        17-09-2015

 * @last edit   30-09-2015

 * @copyright	Copyright 2015 EDPA

 */

class Amber_Boxes_AjaxController extends Mage_Core_Controller_Front_Action {

	public function getProductsAction(){

		$brand_id = Mage::app()->getRequest()->getPost('brand_id', false);
		
		if($brand_id )
		{
			$products = Mage::getModel('boxes/boxes')->getProducts($brand_id);
				
			$this->getResponse()->setBody($products);	
		}
	}

//*****************************
// COMPARE ACTION
//*****************************	
	public function CompareAction(){
		$items =  Mage::app()->getRequest()->getPost('items', false);
		$this-> connection = Mage::getSingleton('core/resource')->getConnection('core_read');
		$items = explode(',',$items);
		//$res = Mage::getModel('boxes/boxes')->getPre($items);
		//print_r('Data: ',$res);
//*****************************
// COLLECTING PRODUCT DATA
//*****************************	
		$content = '<div class="return">';
		$tabela = '<table style="width: 320px;">';
		foreach($items as $it){
			$row = array();
			$sql = "SELECT * FROM `edpa_product_collection` WHERE `sku` = {$it} ";
			$row = ($this->connection->fetchAll($sql));
			$fulltab = array();
				foreach($row as $col){
					$fulltab[] = $col;
					var_dump($fulltab);
				/* $res = Mage::getModel('boxes/boxes')->getPre($col);
				
//*****************************
// BUILDING BOXES
//*****************************	
				$image = Mage::getModel('edpacatalog/product_image')->getImage($col['image']);
				$url = Mage::getUrl().$col['url_path'];
				$content .= "<a href='".$url."'>";
				$content .= "<div class='box'>";
				$tabela .= "<tr><td>".$col['name']."</td>";
				$content .= "<table>";
				$content .= "<div><img style='width:50px; height:50px;' src='".$image."'/></div>";
				$content .= "<tr><td>".$col['name']."</td></tr>";
				$content .= "<tr><td>".number_format($col['price'],2)."</td></tr>";
				$content .= "<tr><td>".$col['rating']."</td></tr>";
				$content .= "<tr><td>".$col['manufacturer_id']."</td></tr>";
				$content .= "<tr><td>".$col['sku']."</td></tr>";
				$content .= "<tr><td>".$col['sku']."</td></tr>";
				$content .= "<tr><td>".$col['sku']."</td></tr>";
				$content .= "<tr><td>".$col['id']."</td></tr>";
				$content .= "</table></div></a>";
				$a++; */
			}
		}
		//$content .= "</div>";
		
//*****************************
// BOX WIDTH DEFINITION
//*****************************
		$width = (410/$a-(3.5*$a));
//*****************************
// ADDING SOME STYLING
//*****************************
		$content .= '<style>.return {width: 410px;float: left;background-color: #eeeeee;border: 1px solid #aaaaaa;}
					table{font-family:Verdana;font-size:8px;color:#000000;}
					.box {margin: 1px; padding: 4px;max-width:'.$width.'px;width:'.$width.'px;height: auto;float: left;background-color: #eeeeee;border: 1px solid #aaaaaa;font-family:Verdana;font-size:9px;color:#000000;}
					tr:nth-child(even) {background: #CCC} tr:nth-child(odd) {background: #FFF}
					</style>';
					
//*****************************
// RETURNING DATA
//*****************************
		echo $content;
	}
}
?>