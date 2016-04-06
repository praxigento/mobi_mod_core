<?php
/**
 * Converting tool.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Tool;

interface IConvert
{
    /**
     * @param $data int|\DateTime|string Date as unix time or DateTime or string in format 'Y-m-d H:i:s'.
     *
     * @return \DateTime
     */
    public function toDateTime($data);
}