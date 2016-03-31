<?php
/**
 * Base class for module's repositories implementations.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Repo;

class  Base implements IModule {
    /** @var IBasic */
    protected $_repoBasic;

    public function __construct(
        IBasic $repoBasic
    ) {
        $this->_repoBasic = $repoBasic;
    }

    /**
     * Decorator for DBA method (shortcut).
     * Previous return was: \Magento\Framework\DB\Adapter\Pdo\Mysql|\Magento_Db_Adapter_Pdo_Mysql
     *
     * @return \Praxigento\Core\Lib\Context\Dba\IConnection
     */
    protected function _getConn() {
        return $this->_repoBasic->getDba()->getDefaultConnection();
    }

    /**
     * Decorator for DBA method (shortcut).
     *
     * @param string $entityName 'prxgt_mod_entity'
     *
     * @return string 'm1_prxgt_mod_entity' table name (with prefix or M1 analog for M2 name - sales_flat_order
     * & sales_order).
     */
    protected function _getTableName($entityName) {
        $result = $this->_repoBasic->getDba()->getTableName($entityName);
        return $result;
    }

    /**
     * Access to basic repository,
     *
     * @return IBasic
     */
    public function getBasicRepo() {
        return $this->_repoBasic;
    }
}