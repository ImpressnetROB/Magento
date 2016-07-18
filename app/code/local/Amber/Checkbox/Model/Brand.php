<?php

/*

 * @category	AMBeR

 * @package		AMBeR_Checkbox

 * @author		AMBR

 * @date        12-07-2016

 * @last edit   12-07-2016

 * @copyright	Copyright 2016 AMBeR

 */

class Amber_Checkbox_Model_Brand extends Mage_Core_Model_Abstract
{
		private $connection;
	
	public function __construct(){
		$this-> connection = Mage::getSingleton('core/resource')->getConnection('core_read');
		}

	public function getBrand()
	{
		//returning brands
		$brand = $this->connection->fetchAll('SELECT `manufacturer_id`, `manufacturer_name` FROM `edpa_product_collection` GROUP BY manufacturer_name');
		return $brand;
	}
	
}
?>