<?php

class Amber_Checkbox_Block_Welcome extends Mage_Core_Block_Template
{
	public function _construct()
	{
		parent::_construct();
		$this->setTemplate('checkbox/welcome.phtml');
	}
}
?>