<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Tool;

use Praxigento\Core\Lib\Context;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class Period_UnitTest extends \Praxigento\Core\Lib\Test\BaseTestCase {

    /**
     * @return Period
     */
    private function _getObj() {
        $mDateTime = $this->_mockFor('Magento\Framework\Stdlib\DateTime\DateTime', ['getGmtOffset']);
        $mDateTime
            ->expects($this->any())
            ->method('getGmtOffset')
            ->will($this->returnValue(-7 * 3600));
        /** @var  $result Period */
        $result = new Period(new Convert(), $mDateTime);
        $result->setWeekFirstDay(Period::WEEK_MONDAY);
        return $result;
    }

    public function test_constructor() {
        $mDateTime = $this->_mockFor('Magento\Framework\Stdlib\DateTime\DateTime', ['getGmtOffset']);
        $mDateTime
            ->expects($this->once())
            ->method('getGmtOffset')
            ->will($this->returnValue(-7 * 3600));
        /** @var  $obj Period */
        $obj = new Period(new Convert(), $mDateTime);
        $this->assertNotNull($obj);
        $this->assertEquals(Period::WEEK_FRIDAY, $obj->getWeekLastDay());
        $this->assertEquals(Period::WEEK_SATURDAY, $obj->getWeekFirstDay());
    }

    public function test_getWeekDayPrev() {
        $obj = $this->_getObj();
        $this->assertEquals(Period::WEEK_SATURDAY, $obj->getWeekDayPrev(Period::WEEK_SUNDAY));
        $this->assertEquals(Period::WEEK_SUNDAY, $obj->getWeekDayPrev(Period::WEEK_MONDAY));
        $this->assertEquals(Period::WEEK_MONDAY, $obj->getWeekDayPrev(Period::WEEK_TUESDAY));
        $this->assertEquals(Period::WEEK_TUESDAY, $obj->getWeekDayPrev(Period::WEEK_WEDNESDAY));
        $this->assertEquals(Period::WEEK_WEDNESDAY, $obj->getWeekDayPrev(Period::WEEK_THURSDAY));
        $this->assertEquals(Period::WEEK_THURSDAY, $obj->getWeekDayPrev(Period::WEEK_FRIDAY));
        $this->assertEquals(Period::WEEK_FRIDAY, $obj->getWeekDayPrev(Period::WEEK_SATURDAY));
    }

    public function test_getWeekDayNext() {
        $obj = $this->_getObj();
        $this->assertEquals(Period::WEEK_SATURDAY, $obj->getWeekDayNext(Period::WEEK_FRIDAY));
        $this->assertEquals(Period::WEEK_SUNDAY, $obj->getWeekDayNext(Period::WEEK_SATURDAY));
        $this->assertEquals(Period::WEEK_MONDAY, $obj->getWeekDayNext(Period::WEEK_SUNDAY));
        $this->assertEquals(Period::WEEK_TUESDAY, $obj->getWeekDayNext(Period::WEEK_MONDAY));
        $this->assertEquals(Period::WEEK_WEDNESDAY, $obj->getWeekDayNext(Period::WEEK_TUESDAY));
        $this->assertEquals(Period::WEEK_THURSDAY, $obj->getWeekDayNext(Period::WEEK_WEDNESDAY));
        $this->assertEquals(Period::WEEK_FRIDAY, $obj->getWeekDayNext(Period::WEEK_THURSDAY));
    }

    public function test_getPeriodCurrent() {
        $obj = $this->_getObj();
        $date = '2015-01-05 18:00:00';
        /* tests */
        $this->assertEquals('20150105', $obj->getPeriodCurrent($date, Period::TYPE_DAY, false));
        $this->assertEquals('20150106', $obj->getPeriodCurrent($date, Period::TYPE_DAY));
        $this->assertEquals('20150111', $obj->getPeriodCurrent($date, Period::TYPE_WEEK));
        $this->assertEquals('20150111', $obj->getPeriodCurrent('2015-01-11 14:32:32', Period::TYPE_WEEK));
        $this->assertEquals('201501', $obj->getPeriodCurrent($date, Period::TYPE_MONTH));
        $this->assertEquals('2015', $obj->getPeriodCurrent($date, Period::TYPE_YEAR));
    }

    public function test_getPeriodNext() {
        $obj = $this->_getObj();
        /* tests */
        $this->assertEquals('20150105', $obj->getPeriodNext('20150104', Period::TYPE_DAY));
        $this->assertEquals('20150111', $obj->getPeriodNext('20150105', Period::TYPE_WEEK));
        $this->assertEquals('201501', $obj->getPeriodNext('201412', Period::TYPE_MONTH));
        $this->assertEquals('2015', $obj->getPeriodNext('2014', Period::TYPE_YEAR));
    }

    public function test_getPeriodPrev() {
        $obj = $this->_getObj();
        /* tests */
        $this->assertEquals('20150103', $obj->getPeriodPrev('20150104', Period::TYPE_DAY));
        $this->assertEquals('20150104', $obj->getPeriodPrev('20150105', Period::TYPE_WEEK));
        $this->assertEquals('20141228', $obj->getPeriodPrev('20150104', Period::TYPE_WEEK));
        $this->assertEquals('201312', $obj->getPeriodPrev('201401', Period::TYPE_MONTH));
        $this->assertEquals('2013', $obj->getPeriodPrev('2014', Period::TYPE_YEAR));
    }

    public function test_getPeriodLastDate() {
        $obj = $this->_getObj();
        $this->assertEquals('20151231', $obj->getPeriodLastDate('2015'));
        $this->assertEquals('20150630', $obj->getPeriodLastDate('201506'));
        $this->assertEquals('20150908', $obj->getPeriodLastDate('20150908'));
    }

    public function test_getTimestamps() {
        $obj = $this->_getObj();
        /* tests for zone "America/Los_Angeles" as set up in test/templates.json */
        $this->assertEquals('2015-08-12 07:00:00', $obj->getTimestampFrom('20150812', Period::TYPE_DAY));
        $this->assertEquals('2015-08-13 06:59:59', $obj->getTimestampTo('20150812', Period::TYPE_DAY));
        $this->assertEquals('2015-08-10 07:00:00', $obj->getTimestampFrom('20150816', Period::TYPE_WEEK));
        $this->assertEquals('2015-08-17 06:59:59', $obj->getTimestampTo('20150816', Period::TYPE_WEEK));
        $this->assertEquals('2015-08-01 07:00:00', $obj->getTimestampFrom('201508', Period::TYPE_MONTH));
        $this->assertEquals('2015-09-01 06:59:59', $obj->getTimestampTo('201508', Period::TYPE_MONTH));
        /* switch from and to sequence to cover getTimestampTo() branches */
        $this->assertEquals('2016-01-01 06:59:59', $obj->getTimestampTo('2015', Period::TYPE_YEAR));
        $this->assertEquals('2015-01-01 07:00:00', $obj->getTimestampFrom('2015', Period::TYPE_YEAR));
        /* tests nextFrom & prevTo */
        $this->assertEquals('2014-12-29 07:00:00', $obj->getTimestampNextFrom('20141228', Period::TYPE_WEEK));
        $this->assertEquals('2015-01-05 06:59:59', $obj->getTimestampPrevTo('20150105', Period::TYPE_WEEK));
    }

    public function test_isPeriod_() {
        $obj = $this->_getObj();
        $this->assertTrue($obj->isPeriodDay('20150812'));
        $this->assertTrue($obj->isPeriodMonth('201508'));
        $this->assertTrue($obj->isPeriodYear('2015'));
    }

    public function test_setWeekFirstDay() {
        $obj = $this->_getObj();
        $obj->setWeekFirstDay(Period::WEEK_WEDNESDAY);
        $this->assertEquals(Period::WEEK_WEDNESDAY, $obj->getWeekFirstDay());
        $this->assertEquals(Period::WEEK_TUESDAY, $obj->getWeekLastDay());
    }

    public function test_setWeekLastDay() {
        $obj = $this->_getObj();
        $obj->setWeekLastDay(Period::WEEK_WEDNESDAY);
        $this->assertEquals(Period::WEEK_WEDNESDAY, $obj->getWeekLastDay());
        $this->assertEquals(Period::WEEK_THURSDAY, $obj->getWeekFirstDay());
    }

    public function test_getPeriodFirstDate() {
        $obj = $this->_getObj();
        /* tests */
        $this->assertEquals('20151221', $obj->getPeriodFirstDate('20151221'));
        $this->assertEquals('20151201', $obj->getPeriodFirstDate('201512'));
        $this->assertEquals('20150101', $obj->getPeriodFirstDate('2015'));
    }
}