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
 * @package     Magestore_Inventorybarcode
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

/**
 * Inventorybarcode Block
 * 
 * @category    Magestore
 * @package     Magestore_Inventorybarcode
 * @author      Magestore Developer
 */
class Magestore_Inventorybarcode_Block_Adminhtml_Barcode_Edit_Renderer_Custompo extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    protected $_values;

    /**
     * Renders grid column
     *
     * @param   Varien_Object $row
     * @return  string
     */
    public function render(Varien_Object $row)
    {
         $value = $row->getData($this->getColumn()->getIndex());
         
        
       
            $html = Mage::helper('inventorybarcode')->__('Auto').': <input onclick="setBarcodeAuto(this,\'barcode-' . $row->getId() . '\')" type="checkbox" name="barcode_auto" checked="checked" value="">';
            $html .= '<input type="text" ';
            $html .= 'id="barcode-' . $row->getId() . '" ';
            $html .= 'style="width: 160px !important;"';
            $html .= 'name="' . $this->getColumn()->getId() . '" ';
            $html .= 'value=""';
            $html .= 'class="input-text' . $this->getColumn()->getInlineCss() . '" readonly />';
//            $html .= '<p class="note" id="note_barcode"><span>'.Mage::helper('inventory')->__('Just [A-Z][a-z][0-9] are allowed').'</span></p>';
        
        return $html;
    }

}

