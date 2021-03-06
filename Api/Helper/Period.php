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

namespace Praxigento\Core\Api\Helper;

/**
 * Periods related functionality (YYYY, YYYYMM, YYYYMMDD).
 */
interface Period
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
     *  Get current period for datetime (with timezone fixation MOBI-704).
     *
     * $changeTz: account delta between "Magento" time and GMT.
     *  - "= 0" - don't change timezone for $date;
     *  - "< 0" - decrease $date on tzDelta (GMT offset);
     *  - "> 0" - increase $date on tzDelta (GMT offset);
     * (see \Praxigento\Core\Helper\Period::$tzDelta)
     *
     * @param \DateTime|int|string|null $date datetime to process (see \Praxigento\Core\Tool\Def\Convert::toDateTime)
     * @param int $changeTz
     * @param string $periodType
     * @return string|null 20150601 | 201506 | 2015
     */
    public function getPeriodCurrent($date = null, $changeTz = 0, $periodType = self::TYPE_DAY);

    /**
     * Return the datestamp for the first date of the month or year period.
     *
     * @param $periodValue 'YYYY' or 'YYYYMM'
     *
     * @return string 'YYYYMMDD' - the first datestamp for the given period.
     */
    public function getPeriodFirstDate($periodValue);

    /**
     * Convert date "YYYY-MM-DD" to period "YYYYMMDD|YYYYMM|YYYY"
     * @param string $date
     * @param string $periodType
     * @return string
     */
    public function getPeriodForDate($date, $periodType = self::TYPE_DAY);

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
     * @param string $periodValue [20150601 | 201506 | 2015]
     * @param string $periodType [DAY | WEEK | MONTH | YEAR]
     *
     * @return string 2015-08-12 12:23:34
     */
    public function getTimestampFrom($periodValue, $periodType = self::TYPE_DAY);

    public function getTimestampNextFrom($periodValue, $periodType = self::TYPE_DAY);

    public function getTimestampPrevTo($periodValue, $periodType = self::TYPE_DAY);

    public function getTimestampTo($periodValue, $periodType = self::TYPE_DAY);

    /**
     * @param $periodValue
     * @param string $periodType
     * @return string
     *
     * @deprecated use "< $nextPeriod"  instead of "<= $lastSecond"
     */
    public function getTimestampUpTo($periodValue, $periodType = self::TYPE_DAY);

    /**
     * Get "1 second before next period begin" timestamp.
     *
     * @param $periodValue
     * @param string $periodType
     * @return string
     */
    public function getTimestampLastSecond($periodValue, $periodType = self::TYPE_DAY);

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
     * @param string $periodValue 'YYYY', 'YYYYMM', 'YYYYMMDD'
     * @param string $periodType
     * @return string
     */
    public function normalizePeriod($periodValue, $periodType = self::TYPE_DAY);

}
