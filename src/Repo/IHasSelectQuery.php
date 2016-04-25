<?php
/**
 * MOBI-273: Proto for interface for SELECT QUERIES in Aggregates.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo;


interface  IHasSelectQuery
{
    /**
     * Get SELECT COUNT query.
     *
     * @return \Praxigento\Core\Repo\ISelect
     */
    public function getSelectCountQuery();

    /**
     * Get SELECT query.
     *
     * @return \Praxigento\Core\Repo\ISelect
     */
    public function getSelectQuery();

}