<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Api\Request\Part;

/**
 * Part of the request to get grid-like data (contains order, filter, pagination).
 */
class Conditions
    extends \Flancer32\Lib\Data
{
    /**
     * Set of ordering conditions.
     *
     * @return \Praxigento\Core\Api\Request\Part\Conditions\Order\Entry[]
     */
    public function getOrder()
    {
        $result = parent::getOrder();
        return $result;
    }

    /**
     * @return \Flancer32\Lib\Data[]
     */
    public function getFilters()
    {
        $result = parent::getFilters();
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
}