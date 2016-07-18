<?php

class Hs_Simplebanner_Model_Simplebanner extends Mage_Core_Model_Abstract
{
	public function _construct()
	{
		parent::_construct();
		$this->_init('simplebanner/simplebanner');
	}
}
