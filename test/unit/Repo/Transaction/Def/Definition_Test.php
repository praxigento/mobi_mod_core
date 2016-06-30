<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Transaction\Def;


include_once(__DIR__ . '/../../../phpunit_bootstrap.php');

class Definition_UnitTest extends \Praxigento\Core\Test\BaseMockeryCase
{
    /** @var  Definition */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create object to test */
        $this->obj = new Definition();
    }


    public function test_accessors()
    {
        $LEVEL = 21;
        $this->obj->setLevel($LEVEL);
        $this->assertEquals($LEVEL, $this->obj->getLevel());
    }

}
