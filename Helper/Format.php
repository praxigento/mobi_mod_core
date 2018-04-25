<?php
/**
 * Formatting tool default implementation.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Helper;

use Praxigento\Core\Config as Cfg;

class Format
    implements \Praxigento\Core\Api\Helper\Format
{
    public function dateAsRfc3339($date = null)
    {
        if (is_null($date)) {
            $result = date(DATE_RFC3339);
        } elseif ($date instanceof \DateTime) {
            $result = $date->format(DATE_RFC3339);
        } elseif (is_int($date)) {
            $dt = new \DateTime($date);
            $result = $dt->format(DATE_RFC3339);
        } else {
            $time = strtotime($date);
            $dt = new \DateTime($time);
            $result = $dt->format(DATE_RFC3339);
        }
        return $result;
    }

    public function dateTimeForDb(\DateTime $dt)
    {
        $result = $dt->format(Cfg::FORMAT_DATETIME);
        return $result;
    }

    public function roundBonus($val, $precision = 2)
    {
        $round = round($val, $precision, PHP_ROUND_HALF_UP);
        $result = number_format($round, $precision, '.', '');
        return $result;
    }

    public function toNumber($val, $precision = 2, $decimal = '.', $group = '')
    {
        $result = (float)number_format($val, $precision, $decimal, $group);
        return $result;
    }
}