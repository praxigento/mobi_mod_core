<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Lib\Context\Dba;

/**
 * Connection adapter (\Magento_Db_Adapter_Pdo_Mysql & \Magento\Framework\DB\Adapter\Pdo\Mysql classes are behind).
 */
interface IConnection {
    
    public function beginTransaction();

    public function commit();

    public function fetchAll($sql, $bind = null);

    public function fetchOne($sql, $bind = null);

    public function fetchRow($sql, $bind = null);

    public function rollBack();

    /**
     * @return ISelect
     */
    public function select();
}