<?php
/**
 * Default implementation for basic repository to do universal operations with data (CRUD).
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Repo\Def;

use Flancer32\Lib\DataObject;
use Praxigento\Core\Lib\Context;
use Praxigento\Core\Lib\Repo\IBasic;

class  Basic implements IBasic
{
    /** @var \Magento\Framework\App\ResourceConnection */
    protected $_resourceConnection;
    /** @var  \Magento\Framework\DB\Adapter\AdapterInterface */
    protected $_dba;

    public function __construct(
        \Magento\Framework\App\ResourceConnection $resourceConnection
    ) {
        $this->_resourceConnection = $resourceConnection;
        $this->_dba = $resourceConnection->getConnection();
    }

    public function addEntity($entity, $bind)
    {
        $result = null;
        $tbl = $this->_dba->getTableName($entity);
        if ($bind instanceof DataObject) {
            $data = $bind->getData();
        } else {
            $data = $bind;
        }
        $rowsAdded = $this->_dba->insert($tbl, $data);
        if ($rowsAdded) {
            $result = $this->_dba->lastInsertId($tbl);
        }
        return $result;
    }

    public function getEntities($entity, $cols = null, $where = null, $order = null, $limit = null, $offset = null)
    {
        $tbl = $this->_dba->getTableName($entity);
        $query = $this->_dba->select();
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
        $result = $this->_dba->fetchAll($query);
        return $result;
    }

    public function getEntityByPk($entity, $pk, $fields = '*')
    {
        $tbl = $this->_dba->getTableName($entity);
        /* columns to select */
        $cols = ($fields) ? $fields : '*';
        $query = $this->_dba->select();
        $query->from($tbl, $cols);
        foreach ($pk as $field => $value) {
            $query->where("$field=:$field");
        }
        $result = $this->_dba->fetchRow($query, $pk);
        return $result;
    }

    public function replaceEntity($entity, $bind)
    {
        $tbl = $this->_dba->getTableName($entity);
        $keys = array_keys($bind);
        $columns = implode(',', $keys);
        $values = ":" . implode(',:', $keys);
        $query = "REPLACE $tbl ($columns) VALUES ($values)";
        $this->_dba->query($query, $bind);
    }

    public function updateEntity($entity, $bind, $where = null)
    {
        $tbl = $this->_dba->getTableName($entity);
        if ($bind instanceof DataObject) {
            $data = $bind->getData();
        } else {
            $data = $bind;
        }
        $result = $this->_dba->update($tbl, $data, $where);
        return $result;
    }
}