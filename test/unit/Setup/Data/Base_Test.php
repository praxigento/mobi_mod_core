<?php
/**
 * Empty class to get stub for tests
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Setup\Data;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Praxigento\Core\Lib\Context;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

define('TEST_TABLE_NAME', 'table name');

class Base_UnitTest extends \Praxigento\Core\Lib\Test\BaseMockeryCase
{
    /** @var  \Mockery\MockInterface */
    private $mSetup;
    private $mContext;
    /** @var  ChildToTest */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        $this->mSetup = $this->_mock(\Magento\Framework\Setup\ModuleDataSetupInterface::class);
        $this->mContext = $this->_mock(\Magento\Framework\Setup\ModuleContextInterface::class);
        $this->obj = new ChildToTest();
    }

    public function test_install()
    {      /* === Test Data === */
        /* === Setup Mocks === */
        // $setup->startSetup();
        $this->mSetup
            ->shouldReceive('startSetup')->once();
        // $this->_setup($setup, $context);
        // $this->_getConn();
        // return $this->_setup->getConnection();
        $mConn = $this->_mock(\Magento\Framework\DB\Adapter\AdapterInterface::class);
        $this->mSetup
            ->shouldReceive('getConnection')
            ->andReturn($mConn);
        // $this->_getTableName(TEST_TABLE_NAME);
        // $result = $this->_setup->getConnection()->getTableName($entityName);
        $mConn->shouldReceive('getTableName')->once()
            ->with(TEST_TABLE_NAME);
        // $setup->endSetup();
        $this->mSetup
            ->shouldReceive('endSetup')->once();
        /* === Call and asserts  === */
        $this->obj->install($this->mSetup, $this->mContext);
    }

}

class ChildToTest extends Base
{
    protected function _setup()
    {
        $this->_getConn();
        $this->_getTableName(TEST_TABLE_NAME);
        1 + 1;
    }

}