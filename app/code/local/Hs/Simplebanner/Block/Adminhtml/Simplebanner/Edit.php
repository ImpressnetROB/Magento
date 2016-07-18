<?php

class Hs_Simplebanner_Block_Adminhtml_Simplebanner_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public function __construct()
	{
		parent::__construct();
				 
		$this->_objectId = 'id';
		$this->_blockGroup = 'simplebanner';
		$this->_controller = 'adminhtml_simplebanner';
		
		$this->_updateButton('save', 'label', Mage::helper('simplebanner')->__('Save Image'));
		$this->_updateButton('delete', 'label', Mage::helper('simplebanner')->__('Delete Image'));
		
		$this->_addButton('saveandcontinue', array(
			'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
			'onclick'   => 'saveAndContinueEdit()',
			'class'     => 'save',
		), -100);

		$this->_formScripts[] = "
			function toggleEditor() {
				if (tinyMCE.getInstanceById('simplebanner_content') == null) {
					tinyMCE.execCommand('mceAddControl', false, 'simplebanner_content');
				} else {
					tinyMCE.execCommand('mceRemoveControl', false, 'simplebanner_content');
				}
			}

			function saveAndContinueEdit(){
				editForm.submit($('edit_form').action+'back/edit/');
			}
		";
	}

	public function getHeaderText()
	{
		if( Mage::registry('simplebanner_data') && Mage::registry('simplebanner_data')->getId() ) {
			return Mage::helper('simplebanner')->__("Edit Image '%s'", $this->htmlEscape(Mage::registry('simplebanner_data')->getTitle()));
		} else {
			return Mage::helper('simplebanner')->__('Add Image');
		}
	}
}
