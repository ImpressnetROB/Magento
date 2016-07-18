<?php

class Hs_Simplebanner_Block_Adminhtml_Simplebanner_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
	{
		$id =  $row->getData($this->getColumn()->getIndex());
		$model = Mage::getModel('simplebanner/simplebanner')->load($id);	
		$img = explode('/',$model->getImage());			
		$imageName = $img[1];
		$imagePath = $img[0];
		$image = Mage::helper('simplebanner')->resizeImage($imageName, 50, 50, $imagePath);	
		return '<img src="'.$image.'" alt="'.$model->getName().'" title="'.$model->getName().'" />';
	}
}
