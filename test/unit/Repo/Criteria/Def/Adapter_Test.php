<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Criteria\Def;

include_once(__DIR__ . '/../../../phpunit_bootstrap.php');

class Adapter_UnitTest extends \Praxigento\Core\Test\BaseMockeryCase
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
        /** create object to test */
        $mResource = $this->_mockResourceConnection($this->mConn);
        $this->obj = new Adapter($mResource);
    }

    public function test_constructor()
    {
        /** === Call and asserts  === */
        $this->assertInstanceOf(\Praxigento\Core\Repo\Criteria\Def\Adapter::class, $this->obj);
    }

    public function test_getOrderFromApiCriteria()
    {
        /** === Test Data === */
        $CRIT = $this->_mock(\Magento\Framework\Api\Search\SearchCriteriaInterface::class);
        $FIELD = 'field';
        $DIRECTION = 'direction';
        /** === Setup Mocks === */
        // $orders = $criteria->getSortOrders();
        $mOrder = $this->_mock(\Magento\Framework\Api\SortOrder::class);
        $CRIT->shouldReceive('getSortOrders')->once()
            ->andReturn([$mOrder]);
        // $field = $item->getField();
        $mOrder->shouldReceive('getField')->once()
            ->andReturn($FIELD);
        // $direction = $item->getDirection();
        $mOrder->shouldReceive('getDirection')->once()
            ->andReturn($DIRECTION);
        /** === Call and asserts  === */
        $res = $this->obj->getOrderFromApiCriteria($CRIT);
        $this->assertEquals(["$FIELD $DIRECTION"], $res);
    }

    public function test_getOrderFromApiCriteria_noData()
    {
        /** === Test Data === */
        $CRIT = $this->_mock(\Magento\Framework\Api\Search\SearchCriteriaInterface::class);
        /** === Setup Mocks === */
        // $orders = $criteria->getSortOrders();
        $CRIT->shouldReceive('getSortOrders')->once()
            ->andReturn([]);
        /** === Call and asserts  === */
        $res = $this->obj->getOrderFromApiCriteria($CRIT);
        $this->assertNull($res);
    }

    public function test_getWhereFromApiCriteria()
    {
        /** === Test Data === */
        $CRIT = $this->_mock(\Magento\Framework\Api\Search\SearchCriteriaInterface::class);
        $FIELD = 'field';
        $COND = 'cond type';
        $VALUE = 'value';
        $WHERE = 'where';
        /** === Setup Mocks === */
        // $filterGroups = $criteria->getFilterGroups();
        $mFilterGroup = $this->_mock(\Magento\Framework\Api\Search\FilterGroup::class);
        $CRIT->shouldReceive('getFilterGroups')->once()
            ->andReturn([$mFilterGroup]);
        // foreach ($filterGroup->getFilters() as $item) {}
        $mFilter = $this->_mock(\Magento\Framework\Api\Filter::class);
        $mFilterGroup->shouldReceive('getFilters')->once()
            ->andReturn([$mFilter]);
        // $field = $item->getField();
        $mFilter->shouldReceive('getField')->once()
            ->andReturn($FIELD);
        // $cond = $item->getConditionType();
        $mFilter->shouldReceive('getConditionType')->once()
            ->andReturn($COND);
        // $value = $item->getValue();
        $mFilter->shouldReceive('getValue')->once()
            ->andReturn($VALUE);
        // $where = $this->_conn->prepareSqlCondition($field, [$cond => $value]);
        $this->mConn
            ->shouldReceive('prepareSqlCondition')->once()
            ->andReturn($WHERE);
        /** === Call and asserts  === */
        $res = $this->obj->getWhereFromApiCriteria($CRIT);
        $this->assertEquals("($WHERE) AND 1", $res);
    }
}
