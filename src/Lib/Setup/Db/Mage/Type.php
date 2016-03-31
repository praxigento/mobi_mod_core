<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Setup\Db\Mage;

class Type {
    /**
     * Column types in Magento.
     *
     * M1: \Varien_Db_Ddl_Table::TYPE_...
     * M2: \Magento\Framework\DB\Ddl\Table::TYPE_...
     */

    const COL_BLOB = 'blob';
    const COL_BOOLEAN = 'boolean';
    const COL_DECIMAL = 'decimal';
    const COL_INTEGER = 'integer';
    const COL_SMALLINT = 'smallint';
    const COL_TEXT = 'text';
    const COL_TIMESTAMP = 'timestamp';

    /**
     * Default values for attributes.
     * M1: \Varien_Db_Ddl_Table::TIMESTAMP_INIT
     */

    const DEF_CURRENT_TIMESTAMP = 'TIMESTAMP_INIT';

    /**
     * Index types in Magento.
     *
     * M1: \Varien_Db_Adapter_Interface::INDEX_TYPE_...
     * M2: \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_...
     */

    const INDEX_FULLTEXT = 'fulltext';
    const INDEX_INDEX = 'simple';
    const INDEX_PRIMARY = 'primary';
    const INDEX_UNIQUE = 'unique';

    /**
     * Other options.
     */

    const OPT_AUTO_INC = 'auto_increment';
    const OPT_DEFAULT = 'default';
    const OPT_NULLABLE = 'nullable';
    const OPT_PRECISION = 'precision';
    const OPT_SCALE = 'scale';
    const OPT_TYPE = 'type';
    const OPT_UNSIGNED = 'unsigned';

    /**
     * Foreign key action in the references.
     *
     * M1: \Varien_Db_Adapter_Interface::FK_ACTION_...
     * M1: \Varien_Db_Ddl_Table::ACTION_...
     * M2: \Magento\Framework\DB\Adapter\AdapterInterface::FK_ACTION_...
     * M2: \Magento\Framework\DB\Ddl\Table::ACTION_...
     */

    const REF_ACTION_CASCADE = 'CASCADE';
    const REF_ACTION_NO_ACTION = 'NO ACTION';
    const REF_ACTION_RESTRICT = 'RESTRICT';
}