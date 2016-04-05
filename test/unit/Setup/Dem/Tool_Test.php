<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Setup\Dem;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class Tool_UnitTest extends \Praxigento\Core\Lib\Test\BaseMockeryCase
{
    /** @var  \Mockery\MockInterface */
    private $mSetup;
    /** @var  \Mockery\MockInterface */
    private $mContext;
    /** @var  \Mockery\MockInterface */
    private $mConn;
    /** @var  \Mockery\MockInterface */
    private $mParser;
    /** @var  Tool */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /* create mocks */
        $this->mConn = $this->_mockConn();
        $this->mParser = $this->_mock(\Praxigento\Core\Setup\Dem\Parser::class);
        $this->mSetup = $this->_mock(\Magento\Framework\Setup\SchemaSetupInterface::class);
        $this->mContext = $this->_mock(\Magento\Framework\Setup\ModuleContextInterface::class);
        /* create object */
        $mResource = $this->_mockResourceConnection($this->mConn);
        $this->obj = new Tool($mResource, $this->mParser);
    }

//    public function test_readDemPackage()
//    {
//        /* === Test Data === */
//        /* === Setup Mocks === */
//        /* === Call and asserts  === */
////        $this->obj->readDemPackage('pathToDemFile', 'pathToDemNode');
//    }

}