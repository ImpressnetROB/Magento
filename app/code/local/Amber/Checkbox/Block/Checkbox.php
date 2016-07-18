<?php

class Amber_Checkbox_Block_Checkbox extends Mage_Core_Block_Template
{
	public function _construct()
	{
		parent::_construct();
		
		$this->setTemplate('checkbox/checkbox.phtml');
	}
}
?>