<?php
class MasteringMagento_Example_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		$this->loadLayout();
		return $this->renderLayout();
		echo "Hallo I'm changing Index";
	}
}