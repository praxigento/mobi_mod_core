<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Tool\Def;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class Period_UnitTest extends \Praxigento\Core\Test\BaseCase\Mockery
{
    const OFFSET = -25200; // -7 * 3600 (UTC-7)
    /** @var  \Mockery\MockInterface */
    private $mConvert;
    /** @var  \Mockery\MockInterface */
    private $mDt;
    /** @var  Period */
    private $obj;

    /**
     * @return Period
     */
    private function _getObj()
    {
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

    protected function setUp()
    {
        parent::setUp();
        $this->mConvert = new Convert();
        $this->mDt = $this->_mock(\Magento\Framework\Stdlib\DateTime\DateTime::class);
        $this->mDt
            ->shouldReceive('getGmtOffset')
            ->andReturn(self::OFFSET);
        $this->obj = new Period(
            $this->mConvert,
            $this->mDt
        );
        $this->obj->setWeekFirstDay(Period::WEEK_MONDAY);
    }

    public function test_cacheReset()
    {
        $this->obj->cacheReset();
    }

    public function test_getPeriodCurrent()
    {
        /** === Test Data === */
        $DATE = '2015-01-05 18:00:00';
        /** === Call and asserts  === */
        $this->assertEquals('20150105', $this->obj->getPeriodCurrentOld($DATE, Period::TYPE_DAY, false));
        $this->assertEquals('20150106', $this->obj->getPeriodCurrentOld($DATE, Period::TYPE_DAY));
        $this->assertEquals('20150111', $this->obj->getPeriodCurrentOld($DATE, Period::TYPE_WEEK));
        $this->assertEquals('20150111', $this->obj->getPeriodCurrentOld('2015-01-11 14:32:32', Period::TYPE_WEEK));
        $this->assertEquals('201501', $this->obj->getPeriodCurrentOld($DATE, Period::TYPE_MONTH));
        $this->assertEquals('2015', $this->obj->getPeriodCurrentOld($DATE, Period::TYPE_YEAR));
    }

    public function test_getPeriodFirstDate()
    {
        $this->assertEquals('20151221', $this->obj->getPeriodFirstDate('20151221'));
        $this->assertEquals('20151201', $this->obj->getPeriodFirstDate('201512'));
        $this->assertEquals('20150101', $this->obj->getPeriodFirstDate('2015'));
    }

    public function test_getPeriodLastDate()
    {
        $this->assertEquals('20151231', $this->obj->getPeriodLastDate('2015'));
        $this->assertEquals('20150630', $this->obj->getPeriodLastDate('201506'));
        $this->assertEquals('20150908', $this->obj->getPeriodLastDate('20150908'));
    }

    public function test_getPeriodNext()
    {
        $this->assertEquals('20150105', $this->obj->getPeriodNext('20150104', Period::TYPE_DAY));
        $this->assertEquals('20150111', $this->obj->getPeriodNext('20150105', Period::TYPE_WEEK));
        $this->assertEquals('201501', $this->obj->getPeriodNext('201412', Period::TYPE_MONTH));
        $this->assertEquals('2015', $this->obj->getPeriodNext('2014', Period::TYPE_YEAR));
    }

    public function test_getPeriodPrev()
    {
        $this->assertEquals('20150103', $this->obj->getPeriodPrev('20150104', Period::TYPE_DAY));
        $this->assertEquals('20150104', $this->obj->getPeriodPrev('20150105', Period::TYPE_WEEK));
        $this->assertEquals('20141228', $this->obj->getPeriodPrev('20150104', Period::TYPE_WEEK));
        $this->assertEquals('201312', $this->obj->getPeriodPrev('201401', Period::TYPE_MONTH));
        $this->assertEquals('2013', $this->obj->getPeriodPrev('2014', Period::TYPE_YEAR));
    }

    public function test_getTimestamps()
    {
        /* tests for zone "America/Los_Angeles" as set up in test/templates.json */
        $this->assertEquals('2015-08-12 07:00:00', $this->obj->getTimestampFrom('20150812', Period::TYPE_DAY));
        $this->assertEquals('2015-08-13 06:59:59', $this->obj->getTimestampTo('20150812', Period::TYPE_DAY));
        $this->assertEquals('2015-08-10 07:00:00', $this->obj->getTimestampFrom('20150816', Period::TYPE_WEEK));
        $this->assertEquals('2015-08-17 06:59:59', $this->obj->getTimestampTo('20150816', Period::TYPE_WEEK));
        $this->assertEquals('2015-08-01 07:00:00', $this->obj->getTimestampFrom('201508', Period::TYPE_MONTH));
        $this->assertEquals('2015-09-01 06:59:59', $this->obj->getTimestampTo('201508', Period::TYPE_MONTH));
        /* switch from and to sequence to cover getTimestampTo() branches */
        $this->assertEquals('2016-01-01 06:59:59', $this->obj->getTimestampTo('2015', Period::TYPE_YEAR));
        $this->assertEquals('2015-01-01 07:00:00', $this->obj->getTimestampFrom('2015', Period::TYPE_YEAR));
        /* tests nextFrom & prevTo */
        $this->assertEquals('2014-12-29 07:00:00', $this->obj->getTimestampNextFrom('20141228', Period::TYPE_WEEK));
        $this->assertEquals('2015-01-05 06:59:59', $this->obj->getTimestampPrevTo('20150105', Period::TYPE_WEEK));
    }

    public function test_getWeekDayNext()
    {
        $this->assertEquals(Period::WEEK_SATURDAY, $this->obj->getWeekDayNext(Period::WEEK_FRIDAY));
        $this->assertEquals(Period::WEEK_SUNDAY, $this->obj->getWeekDayNext(Period::WEEK_SATURDAY));
        $this->assertEquals(Period::WEEK_MONDAY, $this->obj->getWeekDayNext(Period::WEEK_SUNDAY));
        $this->assertEquals(Period::WEEK_TUESDAY, $this->obj->getWeekDayNext(Period::WEEK_MONDAY));
        $this->assertEquals(Period::WEEK_WEDNESDAY, $this->obj->getWeekDayNext(Period::WEEK_TUESDAY));
        $this->assertEquals(Period::WEEK_THURSDAY, $this->obj->getWeekDayNext(Period::WEEK_WEDNESDAY));
        $this->assertEquals(Period::WEEK_FRIDAY, $this->obj->getWeekDayNext(Period::WEEK_THURSDAY));
    }

    public function test_getWeekDayPrev()
    {
        $this->assertEquals(Period::WEEK_SATURDAY, $this->obj->getWeekDayPrev(Period::WEEK_SUNDAY));
        $this->assertEquals(Period::WEEK_SUNDAY, $this->obj->getWeekDayPrev(Period::WEEK_MONDAY));
        $this->assertEquals(Period::WEEK_MONDAY, $this->obj->getWeekDayPrev(Period::WEEK_TUESDAY));
        $this->assertEquals(Period::WEEK_TUESDAY, $this->obj->getWeekDayPrev(Period::WEEK_WEDNESDAY));
        $this->assertEquals(Period::WEEK_WEDNESDAY, $this->obj->getWeekDayPrev(Period::WEEK_THURSDAY));
        $this->assertEquals(Period::WEEK_THURSDAY, $this->obj->getWeekDayPrev(Period::WEEK_FRIDAY));
        $this->assertEquals(Period::WEEK_FRIDAY, $this->obj->getWeekDayPrev(Period::WEEK_SATURDAY));
    }

    public function test_isPeriod_()
    {
        $this->assertTrue($this->obj->isPeriodDay('20150812'));
        $this->assertTrue($this->obj->isPeriodMonth('201508'));
        $this->assertTrue($this->obj->isPeriodYear('2015'));
    }

    public function test_setWeekFirstDay()
    {
        $this->obj->setWeekFirstDay(Period::WEEK_WEDNESDAY);
        $this->assertEquals(Period::WEEK_WEDNESDAY, $this->obj->getWeekFirstDay());
        $this->assertEquals(Period::WEEK_TUESDAY, $this->obj->getWeekLastDay());
    }

    public function test_setWeekLastDay()
    {
        $this->obj->setWeekLastDay(Period::WEEK_WEDNESDAY);
        $this->assertEquals(Period::WEEK_WEDNESDAY, $this->obj->getWeekLastDay());
        $this->assertEquals(Period::WEEK_THURSDAY, $this->obj->getWeekFirstDay());
    }
}