<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\App\Repo\Query;

/**
 * Interface for DB selection queries generators (MOBI-273).
 */
interface  IHasSelect
{
    /**
     * Get SELECT query.
     *
     * @return \Praxigento\Core\App\Repo\Query\ISelect
     */
    public function getQueryToSelect();

    /**
     * Get SELECT COUNT query.
     *
     * @return \Praxigento\Core\App\Repo\Query\ISelect
     */
    public function getQueryToSelectCount();

}