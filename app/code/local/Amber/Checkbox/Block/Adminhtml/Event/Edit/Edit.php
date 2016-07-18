<?php
/*

 * @category	AMBeR

 * @package		AMBeR_Checkbox

 * @author		AMBR

 * @date        12-07-2016

 * @last edit   12-07-2016

 * @copyright	Copyright 2016 AMBeR

 */
class Amber_Checkbox_Block_Adminhtml_Event_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public function __construct()
	{
		$this->_objectId = 'event_id';
		$this->_blockGroup = 'checkbox';
		$this->_controller = 'adminhtml_event';
		
		parent::__construct();
	}

	public function getHeaderText()
	{
		return Mage::helper('checkbox')->__('New event');
	}
	public function getSaveUrl()
	{
		return $this->getUrl('*/event/save');
	}
}
?>