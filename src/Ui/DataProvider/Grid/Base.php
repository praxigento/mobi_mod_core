<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Ui\DataProvider\Grid;


/**
 * Base data provider for (admin???) grids.
 */
class Base
    extends \Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider
{
    /**#@+
     *  See method \Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider::searchResultToOutput
     */
    const JSON_ATTR_ITEMS = 'items';
    const JSON_ATTR_TOTAL_RECORDS = 'totalRecords';
    /**#@-  */

    /** @var  \Praxigento\Core\Ui\DataProvider\Grid\Query\IBuilder */
    private $gridQueryBuilder;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Magento\Framework\Api\Search\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\App\RequestInterface $request,
        \Praxigento\Core\Ui\DataProvider\Grid\Query\IBuilder $gridQueryBuilder,
        array $meta = [],
        array $data = []
    )
    {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            null, // $reporting is not used in this case
            $searchCriteriaBuilder,
            $request,
            null, // $filterBuilder is not used in this case
            $meta,
            $data
        );
             $this->gridQueryBuilder = $gridQueryBuilder;
    }

    public function getData()
    {
        /* get Web UI search criteria */
        $search = $this->getSearchCriteria();
        /* get build queries and fetch data for total count and items */
        $total = $this->gridQueryBuilder->getTotal($search);
        $items = $this->gridQueryBuilder->getItems($search);
        $result = [
            static::JSON_ATTR_TOTAL_RECORDS => $total,
            static::JSON_ATTR_ITEMS => $items
        ];
        return $result;
    }
}