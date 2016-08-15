<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Tool\Def;

use Praxigento\Core\Config as Cfg;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class Format_UnitTest extends \Praxigento\Core\Test\BaseMockeryCase
{
    /** @var  Format */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        $this->obj = new Format();
    }

    public function test_dateTimeForDb()
    {
        /** === Test Data === */
        $FORMATTED = 'formatted datetime';
        /** === Setup Mocks === */
        $mDt = $this->_mock(\DateTime::class);
        $mDt->shouldReceive('format')->once()
            ->with(Cfg::FORMAT_DATETIME)
            ->andReturn($FORMATTED);
        /** === Call and asserts  === */
        $res = $this->obj->dateTimeForDb($mDt);
        $this->assertEquals($FORMATTED, $res);
    }

    public function test_roundBonus()
    {
        /** === Call and asserts  === */
        $res = $this->obj->roundBonus(10.236);
        $this->assertEquals(10.24, $res);
    }

    public function test_toNumber()
    {
        /** === Call and asserts  === */
        $res = $this->obj->toNumber('12.242');
        $this->assertTrue(is_float($res));
        $this->assertEquals(12.24, $res);
    }

}