<?php
/*include('../app/Mage.php');
Mage::app();
$mage_php_url = '../app/Mage.php';
*/

class Amber_Demo_Model_Query extends Mage_Catalog_Model_Abstract {

	private $connection;
	private $title = "New Products";
	private $new_for = 30;
	private $limit = 10;

	public function __construct()
	{
		$resource = Mage::getSingleton('core/resource');
		$this->connection = $resource->getConnection('core_read');
	}

	public function getSpider($product_id, $category_ids){

		$title = "<h3>New Products</h3>";
		$query = array();
		$result = array();
		$return = "";

		$select 	= " SELECT * ";
		$from 		= " FROM `edpa_product_collection` AS epc ";
		$join		= " INNER JOIN catalog_category_product AS ccp
							ON ccp.product_id = epc.entity_id
							";

		if(!is_null($product_id)){
			$category = Mage::helper('edpacatalog/category')->getCategoryByProductId($product_id, false, true, false, null);
			$cat_id = $category['cat_id'];

			$where = " WHERE `ccp`.`category_id` = '{$cat_id}' AND `epc`.`created_at` >= (CURRENT_DATE - INTERVAL {$this->new_for} DAY) GROUP BY epc.sku";

			$query[] = $select;
			$query[] = $from;
			$query[] = $join;
			$query[] = $where;

			$sql = implode($query);
			$result = $this->connection->fetchAll($sql);

			if(count($result) < $this->limit){

				$where = " WHERE `ccp`.`category_id` = '{$cat_id}' GROUP BY epc.sku ORDER BY  `epc`.`created_at` DESC LIMIT {$this->limit} ";
				$query = array();

				$query[] = $select;
				$query[] = $from;
				$query[] = $join;
				$query[] = $where;

				$sql = implode($query);
				$result = $this->connection->fetchAll($sql);
			}
			$return = $this->productView($result);
		}elseif(!empty($category_ids)){
			$ids = implode("', '",$category_ids);
			$where = " WHERE `ccp`.`category_id` IN ('{$ids}') AND `epc`.`created_at` >= (CURRENT_DATE - INTERVAL {$this->new_for} DAY) GROUP BY epc.sku";

			$query[] = $select;
			$query[] = $from;
			$query[] = $join;
			$query[] = $where;

			$sql = implode($query);

			$result = $this->connection->fetchAll($sql);
			if(count($result) < $this->limit){

				$where = " WHERE `ccp`.`category_id` IN ('{$ids}') GROUP BY epc.sku ORDER BY  `epc`.`created_at` DESC LIMIT {$this->limit} ";
				$query = array();
				$query[] = $select;
				$query[] = $from;
				$query[] = $join;
				$query[] = $where;

				$sql = implode($query);
				$result = $this->connection->fetchAll($sql);
			}

			$this->title_class = "edpa-slider-categorypage-title";
			$this->slider_class = "edpa-slider-categorypage";
			$return = $this->productView($result);
			}else {
			$sql = "SELECT *  FROM `edpa_product_collection` WHERE  `created_at` >= (CURRENT_DATE - INTERVAL {$this->new_for} DAY)";
			$result = $this->connection->fetchAll($sql);

			if (count($result) < $this->limit) {
				$sql = "SELECT *  FROM `edpa_product_collection` ORDER BY `created_at` LIMIT {$this->limit}";
				$result = $this->connection->fetchAll($sql);

			}
			$return = $this->imageView($result);
		}
		return $return;
	}		

}

?>


$product = M