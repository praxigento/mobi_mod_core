<?php
/**
 * Converting tool default implementation.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Tool\Def;

use Praxigento\Core\Config as Cfg;
use Praxigento\Core\Tool\IConvert;

class Convert implements IConvert
{
    /**
     * @inheritdoc
     */
    public function toDateTime($data)
    {
        if (is_int($data)) {
            /* create DateTie from unix time */
            $dt = new \DateTime();
            $dt->setTimestamp($data);
            $result = $dt;
        } elseif ($data instanceof \DateTime) {
            $result = $data;
        } else {
            $result = \DateTime::createFromFormat(Cfg::FORMAT_DATETIME, trim($data));
        }
        return $result;
    }
}