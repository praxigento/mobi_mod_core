<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2018
 */

namespace Praxigento\Core\Helper;

use Praxigento\Core\Api\Helper\path;

/**
 * CSV files functions.
 */
class Csv
    implements \Praxigento\Core\Api\Helper\Csv
{
    function read($path, $keyIndex = null, $skipFirstRow = true)
    {
        $result = [];
        $file = fopen($path, 'r');
        /* skip first row with header */
        if ($skipFirstRow) fgetcsv($file);
        $useKey = !is_null($keyIndex);
        while ($row = fgetcsv($file)) {
            if ((count($row) > 0) && !is_null($row[0])) {
                if ($useKey) {
                    $key = $row[$keyIndex];
                    $result[$key] = $row;
                } else {
                    $result[] = $row;
                }

            }
        }
        return $result;
    }
}