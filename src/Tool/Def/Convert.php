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
    /** @inheritdoc */
    public function camelCaseToSnakeCase($data)
    {
        $result = \Magento\Framework\Api\SimpleDataObjectConverter::camelCaseToSnakeCase($data);
        return $result;
    }

    /** @inheritdoc */
    public function snakeCaseToCamelCase($data)
    {
        $result = \Magento\Framework\Api\SimpleDataObjectConverter::snakeCaseToCamelCase($data);
        return $result;
    }

    /** @inheritdoc */
    public function snakeCaseToUpperCamelCase($data)
    {
        $result = \Magento\Framework\Api\SimpleDataObjectConverter::snakeCaseToUpperCamelCase($data);
        return $result;
    }

    /** @inheritdoc */
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