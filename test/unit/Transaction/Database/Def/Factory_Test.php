<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Transaction\Database\Def;

include_once(__DIR__ . '/../../../phpunit_bootstrap.php');

class Factory_UnitTest extends \Praxigento\Core\Test\BaseCase\Mockery
{

    /** @var  \Mockery\MockInterface */
    private $mManObj;
    /** @var  \Mockery\MockInterface */
    private $mConfigDeployment;
    /** @var  \Mockery\MockInterface */
    private $mFactoryConn;
    /** @var  Factory */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mManObj = $this->_mock(\Magento\Framework\ObjectManagerInterface::class);
        $this->mConfigDeployment = $this->_mock(\Magento\Framework\App\DeploymentConfig::class);
        $this->mFactoryConn = $this->_mock(\Magento\Framework\Model\ResourceModel\Type\Db\ConnectionFactory::class);
        $this->obj = new Factory(
            $this->mManObj,
            $this->mConfigDeployment,
            $this->mFactoryConn
        );
    }

    public function test_constructor()
    {
        $this->assertInstanceOf(\Praxigento\Core\Transaction\Database\IFactory::class, $this->obj);
    }

    public function test_create_new()
    {
        /** === Test Data === */
        $TRANS = 'transaction name';
        $CONN = 'connection name';
        /** === Setup Mocks === */
        // $result = $this->_manObj->create(\Praxigento\Core\Transaction\Database\Def\Item::class);
        $mResult = $this->_mock(\Praxigento\Core\Transaction\Database\Def\Item::class);
        $this->mManObj
            ->shouldReceive('create')->once()
            ->andReturn($mResult);
        // $result->setTransactionName($transactionName);
        $mResult
            ->shouldReceive('setTransactionName')->once()
            ->with($TRANS);
        // $result->setConnectionName($connectionName);
        $mResult
            ->shouldReceive('setConnectionName')->once()
            ->with($CONN);
        // $cfgData = $this->_configDeployment->get($cfgName);
        $mCfgData = [];
        $this->mConfigDeployment
            ->shouldReceive('get')->once()
            ->andReturn($mCfgData);
        // $conn = $this->_factoryConn->create($cfgData);
        $mConn = $this->_mock(\Magento\Framework\DB\Adapter\AdapterInterface::class);
        $this->mFactoryConn
            ->shouldReceive('create')->once()
            ->andReturn($mConn);
        // $result->setConnection($conn);
        $mResult
            ->shouldReceive('setConnection')->once();
        /** === Call and asserts  === */
        $res = $this->obj->create($TRANS, $CONN);
        $this->assertTrue($res instanceof \Praxigento\Core\Transaction\Database\IItem);
    }
}