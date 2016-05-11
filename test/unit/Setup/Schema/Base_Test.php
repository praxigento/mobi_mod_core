<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Setup\Schema;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class Base_UnitTest extends \Praxigento\Core\Test\BaseMockeryCase
{
    /** @var  \Mockery\MockInterface */
    private $mSetup;
    /** @var  \Mockery\MockInterface */
    private $mContext;
    /** @var  \Mockery\MockInterface */
    private $mConn;
    /** @var  \Mockery\MockInterface */
    private $mToolDem;
    /** @var  ChildToTest */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mConn = $this->_mockConn();
        $this->mToolDem = $this->_mock(\Praxigento\Core\Setup\Dem\Tool::class);
        $this->mSetup = $this->_mock(\Magento\Framework\Setup\SchemaSetupInterface::class);
        $this->mContext = $this->_mock(\Magento\Framework\Setup\ModuleContextInterface::class);
        /* create object */
        $mResource = $this->_mockResourceConnection($this->mConn);
        $this->obj = new ChildToTest($mResource, $this->mToolDem);
    }

    public function test_install()
    {
        /** === Test Data === */
        /** === Setup Mocks === */
        // $setup->startSetup();
        $this->mSetup
            ->shouldReceive('startSetup')->once();
        // $this->_setup();
        // $this->_toolDem->readDemPackage('pathToFile', 'pathToNode');
        $this->mToolDem
            ->shouldReceive('readDemPackage')->once();
        // $setup->endSetup();
        $this->mSetup
            ->shouldReceive('endSetup')->once();
        /** === Call and asserts  === */
        $this->obj->install($this->mSetup, $this->mContext);
    }

}

class ChildToTest extends Base
{
    protected function _setup()
    {
        $this->_toolDem->readDemPackage('pathToFile', 'pathToNode');
    }

}