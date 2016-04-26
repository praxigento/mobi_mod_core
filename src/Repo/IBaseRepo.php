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
     * Create new entity (simple or aggregate) using $data.
     *
     * @param DataObject|array $data
     * @return DataObject|array|int|null Created entity, ID or nothing
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
     * @return DataObject|array|null Found instance data
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