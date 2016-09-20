<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Ui\DataProvider;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class Base_UnitTest extends \Praxigento\Core\Test\BaseCase\Mockery
{
    private $NAME = 'provider name';
    /** @var  \Mockery\MockInterface */
    private $mCriteriaAdapter;
    /** @var  \Mockery\MockInterface */
    private $mFilterBuilder;
    /** @var  \Mockery\MockInterface */
    private $mRepo;
    /** @var  \Mockery\MockInterface */
    private $mReporting;
    /** @var  \Mockery\MockInterface */
    private $mRequest;
    /** @var  \Mockery\MockInterface */
    private $mSearchCriteriaBuilder;
    /** @var  \Mockery\MockInterface */
    private $mUrl;
    /** @var  Base */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mUrl = $this->_mock(\Magento\Framework\UrlInterface::class);
        $this->mCriteriaAdapter = $this->_mock(\Praxigento\Core\Repo\Query\Criteria\IAdapter::class);
        $this->mRepo = $this->_mock(\Praxigento\Core\Repo\ICrud::class);
        $this->mReporting = $this->_mock(\Magento\Framework\View\Element\UiComponent\DataProvider\Reporting::class);
        $this->mSearchCriteriaBuilder = $this->_mock(\Magento\Framework\Api\Search\SearchCriteriaBuilder::class);
        $this->mRequest = $this->_mock(\Magento\Framework\App\RequestInterface::class);
        $this->mFilterBuilder = $this->_mock(\Magento\Framework\Api\FilterBuilder::class);
        /** setup mocks for constructor */
        $this->mUrl
            ->shouldReceive('getRouteUrl')->once();
        /** create object to test */
        $this->obj = new ChildToTestBase(
            $this->mUrl,
            $this->mCriteriaAdapter,
            null,
            $this->mRepo,
            $this->mReporting,
            $this->mSearchCriteriaBuilder,
            $this->mRequest,
            $this->mFilterBuilder,
            $this->NAME
        );
    }

    public function test_constructor()
    {
        /** === Call and asserts  === */
        $this->assertInstanceOf(\Praxigento\Core\Ui\DataProvider\Base::class, $this->obj);
    }

    public function test_getData()
    {
        /** === Test Data === */
        $WHERE = 'where';
        $ORDER = 'order by';
        $PAGE_SIZE = 100;
        $PAGE_INDEX = 3;
        $TOTAL = 100;
        $DATA = ['entry'];
        /** === Setup Mocks === */
        //
        // $criteria = $this->getSearchCriteria();
        //
        // $this->searchCriteria = $this->searchCriteriaBuilder->create();
        $mCriteria = $this->_mock(\Magento\Framework\Api\Search\SearchCriteria::class);
        $this->mSearchCriteriaBuilder
            ->shouldReceive('create')->once()
            ->andReturn($mCriteria);
        // $this->searchCriteria->setRequestName($this->name);
        $mCriteria->shouldReceive('setRequestName')->once();
        //
        // $where = $this->_criteriaAdapter->getWhereFromApiCriteria($criteria);
        $this->mCriteriaAdapter
            ->shouldReceive('getWhereFromApiCriteria')->once()
            ->andReturn($WHERE);
        // $queryTotal = $this->_repo->getQueryToSelectCount();
        $mQueryTotal = $this->_mockDbSelect();
        $this->mRepo
            ->shouldReceive('getQueryToSelectCount')->once()
            ->andReturn($mQueryTotal);
        // $queryTotal->where($where);
        $mQueryTotal->shouldReceive('where')->once();
        // $conn = $queryTotal->getConnection();
        $mConn = $this->_mockConn();
        $mQueryTotal->shouldReceive('getConnection')->once()
            ->andReturn($mConn);
        // $total = $conn->fetchOne($queryTotal);
        $mConn->shouldReceive('fetchOne')->once()
            ->andReturn($TOTAL);
        // $query = $this->_repo->getQueryToSelect();
        $mQuery = $this->_mockDbSelect();
        $this->mRepo
            ->shouldReceive('getQueryToSelect')->once()
            ->andReturn($mQuery);
        // $query->where($where);
        $mQuery->shouldReceive('where')->once();
        // $order = $this->_criteriaAdapter->getOrderFromApiCriteria($criteria);
        $this->mCriteriaAdapter
            ->shouldReceive('getOrderFromApiCriteria')->once()
            ->andReturn($ORDER);
        // $query->order($order);
        $mQuery->shouldReceive('order')->once();
        // $pageSize = $criteria->getPageSize();
        $mCriteria->shouldReceive('getPageSize')->once()
            ->andReturn($PAGE_SIZE);
        // $pageIndx = $criteria->getCurrentPage();
        $mCriteria->shouldReceive('getCurrentPage')->once()
            ->andReturn($PAGE_INDEX);
        // $query->limitPage($pageIndx, $pageSize);
        $mQuery->shouldReceive('limitPage')->once()
            ->with($PAGE_INDEX, $PAGE_SIZE)
            ->andReturn();
        // $data = $conn->fetchAll($query);
        $mConn->shouldReceive('fetchAll')->once()
            ->andReturn($DATA);
        /** === Call and asserts  === */
        $res = $this->obj->getData();
        $expected = [
            Base::JSON_ATTR_TOTAL_RECORDS => $TOTAL,
            Base::JSON_ATTR_ITEMS => $DATA

        ];
        $this->assertEquals($expected, $res);
    }
}

class ChildToTestBase extends Base
{

}