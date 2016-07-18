<?php
/*
 * @category	EDPA
 * @package		EDPA_Browse
 * @author		EDPA
 * @date        27-09-2015
 * @last edit   28-09-2015
 * @copyright	Copyright 2015 EDPA
 */


class EDPA_MegaNavigation_Block_Navigation extends Infortis_UltraMegamenu_Block_Navigation{


	//*********************************
	//PRIVATE VARIABLES
	//*********************************
	private $exception = array('Highchairs');

	//*********************************
	//CONSTRUCTOR
	//*********************************
	public function __construct(){}

	//*********************************
	//PUBLIC FUNCTIONS
	//*********************************

	// MegaNavigation starts rendering navigation from this render function and called 2x from
	// app\design\frontend\ultimo\default\template\infortis\ultramegamenu\mainmenu.php
	//
	// Original functions and code blocks deleted and replaced with custom navigation generator
	//
	// original function
	// @renderCategoriesMenuHtml($x3e = FALSE, $x12 = 0, $x16 = '', $x17 = '')
	// $x3e = is_mobile?
	//
	public function renderCategoriesMenuHtml($x3e = FALSE, $x12 = 0, $x16 = '', $x17 = '')
	{

		//Init
		$category_level_0 = $this->getStoreCategories();

		$browse = 'browse';
		$base_url = Mage::getBaseUrl().$browse.'/'; //custom url navigate to custom page filter
		//$base_url = Mage::getBaseUrl(); //original base url
		$urlfunction = 'getUrlKey'; //url key without .html at the end
		//$urlfunction = 'getRequestPath'; //url path with .html at the end

		if($x3e){
			$rendered_navigation = $this->renderMobileNavigation($category_level_0,$base_url,$urlfunction);

		}else{
			$rendered_navigation = $this->renderFullNavigation($category_level_0,$base_url,$urlfunction);

		}


		return $rendered_navigation;
	}

	//*********************************
	//PRIVATE FUNCTIONS
	//*********************************

	// Render mobile navigation HTML
	// @$category_level_0
	// @$base_url
	// @$urlfunction
	private function renderMobileNavigation($category_level_0,$base_url,$urlfunction){


		$level_0_counter = 1;
		$pos = 1;
		$output = '';
		foreach($category_level_0 as $index_level_0 => $data_level_0) {
			//("NAV NAME: ",$data_level_0->getName());
			$level_0_name = $this->getNavigationName($data_level_0->getName());
			$level_0_url = $base_url . $data_level_0->$urlfunction();


			if ($level_0_counter == 1) {
				$position = "first";
			} else if ($level_0_counter == count($category_level_0->getNodes())) {
				$position = "last";
			} else {
				$position = "";
			}

			$class = " class='level0 nav-{$level_0_counter} level-top {$position}'";

			if($level_0_name == 'Brands'){
				$output .= "<li {$class}>";
				$output .= "<a href='" . Mage::getBaseUrl().$data_level_0->getRequestPath(). "' class='level-top '><span>{$level_0_name}</span>{$caret}</a>";

			}elseif($level_0_name == 'Sale'){
				$output .= "<li {$class}>";
				$output .= "<a href='" . Mage::getBaseUrl().$data_level_0->getRequestPath(). "' class='level-top '><span>{$level_0_name}</span>{$caret}</a>";

			}else {
				
				$output .= "<li {$class}>";
				$output .= "<a href='" . $level_0_url . "' class='level-top '><span>{$level_0_name}</span></a>";
				$output .= "</li>";
			}
			$level_0_counter++;
			$pos++;
		}


		return $output;

	}

