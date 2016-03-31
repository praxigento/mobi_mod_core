<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Tool;

use Praxigento\Core\Config;

/**
 * Converting tool.
 *
 * @package Praxigento\Core\Lib\Tool
 */
class Convert {

    /**
     * @param $data int|\DateTime|string Date as unix time or DateTime or string in format 'Y-m-d H:i:s'.
     *
     * @return \DateTime
     */
    public function toDateTime($data) {
        if(is_int($data)) {
            /* create DateTie from unix time */
            $dt = new \DateTime();
            $dt->setTimestamp($data);
            $result = $dt;
        } elseif($data instanceof \DateTime) {
            $result = $data;
        } else {
            $result = \DateTime::createFromFormat(Config::FORMAT_DATETIME, trim($data));
        }
        return $result;
    }
}