<?php
/**
 * Empty class to get stub for tests
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Api\Data\Def;

include_once(__DIR__ . '/../../../phpunit_bootstrap.php');

class Base_UnitTest extends \Praxigento\Core\Lib\Test\BaseMockeryCase
{
    /** @var Base */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        $this->obj = new Base();
    }

    public function test_implements()
    {
        $this->assertInstanceOf(\Praxigento\Core\Api\Data\IBase::class, $this->obj);
    }
}