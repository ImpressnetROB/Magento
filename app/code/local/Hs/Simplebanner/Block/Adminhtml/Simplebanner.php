<?php
class Hs_Simplebanner_Block_Adminhtml_Simplebanner extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
	$this->_controller = 'adminhtml_simplebanner';
	$this->_blockGroup = 'simplebanner';
	$this->_headerText = Mage::helper('simplebanner')->__('Banner Manager');
	$this->_addButtonLabel = Mage::helper('simplebanner')->__('Add Image');
	parent::__construct();
  }
}
