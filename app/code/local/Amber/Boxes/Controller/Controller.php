<?php

/*
 * @category	EDPA
 * @package		EDPA_Browse_Router
 * @author		EDPA
 * @date        17-09-2015
 * @last edit   23-10-2015
 * @copyright	Copyright 2015 EDPA
 */

class Amber_Boxes_Controller_Router extends Mage_Core_Controller_Varien_Router_Abstract{

    public function initControllerRouters($observer){

        $front = $observer->getEvent()->getFront();
        $front->addRouter('amber',$this);

        return $this;

    }

    public function match(Zend_Controller_Request_Http $request){

        if(!Mage::isInstalled()){
              Mage::app()->getFrontController()->getResponse()
                ->setRedirect(Mage::getUrl('install'))
                ->sendResponse();
            exit;
        }

        $pathInfo = trim($request->getPathInfo(),'/');
        $params = explode('/',$pathInfo);

                if(isset($params[0]) && $params[0] == 'amber'){

                   $request->setModuleName('amber')
                           ->setControllerName('index')
                           ->setActionName('index');
                   return true;
               }

        return false;

    }
}

?>