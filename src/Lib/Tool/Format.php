<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Tool;

use Praxigento\Core\Config as Cfg;

/**
 * Formatting tool.
 *
 * @package Praxigento\Core\Lib\Tool
 */
class Format {
    /**
     * Return datetime value formatted to use in DB expressions (Y-m-d H:i:s).
     *
     * @param \DateTime $dt
     *
     * @return string
     */
    public function dateTimeForDb(\DateTime $dt) {
        $result = $dt->format(Cfg::FORMAT_DATETIME);
        return $result;
    }

    /**
     * Standard round function for bonus amounts.
     *
     * @param     $val
     * @param int $precision
     *
     * @return string
     */
    public function roundBonus($val, $precision = 2) {
        $round = round($val, $precision, PHP_ROUND_HALF_UP);
        $result = number_format($round, $precision, '.', '');
        return $result;
    }
}