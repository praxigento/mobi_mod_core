<?php
/**
 * Interface for repository that operates with entities data.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Repo;


use Flancer32\Lib\DataObject;

interface IEntity extends IBaseRepo
{


    /**
     * @param array $data [COL_NAME=>$value, ...]
     * @param mixed $where
     * @return int Count of the updated rows.
     */
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