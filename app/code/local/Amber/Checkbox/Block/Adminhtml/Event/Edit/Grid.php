<?php


class Amber_Checkbox_Block_Adminhtml_Event_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	protected function _prepareCollection()
	{
		$collection = Mage::getModel('checkbox/event')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	protected function _prepareColumns()
	{
		$this->addColumn('name', array(
			'type' => 'text',
			'index' => 'name',
			'header' => $this->_('name')
			));
		$this->addColumn('start', array(
			'type' => 'date',
			'index' => 'start',
			'header' => $this->_('Start date')
			));
		$this->addColumn('end', array(
			'type' => 'date',
			'index' => 'end',
			'header' => $this->_('End date')
			));
		return $this;
	}
}