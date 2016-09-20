<?php
/**
 * Module's configuration (hard-coded).
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core;

use Magento\CatalogInventory\Model\Stock as ModelStock;
use Magento\CatalogInventory\Model\Stock\Status as ModelStockStatus;
use Magento\Sales\Api\Data\OrderItemInterface as ModelOrderItem;

class Config
{
    const DEFAULT_WRITE_RESOURCE = 'core_write';
    /** Default stock ID for empty Magento instance. */
    const DEF_STOCK_ID = 1;
    /** Default 'admin' website ID for empty Magento instance */
    const DEF_WEBSITE_ID_ADMIN = 0;
    /** Default 'base' website ID for empty Magento instance */
    const DEF_WEBSITE_ID_BASE = 1;
    /** Default '0' to use in floats comparison: ($val>Cfg::DEF_ZERO) instead of "($val>0)" */
    const DEF_ZERO = 0.000001;
    /** Path separator for nodes to address package in DEM. */
    const DEM_PS = '/';
    /**
     * Names for Data Sources.
     */
    const DS_CUSTOMERS_GRID = 'customer_listing_data_source';
    const DS_SALES_ORDERS_GRID = 'sales_order_grid_data_source';
    /**
     * Magento entities as defined in version 2.
     */
    const ENTITY_MAGE_CATALOGINVENTORY_STOCK = ModelStock::ENTITY;
    const ENTITY_MAGE_CATALOGINVENTORY_STOCK_ITEM = 'cataloginventory_stock_item';
    const ENTITY_MAGE_CATALOGINVENTORY_STOCK_STATUS = 'cataloginventory_stock_status';
    const ENTITY_MAGE_CATALOG_CATEGORY_EAV_INT = 'catalog_category_entity_int';
    const ENTITY_MAGE_CORE_CONFIG_DATA = 'core_config_data';
    const ENTITY_MAGE_CUSTOMER = 'customer_entity';
    const ENTITY_MAGE_CUSTOMER_GROUP = 'customer_group';
    const ENTITY_MAGE_PRODUCT = 'catalog_product_entity';
    const ENTITY_MAGE_SALES_ORDER = 'sales_order';
    const ENTITY_MAGE_SALES_ORDER_ITEM = 'sales_order_item';
    const ENTITY_MAGE_TAX_CALC = 'tax_calculation';
    const ENTITY_MAGE_TAX_CALC_RATE = 'tax_calculation_rate';
    const ENTITY_MAGE_TAX_CALC_RULE = 'tax_calculation_rule';
    /**
     * Codifier for entities' attributes.
     * Mage2 has different places to store DB fields info, so accumulate this info in the Config.
     */
    const E_CATCAT_EAV_INT_ATTR_ID = 'attribute_id';
    const E_CATCAT_EAV_INT_STORE_ID = 'store_id';
    const E_CATCAT_EAV_INT_VALUE = 'value';
    const E_CATINV_STOCK_A_STOCK_ID = ModelStock::STOCK_ID;
    const E_CATINV_STOCK_A_STOCK_NAME = ModelStock::STOCK_NAME;
    const E_CATINV_STOCK_A_WEBSITE_ID = 'website_id';
    const E_CATINV_STOCK_ITEM_A_ITEM_ID = 'item_id';
    const E_CATINV_STOCK_ITEM_A_PROD_ID = 'product_id';
    const E_CATINV_STOCK_ITEM_A_STOCK_ID = 'stock_id';
    const E_CATINV_STOCK_STATUS_A_PROD_ID = ModelStockStatus::KEY_PRODUCT_ID;
    const E_CATINV_STOCK_STATUS_A_STOCK_ID = ModelStockStatus::KEY_STOCK_ID;
    const E_CATINV_STOCK_STATUS_A_STOCK_STATUS = ModelStockStatus::KEY_STOCK_STATUS;
    const E_COMMON_A_ENTITY_ID = 'entity_id';
    const E_CONFIG_A_PATH = 'path';
    const E_CONFIG_A_SCOPE = 'scope';
    const E_CONFIG_A_SCOPE_ID = 'scope_id';
    const E_CONFIG_A_VALUE = 'value';
    const E_CUSTGROUP_A_CODE = 'customer_group_code';
    const E_CUSTGROUP_A_ID = 'customer_group_id';
    const E_CUSTGROUP_A_TAX_CLASS_ID = 'tax_class_id';
    const E_CUSTOMER_A_EMAIL = 'email';
    const E_CUSTOMER_A_ENTITY_ID = self::E_COMMON_A_ENTITY_ID;
    const E_CUSTOMER_A_FIRSTNAME = 'firstname';
    const E_CUSTOMER_A_LASTNAME = 'lastname';
    const E_CUSTOMER_A_WEBSITE_ID = 'website_id';
    const E_PRODUCT_A_ATTR_SET_ID = 'attribute_set_id';
    const E_PRODUCT_A_CRETED_AT = 'created_at';
    const E_PRODUCT_A_ENTITY_ID = self::E_COMMON_A_ENTITY_ID;
    const E_PRODUCT_A_HAS_OPTIONS = 'has_options';
    const E_PRODUCT_A_REQUIRED_OPTIONS = 'required_options';
    const E_PRODUCT_A_SKU = 'sku';
    const E_PRODUCT_A_TYPE_ID = 'type_id';
    const E_PRODUCT_A_UPDATED_AT = 'updated_at';
    const E_SALE_ORDER_A_BASE_GRAND_TOTAL = 'base_grand_total';
    const E_SALE_ORDER_A_CREATED_AT = 'created_at';
    const E_SALE_ORDER_A_CUSTOMER_ID = 'customer_id';
    const E_SALE_ORDER_A_ENTITY_ID = self::E_COMMON_A_ENTITY_ID;
    const E_SALE_ORDER_A_UPDATED_AT = 'updated_at';
    const E_SALE_ORDER_ITEM_A_ITEM_ID = ModelOrderItem::ITEM_ID;
    const E_SALE_ORDER_ITEM_A_ORDER_ID = ModelOrderItem::ORDER_ID;
    const E_SALE_ORDER_ITEM_A_PRODUCT_ID = ModelOrderItem::PRODUCT_ID;
    const E_TAX_CALC_A_CUST_TAX_CLASS_ID = 'customer_tax_class_id';
    const E_TAX_CALC_A_ID = 'tax_calculation_id';
    const E_TAX_CALC_A_PROD_TAX_CLASS_ID = 'product_tax_class_id';
    const E_TAX_CALC_A_RATE_ID = 'tax_calculation_rate_id';
    const E_TAX_CALC_A_RULE_ID = 'tax_calculation_rule_id';
    const E_TAX_CALC_RATE_A_ID = 'tax_calculation_rate_id';
    const E_TAX_CALC_RULE_A_ID = 'tax_calculation_rule_id';
    /**
     * other
     */
    const FORMAT_DATETIME = 'Y-m-d H:i:s';
    const MODULE = 'Praxigento_Core';
    const SCOPE_CFG_DEFAULT = \Magento\Config\Block\System\Config\Form::SCOPE_DEFAULT;
    const SCOPE_CFG_STORES = \Magento\Config\Block\System\Config\Form::SCOPE_STORES;
    const SCOPE_CFG_WEBSITE = \Magento\Config\Block\System\Config\Form::SCOPE_WEBSITES;
    const TYPE_PRODUCT_SIMPLE = \Magento\Catalog\Model\Product\Type::TYPE_SIMPLE;
}