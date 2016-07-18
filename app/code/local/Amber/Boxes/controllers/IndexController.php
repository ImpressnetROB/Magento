<?php

/*

 * @category	EDPA

 * @package		EDPA_Browse

 * @author		ISP

 * @date        17-09-2015

 * @last edit   30-09-2015

 * @copyright	Copyright 2015 EDPA

 */

class Amber_Boxes_IndexController extends Mage_Core_Controller_Front_Action {

	public function indexAction(){
			
        $this->loadLayout();

        $this->renderLayout();

		}

	public function productAction(){

        $this->loadLayout();

        $this->renderLayout();

		}
	
	}
?>
