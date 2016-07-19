<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Transaction\Def;


include_once(__DIR__ . '/../../../phpunit_bootstrap.php');

class Manager_UnitTest extends \Praxigento\Core\Test\BaseMockeryCase
{
    /** @var  \Mockery\MockInterface */
    private $mConn;
    /** @var  \Mockery\MockInterface */
    private $mManObj;
    /** @var  Manager */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mConn = $this->_mockConn();
        $this->mManObj = $this->_mock(\Magento\Framework\ObjectManagerInterface::class);
        /** create object to test */
        $mResource = $this->_mockResourceConnection($this->mConn);
        $this->obj = new Manager($mResource, $this->mManObj);
    }

    public function test_begin()
    {
        /** === Test Data === */
        $LEVEL = 1;
        /** === Setup Mocks === */
        // $this->_conn->beginTransaction();
        $this->mConn
            ->shouldReceive('beginTransaction')->once();
        // $result = $this->manObj->create(IDefinition::class);
        $mDef = new Definition();
        $this->mManObj
            ->shouldReceive('create')->once()
            ->andReturn($mDef);
        // $result->setLevel($this->_transactionLevel);
        /** === Call and asserts  === */
        $res = $this->obj->transactionBegin();
        $this->assertEquals($LEVEL, $res->getLevel());
    }

    public function test_close_committed()
    {
        /** === Test Data === */
        $LEVEL = 1;
        $mTrans = new Definition();
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
        $mTrans = new Definition();
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
        $mTrans = new Definition();
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
        $mTrans = new Definition();
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
        $mTrans = new Definition();
        $mTrans->setLevel($LEVEL);
        /** === Setup Mocks === */
        // $this->_conn->rollBack();
        $this->mConn
            ->shouldReceive('rollBack')->once();
        /** === Call and asserts  === */
        $this->obj->transactionRollback($mTrans);
    }

}
