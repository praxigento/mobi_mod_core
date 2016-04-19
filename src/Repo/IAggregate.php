<?php
/**
 * Interface for repository that operates with aggregates data.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Repo;


use Flancer32\Lib\DataObject;

interface IAggregate
{
    /**
     * @param DataObject $data
     * @return mixed
     */
    public function create($data);

    /**
     * @param mixed $id
     * @return mixed
     */
    public function getById($id);

    /**
     * @return \Magento\Framework\DB\Select
     */
    public function getQueryToSelect();
}