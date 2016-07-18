<?php

class Hs_Simplebanner_Block_Adminhtml_Simplebanner_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
	  parent::__construct();
	  $this->setId('simplebanner_tabs');
	  $this->setDestElementId('edit_form');
	  $this->setTitle(Mage::helper('simplebanner')->__('Image Information'));
  }

  protected function _beforeToHtml()
  {
	  $this->addTab('form_section', array(
		  'label'     => Mage::helper('simplebanner')->__('Image Information'),
		  'title'     => Mage::helper('simplebanner')->__('Image Information'),
		  'content'   => $this->getLayout()->createBlock('simplebanner/adminhtml_simplebanner_edit_tab_form')->toHtml(),
	  ));
	 
	  return parent::_beforeToHtml();
  }
}
