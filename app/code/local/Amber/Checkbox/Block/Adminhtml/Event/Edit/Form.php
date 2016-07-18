<?php
/*

 * @category	AMBeR

 * @package		AMBeR_Checkbox

 * @author		AMBR

 * @date        12-07-2016

 * @last edit   12-07-2016

 * @copyright	Copyright 2016 AMBeR

 */
class Amber_Checkbox_Block_Adminhtml_Event_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form(
			array('id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post'
			)
		);
		
		$fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('checkbox'->__('General information'), 'class' => 'fieldset-wide'));
		
		$fieldset->addField('name', 'text', array(
			'name'	=>	'name',
			'label'	=>	Mage::helper('checkbox')->__('Event name'),
			'title'	=>	Mage::helper('checkbox')->__('Event name'),
			'required'	=>	true
		));
		$dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);
		$fieldset->addField('start', 'date', array(
			'name'	=>	'start',
			'format'	=>	$dateFormatIso,
			'image'	=>	$this->getSkinUrl('images/grid-cal.gif'),
			'label'	=>	Mage::helper('checkbox')->__('Start date'),
			'title'	=>	Mage::helper('checkbox')->__('Start date'),
			'required'	=>	true
		));
		$fieldset->addField('end', 'date', array(
			'name'	=>	'end',
			'format'	=>	$dateFormatIso,
			'image'	=>	$this->getSkinUrl('images/grid-cal.gif'),
			'label'	=>	Mage::helper('checkbox')->__('End date'),
			'title'	=>	Mage::helper('checkbox')->__('End date'),
			'required'	=>	true
		));
		$form->setUseContainer(true);
		$this->setForm($form);
		
		return parent::_prepareForm();
	}
}
?>