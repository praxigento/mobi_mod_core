<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Ui\DataProvider\Grid\Query;


/**
 * Interface for query builders to fetch data for UI Grids.
 */
interface IBuilder
{
    /**
     * Get data items according to search criteria.
     *
     * @param \Magento\Framework\Api\Search\SearchCriteriaInterface $search
     * @return array
     */
    public function getItems(\Magento\Framework\Api\Search\SearchCriteriaInterface $search);

    /**
     * Get total count of the items that are matched to some search criteria.
     *
     * @param \Magento\Framework\Api\Search\SearchCriteriaInterface $search
     * @return int
     */
    public function getTotal(\Magento\Framework\Api\Search\SearchCriteriaInterface $search);
}