<?php
class Hs_Simplebanner_Block_Simplebanner extends Mage_Core_Block_Template
{
	public function _prepareLayout()
	{
		return parent::_prepareLayout();
	}
	
	 public function getSimplebanner()     
	 { 
		if (!$this->hasData('simplebanner')) {
			$this->setData('simplebanner', Mage::registry('simplebanner'));
		}
		return $this->getData('simplebanner');
		
	}
	
	public function getCollection()     
	{
		$_collection = Mage::getModel('simplebanner/simplebanner')->getCollection()->addFieldToFilter('status',1);
		return $_collection;
	}
}
   
