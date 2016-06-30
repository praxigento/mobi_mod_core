<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo;

use Flancer32\Lib\DataObject;

/**
 * Base interface for CRUD repositories (general Create-Read-Update-Delete operations).
 */
interface IBaseCrud
{
    /**
     * Create new data instance (simple entity or aggregate) using $data. Exception is thrown in case of any error.
     *
     * @param DataObject|array $data
     * @return bool|int|string|array|DataObject ID (integer|string|array) or 'true|false' (if insertion is failed)
     * or array|DataObject (if newly created object is returned).
     */
    public function create($data);

    /**
     * @param $where
     * @return int The number of affected rows.
     */
    public function delete($where);

    /**
     * @param int|string|array $id
     * @return int The number of affected rows.
     */
    public function deleteById($id);

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
     * @return array Found data or empty array if no data found.
     */
    public function get(
        $where = null,
        $order = null,
        $limit = null,
        $offset = null,
        $columns = null,
        $group = null,
        $having = null
    );

    /**
     * Get the data instance by ID (ID can be an array for complex primary keys).
     *
     * @param int|string|array $id
     * @return DataObject|array|bool Found instance data or 'false'
     */
    public function getById($id);

    /**
     * Retrieve connection to resource specified by $name
     *
     * @param string $name
     * @return \Magento\Framework\DB\Adapter\AdapterInterface
     */
    public function getConnection($name);

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
     * Update instance in the DB (look up by ID values).
     *
     * TODO: add update() & updateWhere() methods
     *
     * @param int|string|array $id
     * @param array|DataObject $data
     * @return int The number of affected rows.
     */
    public function updateById($id, $data);

}