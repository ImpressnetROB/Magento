<?php

class Amber_Checkbox_Model_Observer
{
	public function controllerActionPredispatch($observer)
	{
		$controllerAction = $observer->getEvent()->getControllerAction();
		
		Mage::log($controllerAction->getRequest()->getParams());
	}
}
?>