	// Render mobile navigation HTML
	// @$category_level_0
	// @$base_url
	// @$urlfunction
	private function renderFullNavigation($category_level_0,$base_url,$urlfunction){

		$exploded = Mage::helper('browse/url')->getExplodedUrl();
		$level_0_counter = 1 + count($category_level_0->getNodes());
		$level_1_counter = $level_0_counter;
		$level_2_counter = $level_0_counter;
		$output = '';
		// Navigation Level 0

		foreach($category_level_0 as $index_level_0 => $data_level_0){

			$level_0_name = $this->getNavigationName($data_level_0->getName());
			$level_0_url = $base_url.$data_level_0->$urlfunction();
			$level_0_url_key = $data_level_0->$urlfunction();
			$level_0_has_children = $data_level_0->hasChildren();
			$level_0_request_key = $data_level_0->$urlfunction();
			
			$category_level_1 = $data_level_0->getChildren();

			if($level_0_counter == 1){
				$position = "first";
			}else if($level_0_counter == count($category_level_0->getNodes())){
				$position = "last";
			}else{
				$position = "";
			}

			if($level_0_has_children){
				$active = '';
				if(isset($exploded['browse'])){
					if(in_array($level_0_request_key,$exploded['browse'])){
						$active = "active";
					}
				}
				
				$class= " class='level0 nav-{$level_0_counter} level-top {$position} {$active} parent'";
				$caret = "</span><span class='caret'> </span>";

			}else{
				$class= " class='level0 nav-{$level_0_counter} level-top {$position} {$level_0_url_key}'";
				$caret = '';
			}

			if($level_0_name == 'Brands'){
				$output .= "<li class='level0 nav-{$level_0_counter} level-top {$position} {$active} parent'>";
				$output .= "<a href='" . Mage::getBaseUrl().$data_level_0->getRequestPath(). "' class='level-top'><span>{$level_0_name}</span></span><span class='caret'> </span></a>";
				$subcategories = Mage::getModel('catalog/category')
										->load($data_level_0->getId())
										->getChildren();
				$cat_ids = explode(',', $subcategories);
				$exception = array(232,236,237,238,239,240,241,245,250, 253);
				$output .= "<ul class='level0 brands-ul'>";
					foreach($cat_ids as $id) {
						if (in_array($id, $exception)) {
							$brand = Mage::getModel('catalog/category')->load($id);
							$image = Mage::getUrl("media/catalog/category/") . $brand->getThumbnail();
							$url = Mage::getUrl().$brand->getRequestPath();
							$output .= "<li class='brands-subnavigation'>";
							$output .= "<a href='{$url}'><img src='{$image}'></a>";
							$output .= "</li>";
						}
					}
					
				$output .= "<li style='' class='see-all-brands'><a href='".Mage::getBaseUrl().$data_level_0->getRequestPath()."'>See All</a></li>";
				//$output .= "<a href='{$url}'><img src='{$image}'></a>";
				$output .= "</ul>";

			}elseif($level_0_name == 'Sale'){
				$output .= "<li {$class}>";
				$output .= "<a href='" . Mage::getBaseUrl().$data_level_0->getRequestPath(). "' class='level-top '><span>{$level_0_name}</span>{$caret}</a>";

			}else {

				$output .= "<li {$class} >";
				$output .= "<a href='" . $level_0_url . "' class='level-top '><span>{$level_0_name}</span>{$caret}</a>";
			$data_level_0->getId();
			
			$show = Mage::getModel('demo/promo')->showPromo($data_level_0->getId());
			var_dump($show);
			}
			// Navigation Level 1
			if($level_0_has_children){
				$output .= "<ul class='level0'>";
				foreach($category_level_1 as $index_level_1 => $data_level_1){
					$level_1_name = $data_level_1->getName();
					$level_1_url = $base_url.$level_0_url_key."/".$data_level_1->$urlfunction();
					$level_1_url_key = $data_level_1->$urlfunction();
					$level_2_has_children = $data_level_1->hasChildren();
					if($level_1_counter == 1){
						$position = "first";
					}else if($level_1_counter == count($category_level_1->getNodes())){
						$position = "last";
					}else{
						$position = "";
					}

					if($level_2_has_children){
						$class= " class='level1 nav-{$level_1_counter} level-top {$position} parent'";
						$caret = '';
					}else{
						$class= " class='level1 nav-{$level_1_counter} level-top {$position}'";
						$caret = '';
					}


					if(in_array($level_1_name, $this->exception)){
						$output .= "<li {$class}>";
						$output .= "<a href='" . Mage::getUrl().$data_level_1->getRequestPath(). "' class='level-top '><span>{$level_1_name}</span>{$caret}</a>";

					}else {

						$output .= "<li {$class}>";
						$output .= "<a href='" . $level_1_url . "' class='level-top '><span>{$level_1_name}</span>{$caret}</a>";
					}

					$category_level_2 = $data_level_1->getChildren();

					// Navigation Level 2
					if($level_2_has_children){
						$output .= "<ul class='level1'>";

						foreach($category_level_2  as $index_level_2 => $data_level_2){
							$level_2_name = $data_level_2->getName();
							$level_2_url = $base_url.$level_0_url_key."/".$level_1_url_key."/".$data_level_2->$urlfunction();

							if($level_1_counter == 1){
								$position = "first";
							}else if($level_1_counter == count($category_level_1->getNodes())){
								$position = "last";
							}else{
								$position = "";
							}


							$output .= "<li class='level2 nav-{$level_0_counter}-{$level_1_counter}-{$level_2_counter} {$position}'>";
							$output .= "<a href='".$level_2_url."' class=''><span>{$level_2_name}</span></a>";
							$output .= "</li>";//end Level 2 Nav Item



							$level_2_counter++;
						}
						$output .= "</ul>";//end Level 1
					}
					$level_1_counter++;
					$output .= "</li>";//end Level 1 Nav Item
				}
				/*$test = Mage::getModel('edpacatalog/product_randomimage')->getCategoryID();
				//var_dump($test);
				$output .= $test;
				$output .= "<li>Category image<a href='#'><img style=' position: absolute; top: -120px;right: -180px;float: right;' src='http://edpa-dev.site/istvan/bsr/media/catalog/category/arc.gif'></a></li>";
			*/	$output .= "</ul>";//end Level 1
			}
			$level_0_counter++;
		}
		$output .= "</li>";//end Level 0 Nav Item
		


		return $output;
	}
	
	private function getNavigationName($nav_name){

                switch ($nav_name) {
                    case 'Feeding & Highchairs':
                        $display = 'Feeding';
                        break;
                    case 'Safety Gates & Fireguards':
                        $display = 'Safety Gates';
                        break;
                    case 'Baby Monitors':
                        $display = 'Monitors';
                        break;
                    case 'Baby-Toddler Home Safety':
                        $display = 'Home Safety';
                        break;
                    case 'Baby-Toddler Travel':
                        $display = 'Travel';
                        break;
                    case 'Pushchairs & Strollers':
                        $display = 'Strollers';
                        break;
					case 'New Year Sale':
						$display = 'Sale';
						break;
                    case 'Changing & Hygiene':
                        $display = 'Health';
                        break;
                    case 'Play Time Toys & Gifts':
                        $display = 'Toys & Gifts';
                        break;
                    case 'Nursery & Furniture':
                        $display = 'Nursery';
                        break;
                    default:
                        return $nav_name;
                }
                return $display;
            }
			
}

