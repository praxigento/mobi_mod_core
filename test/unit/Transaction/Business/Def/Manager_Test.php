<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Transaction\Business\Def;

include_once(__DIR__ . '/../../../phpunit_bootstrap.php');

class Manager_UnitTest extends \Praxigento\Core\Test\BaseCase\Mockery
{

    /** @var  \Mockery\MockInterface */
    private $mFactoryTrans;
    /** @var  Manager */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mFactoryTrans = $this->_mock(\Praxigento\Core\Transaction\Business\IFactory::class);
        $this->obj = new Manager(
            $this->mFactoryTrans
        );
    }

    public function test_begin()
    {
        /** === Test Data === */
        $TRANS_NAME = 'transaction name';
        /** === Setup Mocks === */
        // $result = $this->_factoryTrans->create($transactionName);
        $mResult = $this->_mock(\Praxigento\Core\Transaction\Business\IItem::class);
        $this->mFactoryTrans
            ->shouldReceive('create')->once()
            ->with($TRANS_NAME)
            ->andReturn($mResult);
        // $result->setLevel($level);
        $mResult->shouldReceive('setLevel')->once();
        /** === Call and asserts  === */
        $this->obj->begin($TRANS_NAME);
        $res = $this->obj->begin($TRANS_NAME);
        $this->assertTrue($res instanceof \Praxigento\Core\Transaction\Business\IItem);
    }

    public function test_commit_currentLevel()
    {
        /** === Test Data === */
        $TRANS_NAME = 'transaction name';
        /** === Setup Mocks === */
        // $item = $this->obj->begin($TRANS_NAME);
        // $result = $this->_factoryTrans->create($transactionName);
        $mItem = new \Praxigento\Core\Transaction\Business\Def\Item($this->_mockLogger());
        $mItem->setName($TRANS_NAME);
        $this->mFactoryTrans
            ->shouldReceive('create')->once()
            ->with($TRANS_NAME)
            ->andReturn($mItem);
        /** === Call and asserts  === */
        $item = $this->obj->begin($TRANS_NAME);
        $this->obj->commit($TRANS_NAME, $item->getLevel());
    }

    /**
     * @expectedException \Exception
     */
    public function test_commit_exception()
    {
        /** === Test Data === */
        $TRANS_NAME = 'transaction name';
        $TRANS_LEVEL = 1;
        /** === Setup Mocks === */
        /** === Call and asserts  === */
        $this->obj->commit($TRANS_NAME, $TRANS_LEVEL);
    }

    public function test_commit_missedLevel()
    {
        /** === Test Data === */
        $TRANS_NAME = 'transaction name';
        $TRANS_LEVEL = -1;
        /** === Setup Mocks === */
        // $item = $this->obj->begin($TRANS_NAME);
        // $result = $this->_factoryTrans->create($transactionName);
        $mItem = new \Praxigento\Core\Transaction\Business\Def\Item($this->_mockLogger());
        $mItem->setName($TRANS_NAME);
        $this->mFactoryTrans
            ->shouldReceive('create')->once()
            ->with($TRANS_NAME)
            ->andReturn($mItem);
        /** === Call and asserts  === */
        $this->obj->begin($TRANS_NAME);
        $this->obj->commit($TRANS_NAME, $TRANS_LEVEL);
    }

    public function test_constructor()
    {
        /** === Call and asserts  === */
        $this->assertInstanceOf(Manager::class, $this->obj);
    }

    /**
     * @expectedException \Exception
     */
    public function test_end_exception()
    {
        /** === Test Data === */
        $TRANS_NAME = 'transaction name';
        /** === Setup Mocks === */
        /** === Call and asserts  === */
        $this->obj->end($TRANS_NAME);
    }

    public function test_end_success()
    {
        /** === Test Data === */
        $TRANS_NAME = 'transaction name';
        /** === Setup Mocks === */
        // $item = $this->obj->begin($TRANS_NAME);
        // $result = $this->_factoryTrans->create($transactionName);
        $mItem = new \Praxigento\Core\Transaction\Business\Def\Item($this->_mockLogger());
        $mItem->setName($TRANS_NAME);
        $this->mFactoryTrans
            ->shouldReceive('create')->once()
            ->with($TRANS_NAME)
            ->andReturn($mItem);
        /** === Call and asserts  === */
        $this->obj->begin($TRANS_NAME);
        $this->obj->end($TRANS_NAME);
    }

    /**
     * @expectedException \Exception
     */
    public function test_rollback_exception()
    {
        /** === Test Data === */
        $TRANS_NAME = 'transaction name';
        $TRANS_LEVEL = 1;
        /** === Setup Mocks === */
        /** === Call and asserts  === */
        $this->obj->rollback($TRANS_NAME, $TRANS_LEVEL);
    }

    public function test_rollback_success()
    {
        /** === Test Data === */
        $TRANS_NAME = 'transaction name';
        /** === Setup Mocks === */
        // $item = $this->obj->begin($TRANS_NAME);
        // $result = $this->_factoryTrans->create($transactionName);
        $mItem = new \Praxigento\Core\Transaction\Business\Def\Item($this->_mockLogger());
        $mItem->setName($TRANS_NAME);
        $this->mFactoryTrans
            ->shouldReceive('create')->once()
            ->with($TRANS_NAME)
            ->andReturn($mItem);
        /** === Call and asserts  === */
        $item = $this->obj->begin($TRANS_NAME);
        $this->obj->rollback($TRANS_NAME, $item->getLevel());
    }
}