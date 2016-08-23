<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Transaction\Database\Def;

include_once(__DIR__ . '/../../../phpunit_bootstrap.php');

class Manager_UnitTest extends \Praxigento\Core\Test\BaseCase\Mockery
{

    /** @var  \Mockery\MockInterface */
    private $mFactoryTrans;
    /** @var  \Mockery\MockInterface */
    private $mTransItem;
    /** @var  Manager */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mFactoryTrans = $this->_mock(\Praxigento\Core\Transaction\Database\IFactory::class);
        $this->mTransItem = $this->_mock(\Praxigento\Core\Transaction\Database\IItem::class);
        /** setup mocks for constructor */
        // $trans = $this->_factoryTrans->create(self::DEF_TRANSACTION, self::DEF_CONNECTION);
        $this->mFactoryTrans
            ->shouldReceive('create')->once()
            ->andReturn($this->mTransItem);
        /** create object to test */
        $this->obj = new Manager(
            $this->mFactoryTrans
        );
    }

    public function test_begin_default()
    {
        /** === Test Data === */
        $DEFINITION = 'transaction definition';
        /** === Setup Mocks === */
        // $conn = $trans->getConnection();
        $mConn = $this->_mockConn();
        $this->mTransItem
            ->shouldReceive('getConnection')->once()
            ->andReturn($mConn);
        // $conn->beginTransaction();
        $mConn->shouldReceive('beginTransaction')->once();
        // $trans->levelIncrease();
        $this->mTransItem
            ->shouldReceive('levelIncrease')->once();
        // $result = $trans->getDefinition();
        $this->mTransItem
            ->shouldReceive('getDefinition')->once()
            ->andReturn($DEFINITION);
        /** === Call and asserts  === */
        $res = $this->obj->begin();
        $this->assertEquals($DEFINITION, $res);
    }


    public function test_begin_named()
    {
        /** === Test Data === */
        $TRANS_NAME = 'transaction';
        $CONN_NAME = 'connection';
        $DEFINITION = 'transaction definition';
        /** === Setup Mocks === */
        // $trans = $this->_factoryTrans->create($transactionName, $connectionName);
        $this->mFactoryTrans
            ->shouldReceive('create')->once()
            ->with($TRANS_NAME, $CONN_NAME)
            ->andReturn($this->mTransItem);
        // $conn = $trans->getConnection();
        $mConn = $this->_mockConn();
        $this->mTransItem
            ->shouldReceive('getConnection')->once()
            ->andReturn($mConn);
        // $conn->beginTransaction();
        $mConn->shouldReceive('beginTransaction')->once();
        // $trans->levelIncrease();
        $this->mTransItem
            ->shouldReceive('levelIncrease')->once();
        // $result = $trans->getDefinition();
        $this->mTransItem
            ->shouldReceive('getDefinition')->once()
            ->andReturn($DEFINITION);
        /** === Call and asserts  === */
        $res = $this->obj->begin($TRANS_NAME, $CONN_NAME);
        $this->assertEquals($DEFINITION, $res);
    }

    /**
     * @expectedException \Exception
     */
    public function test_commit_exception()
    {
        /** === Test Data === */
        $TRANS_NAME = 'transaction';
        $CONN_NAME = 'connection';
        $LEVEL = 4;
        $def = new \Praxigento\Core\Transaction\Database\Def\Definition($TRANS_NAME, $CONN_NAME, $LEVEL);
        /** === Setup Mocks === */
        /** === Call and asserts  === */
        $this->obj->commit($def);
    }

    public function test_commit_withCommit()
    {
        /** === Test Data === */
        $TRANS_NAME = \Praxigento\Core\Transaction\Database\IManager::DEF_TRANSACTION;
        $CONN_NAME = \Praxigento\Core\Transaction\Database\IManager::DEF_CONNECTION;
        $LEVEL = 4;
        $def = new \Praxigento\Core\Transaction\Database\Def\Definition($TRANS_NAME, $CONN_NAME, $LEVEL);
        /** === Setup Mocks === */
        // $maxLevel = $item->getLevel();
        $this->mTransItem
            ->shouldReceive('getLevel')->once()
            ->andReturn($LEVEL);
        // $conn = $item->getConnection();
        $mConn = $this->_mockConn(['commit']);
        $this->mTransItem
            ->shouldReceive('getConnection')->once()
            ->andReturn($mConn);
        // $conn->commit();
        // $item->levelDecrease();
        $this->mTransItem
            ->shouldReceive('levelDecrease')->once();
        /** === Call and asserts  === */
        $this->obj->commit($def);
    }

    public function test_commit_withRollback()
    {
        /** === Test Data === */
        $TRANS_NAME = \Praxigento\Core\Transaction\Database\IManager::DEF_TRANSACTION;
        $CONN_NAME = \Praxigento\Core\Transaction\Database\IManager::DEF_CONNECTION;
        $LEVEL = 4;
        $def = new \Praxigento\Core\Transaction\Database\Def\Definition($TRANS_NAME, $CONN_NAME, $LEVEL);
        /** === Setup Mocks === */
        // $maxLevel = $item->getLevel();
        $this->mTransItem
            ->shouldReceive('getLevel')->once()
            ->andReturn($LEVEL + 1);
        // $conn = $item->getConnection();
        $mConn = $this->_mockConn(['rollBack']);
        $this->mTransItem
            ->shouldReceive('getConnection')->once()
            ->andReturn($mConn);
        // $conn->rollBack();
        // $item->levelDecrease();
        $this->mTransItem
            ->shouldReceive('levelDecrease')->once();
        /** === Call and asserts  === */
        $this->obj->commit($def);
    }

    public function test_constructor()
    {
        $this->assertInstanceOf(\Praxigento\Core\Transaction\Database\IManager::class, $this->obj);
    }

    /**
     * @expectedException \Exception
     */
    public function test_end_exception()
    {
        /** === Test Data === */
        $TRANS_NAME = 'transaction';
        $CONN_NAME = 'connection';
        $LEVEL = 4;
        $def = new \Praxigento\Core\Transaction\Database\Def\Definition($TRANS_NAME, $CONN_NAME, $LEVEL);
        /** === Setup Mocks === */
        /** === Call and asserts  === */
        $this->obj->end($def);
    }

    public function test_end_success()
    {
        /** === Test Data === */
        $TRANS_NAME = \Praxigento\Core\Transaction\Database\IManager::DEF_TRANSACTION;
        $CONN_NAME = \Praxigento\Core\Transaction\Database\IManager::DEF_CONNECTION;
        $LEVEL = 4;
        $def = new \Praxigento\Core\Transaction\Database\Def\Definition($TRANS_NAME, $CONN_NAME, $LEVEL);
        /** === Setup Mocks === */
        // $maxLevel = $item->getLevel();
        $this->mTransItem
            ->shouldReceive('getLevel')->once()
            ->andReturn($LEVEL + 1);
        // $conn = $item->getConnection();
        $mConn = $this->_mockConn(['rollBack']);
        $this->mTransItem
            ->shouldReceive('getConnection')
            ->andReturn($mConn);
        // $conn->rollBack();
        // $item->levelDecrease();
        $this->mTransItem
            ->shouldReceive('levelDecrease');
        /** === Call and asserts  === */
        $this->obj->end($def);
    }

    public function test_getConnection_exist()
    {
        /** === Test Data === */
        $TRANS_NAME = \Praxigento\Core\Transaction\Database\IManager::DEF_TRANSACTION;
        $CONN_NAME = \Praxigento\Core\Transaction\Database\IManager::DEF_CONNECTION;
        $LEVEL = 4;
        $def = new \Praxigento\Core\Transaction\Database\Def\Definition($TRANS_NAME, $CONN_NAME, $LEVEL);
        /** === Setup Mocks === */
        // $result = $registered->getConnection();
        $mResult = $this->_mockConn();
        $this->mTransItem
            ->shouldReceive('getConnection')->once()
            ->andReturn($mResult);
        /** === Call and asserts  === */
        $res = $this->obj->getConnection($def);
        $this->assertTrue($res instanceof \Magento\Framework\DB\Adapter\AdapterInterface);
    }

    public function test_getConnection_null()
    {
        /** === Test Data === */
        $TRANS_NAME = 'transaction';
        $CONN_NAME = 'connection';
        $LEVEL = 4;
        $def = new \Praxigento\Core\Transaction\Database\Def\Definition($TRANS_NAME, $CONN_NAME, $LEVEL);
        /** === Setup Mocks === */
        // $result = $registered->getConnection();
        $mResult = $this->_mockConn();
        $this->mTransItem
            ->shouldReceive('getConnection')->once()
            ->andReturn($mResult);
        /** === Call and asserts  === */
        $res = $this->obj->getConnection($def);
        $this->assertNull($res);
    }

    /**
     * @expectedException \Exception
     */
    public function test_rollback_exception()
    {
        /** === Test Data === */
        $TRANS_NAME = 'transaction';
        $CONN_NAME = 'connection';
        $LEVEL = 4;
        $def = new \Praxigento\Core\Transaction\Database\Def\Definition($TRANS_NAME, $CONN_NAME, $LEVEL);
        /** === Setup Mocks === */
        /** === Call and asserts  === */
        $this->obj->rollback($def);
    }

    public function test_rollback_success()
    {
        /** === Test Data === */
        $TRANS_NAME = \Praxigento\Core\Transaction\Database\IManager::DEF_TRANSACTION;
        $CONN_NAME = \Praxigento\Core\Transaction\Database\IManager::DEF_CONNECTION;
        $LEVEL = 4;
        $def = new \Praxigento\Core\Transaction\Database\Def\Definition($TRANS_NAME, $CONN_NAME, $LEVEL);
        /** === Setup Mocks === */
        // $maxLevel = $item->getLevel();
        $this->mTransItem
            ->shouldReceive('getLevel')->once()
            ->andReturn($LEVEL + 1);
        // $conn = $item->getConnection();
        $mConn = $this->_mockConn(['rollBack']);
        $this->mTransItem
            ->shouldReceive('getConnection')
            ->andReturn($mConn);
        // $conn->rollBack();
        // $item->levelDecrease();
        $this->mTransItem
            ->shouldReceive('levelDecrease');
        /** === Call and asserts  === */
        $this->obj->rollback($def);
    }
}