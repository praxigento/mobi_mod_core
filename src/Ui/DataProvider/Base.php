<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Ui\DataProvider;

use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider;
use Magento\Store\Model\StoreManagerInterface;
use Praxigento\Core\Repo\Criteria\IAdapter as ICriteriaAdapter;
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
    /**#@- */
    
    /** @var  ICriteriaAdapter */
    protected $_criteriaAdapter;
    /**
     * Repository to select data for grid.
     *
     * @var IBaseRepo
     */
    protected $_repo;

    public function __construct(
        \Magento\Framework\UrlInterface $url,
        \Praxigento\Core\Repo\Criteria\IAdapter $criteriaAdapter,
        \Praxigento\Core\Repo\IBaseRepo $repo,
        \Magento\Framework\View\Element\UiComponent\DataProvider\Reporting $reporting,
        \Magento\Framework\Api\Search\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Api\FilterBuilder $filterBuilder,
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
        $this->_criteriaAdapter = $criteriaAdapter;
        $this->_repo = $repo;
    }

    public function getData()
    {
        $criteria = $this->getSearchCriteria();
        $where = $this->_criteriaAdapter->getWhereFromApiCriteria($criteria);
        /* get query for total count */
        /** @var \Magento\Framework\DB\Select $queryTotal */
        $queryTotal = $this->_repo->getQueryToSelectCount();
        $queryTotal->where($where);
        $conn = $queryTotal->getConnection();
        $total = $conn->fetchOne($queryTotal);
        /* get query to select data */
        /** @var \Magento\Framework\DB\Select $query */
        $query = $this->_repo->getQueryToSelect();
        $query->where($where);
        /* set order */
        $order = $this->_criteriaAdapter->getOrderFromApiCriteria($criteria);
        $query->order($order);
        /* limit pages */
        $pageSize = $criteria->getPageSize();
        $pageIndx = $criteria->getCurrentPage();
        $query->limitPage($pageIndx, $pageSize);
        $data = $conn->fetchAll($query);
        $result = [
            static::JSON_ATTR_TOTAL_RECORDS => $total,
            static::JSON_ATTR_ITEMS => $data
        ];
        return $result;
    }

}