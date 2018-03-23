<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Ui\DataProvider\Grid;


/**
 * Base data provider for (admin???) grids.
 */
class Base
    extends \Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider
{
    /**#@+
     *  See method \Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider::searchResultToOutput
     */
    const JSON_A_ITEMS = 'items';
    const JSON_A_TOTAL_RECORDS = 'totalRecords';
    /**#@-  */
    const UICD_UPDATE_URL = 'mui/index/render';
    const UIC_CONFIG = 'config';
    const UIC_UPDATE_URL = 'update_url';
     /** @var  \Praxigento\Core\App\Ui\DataProvider\Grid\Query\IBuilder */
    private $gridQueryBuilder;

    public function __construct(
        $name,
        \Magento\Framework\Api\Search\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\App\RequestInterface $request,
        \Praxigento\Core\App\Ui\DataProvider\Grid\Query\IBuilder $gridQueryBuilder,
        $primaryFieldName = 'primaryFieldName',
        $requestFieldName = 'requestFieldName',
        array $meta = [],
        array $data = []
    )
    {
        /**
         * I know, we need inject object manager but we need no tests for the time.
         *
         * @var \Magento\Framework\ObjectManagerInterface $manObj
         */
        $manObj = \Magento\Framework\App\ObjectManager::getInstance();
        /* add default Update URL */
        if (!isset($data[static::UIC_CONFIG][static::UIC_UPDATE_URL])) {
            /** @var \Magento\Framework\UrlInterface $url */
            $url = $manObj->get(\Magento\Framework\UrlInterface::class);
            $val = $url->getRouteUrl(static::UICD_UPDATE_URL);
            $data[static::UIC_CONFIG][static::UIC_UPDATE_URL] = $val;
        }
        /* these parameters are not used in overwritten Data Provider */
        $daorting = $manObj->get(\Magento\Framework\Api\Search\ReportingInterface::class);
        $filterBuilder = $manObj->get(\Magento\Framework\Api\FilterBuilder::class);
        /* init parent */
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $daorting, // $daorting is not used in overwritten class
            $searchCriteriaBuilder,
            $request,
            $filterBuilder, // $filterBuilder is not used in overwritten class
            $meta,
            $data
        );
        /* init own properties */
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
            static::JSON_A_TOTAL_RECORDS => $total,
            static::JSON_A_ITEMS => $items
        ];
        return $result;
    }
}