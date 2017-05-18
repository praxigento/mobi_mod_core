<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Service\Base;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

/**
 * @SuppressWarnings(PHPMD.CamelCaseClassName)
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class Call_UnitTest
    extends \Praxigento\Core\Test\BaseCase\Service\Call
{
    /** @var  ChildToTest */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create object to test */
        $this->obj = new ChildToTest(
            $this->mLogger,
            $this->mManObj
        );
    }

    public function test_logMemoryUsage()
    {
        /** === Call and asserts  === */
        $this->obj->logMemoryUsage();
    }

}

class ChildToTest extends Call
{
    public function logMemoryUsage()
    {
        $this->logMemoryUsage();
    }
}