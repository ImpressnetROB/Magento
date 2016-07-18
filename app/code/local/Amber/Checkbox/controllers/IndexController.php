<?php
class Amber_Checkbox_IndexController extends Mage_Core_Controller_Front_Action
{
	
	public function indexAction()
	{
		$this->loadLayout();
		
		echo "Index controller => checkbox app/code/local/amber/checkbox/controllers/";
		
		return $this->renderLayout();
	}
}
?>