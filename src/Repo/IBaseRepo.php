<?php
/**
 * Basic repository interface.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Repo;


use Flancer32\Lib\DataObject;

interface IBaseRepo
{
    /**
     * Create new entity (simple or aggregate) using $data. Exception is thrown in case of any error.
     *
     * @param DataObject|array $data
     * @return bool|int|string|array|DataObject ID (integer|string|array) or 'true|false' (if insertion is failed)
     * or array|DataObject (if newly created object is returned).
     */
    public function create($data);

    /**
     * @param $where
     * @return mixed
     */
    public function delete($where);

    public function deleteById($id);

    /**
     * Get the data instance by ID (ID can be an array for complex primary keys).
     *
     * @param int|array $id
     * @return DataObject|array|bool Found instance data or 'false'
     */
    public function getById($id);

    /**
     * Compose SELECT query for the simple entity or aggregate.
     *
     * @return ISelect
     */
    public function getQueryToSelect();

    /**
     * Compose COUNT SELECT query for the simple entity or aggregate.
     *
     * @return ISelect
     */
    public function getQueryToSelectCount();

    /**
     * Referenced data object to address attributes.
     *
     * @return object
     */
    public function getRef();

}