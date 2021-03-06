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
 * @category 	Magestore
 * @package 	Magestore_Inventorysupplier
 * @copyright 	Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license 	http://www.magestore.com/license-agreement.html
 */
/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$connection = $installer->getConnection();

/**
 * create inventorysupplier table
 */

$installer->run("	
	CREATE TABLE IF NOT EXISTS {$this->getTable('erp_inventory_supplier')} (
		`supplier_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		`supplier_name` varchar(255) NOT NULL default '',
		`contact_name` varchar(255),
		`supplier_email` varchar(255) NOT NULL default '',
		`telephone` varchar(50) NOT NULL default '',
		`fax` varchar(50) default '',
		`street` text NOT NULL default '',
		`city` varchar(255) NOT NULL default '',
		`country_id` char(3) NOT NULL default '',
		`state` varchar(255) NOT NULL default '',
		`state_id` varchar(255) NOT NULL default '',
		`postcode` varchar(255) NOT NULL default '',
		`description` text default '',
		`website` varchar(255) default '',
		`created_by` varchar(255) default '',
		`created_time` DATETIME default NULL,
		`updated_time` DATETIME default NULL,
		`supplier_status` tinyint(1) NOT NULL default '1',     
		`total_order` decimal(10,0) NOT NULL default '0',
                `purchase_order` decimal(12,4) NOT NULL default '0',
                `return_order` decimal(12,4) NOT NULL default '0',
		`last_purchase_order` date default NULL,
		`ship_via` int(11) default 0,
                `payment_term` int(11) default 0,
		PRIMARY KEY(`supplier_id`)
	)ENGINE=InnoDB DEFAULT CHARSET=utf8;
        
	CREATE TABLE IF NOT EXISTS {$this->getTable('erp_inventory_supplier_product')}(
		`supplier_product_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		`supplier_id` int(11) unsigned NOT NULL,
		`product_id` int(11) unsigned NOT NULL,		
		`cost` decimal(12,4) unsigned NOT NULL default '0.0000',
		`discount` float unsigned NOT NULL default '0.0000',
		`tax` float unsigned NOT NULL default '0.0000',
		`supplier_sku` varchar(244) default NULL,
		INDEX (`supplier_id`),
		INDEX (`product_id`),
		PRIMARY KEY(`supplier_product_id`),
		FOREIGN KEY (`supplier_id`) REFERENCES {$this->getTable('erp_inventory_supplier')}(`supplier_id`) ON DELETE CASCADE ON UPDATE CASCADE,
		FOREIGN KEY (`product_id`) REFERENCES {$this->getTable('catalog_product_entity')}(`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE
	)ENGINE=InnoDB DEFAULT CHARSET=utf8;
        
	CREATE TABLE IF NOT EXISTS {$this->getTable('erp_inventory_supplier_history')} (
		`supplier_history_id` int(11) unsigned NOT NULL auto_increment,
		`supplier_id` int(11) unsigned NOT NULL,
		`time_stamp` datetime,
		`created_by` varchar(255) NOT NULL,
		INDEX (`supplier_id`),
		FOREIGN KEY (`supplier_id`) REFERENCES {$this->getTable('erp_inventory_supplier')}(`supplier_id`) ON DELETE CASCADE ON UPDATE CASCADE,
		PRIMARY KEY  (`supplier_history_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
	CREATE TABLE IF NOT EXISTS {$this->getTable('erp_inventory_supplier_history_content')} (
		`supplier_history_content_id` int(11) unsigned NOT NULL auto_increment,
		`supplier_history_id` int(11) unsigned NOT NULL,
		`field_name` varchar(255) NOT NULL,
		`old_value` text,
		`new_value` text,
		INDEX (`supplier_history_id`),
		FOREIGN KEY (`supplier_history_id`) REFERENCES {$this->getTable('erp_inventory_supplier_history')}(`supplier_history_id`) ON DELETE CASCADE ON UPDATE CASCADE,
		PRIMARY KEY  (`supplier_history_content_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
	CREATE TABLE IF NOT EXISTS {$this->getTable('erp_inventory_purchase_order')} (
		`purchase_order_id` int(11) unsigned NOT NULL auto_increment,
		`purchase_on` DATETIME default NULL,
		`bill_name` varchar(255) default NULL,
		`warehouse_id` varchar(255) DEFAULT '0',
		`warehouse_name` varchar(255) default '',
		`supplier_id` int(11) unsigned NOT NULL,
		`supplier_name` varchar(255) default '',
		`total_products` decimal(10,0) default '0',
		`total_amount` decimal(12,4) default '0',
		`comments` text,
		`currency` varchar(255) default NULL,
		`tax_rate` float default '0',
		`shipping_cost` float default '0',
		`delivery_process` float default '0',
		`status` tinyint(1) NOT NULL default '1',
		`paid` decimal(12,4) default '0',
		`total_products_recieved` decimal(10,0) default '0',
		`created_by` varchar(255) default '',
		`order_placed` int(11),
		`started_date` date,
		`canceled_date` date,
		`expected_date` date,
		`payment_date` date,
		`ship_via` int(11),
		`payment_term` int(11),
		`change_rate` varchar(255) NOT NULL default '1',
		`total_product_refunded` int(11) not null default 0,
		PRIMARY KEY  (`purchase_order_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        
	CREATE TABLE IF NOT EXISTS {$this->getTable('erp_inventory_purchase_order_product')} (
		`purchase_order_product_id` int(11) unsigned NOT NULL auto_increment,
		`product_id` int(11) unsigned default NULL,
		`product_name` varchar(255) default '',
		`product_sku` varchar(255) default '',
		`purchase_order_id` int(11) unsigned NOT NULL,
		`qty` decimal(10,0) default '0',
		`qty_recieved` decimal(10,0) default '0',
		`cost` decimal(12,4) unsigned NOT NULL default '0.0000',
		`discount` float unsigned NOT NULL default '0.0000',
		`tax` float unsigned NOT NULL default '0.0000',
		`qty_returned` decimal(10,0) default '0',
		`supplier_sku` varchar(244) default NULL,
		`barcode` varchar(255) default '',
		PRIMARY KEY(`purchase_order_product_id`),
		INDEX(`purchase_order_id`),
		FOREIGN KEY (`purchase_order_id`) REFERENCES {$this->getTable('erp_inventory_purchase_order')}(`purchase_order_id`) ON DELETE CASCADE ON UPDATE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        

	CREATE TABLE IF NOT EXISTS {$this->getTable('erp_inventory_delivery')} (
		`delivery_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		`delivery_date` datetime,
		`qty_delivery` decimal(10,0) unsigned NOT NULL default '0',
		`purchase_order_id` int(11) unsigned NOT NULL,
		`product_id` int(11) unsigned NOT NULL,
		`product_name` varchar(255) NOT NULL,
		`product_sku` varchar(255) NOT NULL,
		`sametime` varchar(255) default '',
		`created_by` varchar(255) default '',
		PRIMARY KEY(`delivery_id`),
		FOREIGN KEY (`purchase_order_id`) REFERENCES {$this->getTable('erp_inventory_purchase_order')}(`purchase_order_id`) ON DELETE CASCADE ON UPDATE CASCADE
	)ENGINE=InnoDB DEFAULT CHARSET=utf8;

	
	CREATE TABLE IF NOT EXISTS {$this->getTable('erp_inventory_returned_order')} (
		`returned_order_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		`purchase_order_id` int(11) unsigned NOT NULL,
		`total_products` decimal(10,0) unsigned NOT NULL default '0',
		`total_amount` decimal(12,4) unsigned NOT NULL default '0.0000',
		`returned_on` datetime,
		`status` tinyint(1) NOT NULL default '1',
		`paid` decimal(12,4) default '0',
		`supplier_id` int(11) unsigned NOT NULL default '0',
		PRIMARY KEY(`returned_order_id`),
		INDEX(`purchase_order_id`),
		FOREIGN KEY (`purchase_order_id`) REFERENCES {$this->getTable('erp_inventory_purchase_order')}(`purchase_order_id`) ON DELETE CASCADE ON UPDATE CASCADE
	)ENGINE=InnoDB DEFAULT CHARSET=utf8;


	
	CREATE TABLE IF NOT EXISTS {$this->getTable('erp_inventory_returned_order_product')} (
		`returned_order_product_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		`returned_order_id` int(11) unsigned NOT NULL,
		`qty_return` decimal(10,0) unsigned NOT NULL default '0',
		`product_id` int(11) unsigned NOT NULL,
		`product_name` varchar(255) default '',
		`product_sku` varchar(255) default '',
		PRIMARY KEY(`returned_order_product_id`),
		INDEX (`returned_order_id`),
		FOREIGN KEY (`returned_order_id`) REFERENCES {$this->getTable('erp_inventory_returned_order')}(`returned_order_id`) ON DELETE CASCADE ON UPDATE CASCADE
	)ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
	
        CREATE TABLE IF NOT EXISTS {$this->getTable('erp_inventory_shipping_method')} (
            `shipping_method_id` int(11) unsigned NOT NULL auto_increment,
            `shipping_method_name` varchar(255) NOT NULL,
            `description` text,
            `shipping_method_status` tinyint(1) NOT NULL,
            `created_by` varchar(255) NOT NULL,
            PRIMARY KEY  (`shipping_method_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        

	CREATE TABLE IF NOT EXISTS {$this->getTable('erp_inventory_shipping_method_history')} (
            `shipping_method_history_id` int(11) unsigned NOT NULL auto_increment,
            `shipping_method_id` int(11) unsigned NOT NULL,
            `time_stamp` datetime,
            `created_by` varchar(255) NOT NULL,
            INDEX (`shipping_method_id`),
            FOREIGN KEY (`shipping_method_id`) REFERENCES {$this->getTable('erp_inventory_shipping_method')}(`shipping_method_id`) ON DELETE CASCADE ON UPDATE CASCADE,
            PRIMARY KEY  (`shipping_method_history_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        

        
	CREATE TABLE IF NOT EXISTS {$this->getTable('erp_inventory_shipping_method_history_content')} (
            `shipping_method_history_content_id` int(11) unsigned NOT NULL auto_increment,
            `shipping_method_history_id` int(11) unsigned NOT NULL,
            `field_name` varchar(255) NOT NULL,
            `old_value` text,
            `new_value` text,
            INDEX (`shipping_method_history_id`),
            FOREIGN KEY (`shipping_method_history_id`) REFERENCES {$this->getTable('erp_inventory_shipping_method_history')}(`shipping_method_history_id`) ON DELETE CASCADE ON UPDATE CASCADE,
            PRIMARY KEY  (`shipping_method_history_content_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        

	
	CREATE TABLE IF NOT EXISTS {$this->getTable('erp_inventory_payment_term')} (
            `payment_term_id` int(11) unsigned NOT NULL auto_increment,
            `payment_term_name` varchar(255) NOT NULL,
            `description` text,
            `payment_days` int(11) NOT NULL default 0,
            `payment_term_status` tinyint(1) NOT NULL,
            `created_by` varchar(255) NOT NULL,
            PRIMARY KEY  (`payment_term_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        
        
	CREATE TABLE IF NOT EXISTS {$this->getTable('erp_inventory_payment_term_history')} (
            `payment_term_history_id` int(11) unsigned NOT NULL auto_increment,
            `payment_term_id` int(11) unsigned NOT NULL,
            `time_stamp` datetime,
            `created_by` varchar(255) NOT NULL,
            INDEX (`payment_term_id`),
            FOREIGN KEY (`payment_term_id`) REFERENCES {$this->getTable('erp_inventory_payment_term')}(`payment_term_id`) ON DELETE CASCADE ON UPDATE CASCADE,
            PRIMARY KEY  (`payment_term_history_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	
	CREATE TABLE IF NOT EXISTS {$this->getTable('erp_inventory_payment_term_history_content')} (
		`payment_term_history_content_id` int(11) unsigned NOT NULL auto_increment,
		`payment_term_history_id` int(11) unsigned NOT NULL,
		`field_name` varchar(255) NOT NULL,
		`old_value` text,
		`new_value` text,
		INDEX (`payment_term_history_id`),
		FOREIGN KEY (`payment_term_history_id`) REFERENCES {$this->getTable('erp_inventory_payment_term_history')}(`payment_term_history_id`) ON DELETE CASCADE ON UPDATE CASCADE,
		PRIMARY KEY  (`payment_term_history_content_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
	
	CREATE TABLE IF NOT EXISTS {$this->getTable('erp_inventory_purchase_order_history')} (
		`purchase_order_history_id` int(11) unsigned NOT NULL auto_increment,
		`purchase_order_id` int(11) unsigned NOT NULL,
		`time_stamp` datetime,
		`created_by` varchar(255) NOT NULL,
		INDEX (`purchase_order_id`),
		FOREIGN KEY (`purchase_order_id`) REFERENCES {$this->getTable('erp_inventory_purchase_order')}(`purchase_order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
		PRIMARY KEY  (`purchase_order_history_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        
	
	CREATE TABLE IF NOT EXISTS {$this->getTable('erp_inventory_purchase_order_history_content')} (
		`purchase_order_history_content_id` int(11) unsigned NOT NULL auto_increment,
		`purchase_order_history_id` int(11) unsigned NOT NULL,
		`field_name` varchar(255) NOT NULL,
		`old_value` text,
		`new_value` text,
		INDEX (`purchase_order_history_id`),
		FOREIGN KEY (`purchase_order_history_id`) REFERENCES {$this->getTable('erp_inventory_purchase_order_history')}(`purchase_order_history_id`) ON DELETE CASCADE ON UPDATE CASCADE,
		PRIMARY KEY  (`purchase_order_history_content_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
	
	CREATE TABLE IF NOT EXISTS {$this->getTable('erp_inventory_purchase_order_product_warehouse')} (
		`purchase_order_product_warehouse_id` int(11) unsigned NOT NULL auto_increment,
		`purchase_order_id` int(11) unsigned NOT NULL,
		`product_id` int(11) unsigned NOT NULL,
		`product_name` varchar(255) default '',
		`product_sku` varchar(255) default '',
		`warehouse_id` int(11) unsigned NOT NULL,
		`warehouse_name` varchar(255) default '',
		`qty_order` decimal(10,0) default '0',
		`qty_received` decimal(10,0) default '0',
		`qty_returned` decimal(10,0) default '0',
		`supplier_sku` varchar(244) default NULL,
		PRIMARY KEY  (`purchase_order_product_warehouse_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;   
	
	
	CREATE TABLE IF NOT EXISTS {$this->getTable('erp_inventory_return_product_warehouse')} (
		`return_product_warehouse_id` int(11) unsigned NOT NULL auto_increment,
		`returned_on` datetime,
		`purchase_order_id` int(11) unsigned NOT NULL,
		`product_id` int(11) unsigned NOT NULL,
		`product_name` varchar(255) default '',
		`product_sku` varchar(255) default '',
		`warehouse_id` int(11) unsigned NOT NULL,
		`warehouse_name` varchar(255) default '',
		`qty_return` decimal(10,0) default '0',
		`created_by` varchar(255) default '',
		`reason` text default '',
		PRIMARY KEY  (`return_product_warehouse_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	
	CREATE TABLE IF NOT EXISTS {$this->getTable('erp_inventory_delivery_warehouse')} (
		`delivery_warehouse_id` int(11) unsigned NOT NULL auto_increment,
		`delivery_date` datetime,
		`purchase_order_id` int(11) unsigned NOT NULL,
		`product_id` int(11) unsigned NOT NULL,
		`product_name` varchar(255) default '',
		`product_sku` varchar(255) default '',
		`warehouse_id` int(11) unsigned NOT NULL,
		`warehouse_name` varchar(255) default '',
		`qty_delivery` decimal(10,0) default '0',
		`sametime` varchar(255) default '',
		PRIMARY KEY  (`delivery_warehouse_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
");
        
/* add columns to erp_inventory_supplier */
$connection->addColumn(
        $this->getTable('erp_inventory_supplier'), 'state_id', array(
    'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
    'length' => 255,
    'default' => '',
    'comment' => 'State ID'
        )
);

$connection->addColumn(
        $this->getTable('erp_inventory_supplier'), 'created_time', array(
    'type' => Varien_Db_Ddl_Table::TYPE_DATETIME,
    'default' => null,
    'comment' => 'Created Time'
        )
);

$connection->addColumn(
        $this->getTable('erp_inventory_supplier'), 'updated_time', array(
    'type' => Varien_Db_Ddl_Table::TYPE_DATETIME,
    'default' => null,
    'comment' => 'Updated Time'
        )
);

$connection->addColumn(
        $this->getTable('erp_inventory_supplier'), 'ship_via', array(
    'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'length' => 11,
    'default' => null,
    'comment' => 'Ship Via'
        )
);

$connection->addColumn(
        $this->getTable('erp_inventory_supplier'), 'payment_term', array(
    'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'length' => 11,
    'default' => null,
    'comment' => 'Payment Term'
        )
);

if ($connection->tableColumnExists($this->getTable('erp_inventory_supplier'), 'name')) {
    $connection->changeColumn(
            $this->getTable('erp_inventory_supplier'), 'name', 'supplier_name', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length' => 255,
        'default' => null,
        'comment' => 'Supplier Name'
            )
    );
}

if ($connection->tableColumnExists($this->getTable('erp_inventory_supplier'), 'email')) {
    $connection->changeColumn(
            $this->getTable('erp_inventory_supplier'), 'email', 'supplier_email', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length' => 255,
        'default' => null,
        'comment' => 'Supplier Email'
            )
    );
}

if ($connection->tableColumnExists($this->getTable('erp_inventory_supplier'), 'create_by')) {
    $connection->changeColumn(
            $this->getTable('erp_inventory_supplier'), 'create_by', 'created_by', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length' => 255,
        'default' => null,
        'comment' => 'Created By'
            )
    );
}

if ($connection->tableColumnExists($this->getTable('erp_inventory_supplier'), 'status')) {
    $connection->changeColumn(
            $this->getTable('erp_inventory_supplier'), 'status', 'supplier_status', array(
        'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'length' => 1,
        'default' => 1,
        'comment' => 'Supplier Status'
            )
    );
}

/* add columns to erp_inventory_supplier_product */
$connection->addColumn(
        $this->getTable('erp_inventory_supplier_product'), 'supplier_sku', array(
    'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
    'length' => 255,
    'default' => null,
    'comment' => 'Supplier Product Sku'
        )
);

if ($connection->tableColumnExists($this->getTable('erp_inventory_supplier_history'), 'create_by')) {
    $connection->changeColumn(
            $this->getTable('erp_inventory_supplier_history'), 'create_by', 'created_by', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length' => 255,
        'default' => null,
        'comment' => 'Created By'
            )
    );
}

/* add columns to erp_inventory_purchase_order */
$connection->addColumn(
        $this->getTable('erp_inventory_purchase_order'), 'change_rate', array(
    'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
    'length' => 255,
    'default' => 1,
    'comment' => 'Change Rate'
        )
);

$connection->addColumn(
        $this->getTable('erp_inventory_purchase_order'), 'total_product_refunded', array(
    'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'length' => 1,
    'default' => 0,
    'comment' => 'Total Refunded Products'
        )
);

if ($connection->tableColumnExists($this->getTable('erp_inventory_purchase_order'), 'create_by')) {
    $connection->changeColumn(
            $this->getTable('erp_inventory_purchase_order'), 'create_by', 'created_by', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length' => 255,
        'default' => null,
        'comment' => 'Created By'
            )
    );
}

if ($connection->tableColumnExists($this->getTable('erp_inventory_purchase_order'), 'start_date')) {
    $connection->changeColumn(
            $this->getTable('erp_inventory_purchase_order'), 'start_date', 'started_date', array(
        'type' => Varien_Db_Ddl_Table::TYPE_DATE,
        'default' => null,
        'comment' => 'Started Date'
            )
    );
}

if ($connection->tableColumnExists($this->getTable('erp_inventory_purchase_order'), 'cancel_date')) {
    $connection->changeColumn(
            $this->getTable('erp_inventory_purchase_order'), 'cancel_date', 'canceled_date', array(
        'type' => Varien_Db_Ddl_Table::TYPE_DATE,
        'default' => null,
        'comment' => 'Canceled Date'
            )
    );
}

/* add columns to erp_inventory_purchase_order_product */
$connection->addColumn(
        $this->getTable('erp_inventory_purchase_order_product'), 'supplier_sku', array(
    'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
    'length' => 255,
    'default' => null,
    'comment' => 'Supplier Product Sku'
        )
);

$connection->addColumn(
        $this->getTable('erp_inventory_purchase_order_product'), 'barcode', array(
    'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
    'length' => 255,
    'default' => null,
    'comment' => 'Barcode'
        )
);

/* change columns of erp_inventory_delivery */
if ($connection->tableColumnExists($this->getTable('erp_inventory_delivery'), 'create_by')) {
    $connection->changeColumn(
            $this->getTable('erp_inventory_delivery'), 'create_by', 'created_by', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length' => 255,
        'default' => '',
        'comment' => 'Created By'
            )
    );
}


/* change columns of erp_inventory_shipping_method */
if ($connection->tableColumnExists($this->getTable('erp_inventory_shipping_method'), 'name')) {
    $connection->changeColumn(
            $this->getTable('erp_inventory_shipping_method'), 'name', 'shipping_method_name', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length' => 255,
        'default' => '',
        'comment' => 'Shipping Method Name'
            )
    );
}

if ($connection->tableColumnExists($this->getTable('erp_inventory_shipping_method'), 'status')) {
    $connection->changeColumn(
            $this->getTable('erp_inventory_shipping_method'), 'status', 'shipping_method_status', array(
        'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'length' => 1,
        'default' => 1,
        'comment' => 'Shipping Method Status'
            )
    );
}

if ($connection->tableColumnExists($this->getTable('erp_inventory_shipping_method'), 'create_by')) {
    $connection->changeColumn(
            $this->getTable('erp_inventory_shipping_method'), 'create_by', 'created_by', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length' => 255,
        'default' => '',
        'comment' => 'Created By'
            )
    );
}


/* change columns of erp_inventory_payment_term */
if ($connection->tableColumnExists($this->getTable('erp_inventory_payment_term'), 'name')) {
    $connection->changeColumn(
            $this->getTable('erp_inventory_payment_term'), 'name', 'payment_term_name', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length' => 255,
        'default' => '',
        'comment' => 'Payment Term Name'
            )
    );
}

if ($connection->tableColumnExists($this->getTable('erp_inventory_payment_term'), 'status')) {
    $connection->changeColumn(
            $this->getTable('erp_inventory_payment_term'), 'status', 'payment_term_status', array(
        'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'length' => 1,
        'default' => 1,
        'comment' => 'Payment Term Status'
            )
    );
}

if ($connection->tableColumnExists($this->getTable('erp_inventory_payment_term'), 'create_by')) {
    $connection->changeColumn(
            $this->getTable('erp_inventory_payment_term'), 'create_by', 'created_by', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length' => 255,
        'default' => '',
        'comment' => 'Created By'
            )
    );
}

/* change columns of erp_inventory_shipping_method_history */
if ($connection->tableColumnExists($this->getTable('erp_inventory_shipping_method_history'), 'create_by')) {
    $connection->changeColumn(
            $this->getTable('erp_inventory_shipping_method_history'), 'create_by', 'created_by', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length' => 255,
        'default' => '',
        'comment' => 'Created By'
            )
    );
}

/* change columns of erp_inventory_payment_term_history */
if ($connection->tableColumnExists($this->getTable('erp_inventory_payment_term_history'), 'create_by')) {
    $connection->changeColumn(
            $this->getTable('erp_inventory_payment_term_history'), 'create_by', 'created_by', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length' => 255,
        'default' => '',
        'comment' => 'Created By'
            )
    );
}

/* change columns of erp_inventory_purchase_order_history */
if ($connection->tableColumnExists($this->getTable('erp_inventory_purchase_order_history'), 'create_by')) {
    $connection->changeColumn(
            $this->getTable('erp_inventory_purchase_order_history'), 'create_by', 'created_by', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length' => 255,
        'default' => '',
        'comment' => 'Created By'
            )
    );
}

/* change columns of erp_inventory_return_product_warehouse */
if ($connection->tableColumnExists($this->getTable('erp_inventory_return_product_warehouse'), 'create_by')) {
    $connection->changeColumn(
            $this->getTable('erp_inventory_return_product_warehouse'), 'create_by', 'created_by', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length' => 255,
        'default' => '',
        'comment' => 'Created By'
            )
    );
}


if (Mage::helper('core')->isModuleEnabled('Magestore_Inventorybarcode')) {

    $barcodeAttributeType = Mage::getModel('inventorybarcode/barcodeattribute_type')->getCollection()
            ->addFieldToFilter('attribute_type', 'purchaseorder');
    if ($barcodeAttributeType->getSize() == 0) {
        $installer->run("
			INSERT INTO {$this->getTable('erp_inventory_barcode_attribute_type')} (attribute_type, model) VALUES ('supplier', 'inventorypurchasing/supplier');       
		");
    }
    $barcodeAttributeType = Mage::getModel('inventorybarcode/barcodeattribute_type')->getCollection()
            ->addFieldToFilter('attribute_type', 'purchaseorder');
    if ($barcodeAttributeType->getSize() == 0) {
        $installer->run("
			INSERT INTO {$this->getTable('erp_inventory_barcode_attribute_type')} (attribute_type, model) VALUES ('purchaseorder', 'inventorypurchasing/purchaseorder');       
		");
    }

    $barcodeAttribute = Mage::getModel('inventorybarcode/barcodeattribute')->getCollection()
            ->addFieldToFilter('attribute_code', 'purchaseorder_purchase_order_id');
    if ($barcodeAttribute->getSize() == 0) {
        $installer->run("
			
			INSERT INTO {$this->getTable('erp_inventory_barcode_attribute')} (attribute_name, attribute_code, attribute_type, attribute_display) VALUES ('Purchase Order Id', 'purchaseorder_purchase_order_id', 'purchaseorder', 0);       
		");
    }
    $barcodeAttribute = Mage::getModel('inventorybarcode/barcodeattribute')->getCollection()
            ->addFieldToFilter('attribute_code', 'supplier_supplier_id');
    if ($barcodeAttribute->getSize() == 0) {
        $installer->run("
			
			INSERT INTO {$this->getTable('erp_inventory_barcode_attribute')} (attribute_name, attribute_code, attribute_type, attribute_display) VALUES ('Supplier Id', 'supplier_supplier_id', 'supplier', 0);
			INSERT INTO {$this->getTable('erp_inventory_barcode_attribute')} (attribute_name, attribute_code, attribute_type, attribute_display) VALUES ('Supplier Name', 'supplier_supplier_name', 'supplier', 0);
		");
    }
    $barcodeAttribute = Mage::getModel('inventorybarcode/barcodeattribute')->getCollection()
            ->addFieldToFilter('attribute_code', 'supplier_supplier_name');
    if ($barcodeAttribute->getSize() == 0) {
        $installer->run("     
			INSERT INTO {$this->getTable('erp_inventory_barcode_attribute')} (attribute_name, attribute_code, attribute_type, attribute_display) VALUES ('Supplier Name', 'supplier_supplier_name', 'supplier', 0);
		");
    }
}

$installer->endSetup();

