<?php
/**
 * MOBI-273: Proto for interface for SELECT QUERIES in Aggregates.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo;


interface  IHasQuery
{
    /**
     * Get SELECT query.
     *
     * @return \Magento\Framework\DB\Select
     */
    public function getQuery();

}