<?php
/**
 * Base class to create initial database data in MOBI common modules.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Setup\Data;


abstract class Base implements \Praxigento\Core\Lib\Setup\IData {
    /** @var  \Praxigento\Core\Lib\Context\IDbAdapter */
    protected $_dba;

    /**
     * Data constructor.
     */
    public function __construct(
        \Praxigento\Core\Lib\Context\IDbAdapter $dba
    ) {
        $this->_dba = $dba;
    }

    protected function _getConn() {
        return $this->_dba->getDefaultConnection();
    }

    protected function _getTableName($entityName) {
        $result = $this->_dba->getTableName($entityName);
        return $result;
    }
}