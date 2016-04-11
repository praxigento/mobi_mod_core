<?php
/**
 * Interface for types codifiers repository.
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
    public function getById($id);

    /**
     * Referenced entity to address attributes.
     *
     * @return object
     */
    public function getRef();

    /**
     * Update instance in the DB.
     *
     * @param array|DataObject $data
     * @param int|array $id
     * @return int number of the rows affected
     */
    public function update($data, $id);

}