<?php

/*

 * @category	AMBeR

 * @package		AMBeR_Checkbox

 * @author		AMBR

 * @date        12-07-2016

 * @last edit   12-07-2016

 * @copyright	Copyright 2016 AMBeR

 */

class Amber_Checkbox_Adminhtml_EventController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{
		$this->loadLayout();
		
		$this->addContent(
		
			$this->getLayout()->createBlock('checkbox/adminhtml_event_edit')
			);
			
		return $this->renderLayout();
	}
	
	public function saveAction()
	{
		$eventId = $this->getRequest()->getParam('event_id');
		$eventModel = Mage::getModel('checkbox/event')->load($eventId);
		
		if ($data = $this->getRequest()->getPost){
			try{
				$eventModel->addData($data)->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(
				$this->__("Event saved!")
				);
				
			} catch(Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
		}
		$this->_redirect('*/*/index');
	}
}
?>