<?php
/*

 * @category	AMBeR

 * @package		AMBeR_Checkbox

 * @author		AMBR

 * @date        12-07-2016

 * @last edit   12-07-2016

 * @copyright	Copyright 2016 AMBeR

 */

class Amber_Checkbox_Adminhtml_FutureController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{

		$this->loadLayout();
		$style = "<style>.inline:hover{box-shadow: #888888 3px 3px 3px;}.inline{display: flex; border-radius:5px;margin-bottom: 5px;margin-right: 5px;width: 170px; float: left;font-family: Verdana; font-size: 16px;}.name{position: relative;text-align: center;border-top-left-radius: 5px;border-bottom-left-radius: 5px;padding:10px;border: 1px solid rgba(100,120,100,0.5); height: 110px;width: 110px;}.sub{ border-top-right-radius: 5px;border-bottom-right-radius: 5px;text-align: center;padding:10px;border: 1px solid rgba(100,120,100,0.5);width: 20px; }.pic{z-index:2;width:100px;height:auto;}</style>";
		$brandbox =  $style."<h2>Other brands</h2><div class='bobo'>";		
		$favourite = $style."<h2>Favourites</h2><div class='bobo'>";
		$attribute = Mage::getModel('eav/entity_attribute')
			->loadByCode('catalog_product', 'manufacturer');

		$collection = Mage::getResourceModel('eav/entity_attribute_option_collection')
			->setAttributeFilter($attribute->getData('attribute_id'))
			->setStoreFilter(0, false);
		$a = 0;

		foreach($collection as $value) {
			//var_dump($value);die();
			$brand = Mage::getModel('catalog/product')->load($value['option_id']);
var_dump($brand);
			$image = "../../../../../../media/catalog/category/". $brand->getManufacturer();
			$url = Mage::getUrl().$brand->getRequestPath();
			
			if($value['show_brand']==1){
				$favourite .= "<a href='".$url."'><div class='inline'><div class='name'>" . $value['value'] . "<img class='pic' src='".$image."'/>'".$value['option_id']."'</div><div class='sub caret'></div></div></a>";
			}else{
				$brandbox .= "<a href='".$url."'><div class='inline'><div class='name'>" .$value['value']. "<img class='pic' src='".$image."'/>'".$value['option_id']."'</div><div class='sub caret'></div></div></a>";
					}	
					
					$a++;
					if($a==30){
						break;
					}
			
		}
		$brandbox .="</div>";
		$favourite .="</div>";
		
		$this->_addLeft($this->getLayout()->createBlock('core/text')->setText($favourite));

		$this->_addContent($this->getLayout()->createBlock('core/text')->setText($brandbox));
		
		$this->renderLayout();		
	}
}
?>