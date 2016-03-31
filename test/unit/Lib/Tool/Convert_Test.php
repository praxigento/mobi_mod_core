<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Tool;

use Praxigento\Core\Config;
use Praxigento\Core\Lib\Context;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class Convert_UnitTest extends \Praxigento\Core\Lib\Test\BaseTestCase {

    public function test_constructor() {
        /** @var  $obj Convert */
        $obj = new \Praxigento\Core\Lib\Tool\Convert();
        $this->assertNotNull($obj);
    }


    public function test_toDateTime() {
        /** @var  $obj Convert */
        $obj = new \Praxigento\Core\Lib\Tool\Convert();
        $DATE = '2015-08-23 21:32:43';
        /* string */
        $dt = $obj->toDateTime($DATE);
        $this->assertTrue($dt instanceof \DateTime);
        $this->assertEquals($DATE, $dt->format(Config::FORMAT_DATETIME));
        /* int */
        $dt = $obj->toDateTime($dt->getTimestamp());
        $this->assertTrue($dt instanceof \DateTime);
        $this->assertEquals($DATE, $dt->format(Config::FORMAT_DATETIME));
        /* \DateTime */
        $dt = $obj->toDateTime($dt);
        $this->assertTrue($dt instanceof \DateTime);
        $this->assertEquals($DATE, $dt->format(Config::FORMAT_DATETIME));
    }
}