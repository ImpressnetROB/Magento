<?php

/*

 * @category	AMBeR

 * @package		AMBeR_Checkbox

 * @author		AMBR

 * @date        12-07-2016

 * @last edit   12-07-2016

 * @copyright	Copyright 2016 AMBeR

 */

class Amber_Checkbox_Adminhtml_CheckboxController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{
		
		$event = Mage::getModel('checkbox/event');
		
		$event->setName('Test event')->save();
		
		Mage::getSingleton('adminhtml/session')->addSuccess(
		
			'Event saved. ID = '.$event->getId()
		
		);
		
		$this->loadLayout();
		
		return $this->renderLayout();
		
	}
}
?>