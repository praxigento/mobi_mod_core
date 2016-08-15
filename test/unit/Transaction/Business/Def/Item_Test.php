<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Transaction\Business\Def;

include_once(__DIR__ . '/../../../phpunit_bootstrap.php');

class Item_UnitTest extends \Praxigento\Core\Test\BaseMockeryCase
{

    /** @var  \Mockery\MockInterface */
    private $mLogger;
    /** @var  Item */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mLogger = $this->_mockLogger();
        $this->obj = new Item(
            $this->mLogger
        );
    }

    public function test_accessors()
    {
        /** === Test Data === */
        $NAME = 'name';
        $LEVEL = 'level';
        /** === Setup Mocks === */
        /** === Call and asserts  === */
        $this->obj->setName($NAME);
        $this->obj->setLevel($LEVEL);
        $this->assertEquals($NAME, $this->obj->getName());
        $this->assertEquals($LEVEL, $this->obj->getLevel());
    }

    public function test_callback()
    {
        /** === Test Data === */
        /** === Setup Mocks === */
        $mCallable = function () {
            throw new \Exception();
        };
        /** === Call and asserts  === */
        $this->obj->addCommitCall($mCallable);
        $this->obj->commit();
    }

    public function test_constructor()
    {
        /** === Call and asserts  === */
        $this->assertInstanceOf(Item::class, $this->obj);
    }

    public function test_rollback()
    {
        /** === Test Data === */
        /** === Setup Mocks === */
        $mCallable = function () {
            throw new \Exception();
        };
        /** === Call and asserts  === */
        $this->obj->addRollbackCall($mCallable);
        $this->obj->rollback();
    }

}