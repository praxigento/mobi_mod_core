<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Tool;

use Praxigento\Core\Config as Cfg;
use Praxigento\Core\Lib\Context;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class Format_UnitTest extends \Praxigento\Core\Lib\Test\BaseTestCase {


    public function test_dateTimeForDb() {
        /** === Test Data === */
        $FORMATTED = 'formatted datetime';
        /** === Mocks === */
        $mDt = $this->_mockFor('DateTime');
        $mDt
            ->expects($this->once())
            ->method('format')
            ->with(Cfg::FORMAT_DATETIME)
            ->willReturn($FORMATTED);
        /** === Test itself === */
        /** @var  $obj Format */
        $obj = new \Praxigento\Core\Lib\Tool\Format();
        $resp = $obj->dateTimeForDb($mDt);
        $this->assertEquals($FORMATTED, $resp);
    }

    public function test_roundBonus() {
        /** === Test Data === */
        /** === Mocks === */
        /** === Test itself === */
        /** @var  $obj Format */
        $obj = new \Praxigento\Core\Lib\Tool\Format();
        $res = $obj->roundBonus(10.236);
        $this->assertEquals(10.24, $res);
    }

}