<?php
/**
 * Empty class to get stub for tests
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Setup\Data;

use Praxigento\Core\Lib\Context;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

define('TEST_TABLE_NAME', 'table name');

class Base_UnitTest extends \Praxigento\Core\Lib\Test\BaseMockeryCase
{
    /** @var  \Mockery\MockInterface */
    private $mSetup;
    /** @var  \Mockery\MockInterface */
    private $mContext;
    /** @var  \Mockery\MockInterface */
    private $mConn;
    /** @var  \Mockery\MockInterface */
    private $mRepoBasic;
    /** @var  ChildToTest */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /* create mocks */
        $this->mConn = $this->_mockConn();
        $this->mRepoBasic = $this->_mockRepoBasic();
        $this->mSetup = $this->_mock(\Magento\Framework\Setup\ModuleDataSetupInterface::class);
        $this->mContext = $this->_mock(\Magento\Framework\Setup\ModuleContextInterface::class);
        /* create object */
        $mResource = $this->_mockResourceConnection($this->mConn);
        $this->obj = new ChildToTest($mResource, $this->mRepoBasic);
    }

    public function test_install()
    {
        /* === Test Data === */
        /* === Setup Mocks === */
        // $setup->startSetup();
        $this->mSetup
            ->shouldReceive('startSetup')->once();
        // $this->_setup();
        // $this->_conn->getTableName(TEST_TABLE_NAME);
        $this->mConn
            ->shouldReceive('getTableName')->once()
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
        $this->_conn->getTableName(TEST_TABLE_NAME);
    }

}