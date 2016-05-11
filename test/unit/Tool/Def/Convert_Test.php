<?php
/**
 * Datetime tool default implementation.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Tool\Def;

use Praxigento\Core\Config as Cfg;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class Convert_UnitTest extends \Praxigento\Core\Test\BaseMockeryCase
{


    /** @var  Convert */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        $this->obj = new Convert();
    }

    public function test_toDateTime()
    {
        /** === Test Data === */
        $DATE = '2015-08-23 21:32:43';
        /** === Call and asserts  === */
        /* string */
        $dt = $this->obj->toDateTime($DATE);
        $this->assertTrue($dt instanceof \DateTime);
        $this->assertEquals($DATE, $dt->format(Cfg::FORMAT_DATETIME));
        /* int */
        $dt = $this->obj->toDateTime($dt->getTimestamp());
        $this->assertTrue($dt instanceof \DateTime);
        $this->assertEquals($DATE, $dt->format(Cfg::FORMAT_DATETIME));
        /* \DateTime */
        $dt = $this->obj->toDateTime($dt);
        $this->assertTrue($dt instanceof \DateTime);
        $this->assertEquals($DATE, $dt->format(Cfg::FORMAT_DATETIME));
    }
}