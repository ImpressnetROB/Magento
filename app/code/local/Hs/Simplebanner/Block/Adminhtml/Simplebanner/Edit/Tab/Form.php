<?php

class Hs_Simplebanner_Block_Adminhtml_Simplebanner_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
	  $form = new Varien_Data_Form();
	  $this->setForm($form);
	  $fieldset = $form->addFieldset('simplebanner_form', array('legend'=>Mage::helper('simplebanner')->__('Image information')));
	 
	  $fieldset->addField('title', 'text', array(
		  'label'     => Mage::helper('simplebanner')->__('Title'),
		  'class'     => 'required-entry',
		  'required'  => true,
		  'name'      => 'title',
	  ));

	  $fieldset->addField('image', 'image', array(
		  'label'     => Mage::helper('simplebanner')->__('Image'),
		  'required'  => true,
		  'name'      => 'image',
	  ));
		
	  $fieldset->addField('status', 'select', array(
		  'label'     => Mage::helper('simplebanner')->__('Status'),
		  'name'      => 'status',
		  'values'    => array(
			  array(
				  'value'     => 1,
				  'label'     => Mage::helper('simplebanner')->__('Enabled'),
			  ),

			  array(
				  'value'     => 2,
				  'label'     => Mage::helper('simplebanner')->__('Disabled'),
			  ),
		  ),
	  ));
	 
	  if ( Mage::getSingleton('adminhtml/session')->getSimplebannerData() )
	  {
		  $form->setValues(Mage::getSingleton('adminhtml/session')->getSimplebannerData());
		  Mage::getSingleton('adminhtml/session')->setSimplebannerData(null);
	  } elseif ( Mage::registry('simplebanner_data') ) {
		  $form->setValues(Mage::registry('simplebanner_data')->getData());
	  }
	  return parent::_prepareForm();
  }
}
