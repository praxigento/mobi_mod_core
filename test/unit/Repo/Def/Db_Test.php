<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class ChildToTestDb extends Db
{

}

class Db_UnitTest
    extends \Praxigento\Core\Test\BaseCase\Repo
{
    /** @var  Db */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create object to test */
        $this->obj = new ChildToTestDb(
            $this->mResource
        );
    }

    public function test_constructor()
    {
        /** === Call and asserts  === */
        $this->assertInstanceOf(\Praxigento\Core\Repo\IDb::class, $this->obj);
    }

    public function test_getConnection()
    {
        /** === Setup Mocks === */
        $this->mResource
            ->shouldReceive('getConnection')
            ->andReturn($this->mConn);
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