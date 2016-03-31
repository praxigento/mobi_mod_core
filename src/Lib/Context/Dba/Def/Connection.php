<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Lib\Context\Dba\Def;

use Praxigento\Core\Lib\Context\Dba\IConnection;

class Connection implements IConnection {

    /** @var \Zend_Db_Adapter_Abstract */
    private $_zend;

    public function __construct(\Zend_Db_Adapter_Abstract $adapter) {
        $this->_zend = $adapter;
    }

    public function beginTransaction() {
        $this->_zend->beginTransaction();
    }

    public function commit() {
        $this->_zend->commit();
    }

    public function fetchAll($sql, $bind = null) {
        $result = $this->_zend->fetchAll($sql, $bind);
        return $result;
    }

    public function fetchOne($sql, $bind = null) {
        $result = $this->_zend->fetchOne($sql, $bind);
        return $result;
    }

    public function fetchRow($sql, $bind = null) {
        $result = $this->_zend->fetchRow($sql, $bind);
        return $result;
    }

    public function rollBack() {
        $this->_zend->rollBack();
    }

    public function select() {
        $select = $this->_zend->select();
        $result = new Select($select);
        return $result;
    }
}