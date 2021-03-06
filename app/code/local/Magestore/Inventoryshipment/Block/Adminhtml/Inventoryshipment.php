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
 * @package     Magestore_Inventoryshipment
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

/**
 * Inventoryshipment Adminhtml Block
 * 
 * @category    Magestore
 * @package     Magestore_Inventoryshipment
 * @author      Magestore Developer
 */
class Magestore_Inventoryshipment_Block_Adminhtml_Inventoryshipment extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_inventoryshipment';
        $this->_blockGroup = 'inventoryshipment';
        $this->_headerText = Mage::helper('inventoryshipment')->__('Manage Orders Shipment');        
        parent::__construct();
        $this->_removeButton('add');
    }
}