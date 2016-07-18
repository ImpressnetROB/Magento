<style>imag{alignment-adjust:central;display: block;width: 210px;height: 210px;background: repeating-linear-gradient( -55deg, #FFFFFF, #FFFFFF 2px, #f9f9f9 2px, #f9f9f9 4px);}.imgs{float: left;max-width: 210px; width: 210px;height: 210px; max-height: 210px;margin: 10px; padding: 10px;display: inline-table; list-style: none;border-radius: 4px;	border: 1px solid #bbb;	background-color: #eeeeee;	} #attrs {float: left;width: 250px; height: 100%;border-right:1px solid #999;}#prods {font-family:Verdana; font-size:12px;font-weight: bold; color: $888888;float: left; max-width: 1000px;}.titles {display: block;height: 35px;}.featureds {	position: inherited;top:0px;left: 0px;z-index: 100;}.pages {width: 1000px;}</style>

<?php
class Amber_Demo_Model_Featured extends Mage_Catalog_Model_Abstract {
	//Featured products
	public function showFeatured($id)
	{
		$category = Mage::getModel('catalog/category')->load($id);
		$cat_name = $category->getName();
		$collection = Mage::getResourceModel('catalog/product_collection')->addAttributeToSelect(array('name', 'description', 'image', 'price', 'category',))->addCategoryFilter($category);
			$cat_name = $category->getName();
	$cat_idd = $category->getId();
	$prod = '<div>';
	foreach ($collection as $item) {
		$feat = $item->getFeatured();
		$image = $item->getImage();
		$image_url = Mage::getUrl('media/catalog/product'). $image;
		$url = $item->getProductUrl();
		if ($cat_idd && $feat ==false){
			$prod .= "<style>.imga{alignment-adjust:central;display: block;width: 210px;height: 210px;background: repeating-linear-gradient( -55deg, #FFFFFF, #FFFFFF 2px, #f9f9f9 2px, #f9f9f9 4px);}.imgs{float: left;max-width: 210px; width: 210px;height: 210px; max-height: 210px;margin: 10px; padding: 10px;display: inline-table; list-style: none;border-radius: 4px;	border: 1px solid #bbb;	background-color: #eeeeee;	} #attrs {float: left;width: 250px; height: 100%;border-right:1px solid #999;}#prod {font-family:Verdana; font-size:12px;font-weight: bold; color: $888888;float: left; max-width: 1000px;}.titles {display: block;height: 35px;}.featured {position: inherited;top:0px;left: 0px;z-index: 100;}.papagena {width: 1000px;}.price{font-family:Verdana; font-size:14px;font-weight: bold;color:rgba(0,200,100,0.8);float: right;}</style>";
			$prod .= "<a href='{$url}'>";
			$prod .= "<div class='title'>".$item->getName()."</div>";
			$prod .= "<div class='img'><img class='imga' src='{$image_url}'></div>";
			$prod .= "<div class='price'>Price:" . number_format($item->getPrice(),2)."</div>";
			$prod .= "</a>";
			$a = $a + 1;
			if ($a == 1){
				break;}
		}else{
			//echo "<br/>Currently We have no Products in this category ",$cat_name,'<br/>';
		}
		
    }
	$prod .= "</div>";
	return $prod;
}
}
?>