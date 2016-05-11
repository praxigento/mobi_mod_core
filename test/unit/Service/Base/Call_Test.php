<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Service\Base;


include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class Call_UnitTest extends \Praxigento\Core\Test\BaseMockeryCase
{
    /** @var  \Mockery\MockInterface */
    private $mLogger;

    /** @var  ChildToTest */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mLogger = $this->_mockLogger();
        /* create object */
        $this->obj = new ChildToTest($this->mLogger);
    }

    public function test_logMemoryUsage()
    {
        /** === Setup Mocks === */
        $this->mLogger
            ->shouldReceive('debug')->once();
        /** === Call and asserts  === */
        $this->obj->oper();
    }

}


class ChildToTest extends Call
{
    public function oper()
    {
        $this->_logMemoryUsage();
    }
}