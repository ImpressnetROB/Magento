<?php
/*
 * @category	EDPA
 * @package		EDPA_Catalog
 * @author		EDPA
 * @date        31-03-2016
 * @last edit   06-04-2016
 * @copyright	Copyright 2016 EDPA
 */
class EDPA_Catalog_Model_Product_Compare extends Mage_Catalog_Model_Abstract{


    //*****************************
    // CONST
    //*****************************

    //*****************************
    // PUBLIC VARS
    //*****************************

    //*****************************
    // PRIVATE VARS
    //*****************************
    private $connection;
    private $product;
    private $compare_max = 4;
    private $minumum_protection = 4;
    private $category_id = null;
    private $fields = array();
    private $filtered_tables = array();


    //*************************************
    // PROPERTIES
    //*************************************

    //*****************************
    // SET FUNCTIONS
    //*****************************


    //*****************************
    // GET FUNCTIONS
    //*****************************

    //*********************************************
    // CONSTRUCTOR
    //**********************************************
    public function __construct(){
        $resource = Mage::getSingleton('core/resource');
        $this->connection = $resource->getConnection('core_read');
        $this->product =  Mage::registry('current_product')->getData();

        $this->getFilteredTables();

    }

    //*****************************
    // PROTECTED FUNCTIONS
    //*****************************

    //*****************************
    // PUBLIC FUNCTIONS
    //*****************************

    // Check the compare table is enabled on current product
    // product attribute name: 'product_compare'
    // @parameter:
    // @return (boolean) $return
    // @default: false
    public function isProductCompare(){
        $return = false;
        if($this->product['product_compare']){
            $return = true;
        }

        return $return;
    }

    // Return product collection
    // @parameter:
    // @return: (array) $collection
    public function getProductCollection(){
       $collection = $this->buildCollection();
        return $collection;

    }

    //*****************************
    // PRIVATE FUNCTIONS
    //*****************************

    // Find all products in a category
    // @parameter:
    // @return: (array) $collection
    private function buildCollection(){

        // Get the category id from session or search the first result of categories by product_id
        $product_id = $this->product['entity_id'];
        $session_category =  Mage::getSingleton('core/session')->getCurrentCategoryId();

        // getCategoryByProductId($product_id, $get_all = true, $get_parent_cat = true, $bundles = true, $search = null)
        // Mode details: Catalog\Helper\Category.php
        $categories = Mage::helper('edpacatalog/category')->getCategoryByProductId($product_id, false, false, false, $session_category);

        $collection = array();
        $this->category_id = $categories['cat_id'];

        // Get product collection
        $sql = array();

        $select = "SELECT * ";
        $from    = "FROM `catalog_category_product` AS `ccp` ";

        $join    = " INNER JOIN `edpa_product_collection` AS `epc`
                     ON `epc`.`entity_id` = `ccp`.`product_id`
                     ";
        $where = "WHERE `ccp`.`category_id` = '{$this->category_id}'";
        $order = "ORDER BY `rating` DESC ";

        $sql[] = $select;
        $sql[] = $from;
        $sql[] = $join;
        $sql[] = $where;
        $sql[] = $order;


        $collection = $this->connection->fetchAll(implode($sql));

        // Get all product details
        $collection = $this->getCompareCollection($collection);
        return $collection;
    }

