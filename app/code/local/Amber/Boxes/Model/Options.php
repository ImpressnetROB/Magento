<!-- 

/*
 * @category	EDPA
 * @package		EDPA_Browse
 * @author		AMBR
 * @date        12-07-2015
 * @last edit   12-07-2015
 * @copyright	Copyright 2016 EDPA
 */

 -->
<?php

class Amber_Boxes_Model_Boxes extends Mage_Eav_Model_Entity_Attribute_Backend_Abstract
{
	protected function _afterSave(Mage_Core_Model_Abstract $object)
	{
		$this->_clearUselessAttributeValues($object);
		$this->_saveStoreLabels($object)
			 ->_saveAdditionalAttributeData($object)
			 ->saveInSetIncluding($object)
			 ->_saveOption($object);

		return $this;
	}
	protected function _saveOption(Mage_Core_Model_Abstract $object)
	{
		$option = $object->getOption();
		if (is_array($option)) {
			$adapter            = $this->_getWriteAdapter();
			$optionTable        = $this->getTable('eav/attribute_option');
			$optionValueTable   = $this->getTable('eav/attribute_option_value');

			$stores = Mage::app()->getStores(true);
			if (isset($option['value'])) {
				$attributeDefaultValue = array();
				if (!is_array($object->getDefault())) {
					$object->setDefault(array());
				}

				foreach ($option['value'] as $optionId => $values) {
					$intOptionId = (int) $optionId;
					if (!empty($option['delete'][$optionId])) {
						if ($intOptionId) {
							$adapter->delete($optionTable, array('option_id = ?' => $intOptionId));
						}
						continue;
					}

					$sortOrder = !empty($option['order'][$optionId]) ? $option['order'][$optionId] : 0;
					$imgUrl = !empty($option['image_url'][$optionId]) ? $option['image_url'][$optionId] : 0;
					if (!$intOptionId) {
						$data = array(
						   'attribute_id'  => $object->getId(),
						   'sort_order'    => $sortOrder,
						   'image_url'     => $imgUrl
						);
						$adapter->insert($optionTable, $data);
						$intOptionId = $adapter->lastInsertId($optionTable);
					} else {
						$data  = array('sort_order' => $sortOrder, 'image_url' => $imgUrl);
						$where = array('option_id =?' => $intOptionId);
						$adapter->update($optionTable, $data, $where);
					}

					if (in_array($optionId, $object->getDefault())) {
						if ($object->getFrontendInput() == 'multiselect') {
							$attributeDefaultValue[] = $intOptionId;
						} elseif ($object->getFrontendInput() == 'select') {
							$attributeDefaultValue = array($intOptionId);
						}
					}

					// Default value
					if (!isset($values[0])) {
						Mage::throwException(Mage::helper('eav')->__('Default option value is not defined'));
					}

					$adapter->delete($optionValueTable, array('option_id =?' => $intOptionId));
					foreach ($stores as $store) {
						if (isset($values[$store->getId()])
							&& (!empty($values[$store->getId()])
							|| $values[$store->getId()] == "0")
						) {
							$data = array(
								'option_id' => $intOptionId,
								'store_id'  => $store->getId(),
								'value'     => $values[$store->getId()]
							);
							$adapter->insert($optionValueTable, $data);
						}
					}
				}
				$bind  = array('default_value' => implode(',', $attributeDefaultValue));
				$where = array('attribute_id =?' => $object->getId());
				$adapter->update($this->getMainTable(), $bind, $where);
			}
		}

		return $this;
	}
}
?>