<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Transaction\Database\Def;

include_once(__DIR__ . '/../../../phpunit_bootstrap.php');

class Item_UnitTest extends \Praxigento\Core\Test\BaseCase\Mockery
{
    const CONN = 'connection name';
    const LEVEL = 'level';
    const NAME = 'transaction name';
    /** @var  \Mockery\MockInterface */
    private $mConn;
    /** @var  \Mockery\MockInterface */
    private $mResource;
    /** @var  Item */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mConn = $this->_mockConn();
        $this->mResource = $this->_mockResourceConnection($this->mConn);
        /** create object to test */
        $this->obj = new Item(
            $this->mResource
        );
    }

    public function test_accessorsConnection()
    {
        /** === Test Data === */
        $CONN_NAME = 'connection name';
        $CONN = 'connection';
        /** === Setup Mocks === */
        // $this->_conn = $this->_resource->getConnectionByName($this->_nameConn);
        $mConn = $this->_mockConn();
        $this->mResource
            ->shouldReceive('getConnectionByName')->once()
            ->andReturn($mConn);
        /** === Call and asserts  === */
        $res = $this->obj->getConnection($CONN_NAME);
        $this->assertTrue($res instanceof \Magento\Framework\DB\Adapter\AdapterInterface);
        $this->obj->setConnection($CONN);
        $res = $this->obj->getConnection();
        $this->assertEquals($CONN, $res);
    }

    public function test_accessorsConnectionName()
    {
        /** === Test Data === */
        $CONN_NAME = 'connection name';
        /** === Call and asserts  === */
        $this->obj->setConnectionName($CONN_NAME);
        $res = $this->obj->getConnectionName();
        $this->assertEquals($CONN_NAME, $res);
    }

    public function test_accessorsLevel()
    {
        /** === Test Data === */
        $LEVEL = 128;
        /** === Call and asserts  === */
        $this->obj->setLevel($LEVEL);
        $res = $this->obj->getLevel();
        $this->assertEquals($LEVEL, $res);
    }

    public function test_accessorsResource()
    {
        /** === Call and asserts  === */
        $mResource = $this->_mockResourceConnection();
        $this->obj->setResource($mResource);
    }

    public function test_accessorsTransactionName()
    {
        /** === Test Data === */
        $NAME = 'transaction name';
        /** === Call and asserts  === */
        $this->obj->setTransactionName($NAME);
        $res = $this->obj->getTransactionName();
        $this->assertEquals($NAME, $res);
    }

    public function test_definition()
    {
        /** === Test Data === */
        $TRANS = 'transaction name';
        $CONN = 'transaction name';
        $LEVEL = 8;
        /** === Call and asserts  === */
        $this->obj->setTransactionName($TRANS);
        $this->obj->setConnectionName($CONN);
        $this->obj->setLevel($LEVEL);
        /** @var \Praxigento\Core\Transaction\Database\IDefinition $res */
        $res = $this->obj->getDefinition();
        $this->assertTrue($res instanceof \Praxigento\Core\Transaction\Database\IDefinition);
        $this->assertEquals($TRANS, $res->getTransactionName());
        $this->assertEquals($CONN, $res->getConnectionName());
        $this->assertEquals($LEVEL, $res->getLevel());
    }

    public function test_constructor()
    {
        $this->assertInstanceOf(\Praxigento\Core\Transaction\Database\IItem::class, $this->obj);
    }

    public function test_level()
    {
        /** === Test Data === */
        $LEVEL = 16;
        /** === Call and asserts  === */
        $this->obj->setLevel($LEVEL);
        $res = $this->obj->getLevel();
        $this->assertEquals($LEVEL, $res);
        $this->obj->levelIncrease();
        $res = $this->obj->getLevel();
        $this->assertEquals($LEVEL + 1, $res);
        $this->obj->levelDecrease();
        $res = $this->obj->getLevel();
        $this->assertEquals($LEVEL, $res);
    }
}