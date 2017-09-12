<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Ui\DataProvider;

/**
 * Base data provider for own grids.
 *
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 * @deprecated use \Praxigento\Core\Ui\DataProvider\Grid\Base
 */
class Base
    extends \Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider
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

    /** @var  \Praxigento\Core\Repo\Query\Criteria\IAdapter */
    protected $_criteriaAdapter;
    /** @var  \Praxigento\Core\Repo\Query\Criteria\IMapper */
    protected $_api2sqlMapper;
    /**
     * Repository to select data for grid.
     *
     * @var \Praxigento\Core\Repo\ICrud
     */
    protected $_repo;

    /**
     * @inheritdoc
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\UrlInterface $url,
        \Praxigento\Core\Repo\Query\Criteria\IAdapter $critAdapter,
        \Praxigento\Core\Repo\Query\Criteria\IMapper $api2sqlMapper = null,
        \Praxigento\Core\Repo\ICrud $repo,
        \Magento\Framework\View\Element\UiComponent\DataProvider\Reporting $reporting,
        \Magento\Framework\Api\Search\SearchCriteriaBuilder $searchCritBuilder,
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
            $searchCritBuilder,
            $request,
            $filterBuilder,
            $meta,
            $data
        );
        /* post construction setup */
        $this->_criteriaAdapter = $critAdapter;
        $this->_api2sqlMapper = $api2sqlMapper;
        $this->_repo = $repo;
    }

    public function getData()
    {
        $criteria = $this->getSearchCriteria();
        $where = $this->_criteriaAdapter->getWhereFromApiCriteria($criteria, $this->_api2sqlMapper);
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