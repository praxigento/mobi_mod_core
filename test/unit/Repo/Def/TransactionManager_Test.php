<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;


include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class TransactionManager_UnitTest extends \Praxigento\Core\Test\BaseMockeryCase
{
    /** @var  \Mockery\MockInterface */
    private $mConn;
    /** @var  \Mockery\MockInterface */
    private $mManObj;
    /** @var  TransactionManager */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mConn = $this->_mockConn();
        $this->mManObj = $this->_mock(\Magento\Framework\ObjectManagerInterface::class);
        /** create object to test */
        $mResource = $this->_mockResourceConnection($this->mConn);
        $this->obj = new TransactionManager($mResource, $this->mManObj);
    }

    public function test_begin()
    {
        /** === Test Data === */
        $LEVEL = 1;
        /** === Setup Mocks === */
        // $this->_conn->beginTransaction();
        $this->mConn
            ->shouldReceive('beginTransaction')->once();
        // $result = $this->manObj->create(ITransactionDefinition::class);
        $mTrans = new TransactionDefinition();
        $this->mManObj
            ->shouldReceive('create')->once()
            ->andReturn($mTrans);
        // $result->setLevel($this->_transactionLevel);
        /** === Call and asserts  === */
        $res = $this->obj->transactionBegin();
        $this->assertEquals($LEVEL, $res->getLevel());
    }

    public function test_close_committed()
    {
        /** === Test Data === */
        $LEVEL = 1;
        $mTrans = new TransactionDefinition();
        $mTrans->setLevel($LEVEL);
        /** === Setup Mocks === */
        // $this->_conn->rollBack();
        $this->mConn
            ->shouldReceive('rollBack')->once();
        /** === Call and asserts  === */
        $this->obj->transactionClose($mTrans);
    }
    public function test_close_other()
    {
        /** === Test Data === */
        $LEVEL = 2;
        $mTrans = new TransactionDefinition();
        $mTrans->setLevel($LEVEL);
        /** === Setup Mocks === */
        $this->mConn
            ->shouldNotReceive('rollBack');
        /** === Call and asserts  === */
        $this->obj->transactionClose($mTrans);
    }

    public function test_close_rollback()
    {
        /** === Test Data === */
        $LEVEL = 0;
        $mTrans = new TransactionDefinition();
        $mTrans->setLevel($LEVEL);
        /** === Setup Mocks === */
        // $this->_conn->rollBack();
        $this->mConn
            ->shouldReceive('rollBack')->once();
        /** === Call and asserts  === */
        $this->obj->transactionClose($mTrans);
    }

    public function test_commit()
    {
        /** === Test Data === */
        $LEVEL = 0;
        $mTrans = new TransactionDefinition();
        $mTrans->setLevel($LEVEL);
        /** === Setup Mocks === */
        // $this->_conn->commit();
        $this->mConn
            ->shouldReceive('commit')->once();
        /** === Call and asserts  === */
        $this->obj->transactionCommit($mTrans);
    }

    public function test_rollback()
    {
        /** === Test Data === */
        $LEVEL = 0;
        $mTrans = new TransactionDefinition();
        $mTrans->setLevel($LEVEL);
        /** === Setup Mocks === */
        // $this->_conn->rollBack();
        $this->mConn
            ->shouldReceive('rollBack')->once();
        /** === Call and asserts  === */
        $this->obj->transactionRollback($mTrans);
    }

}
