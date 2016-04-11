<?php
/**
 * Default implementation for entity repository to do universal operations with specific entity data (CRUD).
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;

use Praxigento\Core\Data\IEntity as IDataEntity;
use Praxigento\Core\Repo\IEntity;

class Entity implements IEntity
{
    /** @var  string */
    protected $_entityName;
    /** @var  string */
    protected $_idFieldName;
    /** @var  IDataEntity */
    protected $_refEntity;
    /** @var \Praxigento\Core\Repo\IBasic */
    protected $_repoBasic;

    /**
     * Basic constructor.
     */
    public function __construct(
        \Praxigento\Core\Repo\IBasic $repoBasic,
        IDataEntity $entity
    ) {
        $this->_repoBasic = $repoBasic;
        $this->_refEntity = $entity;
        $this->_entityName = $entity->getEntityName();
        $ids = $entity->getPrimaryKeyAttrs();
        $this->_idFieldName = reset($ids);
    }

    public function create($data)
    {
        $result = $this->_repoBasic->addEntity($this->_entityName, $data);
        return $result;
    }

    public function getById($id)
    {
        if (is_array($id)) {
            /* probably this is complex PK */
            $pk = $id;
        } else {
            $pk = [$this->_idFieldName => $id];
        }
        $result = $this->_repoBasic->getEntityByPk($this->_entityName, $pk);
        return $result;
    }

    public function getRef()
    {
        return $this->_refEntity;
    }

    public function update($data, $id)
    {
        if (is_array($id)) {
            /* probably this is complex PK */
            $where = '';
            foreach ($id as $key => $value) {
                $where = "($key=$value) AND ";
            }
            $where .= '1'; // WHERE ... AND 1;
        } else {
            $where = $this->_idFieldName . '=' . (int)$id;
        }
        $result = $this->_repoBasic->updateEntity($this->_entityName, $data, $where);
        return $result;
    }
}