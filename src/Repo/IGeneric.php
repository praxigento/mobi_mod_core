<?php
/**
 * Interface for generic repository to do universal operations (CRUD) with simple entities (not aggregates).
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Repo;

use Flancer32\Lib\DataObject;

interface IGeneric
{
    /**
     * Create new $entity instance using $data.
     *
     * @param string $entity Entity name (not table name).
     * @param array|DataObject $bind [COL_NAME=>$value, ...]
     *
     * @return int|null ID of the inserted record or nothing (in case of complex primary key, for example).
     */
    public function addEntity($entity, $bind);

    /**
     * Delete one or more simple entities by $where condition.
     *
     * @param string $entity Entity name (not table name).
     * @param mixed $where condition to select entities for delete.
     * @return int number of deleted rows
     */
    public function deleteEntity($entity, $where);

    /**
     * Delete one simple entity using primary key.
     *
     * @param string $entity Entity name (not table name).
     * @param array $pk [COL_NAME=>$value, ...]
     * @return int number of deleted rows
     */
    public function deleteEntityByPk($entity, $pk);

    /**
     * Retrieve connection to resource specified by $name
     *
     * @param string $name
     * @return \Magento\Framework\DB\Adapter\AdapterInterface
     */
    public function getConnection($name = null);

    /**
     * Get list of simple entities according to given conditions ($cols, $where, $order, ...).
     *
     * @param string $entity Entity name (not table name)
     * @param array|null $cols The columns to select from the table or null to select all columns.
     * @param string $where The WHERE condition.
     * @param array|string $order The column(s) and direction to order by.
     * @param int $limit The number of rows to return.
     * @param int $offset Start returning after this many rows.
     *
     * @return array selected data ( [[...], ...]) or empty array ([]) if no data found.
     */
    public function getEntities($entity, $cols = null, $where = null, $order = null, $limit = null, $offset = null);

    /**
     * @param string $entity Entity name (not table name).
     * @param array $pk [COL_NAME=>$value, ...]
     * @param array|null $cols The columns to select from the table or null to select all columns.
     *
     * @return bool|array 'false' or selected data ([...])
     */
    public function getEntityByPk($entity, $pk, $cols = null);

    /**
     * @param string $entity Entity name (not table name).
     * @param array|DataObject $bind [COL_NAME=>$value, ...]
     *
     * @return mixed
     */
    public function replaceEntity($entity, $bind);

    /**
     * @param string $entity Entity name (not table name).
     * @param array|DataObject $bind [COL_NAME=>$value, ...]
     * @param mixed $where
     *
     * @return int Count of the updated rows.
     */
    public function updateEntity($entity, $bind, $where = null);
}