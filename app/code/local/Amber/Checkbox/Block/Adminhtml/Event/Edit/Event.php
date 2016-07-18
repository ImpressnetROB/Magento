<?php

class Amber_Checkbox_Block_Adminhtml_Event extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function _construct()
	{
		$this->_blockGroup = 'checkbox';
		$this->_controller = 'adminhtml_event';
		$this->_headerText = Mage::helper('checkbox')->_('Events');
		$this->_addButtonLabel = Mage::helper('checkbox')->_('Add new event');
		parent::_construct();
		
	}
}