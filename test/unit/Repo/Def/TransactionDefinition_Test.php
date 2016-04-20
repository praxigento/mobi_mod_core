<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;


include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class TransactionDefinition_UnitTest extends \Praxigento\Core\Test\BaseMockeryCase
{
    /** @var  TransactionDefinition */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /* create mocks */
        /* create object */
        $this->obj = new TransactionDefinition();
    }


    public function test_accessors()
    {
        $LEVEL = 21;
        $this->obj->setLevel($LEVEL);
        $this->assertEquals($LEVEL, $this->obj->getLevel());
    }

}
