<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo;

/**
 * Interface for repository that operates with entities data.
 */
interface IEntity extends IBaseRepo
{

    /**
     * Replace data for the entity.
     *
     * @param array $data [COL_NAME=>$value, ...]
     * @return int Count of the updated rows.
     */
    public function replace($data);

    /**
     * @param array $data [COL_NAME=>$value, ...]
     * @param mixed $where
     * @return int Count of the updated rows.
     */
    public function update($data, $where);


}