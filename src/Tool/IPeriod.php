<?php
/**
 * Period tool.
 *
 * Period is a string representation of the day, week, month or year period: '20151112', '201511', '2015'.
 * Week period is like day period but value is equal to the end of the period. If week period is started from friday,
 * then second week of the 2015 is '20150108' - second thursday.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Tool;

interface IPeriod
{
    const TYPE_DAY = 'DAY';
    const TYPE_MONTH = 'MONTH';
    const TYPE_WEEK = 'WEEK';
    const TYPE_YEAR = 'YEAR';

    const WEEK_FRIDAY = 'friday';
    const WEEK_MONDAY = 'monday';
    const WEEK_SATURDAY = 'saturday';
    const WEEK_SUNDAY = 'sunday';
    const WEEK_THURSDAY = 'thursday';
    const WEEK_TUESDAY = 'tuesday';
    const WEEK_WEDNESDAY = 'wednesday';

    /**
     * @param $date string "2015-11-11 22:21:37"
     * @param $periodType string see self::TYPE_...
     *
     * @return null|string 20150601 | 201506 | 2015
     */
    public function getPeriodCurrent($date = null, $periodType = self::TYPE_DAY, $withTimezone = true);

    /**
     * Return the datestamp for the first date of the month or year period.
     *
     * @param $periodValue 'YYYY' or 'YYYYMM'
     *
     * @return string 'YYYYMMDD' - the first datestamp for the given period.
     */
    public function getPeriodFirstDate($periodValue);

    /**
     * Return the datestamp for the last date of the month or year period.
     *
     * @param $periodValue 'YYYY' or 'YYYYMM'
     *
     * @return string 'YYYYMMDD' - the last datestamp for the given period.
     */
    public function getPeriodLastDate($periodValue);

    public function getPeriodNext($periodValue, $periodType = self::TYPE_DAY);

    public function getPeriodPrev($periodValue, $periodType = self::TYPE_DAY);

    /**
     * Calculate FROM bound as timestamp for the period.
     *
     * @param $periodValue 20150601 | 201506 | 2015
     * @param $periodType DAY | WEEK | MONTH | YEAR
     *
     * @return string 2015-08-12 12:23:34
     */
    public function getTimestampFrom($periodValue, $periodType = self::TYPE_DAY);

    public function getTimestampNextFrom($periodValue, $periodType = self::TYPE_DAY);

    public function getTimestampPrevTo($periodValue, $periodType = self::TYPE_DAY);

    public function getTimestampTo($periodValue, $periodType = self::TYPE_DAY);

    /**
     * @param $weekDay - string see self::WEEK_
     *
     * @return string see self::WEEK_
     */
    public function getWeekDayNext($weekDay);

    /**
     * @param $weekDay - string see self::WEEK_
     *
     * @return string see self::WEEK_
     */
    public function getWeekDayPrev($weekDay);

    /**
     * @return string
     */
    public function getWeekFirstDay();

    /**
     * @return string
     */
    public function getWeekLastDay();

    /**
     * Return 'true' if $periodValue is day period (YYYYMMDD).
     *
     * @param $periodValue
     *
     * @return bool
     */
    public function isPeriodDay($periodValue);

    /**
     * Return 'true' if $periodValue is month period (YYYYMM).
     *
     * @param $periodValue
     *
     * @return bool
     */
    public function isPeriodMonth($periodValue);

    /**
     * Return 'true' if $periodValue is year period (YYYY).
     *
     * @param $periodValue
     *
     * @return bool
     */
    public function isPeriodYear($periodValue);

    /**
     * @param string $weekDay see self::WEEK_
     */
    public function setWeekFirstDay($weekDay);

    /**
     * @param string $weekDay see self::WEEK_
     */
    public function setWeekLastDay($weekDay);
}