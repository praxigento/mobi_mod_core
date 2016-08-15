<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Transaction\Business\Def;

include_once(__DIR__ . '/../../../phpunit_bootstrap.php');

class Factory_UnitTest extends \Praxigento\Core\Test\BaseMockeryCase
{

    /** @var  \Mockery\MockInterface */
    private $mManObj;
    /** @var  Factory */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mManObj = $this->_mock(\Magento\Framework\ObjectManagerInterface::class);
        $this->obj = new Factory(
            $this->mManObj
        );
    }

    public function test_constructor()
    {
        /** === Call and asserts  === */
        $this->assertInstanceOf(Factory::class, $this->obj);
    }

    public function test_create()
    {
        /** === Test Data === */
        $NAME = 'name';
        /** === Setup Mocks === */
        // $result = $this->_manObj->create(\Praxigento\Core\Transaction\Business\Def\Item::class);
        $mResult = $this->_mock(\Praxigento\Core\Transaction\Business\Def\Item::class);
        $this->mManObj
            ->shouldReceive('create')->once()
            ->andReturn($mResult);
        // $result->setName($name);
        $mResult
            ->shouldReceive('setName')->once()
            ->with($NAME);
        /** === Call and asserts  === */
        $res = $this->obj->create($NAME);
        $this->assertTrue($res instanceof \Praxigento\Core\Transaction\Business\IItem);
    }
}