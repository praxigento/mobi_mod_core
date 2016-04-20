<?php
/**
 * Default implementation for entity repository to do universal operations with specific entity data (CRUD).
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;

use Praxigento\Core\Data\IEntity as IDataEntity;
use Praxigento\Core\Repo\IEntity;

class Entity extends Base implements IEntity
{
    /** @var  string */
    protected $_entityName;
    /** @var  string */
    protected $_idFieldName;
    /** @var  IDataEntity */
    protected $_refEntity;
    /** @var \Praxigento\Core\Repo\IGeneric */
    protected $_repoGeneric;

    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource,
        \Praxigento\Core\Repo\IGeneric $repoGeneric,
        IDataEntity $entity
    ) {
        parent::__construct($resource);
        $this->_repoGeneric = $repoGeneric;
        $this->_refEntity = $entity;
        $this->_entityName = $entity->getEntityName();
        $ids = $entity->getPrimaryKeyAttrs();
        $this->_idFieldName = reset($ids);
    }

    /**
     * @inheritdoc
     */
    public function create($data)
    {
        $result = $this->_repoGeneric->addEntity($this->_entityName, $data);
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function deleteById($id)
    {
        if (is_array($id)) {
            /* probably this is complex PK */
            $pk = $id;
        } else {
            $pk = [$this->_idFieldName => $id];
        }
        $result = $this->_repoGeneric->deleteEntityByPk($this->_entityName, $pk);
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function get($where = null, $order = null, $limit = null, $offset = null)
    {
        $result = $this->_repoGeneric->getEntities($this->_entityName, null, $where, $order, $limit, $offset);
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function getById($id)
    {
        if (is_array($id)) {
            /* probably this is complex PK */
            $pk = $id;
        } else {
            $pk = [$this->_idFieldName => $id];
        }
        $result = $this->_repoGeneric->getEntityByPk($this->_entityName, $pk);
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function getRef()
    {
        return $this->_refEntity;
    }

    /**
     * @inheritdoc
     */
    public function update($data, $where)
    {
        $result = $this->_repoGeneric->updateEntity($this->_entityName, $data, $where);
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function updateById($data, $id)
    {
        if (is_array($id)) {
            /* probably this is complex PK */
            $where = '';
            foreach ($id as $key => $value) {
                $where = "($key=$value) AND ";
            }
            $where .= '1'; // WHERE ... AND 1;
        } else {
            $val = is_int($id) ? $id : $this->_conn->quote($id);
            $where = $this->_idFieldName . '=' . $val;
        }
        $result = $this->_repoGeneric->updateEntity($this->_entityName, $data, $where);
        return $result;
    }
}