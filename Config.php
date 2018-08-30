<?php
/**
 * Module's configuration (hard-coded).
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core;

use Magento\CatalogInventory\Model\Stock as DStock;
use Magento\CatalogInventory\Model\Stock\Status as DStockStatus;
use Magento\Quote\Api\Data\CartInterface as DCart;
use Magento\Sales\Api\Data\OrderInterface as DSaleOrder;
use Magento\Sales\Api\Data\OrderItemInterface as DOrderItem;

class Config
{
    /** Default alias for main tables in Magento 2 (used in SQL JOINS) */
    const AS_MAIN_TABLE = 'main_table';

    const CODE_CUR_EUR = 'EUR';
    const CODE_CUR_USD = 'USD';

    const DEFAULT_WRITE_RESOURCE = 'core_write';
    /** Customer group code for anonymous customers (we cannot change default code for anonymous group) */
    const DEF_CUST_GROUP_ANON_CODE = 'NOT LOGGED IN';
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
    const ENTITY_MAGE_CATALOGINVENTORY_STOCK = DStock::ENTITY;
    const ENTITY_MAGE_CATALOGINVENTORY_STOCK_ITEM = 'cataloginventory_stock_item';
    const ENTITY_MAGE_CATALOGINVENTORY_STOCK_STATUS = 'cataloginventory_stock_status';
    const ENTITY_MAGE_CATALOG_CATEGORY_EAV_INT = 'catalog_category_entity_int';
    const ENTITY_MAGE_CATALOG_PRODUCT_INDEX_PRICE = 'catalog_product_index_price';
    const ENTITY_MAGE_CATALOG_URL_REWRITE_PRODUCT_CATEGORY = 'catalog_url_rewrite_product_category';
    const ENTITY_MAGE_CORE_CONFIG_DATA = 'core_config_data';
    const ENTITY_MAGE_CUSTOMER = 'customer_entity';
    const ENTITY_MAGE_CUSTOMER_ADDR = 'customer_address_entity';
    const ENTITY_MAGE_CUSTOMER_GROUP = 'customer_group';
    const ENTITY_MAGE_PRODUCT = 'catalog_product_entity';
    const ENTITY_MAGE_QUOTE = 'quote';
    const ENTITY_MAGE_QUOTE_ITEM = 'quote_item';
    const ENTITY_MAGE_SALES_INVOICE = 'sales_invoice';
    const ENTITY_MAGE_SALES_ORDER = 'sales_order';
    const ENTITY_MAGE_SALES_ORDER_GRID = 'sales_order_grid';
    const ENTITY_MAGE_SALES_ORDER_ITEM = 'sales_order_item';
    const ENTITY_MAGE_SALES_ORDER_TAX = 'sales_order_tax';
    const ENTITY_MAGE_SALES_ORDER_TAX_ITEM = 'sales_order_tax_item';
    const ENTITY_MAGE_TAX_CALC = 'tax_calculation';
    const ENTITY_MAGE_TAX_CALC_RATE = 'tax_calculation_rate';
    const ENTITY_MAGE_TAX_CALC_RULE = 'tax_calculation_rule';
    const ENTITY_MAGE_URL_REWRITE = 'url_rewrite';
    /**
     * Codifier for entities' attributes.
     * Mage2 has different places to store DB fields info, so accumulate this info in the Config.
     */
    const E_CATCAT_EAV_INT_A_ID = 'attribute_id';
    const E_CATCAT_EAV_INT_STORE_ID = 'store_id';
    const E_CATCAT_EAV_INT_VALUE = 'value';
    const E_CATINV_STOCK_A_STOCK_ID = DStock::STOCK_ID;
    const E_CATINV_STOCK_A_STOCK_NAME = DStock::STOCK_NAME;
    const E_CATINV_STOCK_A_WEBSITE_ID = 'website_id';
    const E_CATINV_STOCK_ITEM_A_ITEM_ID = 'item_id';
    const E_CATINV_STOCK_ITEM_A_PROD_ID = 'product_id';
    const E_CATINV_STOCK_ITEM_A_QTY = 'qty';
    const E_CATINV_STOCK_ITEM_A_STOCK_ID = 'stock_id';
    const E_CATINV_STOCK_STATUS_A_PROD_ID = DStockStatus::KEY_PRODUCT_ID;
    const E_CATINV_STOCK_STATUS_A_QTY = DStockStatus::KEY_QTY;
    const E_CATINV_STOCK_STATUS_A_STOCK_ID = DStockStatus::KEY_STOCK_ID;
    const E_CATINV_STOCK_STATUS_A_STOCK_STATUS = DStockStatus::KEY_STOCK_STATUS;
    const E_CATPROD_IDX_PRICE_A_CUST_GROUP_ID = 'customer_group_id';
    const E_CAT_URL_REWRITE_PROD_CAT_A_CATEGORY_ID = 'category_id';
    const E_CAT_URL_REWRITE_PROD_CAT_A_PRODUCT_ID = 'product_id';
    const E_COMMON_A_ENTITY_ID = 'entity_id';
    const E_CONFIG_A_PATH = 'path';
    const E_CONFIG_A_SCOPE = 'scope';
    const E_CONFIG_A_SCOPE_ID = 'scope_id';
    const E_CONFIG_A_VALUE = 'value';
    const E_CUSTADDR_A_CITY = 'city';
    const E_CUSTADDR_A_COMPANY = 'company';
    const E_CUSTADDR_A_COUNTRY_ID = 'country_id';
    const E_CUSTADDR_A_ENTITY_ID = self::E_COMMON_A_ENTITY_ID;
    const E_CUSTADDR_A_FAX = 'fax';
    const E_CUSTADDR_A_FIRSTNAME = 'firstname';
    const E_CUSTADDR_A_LASTNAME = 'lastname';
    const E_CUSTADDR_A_PARENT_ID = 'parent_id';
    const E_CUSTADDR_A_POSTCODE = 'postcode';
    const E_CUSTADDR_A_STREET = 'street';
    const E_CUSTADDR_A_TELEPHONE = 'telephone';
    const E_CUSTGROUP_A_CODE = 'customer_group_code';
    const E_CUSTGROUP_A_ID = 'customer_group_id';
    const E_CUSTGROUP_A_TAX_CLASS_ID = 'tax_class_id';
    const E_CUSTOMER_A_CREATED_AT = 'created_at';
    const E_CUSTOMER_A_DEF_BILLING = 'default_billing';
    const E_CUSTOMER_A_DEF_SHIPPING = 'default_shipping';
    const E_CUSTOMER_A_DOB = 'dob';
    const E_CUSTOMER_A_EMAIL = 'email';
    const E_CUSTOMER_A_ENTITY_ID = self::E_COMMON_A_ENTITY_ID;
    const E_CUSTOMER_A_FIRSTNAME = 'firstname';
    const E_CUSTOMER_A_GENDER = 'gender';
    const E_CUSTOMER_A_GROUP_ID = 'group_id';
    const E_CUSTOMER_A_LASTNAME = 'lastname';
    const E_CUSTOMER_A_MIDDLENAME = 'middlename';
    const E_CUSTOMER_A_PASS_HASH = 'password_hash';
    const E_CUSTOMER_A_STORE_ID = 'store_id';
    const E_CUSTOMER_A_WEBSITE_ID = 'website_id';
    const E_PRODUCT_A_A_SET_ID = 'attribute_set_id';
    const E_PRODUCT_A_CRETED_AT = 'created_at';
    const E_PRODUCT_A_ENTITY_ID = self::E_COMMON_A_ENTITY_ID;
    const E_PRODUCT_A_HAS_OPTIONS = 'has_options';
    const E_PRODUCT_A_REQUIRED_OPTIONS = 'required_options';
    const E_PRODUCT_A_SKU = 'sku';
    const E_PRODUCT_A_TYPE_ID = 'type_id';
    const E_PRODUCT_A_UPDATED_AT = 'updated_at';
    const E_QUOTE_A_CUSTOMER_ID = 'customer_id';
    const E_QUOTE_A_ENTITY_ID = DCart::KEY_ENTITY_ID;
    const E_QUOTE_A_IS_ACTIVE = DCart::KEY_IS_ACTIVE;
    const E_QUOTE_A_STORE_ID = DCart::KEY_STORE_ID;
    const E_QUOTE_ITEM_A_ITEM_ID = 'item_id';
    const E_QUOTE_ITEM_A_QUOTE_ID = 'quote_id';
    const E_QUOTE_ITEM_A_STORE_ID = 'store_id';
    const E_SALE_INVOICE_A_CREATED_AT = 'created_at';
    const E_SALE_INVOICE_A_ORDER_ID = 'order_id';
    const E_SALE_INVOICE_A_STATE = 'state';
    const E_SALE_ORDER_A_APPLIED_RULE_IDS = DSaleOrder::APPLIED_RULE_IDS;
    const E_SALE_ORDER_A_BASE_GRAND_TOTAL = DSaleOrder::BASE_GRAND_TOTAL;
    const E_SALE_ORDER_A_CREATED_AT = DSaleOrder::CREATED_AT;
    const E_SALE_ORDER_A_CUSTOMER_ID = DSaleOrder::CUSTOMER_ID;
    const E_SALE_ORDER_A_ENTITY_ID = DSaleOrder::ENTITY_ID;
    const E_SALE_ORDER_A_INCREMENT_ID = DSaleOrder::INCREMENT_ID;
    const E_SALE_ORDER_A_QUOTE_ID = DSaleOrder::QUOTE_ID;
    const E_SALE_ORDER_A_STATE = DSaleOrder::STATE;
    const E_SALE_ORDER_A_UPDATED_AT = DSaleOrder::UPDATED_AT;
    const E_SALE_ORDER_GRID_A_ENTITY_ID = self::E_COMMON_A_ENTITY_ID;
    const E_SALE_ORDER_ITEM_A_BASE_PRICE = DOrderItem::BASE_PRICE;
    const E_SALE_ORDER_ITEM_A_BASE_ROW_TOTAL_INCL_TAX = DOrderItem::BASE_ROW_TOTAL_INCL_TAX;
    const E_SALE_ORDER_ITEM_A_ITEM_ID = DOrderItem::ITEM_ID;
    const E_SALE_ORDER_ITEM_A_ORDER_ID = DOrderItem::ORDER_ID;
    const E_SALE_ORDER_ITEM_A_PRODUCT_ID = DOrderItem::PRODUCT_ID;
    const E_SALE_ORDER_ITEM_A_QTY_ORDERED = DOrderItem::QTY_ORDERED;
    const E_SALE_ORDER_ITEM_A_SKU = DOrderItem::SKU;
    const E_SALE_ORDER_ITEM_A_TAX_PERCENT = DOrderItem::TAX_PERCENT;
    const E_SALE_ORDER_TAX_A_AMOUNT = 'amount';
    const E_SALE_ORDER_TAX_A_BASE_AMOUNT = 'base_amount';
    const E_SALE_ORDER_TAX_A_BASE_REAL_AMOUNT = 'base_real_amount';
    const E_SALE_ORDER_TAX_A_CODE = 'code';
    const E_SALE_ORDER_TAX_A_ORDER_ID = 'order_id';
    const E_SALE_ORDER_TAX_A_PERCENT = 'percent';
    const E_SALE_ORDER_TAX_A_POSITION = 'position';
    const E_SALE_ORDER_TAX_A_PRIORITY = 'priority';
    const E_SALE_ORDER_TAX_A_PROCESS = 'process';
    const E_SALE_ORDER_TAX_A_TAX_ID = 'tax_id';
    const E_SALE_ORDER_TAX_A_TITLE = 'title';
    const E_SALE_ORDER_TAX_ITEM_A_AMOUNT = 'amount';
    const E_SALE_ORDER_TAX_ITEM_A_ASSOCIATED_ITEM_ID = 'associated_item_id';
    const E_SALE_ORDER_TAX_ITEM_A_BASE_AMOUNT = 'base_amount';
    const E_SALE_ORDER_TAX_ITEM_A_ITEM_ID = 'item_id';
    const E_SALE_ORDER_TAX_ITEM_A_REAL_AMOUNT = 'real_amount';
    const E_SALE_ORDER_TAX_ITEM_A_REAL_BASE_AMOUNT = 'real_base_amount';
    const E_SALE_ORDER_TAX_ITEM_A_TAXABLE_ITEM_TYPE = 'taxable_item_type';
    const E_SALE_ORDER_TAX_ITEM_A_TAX_ID = 'tax_id';
    const E_SALE_ORDER_TAX_ITEM_A_TAX_ITEM_ID = 'tax_item_id';
    const E_SALE_ORDER_TAX_ITEM_A_TAX_PERCENT = 'tax_percent';
    const E_TAX_CALC_A_CUST_TAX_CLASS_ID = 'customer_tax_class_id';
    const E_TAX_CALC_A_ID = 'tax_calculation_id';
    const E_TAX_CALC_A_PRODUCT_TAX_CLASS_ID = 'product_tax_class_id';
    const E_TAX_CALC_A_PROD_TAX_CLASS_ID = 'product_tax_class_id';
    const E_TAX_CALC_A_RATE_ID = 'tax_calculation_rate_id';
    const E_TAX_CALC_A_RULE_ID = 'tax_calculation_rule_id';
    const E_TAX_CALC_A_TAX_CALCULATION_RATE_ID = 'tax_calculation_rate_id';
    const E_TAX_CALC_A_TAX_CALCULATION_RULE_ID = 'tax_calculation_rule_id';
    const E_TAX_CALC_RATE_A_CODE = 'code';
    const E_TAX_CALC_RATE_A_COUNTRY_ID = 'tax_country_id';
    const E_TAX_CALC_RATE_A_ID = 'tax_calculation_rate_id';
    const E_TAX_CALC_RATE_A_POSTCODE = 'tax_postcode';
    const E_TAX_CALC_RATE_A_RATE = 'rate';
    const E_TAX_CALC_RATE_A_REGION_ID = 'tax_region_id';
    const E_TAX_CALC_RATE_A_ZIP_FROM = 'zip_from';
    const E_TAX_CALC_RATE_A_ZIP_IS_RANGE = 'zip_is_range';
    const E_TAX_CALC_RATE_A_ZIP_TO = 'zip_to';
    const E_TAX_CALC_RULE_A_CALC_SUBTOTAL = 'calculate_subtotal';
    const E_TAX_CALC_RULE_A_CODE = 'code';
    const E_TAX_CALC_RULE_A_ID = 'tax_calculation_rule_id';
    const E_TAX_CALC_RULE_A_POSITION = 'position';
    const E_TAX_CALC_RULE_A_PRIORITY = 'priority';
    const E_URL_REWRITE_A_ENTITY_ID = 'entity_id';
    const E_URL_REWRITE_A_ENTITY_TYPE = 'entity_type';
    const E_URL_REWRITE_A_REQUEST_PATH = 'request_path';
    /**
     * other
     */
    const FORMAT_DATETIME = 'Y-m-d H:i:s';
    const MODULE = 'Praxigento_Core';
    const REG_REST_INPUT = 'prxgtRestInput';
    const SCOPE_CFG_DEFAULT = \Magento\Config\Block\System\Config\Form::SCOPE_DEFAULT;
    const SCOPE_CFG_STORES = \Magento\Config\Block\System\Config\Form::SCOPE_STORES;
    const SCOPE_CFG_WEBSITE = \Magento\Config\Block\System\Config\Form::SCOPE_WEBSITES;
    const TYPE_PRODUCT_SIMPLE = \Magento\Catalog\Model\Product\Type::TYPE_SIMPLE;
}