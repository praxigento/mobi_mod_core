<?php
/**
 * Interface for generic repository to do universal operations with data (CRUD).
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Repo;


interface IGeneric
{
    /**
     * @param string $entity Entity name (not table name).
     * @param array $bind [COL_NAME=>$value, ...]
     *
     * @return int ID of the inserted record.
     */
    public function addEntity($entity, $bind);

    /**
     * @param string $entity Entity name (not table name).
     * @param array $pk [COL_NAME=>$value, ...]
     * @return int
     */
    public function deleteEntityByPk($entity, $pk);

    /**
     * @param string $entity Entity name (not table name)
     * @param array|string|Zend_Db_Expr $cols The columns to select from the table.
     * @param string $where The WHERE condition.
     * @param array|string $order The column(s) and direction to order by.
     * @param int $limit The number of rows to return.
     * @param int $offset Start returning after this many rows.
     *
     * @return bool|array 'false' or selected data ( [[...], ...]).
     */
    public function getEntities($entity, $cols = null, $where = null, $order = null, $limit = null, $offset = null);

    /**
     * @param string $entity Entity name (not table name).
     * @param array $pk [COL_NAME=>$value, ...]
     * @param array|string $fields
     *
     * @return bool|array 'false' or selected data ([...])
     */
    public function getEntityByPk($entity, $pk, $fields = '*');

    /**
     * @param string $entity Entity name (not table name).
     * @param array $bind [COL_NAME=>$value, ...]
     *
     * @return mixed
     */
    public function replaceEntity($entity, $bind);

    /**
     * @param string $entity Entity name (not table name).
     * @param array $bind [COL_NAME=>$value, ...]
     * @param mixed $where
     *
     * @return int Count of the updated rows.
     */
    public function updateEntity($entity, $bind, $where = null);
}