<?php
/**
 * Common interface for:
 *  - Mage_Core_Model_Resource
 *  - Magento\Framework\App\ResourceConnection
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Lib\Context;


interface IResource {

    const DEFAULT_READ_RESOURCE = 'core_read';

    const DEFAULT_WRITE_RESOURCE = 'core_write';

    /**
     * @param        $modelEntity
     * @param string $connectionName
     *
     * @return string
     */
    public function getTableName($modelEntity, $connectionName = self::DEFAULT_READ_RESOURCE);

    /**
     * @param string $resourceName
     *
     * @rreturn \Magento\Framework\DB\Adapter\Pdo\Mysql
     * @return \Magento_Db_Adapter_Pdo_Mysql
     */
    public function getConnection($resourceName = 'default');
}
