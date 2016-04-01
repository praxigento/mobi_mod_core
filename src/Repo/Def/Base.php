<?php
/**
 * Base class for repositories implementations.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;

abstract class Base
{
    /** @var \Magento\Framework\App\ResourceConnection */
    protected $_resourceConnection;
    /** @var  \Magento\Framework\DB\Adapter\AdapterInterface */
    protected $_dba;

    public function __construct(
        \Magento\Framework\App\ResourceConnection $rsrcConn
    ) {
        $this->_resourceConnection = $rsrcConn;
        $this->_dba = $rsrcConn->getConnection();
    }

    /**
     * Decorator for DBA method (shortcut).
     *
     * @return \Magento\Framework\DB\Adapter\AdapterInterface
     * @deprecated use $this->_dba directly
     */
    protected function _getConn()
    {
        return $this->_dba;
    }

    /**
     * Decorator for DBA method (shortcut).
     *
     * @param string $entityName 'prxgt_mod_entity'
     *
     * @return string 'm1_prxgt_mod_entity' table name (with prefix or M1 analog for M2 name - sales_flat_order
     * & sales_order).
     * @deprecated use $this->_dba->getTableName() directly
     */
    protected function _getTableName($entityName)
    {
        $result = $this->_dba->getTableName($entityName);
        return $result;
    }

}