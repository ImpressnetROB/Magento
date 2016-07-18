<?php
/*

 * @category	AMBeR

 * @package		AMBeR_Checkbox

 * @author		AMBR

 * @date        12-07-2016

 * @last edit   12-07-2016

 * @copyright	Copyright 2016 AMBeR

 */
class Amber_Checkbox_Model_Resource_Event extends Mage_Core_Model_Resource_Db_Abstract
{
	public function _construct()
	{
		$this->_init('checkbox/event', 'event_id');
	}
}
?>