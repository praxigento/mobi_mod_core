<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Context\Dba\Def;

use Praxigento\Core\Lib\Context\Dba\ISelect;

class Select implements ISelect {
    const SQL_WILDCARD = '*';
    /** @var \Zend_Db_Select */
    private $_zend;

    public function __construct(\Zend_Db_Select $adapter) {
        $this->_zend = $adapter;
    }

    public function from($name, $cols = self::SQL_WILDCARD) {
        $this->_zend->from($name, $cols);
    }

    public function group($spec) {
        $this->_zend->group($spec);
    }

    public function joinLeft($name, $cond, $cols = self::SQL_WILDCARD) {
        $this->_zend->joinLeft($name, $cond, $cols);
    }

    public function limit($count, $offset = null) {
        $this->_zend->limit($count, $offset);
    }

    public function order($spec) {
        $this->_zend->order($spec);
    }

    public function where($cond, $value = null) {
        $this->_zend->where($cond, $value);
    }
}