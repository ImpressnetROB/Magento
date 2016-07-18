<?php
/*

 * @category	AMBeR

 * @package		AMBeR_Checkbox

 * @author		AMBR

 * @date        12-07-2016

 * @last edit   12-07-2016

 * @copyright	Copyright 2016 AMBeR

 */
class Amber_Checkbox_Adminhtml_PromotedController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{

		$this->loadLayout();
		$favourites = "Favourite brands";
		$attribute = Mage::getModel('eav/entity_attribute')
			->loadByCode('catalog_product', 'manufacturer');

		$valuesCollection = Mage::getResourceModel('eav/entity_attribute_option_collection')
			->setAttributeFilter($attribute->getData('attribute_id'))
			->setStoreFilter(0, false);

		$style = "<style>.inline{display: flex;width: 200px; float: left;font-family: Verdana; font-size: 16px;}.name{background-color: rgba(120,150,120,0.3); border-top-left-radius: 5px;border-bottom-left-radius: 5px;padding:10px;border: 1px solid rgba(100,120,100,0.5); width: 100px;}.sub{ border-top-right-radius: 5px;border-bottom-right-radius: 5px;text-align: center;padding:10px;border: 1px solid rgba(100,120,100,0.5);width: 20px; }</style>";

		$preparedManufacturers = array();
		foreach($valuesCollection as $value) {
			$preparedManufacturers[$value->getOptionId()] = $value->getValue();
		   	
			if (count($preparedManufacturers)) {
				$brandbox =  $style."<h2>Promoted</h2><div class='bobo'>";
				foreach($preparedManufacturers as $optionId => $value) {
					$brandbox .= "<div class='inline'><div class='name'>" . $value . "</div><div class='sub caret'>". $optionId."</div></div>";
				}
					$brandbox .="</div>";
			}
		}
		$this->_addLeft($this->getLayout()->createBlock('core/text')->setText($favourites));

		$this->_addContent($this->getLayout()->createBlock('core/text')->setText($brandbox));
		
		$this->renderLayout();
	}
}
?>