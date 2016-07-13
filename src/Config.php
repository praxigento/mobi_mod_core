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
    const DEF_WEBSITE_ID_ADMIN = 0; // default '0' to use in floats comparison: ($val>Cfg::DEF_ZERO) instead of "($val>0)"
    /** Default 'base' website ID for empty Magento instance */
    const DEF_WEBSITE_ID_BASE = 1;
    const DEF_ZERO = 0.000001;
    /**
     * Path separator for nodes to address package in DEM.
     */
    const DEM_PS = '/';
    /**
     * Magento entities as defined in version 2.
     */
    const ENTITY_MAGE_CATALOGINVENTORY_STOCK = ModelStock::ENTITY;
    const ENTITY_MAGE_CATALOGINVENTORY_STOCK_ITEM = 'cataloginventory_stock_item';
    const ENTITY_MAGE_CATALOGINVENTORY_STOCK_STATUS = 'cataloginventory_stock_status';
    const ENTITY_MAGE_CATALOG_CATEGORY_EAV_INT = 'catalog_category_entity_int';
    const ENTITY_MAGE_CUSTOMER = 'customer_entity';
    const ENTITY_MAGE_PRODUCT = 'catalog_product_entity';
    const ENTITY_MAGE_SALES_ORDER = 'sales_order';
    const ENTITY_MAGE_SALES_ORDER_ITEM = 'sales_order_item';
    /**
     * Codifier for entities' attributes.
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
    const E_CUSTOMER_A_EMAIL = 'email';
    const E_CUSTOMER_A_ENTITY_ID = self::E_COMMON_A_ENTITY_ID;
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
    /** @deprecated Use ModelOrderItem::... directly where it is possible */
    const E_SALE_ORDER_ITEM_A_ITEM_ID = ModelOrderItem::ITEM_ID;
    const E_SALE_ORDER_ITEM_A_ORDER_ID = ModelOrderItem::ORDER_ID;
    const E_SALE_ORDER_ITEM_A_PRODUCT_ID = ModelOrderItem::PRODUCT_ID;

    /**
     * other
     */
    const FORMAT_DATETIME = 'Y-m-d H:i:s';
    const MODULE = 'Praxigento_Core';

    /* \Magento\Catalog\Model\Product\Type::TYPE_SIMPLE */
    const TYPE_PRODUCT_SIMPLE = 'simple';
}