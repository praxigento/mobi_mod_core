<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2018
 */

namespace Praxigento\Core\Api\Helper;

/**
 * CSV files functions.
 */
interface Csv
{
    /**
     * Read CSV file and put content into simple array or array with keys (if $keyIndex is not null).
     *
     * @param $path path to the CSV file (relative or absolute).
     * @param null $keyIndex index of the ID column.
     * @param bool $skipFirstRow 'true' skip first row (header)
     * @return array
     */
    function read($path, $keyIndex = null, $skipFirstRow = true);

}