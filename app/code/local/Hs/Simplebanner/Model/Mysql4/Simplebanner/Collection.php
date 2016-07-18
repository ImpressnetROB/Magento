<?php

class Hs_Simplebanner_Model_Mysql4_Simplebanner_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	public function _construct()
	{
		parent::_construct();
		$this->_init('simplebanner/simplebanner');
	}
}
