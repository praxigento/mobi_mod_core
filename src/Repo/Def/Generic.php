<?php
/**
 * Default implementation for generic repository to do universal operations with data (CRUD).
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;

use Flancer32\Lib\DataObject;

class  Generic
    extends \Praxigento\Core\Repo\Def\Db
    implements \Praxigento\Core\Repo\IGeneric
{

    public function addEntity($entity, $bind)
    {
        $result = null;
        $tbl = $this->_resource->getTableName($entity);
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

    public function deleteEntity($entity, $where)
    {
        $tbl = $this->_resource->getTableName($entity);
        $result = $this->_conn->delete($tbl, $where);
        return $result;
    }

    /**
     * @inheritdoc
     *
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function deleteEntityByPk($entity, $pk)
    {
        $tbl = $this->_resource->getTableName($entity);
        $where = [];
        foreach ($pk as $field => $value) {
            $where["$field=?"] = $value;
        }
        $result = $this->_conn->delete($tbl, $where);
        return $result;
    }

    public function getEntities($entity, $cols = null, $where = null, $order = null, $limit = null, $offset = null)
    {
        $tbl = $this->_resource->getTableName($entity);
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
        $result = $this->_conn->fetchAll($query);
        return $result;
    }

    /**
     * @inheritdoc
     *
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function getEntityByPk($entity, $pk, $cols = null)
    {
        // TODO: rename PK to ID
        $tbl = $this->_resource->getTableName($entity);
        /* columns to select */
        $cols = ($cols) ? $cols : '*';
        $query = $this->_conn->select();
        $query->from($tbl, $cols);
        foreach (array_keys($pk) as $field) {
            $query->where("$field=:$field");
        }
        $result = $this->_conn->fetchRow($query, $pk);
        return $result;
    }

    public function replaceEntity($entity, $bind)
    {
        $tbl = $this->_resource->getTableName($entity);
        $keys = array_keys($bind);
        $columns = implode(',', $keys);
        $values = ":" . implode(',:', $keys);
        $query = "REPLACE $tbl ($columns) VALUES ($values)";
        $this->_conn->query($query, $bind);
        $result = $this->_conn->lastInsertId($tbl);
        return $result;
    }

    public function updateEntity($entity, $bind, $where = null)
    {
        $tbl = $this->_resource->getTableName($entity);
        if ($bind instanceof DataObject) {
            $data = $bind->getData();
        } else {
            $data = $bind;
        }
        $result = $this->_conn->update($tbl, $data, $where);
        return $result;
    }

    /**
     * @inheritdoc
     *
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function updateEntityById($entity, $bind, $id)
    {
        $tbl = $this->_resource->getTableName($entity);
        if ($bind instanceof DataObject) {
            $data = $bind->getData();
        } else {
            $data = $bind;
        }
        $where = '1';
        foreach ($id as $field => $value) {
            $where .= " AND $field=" . $this->_conn->quote($value);
        }
        $result = $this->_conn->update($tbl, $data, $where);
        return $result;
    }
}