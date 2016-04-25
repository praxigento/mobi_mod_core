<?php
/**
 * Interface for repository that operates with aggregates data.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Repo;


interface IAggregate extends IBaseRepo
{
 
    /**
     * @return \Magento\Framework\DB\Select
     */
    public function getQueryToSelect();
}