    // Build up the product compare collection by attributes
    // each attribute contain it's product' details
    // like $data['sku']: array('bsr1234','bsr4567','bsr7894','bsr6541')
    // like $data['name']: array('name 1','name 2','name 3','name 4')
    // like $data['rating']: array('-200','300','1600','1700')
    // @parameter: (array) $collection
    // @return: (array) $collection
    private function getCompareCollection($collection){

        // find the current product in the full product collection
        $key = array_search($this->product['entity_id'],array_column($collection,'product_id'));
        if(!$key && is_bool($key)){ return array();}

        $current_product = $this->getProductData($collection[$key]);
        $current_fp = $current_product['final_price'];
        $current_rate = $current_product['rating'];
        $limit = ($this->compare_max-1)/2;

        $lower = array();
        $higher = array();

        $temp = array();
        $temp[] = $current_product;
        foreach($collection as $index => $product){
            $product_data =  $this->getProductData($product);
            $product_price = $product_data['final_price'];
            $product_rate = $product_data['rating'];

            if(($product_price < $current_fp)){
                $lower[] = $product_data;
            }


            if($product_price > $current_fp){
                $higher[] = $product_data;
            }
        }

        $lower = array_reverse($lower);
        if(!empty($higher)){}
        $lc = count($lower);
        $hc = count($higher);

        if( $lc > $limit &&  $hc > $limit){
            $offset = 0;
            $limit = $lc-$limit;
            $lower = $this->arrayTrim($lower,$offset,$limit);

            $offset = 2;
            $limit = $hc;
            $higher = $this->arrayTrim($higher,$offset,$limit);

        }elseif( $lc <= $limit && $hc > $limit){
            $offset = ($this->compare_max) - $lc;
            $limit = $hc-$offset;
            $higher = $this->arrayTrim($higher,$offset,$limit);

        }elseif($hc <= $limit && $lc > $limit){
            $offset = ($this->compare_max-1) - $hc;
            $limit = $lc-$offset;
            $lower = $this->arrayTrim($lower,$offset,$limit);
        }

        $temp = array();

        $temp = array_merge($temp, $lower);
        $temp[] = $current_product;
        $temp = array_merge($temp, $higher);

        if(count($temp) < $this->minumum_protection ){return null;}
        // get all attributes name to an array
        foreach($temp[0] as $index => $data){
            $this->fields[] = $index;
        }

        // build up the collection
        // each attribute contain the product details
        // s
        $collection = array();
        foreach($this->fields as $field){
            $fields_empty = true;
            foreach($temp as $product){
                $collection[$field][] = $product[$field];


                if($fields_empty && !empty($product[$field]) && strtolower($product[$field]) != 'no' ){
                    $fields_empty = false;
                }
            }

            if($fields_empty){
                unset( $collection[$field]);
            }
        }

        return $collection;

    }

    // Remove elements from an array with splice
    // @parameter: (array)$array, (int)$offset, (int)$limit
    // @return: (array) $array
    private function arrayTrim($array, $offset, $limit){
        array_splice($array,$offset,$limit);
        return $array;
    }

    private function getFilteredTables(){
        $config =  $this->connection->getConfig();
        $db_name = $config['dbname'];
        $sql = "SHOW TABLES
                FROM `{$db_name}`
                WHERE `Tables_in_{$db_name}` LIKE 'filtered_%'";

        $result = $this->connection->fetchAll($sql);

        foreach($result as $tname){
            $this->filtered_tables[] = $tname["Tables_in_{$db_name}"];

        }
    }


    // Get the product attributes from filtered_ table
    // @parameter:(array)$product
    // @return:(array)$product_data
    private function getProductData($product){

        $table = "filtered_{$this->category_id}";
        if(!in_array($table, $this->filtered_tables)){return array();}
        $sku = $product['sku'];

        $sql = "SELECT * FROM {$table} WHERE `sku` = '{$sku}'";
        $result = $this->connection->fetchAll($sql);
        //if(empty($result)){return;}
        $product_data = array();

        $product_data['image'] = Mage::getModel('edpacatalog/product_image')->getImage($product['image']);
        $product_data['name'] = $product['name'];
        $product_data['url_path'] = rtrim(Mage::getUrl($product['url_path']),'/');
        $product_data['sku'] = $product['sku'];
        $product_data['rating'] = $product['rating'];
        $product_data['final_price'] = number_format($product['final_price'],2);

        $exclude = array('id', 'sku');

        foreach($result[0] as $index => $data){
            if(in_array($index, $exclude)){continue;}
            $product_data[$index] = $data;
        }

        return  $product_data;
    }
}
?>