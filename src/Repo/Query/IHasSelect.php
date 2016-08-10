<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Query;

/**
 * Interface for DB selection queries generators (MOBI-273).
 */
interface  IHasSelect
{
    /**
     * Get SELECT COUNT query.
     *
     * @return \Praxigento\Core\Repo\Query\ISelect
     */
    public function getQueryToSelectCount();

    /**
     * Get SELECT query.
     *
     * @return \Praxigento\Core\Repo\Query\ISelect
     */
    public function getQueryToSelect();

}