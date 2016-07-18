<?php

/*

 * @category	EDPA

 * @package		EDPA_Browse_Block

 * @author		ISP

 * @date        17-09-2015

 * @last edit   16-12-2015

 * @copyright	Copyright 2015 EDPA

 */

class Amber_Boxes_Block_Content extends Mage_Core_Block_Template{
	protected function getBrands(){
		
		return Mage::getModel('boxes/boxes')->getBrands();
		
		}

	protected function getProducts($manufacturer_id){
		
		return Mage::getModel('boxes/boxes')->getProducts($manufacturer_id);
		
		}

	/*protected function getCategories(){
		
		return Mage::getModel('boxes/boxes')->getName()->getChildren();
		
		}*/
}
?>