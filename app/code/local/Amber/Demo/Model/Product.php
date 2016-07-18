<?php 

class Amber_Demo_Model_Product{

	public function getProduct() {
		echo "Product calling:<br/>";
		$root = Mage::getModel('catalog/category')->load(1); 
		foreach ($root->getChildren() as $subCat) {
			$collection = Mage::getModel('catalog/product')->getCollection()->load(3);
			->joinField('category_id', 'catalog/category_product', 'category_id', 'product_id = entity_id', null, 'left')
			->addAttributeToSelect('*')->addAttributeToFilter('category_id', array('in' => $categoryIds));
			
			foreach($collection as $catname){
				echo $catname->getName();
				echo "All Products";
			} 
		}
	}
}

?>