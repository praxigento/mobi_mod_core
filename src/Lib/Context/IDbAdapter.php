<?php
/**
 * Interface for database adapter implementation.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Lib\Context;


interface IDbAdapter
{
    /**
     * Get default database connector.
     *
     * @return \Praxigento\Core\Lib\Context\Dba\IConnection
     */
    public function getDefaultConnection();

    /**
     * @return  \Mage_Core_Model_Resource|\Magento\Framework\App\ResourceConnection
     */
    public function getResource();

    /**
     * @param $entityName M2 entity name
     *
     * @return string M1 or M2 table name (with prefix) for given entity name.
     */
    public function getTableName($entityName);

}
