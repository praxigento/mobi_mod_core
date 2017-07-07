<?php
/**
 * Formatting tool.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Tool;

interface IFormat
{
    /**
     * Return datetime value formatted to use in DB expressions (Y-m-d H:i:s).
     *
     * @param \DateTime $dt
     *
     * @return string
     */
    public function dateTimeForDb(\DateTime $dt);

    /**
     * Standard round function for bonus amounts.
     *
     * @param     $val
     * @param int $precision
     *
     * @return string
     */
    public function roundBonus($val, $precision = 2);

    /**
     * Format $val as number with $precision. Used in external API requests to send numbers outside.
     *
     * @param $val
     * @param int $precision
     * @param string $decimal
     * @param string $group
     * @return string
     */
    public function toNumber($val, $precision = 2, $decimal = '.', $group = '');
}