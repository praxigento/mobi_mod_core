<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Ui\DataProvider;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider;
use Magento\Framework\View\Element\UiComponent\DataProvider\Reporting;
use Magento\Store\Model\StoreManagerInterface;
use Praxigento\Core\Repo\IBaseRepo as IBaseRepo;

class Base extends DataProvider
{
    const JSON_ATTR_ITEMS = 'items';
    const JSON_ATTR_TOTAL_RECORDS = 'totalRecords';

    /**#@+
     * UI XML arguments and default values to configure this component.
     */
    const UICD_UPDATE_URL = 'mui/index/render';
    const UIC_CONFIG = 'config';
    const UIC_UPDATE_URL = 'update_url';
    /**#@-*/

    /**
     * Repository to select data for grid.
     *
     * @var IBaseRepo
     */
    protected $_repo;

    public function __construct(
        UrlInterface $url,
        IBaseRepo $repo,
        Reporting $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder,
        $name,
        array $meta = [],
        array $data = []
    ) {
        /* add default Update URL */
        if (!isset($data[static::UIC_CONFIG][static::UIC_UPDATE_URL])) {
            $val = $url->getRouteUrl(static::UICD_UPDATE_URL);
            $data[static::UIC_CONFIG][static::UIC_UPDATE_URL] = $val;
        }
        parent::__construct(
            $name,
            'entity_id',
            'id',
            $reporting,
            $searchCriteriaBuilder,
            $request,
            $filterBuilder,
            $meta,
            $data
        );
        /* post construction setup */
        $this->_repo = $repo;
    }

    public function getData()
    {
        $criteria = $this->getSearchCriteria();
        $pageSize = $criteria->getPageSize();
        $pageIndx = $criteria->getCurrentPage();
        $where = null;
        /** @var \Magento\Framework\Api\SortOrder[] $apiOrder */
        $apiOrder = $criteria->getSortOrders();
        $order = [];
        foreach ($apiOrder as $item) {
            $field = $item->getField();
            $direction = $item->getDirection();
            if ($field) {
                $order[] = "$field $direction";
            }
        }
        /** @var \Magento\Framework\DB\Select $queryTotal */
        $queryTotal = $this->_repo->getQueryToSelectCount();
        $total = $queryTotal->getConnection()->fetchOne($queryTotal);
        /** @var \Magento\Framework\DB\Select $query */
        $query = $this->_repo->getQueryToSelect();
        $query->limitPage($pageIndx, $pageSize);
        if (count($order) > 0) {
            $query->order($order);
        }
        $data = $query->getConnection()->fetchAll($query);
        $result = [
            static::JSON_ATTR_TOTAL_RECORDS => $total,
            static::JSON_ATTR_ITEMS => $data
        ];
        return $result;
    }

    public function getFieldMetaInfo($fieldSetName, $fieldName)
    {
        return parent::getFieldMetaInfo($fieldSetName, $fieldName);
    }

    public function getFieldSetMetaInfo($fieldSetName)
    {
        return parent::getFieldSetMetaInfo($fieldSetName);
    }

    public function getFieldsMetaInfo($fieldSetName)
    {
        return parent::getFieldsMetaInfo($fieldSetName);
    }

    public function getMeta()
    {
        return parent::getMeta();
    }


    public function getPrimaryFieldName()
    {
        return parent::getPrimaryFieldName();
    }

    public function getRequestFieldName()
    {
        return parent::getRequestFieldName();
    }

    public function getSearchCriteria()
    {
        return parent::getSearchCriteria();
    }

    public function getSearchResult()
    {
        return parent::getSearchResult();
    }

    public function setConfigData($config)
    {
        return parent::setConfigData($config);
    }

}