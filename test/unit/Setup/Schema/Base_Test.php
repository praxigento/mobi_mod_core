<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\App\Setup\Schema;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class Base_UnitTest
    extends \Praxigento\Core\Test\BaseCase\Setup\Schema
{
    /** @var  ChildToTest */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create object to test */
        $this->obj = new ChildToTest(
            $this->mResource,
            $this->mToolDem
        );
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
    protected function setup()
    {
        $this->toolDem->readDemPackage('pathToFile', 'pathToNode');
    }

}