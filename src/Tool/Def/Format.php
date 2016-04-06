<?php
/**
 * Formatting tool default implementation.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Tool\Def;

use Praxigento\Core\Config as Cfg;
use Praxigento\Core\Tool\IFormat;

class Format implements IFormat
{
    /**
     * @inheritdoc
     */
    public function dateTimeForDb(\DateTime $dt)
    {
        $result = $dt->format(Cfg::FORMAT_DATETIME);
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function roundBonus($val, $precision = 2)
    {
        $round = round($val, $precision, PHP_ROUND_HALF_UP);
        $result = number_format($round, $precision, '.', '');
        return $result;
    }
}