<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Query\Criteria\Def;

include_once(__DIR__ . '/../../../../phpunit_bootstrap.php');

/**
 * @SuppressWarnings(PHPMD.CamelCaseClassName)
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class Adapter_UnitTest
    extends \Praxigento\Core\Test\BaseCase\Mockery
{
    /** @var  \Mockery\MockInterface */
    private $mConn;
    /** @var  Adapter */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mConn = $this->_mockConn();
        $mResource = $this->_mockResourceConnection($this->mConn);
        $mResource->shouldReceive('getConnection')->once()
            ->andReturn($this->mConn);
        /** create object to test */
        $this->obj = new Adapter($mResource);
    }

    public function test_constructor()
    {
        /** === Call and asserts  === */
        $this->assertInstanceOf(\Praxigento\Core\Repo\Query\Criteria\Def\Adapter::class, $this->obj);
    }

    public function test_getOrderFromApiCriteria()
    {
        /** === Test Data === */
        $crit = $this->_mock(\Magento\Framework\Api\Search\SearchCriteriaInterface::class);
        $field = 'field';
        $direction = 'direction';
        /** === Setup Mocks === */
        // $orders = $criteria->getSortOrders();
        $mOrder = $this->_mock(\Magento\Framework\Api\SortOrder::class);
        $crit->shouldReceive('getSortOrders')->once()
            ->andReturn([$mOrder]);
        // $field = $item->getField();
        $mOrder->shouldReceive('getField')->once()
            ->andReturn($field);
        // $direction = $item->getDirection();
        $mOrder->shouldReceive('getDirection')->once()
            ->andReturn($direction);
        /** === Call and asserts  === */
        $res = $this->obj->getOrderFromApiCriteria($crit);
        $this->assertEquals(["$field $direction"], $res);
    }

    public function test_getOrderFromApiCriteria_noData()
    {
        /** === Test Data === */
        $crit = $this->_mock(\Magento\Framework\Api\Search\SearchCriteriaInterface::class);
        /** === Setup Mocks === */
        // $orders = $criteria->getSortOrders();
        $crit->shouldReceive('getSortOrders')->once()
            ->andReturn([]);
        /** === Call and asserts  === */
        $res = $this->obj->getOrderFromApiCriteria($crit);
        $this->assertNull($res);
    }

    public function test_getWhereFromApiCriteria()
    {
        /** === Test Data === */
        $crit = $this->_mock(\Magento\Framework\Api\Search\SearchCriteriaInterface::class);
        $mapper = $this->_mock(\Praxigento\Core\Repo\Query\Criteria\IMapper::class);
        $field = 'field';
        $cond = 'cond type';
        $value = 'value';
        $where = 'where';
        /** === Setup Mocks === */
        // $filterGroups = $criteria->getFilterGroups();
        $mFilterGroup = $this->_mock(\Magento\Framework\Api\Search\FilterGroup::class);
        $crit->shouldReceive('getFilterGroups')->once()
            ->andReturn([$mFilterGroup]);
        // foreach ($filterGroup->getFilters() as $item) {}
        $mFilter = $this->_mock(\Magento\Framework\Api\Filter::class);
        $mFilterGroup->shouldReceive('getFilters')->once()
            ->andReturn([$mFilter]);
        // $field = $item->getField();
        $mFilter->shouldReceive('getField')->once()
            ->andReturn($field);
        // $field = $mapper->get($field);
        $mapper->shouldReceive('get')->once()
            ->with($field)
            ->andReturn($field);
        // $cond = $item->getConditionType();
        $mFilter->shouldReceive('getConditionType')->once()
            ->andReturn($cond);
        // $value = $item->getValue();
        $mFilter->shouldReceive('getValue')->once()
            ->andReturn($value);
        // $where = $this->_conn->prepareSqlCondition($field, [$cond => $value]);
        $this->mConn
            ->shouldReceive('prepareSqlCondition')->once()
            ->andReturn($where);
        /** === Call and asserts  === */
        $res = $this->obj->getWhereFromApiCriteria($crit, $mapper);
        $this->assertEquals("($where) AND 1", $res);
    }
}
