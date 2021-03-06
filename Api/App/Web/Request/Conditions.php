<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\App\Web\Request;

/**
 * Part of the request to get grid-like data (contains order, filter, pagination).
 */
class Conditions
    extends \Praxigento\Core\Data
{
    /**
     * Filtering clauses. Clause can be a single filter or group of filters (united with AND/OR statement).
     *
     * @return \Praxigento\Core\Api\App\Web\Request\Conditions\Filter
     */
    public function getFilter()
    {
        $result = parent::getFilter();
        return $result;
    }

    /**
     * Number of entries in result set to return.
     *
     * @return int
     */
    public function getLimit()
    {
        $result = parent::getLimit();
        return $result;
    }

    /**
     * Offset in selected data to skip in result set.
     *
     * @return int
     */
    public function getOffset()
    {
        $result = parent::getOffset();
        return $result;
    }

    /**
     * Set of ordering conditions.
     *
     * @return \Praxigento\Core\Api\App\Web\Request\Conditions\Order\Entry[]
     */
    public function getOrder()
    {
        $result = parent::getOrder();
        return $result;
    }

    /**
     * Filtering clauses. Clause can be a single filter or group of filters (united with AND/OR statement).
     *
     * @param \Praxigento\Core\Api\App\Web\Request\Conditions\Filter $data
     * @return void
     */
    public function setFilter($data)
    {
        parent::setFilter($data);
    }

    /**
     * Number of entries in result set to return.
     *
     * @param int $data
     * @return void
     */
    public function setLimit($data)
    {
        parent::setLimit($data);
    }

    /**
     * Offset in selected data to skip in result set.
     *
     * @param int $data
     * @return void
     */
    public function setOffset($data)
    {
        parent::setOffset($data);
    }

    /**
     * Set of ordering conditions.
     *
     * @param \Praxigento\Core\Api\App\Web\Request\Conditions\Order\Entry[] $data
     * @return void
     */
    public function setOrder($data)
    {
        parent::setOrder($data);
    }
}