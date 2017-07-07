<?php
/**
 * Formatting tool default implementation.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Tool\Def;

use Praxigento\Core\Config as Cfg;

class Format
    implements \Praxigento\Core\Tool\IFormat
{
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
        $result = number_format($val, $precision, $decimal, $group);
        return $result;
    }
}