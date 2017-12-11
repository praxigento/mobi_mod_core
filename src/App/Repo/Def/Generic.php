<?php
/**
 * Default implementation for generic repository to do universal operations with data (CRUD).
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\App\Repo\Def;

use Praxigento\Core\Data as DataObject;

class  Generic
    extends \Praxigento\Core\App\Repo\Def\Db
    implements \Praxigento\Core\App\Repo\IGeneric
{

    public function addEntity($entity, $bind)
    {
        $result = null;
        $tbl = $this->resource->getTableName($entity);
        if ($bind instanceof DataObject) {
            $data = (array)$bind->get();
        } elseif ($bind instanceof \stdClass) {
            $data = (array)$bind;
        } else {
            $data = $bind;
        }
        $rowsAdded = $this->conn->insert($tbl, $data);
        if ($rowsAdded) {
            $result = $this->conn->lastInsertId($tbl);
        }
        return $result;
    }

    public function deleteEntity($entity, $where = null)
    {
        $tbl = $this->resource->getTableName($entity);
        $result = $this->conn->delete($tbl, $where);
        return $result;
    }

    /**
     * @inheritdoc
     *
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function deleteEntityByPk($entity, $pk)
    {
        $tbl = $this->resource->getTableName($entity);
        $where = [];
        foreach ($pk as $field => $value) {
            $where["$field=?"] = $value;
        }
        $result = $this->conn->delete($tbl, $where);
        return $result;
    }

    public function getEntities($entity, $cols = null, $where = null, $order = null, $limit = null, $offset = null)
    {
        $tbl = $this->resource->getTableName($entity);
        $query = $this->conn->select();
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
        $result = $this->conn->fetchAll($query);
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
        $tbl = $this->resource->getTableName($entity);
        /* columns to select */
        $cols = ($cols) ? $cols : '*';
        $query = $this->conn->select();
        $query->from($tbl, $cols);
        foreach (array_keys($pk) as $field) {
            $query->where("$field=:$field");
        }
        $result = $this->conn->fetchRow($query, $pk);
        return $result;
    }

    public function replaceEntity($entity, $bind)
    {
        $tbl = $this->resource->getTableName($entity);
        $keys = array_keys($bind);
        $columns = implode(',', $keys);
        $values = ":" . implode(',:', $keys);
        $query = "REPLACE $tbl ($columns) VALUES ($values)";
        $this->conn->query($query, $bind);
        $result = $this->conn->lastInsertId($tbl);
        return $result;
    }

    public function updateEntity($entity, $bind, $where = null)
    {
        $tbl = $this->resource->getTableName($entity);
        if ($bind instanceof DataObject) {
            $data = (array)$bind->get();
        } else {
            $data = (array)$bind;
        }
        $result = $this->conn->update($tbl, $data, $where);
        return $result;
    }

    /**
     * @inheritdoc
     *
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function updateEntityById($entity, $bind, $id)
    {
        $tbl = $this->resource->getTableName($entity);
        if ($bind instanceof DataObject) {
            $data = $bind->get();
        } else {
            $data = $bind;
        }
        $where = '1';
        foreach ($id as $field => $value) {
            $where .= " AND $field=" . $this->conn->quote($value);
        }
        $result = $this->conn->update($tbl, $data, $where);
        return $result;
    }
}