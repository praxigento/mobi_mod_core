<?php
/**
 * Interface for repository that operates with entities data.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Repo;


use Flancer32\Lib\DataObject;

interface IEntity
{
    /**
     * Create instance in the DB.
     *
     * @param array|DataObject $data fields and bound values
     * @return int|null ID for new instance (if ID is autoincrement)
     */
    public function create($data);

    /**
     * Search for the instance by ID (ID can be an array for complex primary keys).
     *
     * @param int|array $id
     * @return mixed
     */
    public function deleteById($id);

    /**
     * Get list of the entities according to given conditions.
     *
     * @param null $where
     * @param null $order
     * @param null $limit
     * @param null $offset
     * @return mixed
     */
    public function get($where = null, $order = null, $limit = null, $offset = null);

    /**
     * Delete the instance by ID (ID can be an array for complex primary keys).
     *
     * @param int|array $id
     * @return mixed
     */
    public function getById($id);

    /**
     * Referenced entity to address attributes.
     *
     * @return object
     */
    public function getRef();

    public function update($data, $where);

    /**
     * Update instance in the DB (look up by ID values).
     *
     * @param array|DataObject $data
     * @param int|array $id
     * @return int number of the rows affected
     */
    public function updateById($data, $id);

}