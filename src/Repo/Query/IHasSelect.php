<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Query;

/**
 * MOBI-273: Proto for interface for SELECT QUERIES in Aggregates.
 */
interface  IHasSelect
{
    /**
     * Get SELECT COUNT query.
     *
     * @return \Praxigento\Core\Repo\Query\ISelect
     */
    public function getSelectCountQuery();

    /**
     * Get SELECT query.
     *
     * @return \Praxigento\Core\Repo\Query\ISelect
     */
    public function getSelectQuery();

}