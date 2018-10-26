<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Ui\DataProvider\Grid\Query;


/**
 * Interface for query builders to fetch data for UI Grids.
 */
interface IBuilder
{
    /**
     * Get data items according to search criteria.
     *
     * @param \Magento\Framework\Api\Search\SearchCriteriaInterface $search
     * @param array $bind array with query parameters (some queries can have additional configuration for search criteria)
     * @return array
     */
    public function getItems(\Magento\Framework\Api\Search\SearchCriteriaInterface $search, $bind = []);

    /**
     * Get total count of the items that are matched to some search criteria.
     *
     * @param \Magento\Framework\Api\Search\SearchCriteriaInterface $search
     * @param array $bind array with query parameters (some queries can have additional configuration for search criteria)
     * @return int
     */
    public function getTotal(\Magento\Framework\Api\Search\SearchCriteriaInterface $search, $bind = []);
}