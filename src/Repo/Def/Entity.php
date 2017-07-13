<?php
/**
 * Default implementation for entity repository to do universal operations with specific entity data (CRUD).
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;

class Entity
    extends \Praxigento\Core\Repo\Def\Crud
    implements \Praxigento\Core\Repo\IEntity
{
    /** @var  string Class name for the related entity ('\Praxigento\Pv\Data\Entity\Product'). */
    protected $entityClassName;
    /**
     * Name of the first attribute from primary key ('customer_ref').
     *
     * To use "$this->[get|update|delete]ById(32)" in case of PK consists from one attribute only.
     *
     * @var  string
     */
    protected $entityId;
    /** @var  string Entity name (table name w/o prefix: 'prxgt_pv_prod') */
    protected $entityName;
    /** @var  string[] primary key attributes (ordered: ['first_attr', 'second_attr']) */
    protected $entityPk;
    /** @var \Praxigento\Core\Repo\IGeneric generic repository to perform DB operation */
    protected $repoGeneric;

    /**
     * Analyze $entityClassName (@see \Praxigento\Core\Data\Entity\Base children) and save
     *
     *
     * @param \Magento\Framework\App\ResourceConnection $resource
     * @param \Praxigento\Core\Repo\IGeneric $repoGeneric
     * @param string $entityClassName
     */
    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource,
        \Praxigento\Core\Repo\IGeneric $repoGeneric,
        $entityClassName
    ) {
        parent::__construct($resource);
        $this->repoGeneric = $repoGeneric;
        $this->entityClassName = $entityClassName;
        /* analyze entity class to get entity name & PK attributes */
        $this->entityName = $entityClassName::getEntityName();
        $this->entityPk = $entityClassName::getPrimaryKeyAttrs();
        /* ... and first attr of the PK (80% of the entities have one attribute only in PK) */
        $this->entityId = reset($this->entityPk);
    }

    public function create($data)
    {
        $result = $this->repoGeneric->addEntity($this->entityName, $data);
        return $result;
    }

    /**
     * Create entity instance for given $data (convert row DB data to the Entity data object).
     *
     * @param array $data
     * @return \Praxigento\Core\Data\Entity\Base
     */
    protected function createEntity($data = null)
    {
        /** @var \Praxigento\Core\Data\Entity\Base $result */
        $result = new $this->entityClassName($data);
        return $result;
    }

    public function delete($where = null)
    {
        $result = $this->repoGeneric->deleteEntity($this->entityName, $where);
        return $result;
    }

    public function deleteById($id)
    {
        if (is_array($id)) {
            /* probably this is a complex PK (['key1'=>8, 'key2'=>16]) */
            $pk = $id;
        } else {
            /* probably this is a single-attr PK */
            $pk = [$this->entityId => $id];
        }
        $result = $this->repoGeneric->deleteEntityByPk($this->entityName, $pk);
        return $result;
    }

    /**
     * Generic method to get data from repository.
     *
     * @param null $where
     * @param null $order
     * @param null $limit
     * @param null $offset
     * @param null $columns
     * @param null $group
     * @param null $having
     * @return \Praxigento\Core\Data\Entity\Base[] or empty array if no data found.
     */
    public function get(
        $where = null,
        $order = null,
        $limit = null,
        $offset = null,
        $columns = null,
        $group = null,
        $having = null
    ) {
        $result = [];
        $rows = $this->repoGeneric->getEntities($this->entityName, null, $where, $order, $limit, $offset);
        foreach ($rows as $data) {
            $result[] = $this->createEntity($data);
        }
        return $result;
    }

    public function getById($id)
    {
        if (is_array($id)) {
            /* probably this is a complex PK (['key1'=>8, 'key2'=>16]) */
            $pk = $id;
        } else {
            /* probably this is a single-attr PK */
            $pk = [$this->entityId => $id];
        }
        $result = $this->repoGeneric->getEntityByPk($this->entityName, $pk);
        if ($result) {
            $result = $this->createEntity($result);
        }
        return $result;
    }

    public function getQueryToSelect()
    {
        $result = $this->conn->select();
        $tbl = $this->resource->getTableName($this->entityName);
        $result->from($tbl);
        return $result;
    }

    public function getQueryToSelectCount()
    {
        $result = $this->conn->select();
        $tbl = $this->resource->getTableName($this->entityName);
        $result->from($tbl, "COUNT({$this->entityId})");
        return $result;
    }

    public function replace($data)
    {
        if ($data instanceof \Flancer32\Lib\Data) {
            $data = (array)$data->get();
        } elseif ($data instanceof \stdClass) {
            $data = (array)$data;
        }
        $result = $this->repoGeneric->replaceEntity($this->entityName, $data);
        return $result;
    }

    public function update($data, $where)
    {
        $result = $this->repoGeneric->updateEntity($this->entityName, $data, $where);
        return $result;
    }

    public function updateById($id, $data)
    {
        if (is_array($id)) {
            /* probably this is a complex PK (['key1'=>8, 'key2'=>16]) */
            $where = '';
            foreach ($id as $key => $value) {
                $val = is_int($value) ? $value : $this->conn->quote($value);
                $where .= "($key=$val) AND ";
            }
            $where .= '1'; // WHERE ... AND 1;
        } else {
            /* probably this is a single-attr PK */
            $val = is_int($id) ? $id : $this->conn->quote($id);
            $where = $this->entityId . '=' . $val;
        }
        $result = $this->repoGeneric->updateEntity($this->entityName, $data, $where);
        return $result;
    }
}