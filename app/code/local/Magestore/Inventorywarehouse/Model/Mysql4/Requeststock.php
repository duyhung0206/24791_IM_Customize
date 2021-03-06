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
 * Inventorywarehouse Resource Model
 * 
 * @category    Magestore
 * @package     Magestore_Inventorywarehouse
 * @author      Magestore Developer
 */

class Magestore_Inventorywarehouse_Model_Mysql4_Requeststock extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('inventorywarehouse/requeststock', 'warehouse_requeststock_id');
    }

    public function filterWarehouseTo($collection, $column)
    {
        $read = $this->_getReadAdapter();
        $value = $column->getFilter()->getValue();
        if (!is_null($value)) {
            if ($value == 'Others') {
                $condition = $read->prepareSqlCondition('main_table.from_name', array('like' => $value));
                $collection->getSelect()->where($condition);
            } else {
                $condition = $read->prepareSqlCondition('main_table.from_name', array('like' => '%'.$value.'%'));
                $collection->getSelect()->where($condition);
            }
        }
    }
}