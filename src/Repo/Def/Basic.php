<?php
/**
 * Default implementation for basic repository to do universal operations with data (CRUD).
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;

use Flancer32\Lib\DataObject;
use Praxigento\Core\Repo\IBasic;

class  Basic extends Base implements IBasic
{
    public function addEntity($entity, $bind)
    {
        $result = null;
        $tbl = $this->_conn->getTableName($entity);
        if ($bind instanceof DataObject) {
            $data = $bind->getData();
        } else {
            $data = $bind;
        }
        $rowsAdded = $this->_conn->insert($tbl, $data);
        if ($rowsAdded) {
            $result = $this->_conn->lastInsertId($tbl);
        }
        return $result;
    }

    public function getEntities($entity, $cols = null, $where = null, $order = null, $limit = null, $offset = null)
    {
        $tbl = $this->_conn->getTableName($entity);
        $query = $this->_conn->select();
        if (is_null($cols)) {
            $cols = '*';
        }
        $query->from($tbl, $cols);
        if ($where) {
            $query->where($where);
        }
        if ($order) {
            $query->order($order);
        }
        if ($limit) {
            $query->limit($limit, $offset);
        }
        // $sql = (string)$query;
        $result = $this->_conn->fetchAll($query);
        return $result;
    }

    public function getEntityByPk($entity, $pk, $fields = '*')
    {
        $tbl = $this->_conn->getTableName($entity);
        /* columns to select */
        $cols = ($fields) ? $fields : '*';
        $query = $this->_conn->select();
        $query->from($tbl, $cols);
        foreach ($pk as $field => $value) {
            $query->where("$field=:$field");
        }
        $result = $this->_conn->fetchRow($query, $pk);
        return $result;
    }

    public function replaceEntity($entity, $bind)
    {
        $tbl = $this->_conn->getTableName($entity);
        $keys = array_keys($bind);
        $columns = implode(',', $keys);
        $values = ":" . implode(',:', $keys);
        $query = "REPLACE $tbl ($columns) VALUES ($values)";
        $this->_conn->query($query, $bind);
    }

    public function updateEntity($entity, $bind, $where = null)
    {
        $tbl = $this->_conn->getTableName($entity);
        if ($bind instanceof DataObject) {
            $data = $bind->getData();
        } else {
            $data = $bind;
        }
        $result = $this->_conn->update($tbl, $data, $where);
        return $result;
    }
}