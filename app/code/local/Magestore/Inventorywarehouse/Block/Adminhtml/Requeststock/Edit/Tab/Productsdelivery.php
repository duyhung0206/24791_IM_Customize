<?php
/**
 * Magestore
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magestore.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magestore.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Magestore
 * @package     Magestore_Inventorywarehouse
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

/**
 * Inventorywarehouse Adminhtml Block
 *
 * @category    Magestore
 * @package     Magestore_Inventorywarehouse
 * @author      Magestore Developer
 */
class Magestore_Inventorywarehouse_Block_Adminhtml_Requeststock_Edit_Tab_Productsdelivery
    extends Mage_Adminhtml_Block_Widget_Grid
//    implements Magestore_Inventoryplus_Block_Adminhtml_Barcode_Scan_Grid
{
    public function __construct()
    {
        parent::__construct();

        $this->setId('requeststockproductlistGrid');
//        $this->setDefaultSort('entity_id');
//        $this->setDefaultDir('DESC');
        $this->setUseAjax(true);
//        $getSelectedProducts = $this->_getSelectedProducts();
//        if (count($getSelectedProducts) > 0) {
//            $this->_selectedProducts = $getSelectedProducts;
//            //$this->setDefaultFilter(array('in_products' => 1));
//        }
    }
    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('inventorywarehouse/requeststockdelivery')->getCollection();

        $requestStockId = $this->getRequest()->getParam('id');
        if(isset($requestStockId)){

        }
        $this->setCollection($collection);
        parent::_prepareCollection();
    }

    public function getMainButtonsHtml()
    {
        $html = parent::getMainButtonsHtml();//get the parent class buttons
        $requestStockId = $this->getRequest()->getParam('id');
        $addButton = $this->getLayout()->createBlock('adminhtml/widget_button') //create the add button
        ->setData(array(
            'label'     => Mage::helper('inventorywarehouse')->__('Create a new delivery'),
            'onclick'   => "setLocation('".$this->getUrl('*/*/newdelivery')."requeststock_id/".$requestStockId."')",
            'class' => 'add',
        ))->toHtml();
        $addButton .= $this->getLayout()->createBlock('adminhtml/widget_button') //create the add button
        ->setData(array(
            'label'     => Mage::helper('inventorywarehouse')->__('Create all deliveries'),
            'onclick'   => "setLocation('".$this->getUrl('*/*/createalldelivery')."requeststock_id/".$requestStockId."')",
            'class' => 'add',
        ))->toHtml();
        return $addButton.$html;
    }


    protected function _prepareColumns()
    {

        $this->addColumn('requeststock_delivery_id', array(
            'header' => Mage::helper('catalog')->__('ID'),
            'sortable' => true,
            'width' => '60',
            'index' => 'requeststock_delivery_id'
        ));
        $this->addColumn('time', array(
            'header' => Mage::helper('catalog')->__('Date'),
            'sortable' => true,
            'width' => '60',
            'index' => 'time'
        ));
        $this->addColumn('product_name', array(
            'header' => Mage::helper('catalog')->__('Product Name'),
            'sortable' => true,
            'width' => '60',
            'index' => 'product_name'
        ));
        $this->addColumn('product_sku', array(
            'header' => Mage::helper('catalog')->__('Product SKU'),
            'sortable' => true,
            'width' => '60',
            'index' => 'product_sku'
        ));
        $this->addColumn('sku', array(
            'header' => Mage::helper('catalog')->__('Image'),
            'sortable' => true,
            'width' => '60',
            'index' => 'sku'
        ));
        $this->addColumn('qty_delivery', array(
            'header' => Mage::helper('catalog')->__('Qty delivery'),
            'sortable' => true,
            'width' => '60',
            'index' => 'qty_delivery'
        ));
        $this->addColumn('created_by', array(
            'header' => Mage::helper('catalog')->__('Create by'),
            'sortable' => true,
            'width' => '60',
            'index' => 'sku'
        ));
        return parent::_prepareColumns();
    }

    public function getRowUrl($row) {
        return false;
    }
}
