<?php
class Magestore_Inventorywarehouse_Block_Adminhtml_Requeststock_Editdelivery extends Mage_Adminhtml_Block_Widget_Grid_Container{

    public function __construct(){
        parent::__construct();
        $this->_controller = 'adminhtml_requeststock';
        $this->_blockGroup = 'requeststock_editdelivery';
        $this->_headerText = Mage::helper('inventorywarehouse')->__('Delivery');
        $this->_removeButton('add');
    }
}