<?php

class Hs_Simplebanner_Model_Mysql4_Simplebanner extends Mage_Core_Model_Mysql4_Abstract
{
	public function _construct()
	{    
		// Note that the simplebanner_id refers to the key field in your database table.
		$this->_init('simplebanner/simplebanner', 'simplebanner_id');
	}
}
