<?php
class Amber_Boxes_Model_Categories extends Mage_Core_Model_Abstract {
	
	private function getCategories(){
		
		echo "Categories";
		
		var_dump(Mage::getModel('catalog/categories')->getName()->getChildren);
		
		}
	
	}
?>