<?php
/**
 * Core service to perform common DB operations.
 * This service does NOT extend \Praxigento\Core\Lib\Service\Base\Call
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Lib\Service\Repo;

use Praxigento\Core\Lib\Context;

class Call
    implements \Praxigento\Core\Lib\Service\IRepo {
    /** @var  \Praxigento\Core\Lib\Context\IDbAdapter */
    protected $_dba;
    /** @var \Psr\Log\LoggerInterface */
    protected $_logger;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Praxigento\Core\Lib\Context\IDbAdapter $dba
    ) {
        $this->_logger = $logger;
        $this->_dba = $dba;
    }

    protected function _getConn() {
        return $this->_dba->getDefaultConnection();
    }

    protected function _getTableName($entityName) {
        $result = $this->_dba->getTableName($entityName);
        return $result;
    }

    /**
     * @param Request\AddEntity $request
     *
     * @return Response\AddEntity
     */
    public function addEntity(Request\AddEntity $request) {
        $result = new Response\AddEntity();
        $entity = $request->getData(Request\AddEntity::ENTITY);
        $bind = $request->getData(Request\AddEntity::BIND);
        $entityName = Context::getMappedEntityName($entity);
        $tbl = $this->_getTableName($entityName);
        $this->_logger->debug("Add new instance to '$entityName (" . var_export($bind, true) . ").");
        $rowsAdded = $this->_getConn()->insert($tbl, $bind);
        if($rowsAdded) {
            $id = $this->_getConn()->lastInsertId($tbl);
            $result->setData([ Response\AddEntity::ID_INSERTED => $id ]);
            $result->setAsSucceed();
        }
        return $result;
    }

    /**
     * Get one type entities (from one table).
     *
     * @param Request\GetEntities $request
     *
     * @return Response\GetEntities
     */
    public function getEntities(Request\GetEntities $request) {
        $result = new Response\GetEntities();
        $entity = $request->getData(Request\GetEntities::ENTITY);
        $cols = $request->getData(Request\GetEntities::FIELDS);
        $where = $request->getData(Request\GetEntities::WHERE);
        $order = $request->getData(Request\GetEntities::ORDER);
        $limit = $request->getData(Request\GetEntities::LIMIT);
        $entityName = Context::getMappedEntityName($entity);
        $tbl = $this->_getTableName($entityName);
        $query = $this->_getConn()->select();
        $query->from($tbl, $cols);
        if($where) {
            $query->where($where);
        }
        if($order) {
            $query->order($order);
        }
        if($limit) {
            $query->limit($limit);
        }
        // $sql = (string)$query;
        $data = $this->_getConn()->fetchAll($query);
        if($data !== false) {
            $result->setData($data);
            $result->setAsSucceed();
        }
        return $result;
    }

    /**
     * Select entity by primary key (PK).
     *
     * @param Request\GetEntityByPk $request
     *
     * @return Response\GetEntityByPk
     */
    public function getEntityByPk(Request\GetEntityByPk $request) {
        $result = new Response\GetEntityByPk();
        $entity = $request->getData(Request\GetEntityByPk::ENTITY);
        $pk = $request->getData(Request\GetEntityByPk::PK);
        $fields = $request->getData(Request\GetEntityByPk::FIELDS);
        $as = 'a';
        $entityName = Context::getMappedEntityName($entity);
        $tbl = $this->_getTableName($entityName);
        /* columns to select */
        $cols = ($fields) ? $fields : '*';
        $query = $this->_getConn()->select();
        $query->from([ $as => $tbl ], $cols);
        foreach($pk as $field => $value) {
            $query->where("$as.$field=:$field");
        }
        $data = $this->_getConn()->fetchRow($query, $pk);
        if($data) {
            $result->setData($data);
            $result->setAsSucceed();
        }
        return $result;
    }

    /**
     * @param Request\ReplaceEntity $request
     *
     * @return Response\ReplaceEntity
     */
    public function replaceEntity(Request\ReplaceEntity $request) {
        $result = new Response\ReplaceEntity();
        $entity = $request->getData(Request\ReplaceEntity::ENTITY);
        $bind = $request->getData(Request\ReplaceEntity::BIND);
        $entityName = Context::getMappedEntityName($entity);
        $tbl = $this->_getTableName($entityName);
        $keys = array_keys($bind);
        $columns = implode(',', $keys);
        $values = ":" . implode(',:', $keys);
        $query = "REPLACE $tbl ($columns) VALUES ($values)";
        $this->_getConn()->query($query, $bind);
        $result->setAsSucceed();
        return $result;
    }

    /**
     * @param Request\UpdateEntity $request
     *
     * @return Response\UpdateEntity
     */
    public function updateEntity(Request\UpdateEntity $request) {
        $result = new Response\UpdateEntity();
        $entity = $request->getEntity();
        $bind = $request->getBind();
        $where = $request->getWhere();
        $entityName = Context::getMappedEntityName($entity);
        $tbl = $this->_getTableName($entityName);
        $rowsUpdated = $this->_getConn()->update($tbl, $bind, $where);
        $result->setData([ Response\UpdateEntity::ROWS_UPDATED => $rowsUpdated ]);
        $result->setAsSucceed();
        return $result;
    }
}