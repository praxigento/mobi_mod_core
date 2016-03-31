<?php
/**
 * Default implementation for basic repository to do universal operations with data (CRUD).
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Repo\Def;

use Flancer32\Lib\DataObject;
use Praxigento\Core\Lib\Context;
use Praxigento\Core\Lib\Repo\IBasic;

class  Basic implements IBasic {
    /** @var \Praxigento\Core\Lib\Context\IDbAdapter */
    protected $_dba;

    public function __construct(
        \Praxigento\Core\Lib\Context\IDbAdapter $dba
    ) {
        $this->_dba = $dba;
    }

    private function _getConn() {
        return $this->_dba->getDefaultConnection();
    }

    private function _getTableName($entityName) {
        $result = $this->_dba->getTableName($entityName);
        return $result;
    }

    public function addEntity($entity, $bind) {
        $result = null;
        $entityName = Context::getMappedEntityName($entity);
        $tbl = $this->_getTableName($entityName);
        if($bind instanceof DataObject) {
            $data = $bind->getData();
        } else {
            $data = $bind;
        }
        $rowsAdded = $this->_getConn()->insert($tbl, $data);
        if($rowsAdded) {
            $result = $this->_getConn()->lastInsertId($tbl);
        }
        return $result;
    }

    /**
     * @return Context\IDbAdapter
     */
    public function getDba() {
        return $this->_dba;
    }

    public function getEntities($entity, $cols = null, $where = null, $order = null, $limit = null, $offset = null) {
        $entityName = Context::getMappedEntityName($entity);
        $tbl = $this->_getTableName($entityName);
        $query = $this->_getConn()->select();
        if(is_null($cols)) {
            $cols = '*';
        }
        $query->from($tbl, $cols);
        if($where) {
            $query->where($where);
        }
        if($order) {
            $query->order($order);
        }
        if($limit) {
            $query->limit($limit, $offset);
        }
        // $sql = (string)$query;
        $result = $this->_getConn()->fetchAll($query);
        return $result;
    }

    public function getEntityByPk($entity, $pk, $fields = '*') {
        $entityName = Context::getMappedEntityName($entity);
        $tbl = $this->_getTableName($entityName);
        /* columns to select */
        $cols = ($fields) ? $fields : '*';
        $conn = $this->_getConn();
        $query = $conn->select();
        $query->from($tbl, $cols);
        foreach($pk as $field => $value) {
            $query->where("$field=:$field");
        }
        $result = $conn->fetchRow($query, $pk);
        return $result;
    }

    public function replaceEntity($entity, $bind) {
        $entityName = Context::getMappedEntityName($entity);
        $tbl = $this->_getTableName($entityName);
        $keys = array_keys($bind);
        $columns = implode(',', $keys);
        $values = ":" . implode(',:', $keys);
        $query = "REPLACE $tbl ($columns) VALUES ($values)";
        $this->_getConn()->query($query, $bind);
    }

    public function updateEntity($entity, $bind, $where = null) {
        $entityName = Context::getMappedEntityName($entity);
        $tbl = $this->_getTableName($entityName);
        if($bind instanceof DataObject) {
            $data = $bind->getData();
        } else {
            $data = $bind;
        }
        $result = $this->_getConn()->update($tbl, $data, $where);
        return $result;
    }
}