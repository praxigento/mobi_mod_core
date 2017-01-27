<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Query;

/**
 * Interface for DB selection query builders. Queries can be based on other queries.
 */
interface  IBuilder
    extends \Praxigento\Core\Repo\IDb
{
    /**
     * Get SELECT COUNT query.
     *
     * @param \Praxigento\Core\Repo\Query\IBuilder $qbuild
     * @return \Magento\Framework\DB\Select
     */
    public function getCountQuery(\Praxigento\Core\Repo\Query\IBuilder $qbuild = null);

    /**
     * Get SELECT query.
     *
     * @param \Praxigento\Core\Repo\Query\IBuilder $qbuild
     * @return \Magento\Framework\DB\Select
     */
    public function getSelectQuery(\Praxigento\Core\Repo\Query\IBuilder $qbuild = null);

}