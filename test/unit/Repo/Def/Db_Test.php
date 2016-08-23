<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class ChildToTestDb extends Db
{

}

class Db_UnitTest extends \Praxigento\Core\Test\BaseCase\Mockery
{
    /** @var  \Mockery\MockInterface */
    private $mConn;
    /** @var  Db */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mConn = $this->_mockConn();
        $this->mRepoGeneric = $this->_mockRepoGeneric();
        /** create object to test */
        $mResource = $this->_mockResourceConnection($this->mConn);
        $this->obj = new ChildToTestDb($mResource);
    }

    public function test_constructor()
    {
        /** === Call and asserts  === */
        $this->assertInstanceOf(\Praxigento\Core\Repo\IDb::class, $this->obj);
    }

    public function test_getConnection()
    {
        /** === Call and asserts  === */
        $res = $this->obj->getConnection();
        $this->assertInstanceOf(\Magento\Framework\DB\Adapter\AdapterInterface::class, $res);
    }

    public function test_getResource()
    {
        /** === Call and asserts  === */
        $res = $this->obj->getResource();
        $this->assertInstanceOf(\Magento\Framework\App\ResourceConnection::class, $res);
    }

}