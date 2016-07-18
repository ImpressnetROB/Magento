<?php

class Hs_Simplebanner_Helper_Data extends Mage_Core_Helper_Abstract
{
	/**
	* $imageName    name of the image file
	* $width        resize width
	* $height       resize height
	* $imagePath    the path where the image is saved.    (must be inside ‘media’ directory)
	* return        full url path of the image
	*/
	 
	public function resizeImage($imageName, $width=NULL, $height=NULL, $imagePath=NULL)
	{
		$imagePath = str_replace("/", DS, $imagePath);
		$imagePathFull = Mage::getBaseDir('media') . DS . $imagePath . DS . $imageName;
		 
		if($width == NULL && $height == NULL) {
			$width = 100;
			$height = 100;
		}
		$resizePath = $width . 'x' . $height;
		$resizePathFull = Mage::getBaseDir('media') . DS . $imagePath . DS . $resizePath . DS . $imageName;
		 
		if (file_exists($imagePathFull) && !file_exists($resizePathFull)) {
			$imageObj = new Varien_Image($imagePathFull);
			$imageObj->keepAspectRatio(TRUE);
			$imageObj->keepFrame(TRUE);
			$imageObj->keepTransparency(TRUE);
			$imageObj->constrainOnly(TRUE);
			$imageObj->backgroundColor(array(255, 255, 255));
			$imageObj->quality(90);
			$imageObj->resize($width,$height);
			$imageObj->save($resizePathFull);
		}
		 
		$imagePath=str_replace(DS, "/", $imagePath);
		return Mage::getBaseUrl("media") . $imagePath . "/" . $resizePath . "/" . $imageName;
	}
}
