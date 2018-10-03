<?php
/**
 * Period tool default implementation.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Helper;


use Praxigento\Core\Config as Cfg;

class Period
    implements \Praxigento\Core\Api\Helper\Period
{
    /** @var array Common cache for periods bounds: [period][type][from|to] = ... */
    private static $cachePeriodBounds = [];
    /** @var \Magento\Framework\ObjectManagerInterface */
    private $manObj;
    /** @var int Delta in seconds for Magento timezone according to UTC */
    private $tzDelta;
    /**
     * Week first and last day by default.
     */
    private $weekFirstDay = self::WEEK_SATURDAY;
    private $weekLastDay = self::WEEK_FRIDAY;

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $manObj
    ) {
        $this->manObj = $manObj;
    }

    /**
     * Calculate period's from/to bounds (month 201508 = "2015-08-01 02:00:00 / 2015-09-01 02:00:00") and cache it.
     * Use "<=" for dateFrom and "<" for dateTo in comparison.
     *
     * @param string $periodValue [20150601 | 201506 | 2015]
     * @param string $periodType [DAY | WEEK | MONTH | YEAR]
     */
    private function calcPeriodBounds($periodValue, $periodType = self::TYPE_DAY)
    {
        $from = null;
        $to = null;
        switch ($periodType) {
            case self::TYPE_DAY:
                $dt = date_create_from_format('Ymd', $periodValue);
                $ts = strtotime('midnight', $dt->getTimestamp());
                $ts -= $this->getTzDelta();
                $from = date(Cfg::FORMAT_DATETIME, $ts);
                $ts = strtotime('tomorrow midnight', $dt->getTimestamp());
                $ts -= $this->getTzDelta();
                $to = date(Cfg::FORMAT_DATETIME, $ts);
                break;
            case self::TYPE_WEEK:
                /* week period ends on ...  */
                $end = $this->getWeekLastDay();
                $prev = $this->getWeekDayNext($end);
                /* this should be the last day of the week */
                $periodValue = $this->normalizePeriod($periodValue, self::TYPE_DAY);
                $dt = date_create_from_format('Ymd', $periodValue);
                $ts = strtotime("previous $prev midnight", $dt->getTimestamp());
                $ts -= $this->getTzDelta();
                $from = date(Cfg::FORMAT_DATETIME, $ts);
                $ts = strtotime('tomorrow midnight', $dt->getTimestamp());
                $ts -= $this->getTzDelta();
                $to = date(Cfg::FORMAT_DATETIME, $ts);
                break;
            case self::TYPE_MONTH:
                $periodValue = $this->normalizePeriod($periodValue, self::TYPE_MONTH);
                $dt = date_create_from_format('Ym', $periodValue);
                $ts = strtotime('first day of midnight', $dt->getTimestamp());
                $ts -= $this->getTzDelta();
                $from = date(Cfg::FORMAT_DATETIME, $ts);
                $ts = strtotime('first day of next month midnight', $dt->getTimestamp());
                $ts -= $this->getTzDelta();
                $to = date(Cfg::FORMAT_DATETIME, $ts);
                break;
            case self::TYPE_YEAR:
                $periodValue = $this->normalizePeriod($periodValue, self::TYPE_YEAR);
                $dt = date_create_from_format('Y', $periodValue);
                $ts = strtotime('first day of January', $dt->getTimestamp());
                $ts -= $this->getTzDelta();
                $from = date(Cfg::FORMAT_DATETIME, $ts);
                $ts = strtotime('first day of January next year midnight', $dt->getTimestamp());
                $ts -= $this->getTzDelta();
                $to = date(Cfg::FORMAT_DATETIME, $ts);
                break;
        }
        self::$cachePeriodBounds[$periodValue][$periodType]['from'] = $from;
        self::$cachePeriodBounds[$periodValue][$periodType]['to'] = $to;
    }

    public function getPeriodCurrent($date = null, $changeTz = 0, $periodType = self::TYPE_DAY)
    {
        $result = null;
        /* convert $date into datetime and change timezone on demand */
        $dt = $this->toDateTime($date);
        if ($changeTz > 0) {
            $dt->setTimestamp($dt->getTimestamp() + $this->getTzDelta());
        } elseif ($changeTz < 0) {
            $dt->setTimestamp($dt->getTimestamp() - $this->getTzDelta());
        }

        /* calculate expected period for given datetime */
        switch ($periodType) {
            case self::TYPE_DAY:
                $result = date_format($dt, 'Ymd');
                break;
            case self::TYPE_WEEK:
                $weekDay = date('w', $dt->getTimestamp());
                if ($weekDay != 0) {
                    /* week period ends on ...  */
                    $end = $this->getWeekLastDay();
                    $ts = strtotime("next $end", $dt->getTimestamp());
                    $dt = $this->toDateTime($ts);
                }
                $result = date_format($dt, 'Ymd');
                break;
            case self::TYPE_MONTH:
                $result = date_format($dt, 'Ym');
                break;
            case self::TYPE_YEAR:
                $result = date_format($dt, 'Y');
                break;
        }
        return $result;
    }

    /**
     * Return the datestamp for the first date of the month or year period.
     *
     * @param $periodValue 'YYYY' or 'YYYYMM'
     *
     * @return string 'YYYYMMDD' - the first datestamp for the given period.
     */
    public function getPeriodFirstDate($periodValue)
    {
        $result = $periodValue;
        if ($this->isPeriodYear($periodValue)) {
            $dt = date_create_from_format('Y', $periodValue);
            $ts = strtotime('first day of January', $dt->getTimestamp());
            $dt = $this->toDateTime($ts);
            $result = date_format($dt, 'Ymd');
        } else {
            if ($this->isPeriodMonth($periodValue)) {
                $dt = date_create_from_format('Ymd', $periodValue . '01');
                $ts = strtotime('first day of', $dt->getTimestamp());
                $dt = $this->toDateTime($ts);
                $result = date_format($dt, 'Ymd');
            }
        }
        return $result;
    }

    public function getPeriodForDate($date, $periodType = self::TYPE_DAY)
    {
        $year = substr($date, 0, 4); // YYYY-
        $month = substr($date, 5, 2); // -MM-
        $day = substr($date, 8, 2); // -DD
        $result = "$year$month$day";
        $result = $this->normalizePeriod($result, $periodType);
        return $result;
    }

    /**
     * Return the datestamp for the last date of the month or year period.
     *
     * @param $periodValue 'YYYY' or 'YYYYMM'
     *
     * @return string 'YYYYMMDD' - the last datestamp for the given period.
     */
    public function getPeriodLastDate($periodValue)
    {
        $result = $periodValue;
        if ($this->isPeriodYear($periodValue)) {
            $dt = date_create_from_format('Y', $periodValue);
            $ts = strtotime('last day of December', $dt->getTimestamp());
            $dt = $this->toDateTime($ts);
            $result = date_format($dt, 'Ymd');
        } else {
            if ($this->isPeriodMonth($periodValue)) {
                $dt = date_create_from_format('Ymd', $periodValue . '01');
                $ts = strtotime('last day of', $dt->getTimestamp());
                $dt = $this->toDateTime($ts);
                $result = date_format($dt, 'Ymd');
            }
        }
        return $result;
    }

    public function getPeriodNext($periodValue, $periodType = self::TYPE_DAY)
    {
        $result = null;
        $periodValue = $this->normalizePeriod($periodValue, $periodType);
        switch ($periodType) {
            case self::TYPE_DAY:
                $dt = date_create_from_format('Ymd', $periodValue);
                $ts = strtotime('next day', $dt->getTimestamp());
                $dt = $this->toDateTime($ts);
                $result = date_format($dt, 'Ymd');
                break;
            case self::TYPE_WEEK:
                /* week period ends on ...  */
                $end = $this->getWeekLastDay();
                $dt = date_create_from_format('Ymd', $periodValue);
                $ts = strtotime("next $end", $dt->getTimestamp());
                $dt = $this->toDateTime($ts);
                $result = date_format($dt, 'Ymd');
                break;
            case self::TYPE_MONTH:
                $dt = date_create_from_format('Ymd', $periodValue . '01');
                $ts = strtotime('next month', $dt->getTimestamp());
                $dt = $this->toDateTime($ts);
                $result = date_format($dt, 'Ym');
                break;
            case self::TYPE_YEAR:
                $dt = date_create_from_format('Y', $periodValue);
                $ts = strtotime('next year', $dt->getTimestamp());
                $dt = $this->toDateTime($ts);
                $result = date_format($dt, 'Y');
                break;
        }
        return $result;
    }

    public function getPeriodPrev($periodValue, $periodType = self::TYPE_DAY)
    {
        $result = null;
        $periodValue = $this->normalizePeriod($periodValue, $periodType);
        switch ($periodType) {
            case self::TYPE_DAY:
                $dt = date_create_from_format('Ymd', $periodValue);
                $ts = strtotime('previous day', $dt->getTimestamp());
                $dt = $this->toDateTime($ts);
                $result = date_format($dt, 'Ymd');
                break;
            case self::TYPE_WEEK:
                /* week period ends on ...  */
                $end = $this->getWeekLastDay();
                $dt = date_create_from_format('Ymd', $periodValue);
                $ts = strtotime("previous $end", $dt->getTimestamp());
                $dt = $this->toDateTime($ts);
                $result = date_format($dt, 'Ymd');
                break;
            case self::TYPE_MONTH:
                $dt = date_create_from_format('Ym', $periodValue);
                $ts = strtotime('previous month', $dt->getTimestamp());
                $dt = $this->toDateTime($ts);
                $result = date_format($dt, 'Ym');
                break;
            case self::TYPE_YEAR:
                $dt = date_create_from_format('Y', $periodValue);
                $ts = strtotime('previous year', $dt->getTimestamp());
                $dt = $this->toDateTime($ts);
                $result = date_format($dt, 'Y');
                break;
        }
        return $result;
    }

    /**
     * Calculate FROM bound as timestamp for the period.
     *
     * @param $periodValue 20150601 | 201506 | 2015
     * @param $periodType DAY | WEEK | MONTH | YEAR
     *
     * @return string 2015-08-12 12:23:34
     */
    public function getTimestampFrom($periodValue, $periodType = self::TYPE_DAY)
    {
        $periodValue = $this->normalizePeriod($periodValue, $periodType);
        if (
            !isset(self::$cachePeriodBounds[$periodValue]) &&
            !isset(self::$cachePeriodBounds[$periodValue][$periodType])
        ) {
            $this->calcPeriodBounds($periodValue, $periodType);
        }
        $result = self::$cachePeriodBounds[$periodValue][$periodType]['from'];
        return $result;
    }

    public function getTimestampNextFrom($periodValue, $periodType = self::TYPE_DAY)
    {
        $periodValue = $this->normalizePeriod($periodValue, $periodType);
        $periodNext = $this->getPeriodNext($periodValue, $periodType);
        $result = $this->getTimestampFrom($periodNext, $periodType);
        return $result;
    }

    public function getTimestampPrevTo($periodValue, $periodType = self::TYPE_DAY)
    {
        $periodPrev = $this->getPeriodPrev($periodValue, $periodType);
        $result = $this->getTimestampTo($periodPrev, $periodType);
        return $result;
    }

    public function getTimestampTo($periodValue, $periodType = self::TYPE_DAY)
    {
        $periodValue = $this->normalizePeriod($periodValue, $periodType);
        if (
            !isset(self::$cachePeriodBounds[$periodValue]) &&
            !isset(self::$cachePeriodBounds[$periodValue][$periodType])
        ) {
            $this->calcPeriodBounds($periodValue, $periodType);
        }
        $result = self::$cachePeriodBounds[$periodValue][$periodType]['to'];
        return $result;
    }

    public function getTimestampUpTo($periodValue, $periodType = self::TYPE_DAY)
    {
        $tsTo = $this->getTimestampTo($periodValue, $periodType);
        $result = date(Cfg::FORMAT_DATETIME, (strtotime($tsTo) - 1));
        return $result;
    }

    /**
     * MOBI-504: don't retrieve session depended objects from Object Manager
     *
     * @return int
     */
    private function getTzDelta()
    {
        if (is_null($this->tzDelta)) {
            /** @var \Magento\Framework\Stdlib\DateTime\DateTime $dt */
            $dt = $this->manObj->get(\Magento\Framework\Stdlib\DateTime\DateTime::class);
            $this->tzDelta = $dt->getGmtOffset();
        }
        return $this->tzDelta;
    }

    /**
     * @param $weekDay - string see self::WEEK_
     *
     * @return string see self::WEEK_
     */
    public function getWeekDayNext($weekDay)
    {
        switch (strtolower($weekDay)) {
            case self::WEEK_SUNDAY:
                $result = self::WEEK_MONDAY;
                break;
            case self::WEEK_MONDAY:
                $result = self::WEEK_TUESDAY;
                break;
            case self::WEEK_TUESDAY:
                $result = self::WEEK_WEDNESDAY;
                break;
            case self::WEEK_WEDNESDAY:
                $result = self::WEEK_THURSDAY;
                break;
            case self::WEEK_THURSDAY:
                $result = self::WEEK_FRIDAY;
                break;
            case self::WEEK_FRIDAY:
                $result = self::WEEK_SATURDAY;
                break;
            case self::WEEK_SATURDAY:
                $result = self::WEEK_SUNDAY;
                break;
        }
        return $result;
    }

    /**
     * @param $weekDay - string see self::WEEK_
     *
     * @return string see self::WEEK_
     */
    public function getWeekDayPrev($weekDay)
    {
        switch (strtolower($weekDay)) {
            case self::WEEK_SUNDAY:
                $result = self::WEEK_SATURDAY;
                break;
            case self::WEEK_MONDAY:
                $result = self::WEEK_SUNDAY;
                break;
            case self::WEEK_TUESDAY:
                $result = self::WEEK_MONDAY;
                break;
            case self::WEEK_WEDNESDAY:
                $result = self::WEEK_TUESDAY;
                break;
            case self::WEEK_THURSDAY:
                $result = self::WEEK_WEDNESDAY;
                break;
            case self::WEEK_FRIDAY:
                $result = self::WEEK_THURSDAY;
                break;
            case self::WEEK_SATURDAY:
                $result = self::WEEK_FRIDAY;
                break;
        }
        return $result;
    }

    /**
     * @return string
     */
    public function getWeekFirstDay()
    {
        return $this->weekFirstDay;
    }

    /**
     * @return string
     */
    public function getWeekLastDay()
    {
        return $this->weekLastDay;
    }

    /**
     * Return 'true' if $periodValue is day period (YYYYMMDD).
     *
     * @param $periodValue
     *
     * @return bool
     */
    public function isPeriodDay($periodValue)
    {
        $result = (strlen($periodValue) == 8);
        return $result;
    }

    /**
     * Return 'true' if $periodValue is month period (YYYYMM).
     *
     * @param $periodValue
     *
     * @return bool
     */
    public function isPeriodMonth($periodValue)
    {
        $result = (strlen($periodValue) == 6);
        return $result;
    }

    /**
     * Return 'true' if $periodValue is year period (YYYY).
     *
     * @param $periodValue
     *
     * @return bool
     */
    public function isPeriodYear($periodValue)
    {
        $result = (strlen($periodValue) == 4);
        return $result;
    }

    /**
     * @param string $periodValue 'YYYY', 'YYYYMM', 'YYYYMMDD'
     * @param string $periodType
     * @return bool|string
     */
    private function normalizePeriod($periodValue, $periodType = self::TYPE_DAY)
    {
        $result = substr($periodValue, 0, 8);
        switch ($periodType) {
            case self::TYPE_MONTH:
                $result = substr($periodValue, 0, 6);
                break;
            case self::TYPE_YEAR:
                $result = substr($periodValue, 0, 4);
                break;
        }
        return $result;
    }

    private function toDateTime($data)
    {
        if (is_int($data)) {
            /* create DateTie from unix time */
            $dt = new \DateTime();
            $dt->setTimestamp($data);
            $result = $dt;
        } elseif ($data instanceof \DateTime) {
            $result = $data;
        } elseif (is_null($data)) {
            $result = new \DateTime();
        } else {
            $result = \DateTime::createFromFormat(Cfg::FORMAT_DATETIME, trim($data));
        }
        return $result;
    }
}