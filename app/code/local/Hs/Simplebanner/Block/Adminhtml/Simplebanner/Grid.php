<?php

class Hs_Simplebanner_Block_Adminhtml_Simplebanner_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
	  parent::__construct();
	  $this->setId('simplebannerGrid');
	  $this->setDefaultSort('simplebanner_id');
	  $this->setDefaultDir('ASC');
	  $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
	  $collection = Mage::getModel('simplebanner/simplebanner')->getCollection();
	  $this->setCollection($collection);
	  return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
	$this->addColumn('simplebanner_id', array(
		'header'    => Mage::helper('simplebanner')->__('ID'),
		'align'     =>'right',
		'width'     => '50px',
		'index'     => 'simplebanner_id',
	));
	
	$this->addColumn('title', array(
		'header'    => Mage::helper('simplebanner')->__('Title'),
		'align'     =>'left',
		'index'     => 'title',
	));
	
	$this->addColumn('image', array(
		'header' => Mage::helper('simplebanner')->__('Image'),
		'index'     =>'simplebanner_id',
		'sortable'  =>false,
		'filter' => false,                                         
		'renderer' => 'Hs_Simplebanner_Block_Adminhtml_Simplebanner_Renderer_Image',	
	)); 
	
	$this->addColumn('status', array(
		'header'    => Mage::helper('simplebanner')->__('Status'),
		'align'     => 'left',
		'width'     => '80px',
		'index'     => 'status',
		'type'      => 'options',
		'options'   => array(
			1 => 'Enabled',
			2 => 'Disabled',
		),
	));
	
	$this->addColumn('action',
		array(
			'header'    =>  Mage::helper('simplebanner')->__('Action'),
			'width'     => '100',
			'type'      => 'action',
			'getter'    => 'getId',
			'actions'   => array(
				array(
				'caption'   => Mage::helper('simplebanner')->__('Edit'),
				'url'       => array('base'=> '*/*/edit'),
				'field'     => 'id'
				)
			),
		'filter'    => false,
		'sortable'  => false,
		'index'     => 'stores',
		'is_system' => true,
	));
		
		//$this->addExportType('*/*/exportCsv', Mage::helper('simplebanner')->__('CSV'));
		//$this->addExportType('*/*/exportXml', Mage::helper('simplebanner')->__('XML'));
	  
	  return parent::_prepareColumns();
  }

	protected function _prepareMassaction()
	{
		$this->setMassactionIdField('simplebanner_id');
		$this->getMassactionBlock()->setFormFieldName('simplebanner');

		$this->getMassactionBlock()->addItem('delete', array(
			 'label'    => Mage::helper('simplebanner')->__('Delete'),
			 'url'      => $this->getUrl('*/*/massDelete'),
			 'confirm'  => Mage::helper('simplebanner')->__('Are you sure?')
		));

		$statuses = Mage::getSingleton('simplebanner/status')->getOptionArray();

		array_unshift($statuses, array('label'=>'', 'value'=>''));
		$this->getMassactionBlock()->addItem('status', array(
			 'label'=> Mage::helper('simplebanner')->__('Change status'),
			 'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
			 'additional' => array(
					'visibility' => array(
						 'name' => 'status',
						 'type' => 'select',
						 'class' => 'required-entry',
						 'label' => Mage::helper('simplebanner')->__('Status'),
						 'values' => $statuses
					 )
			 )
		));
		return $this;
	}

  public function getRowUrl($row)
  {
	  return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}
