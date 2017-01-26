<?php
/**
 * Converting tool default implementation.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Tool\Def;

use Praxigento\Core\Config as Cfg;

class Convert
    implements \Praxigento\Core\Tool\IConvert
{
    public function camelCaseToSnakeCase($data)
    {
        $result = \Magento\Framework\Api\SimpleDataObjectConverter::camelCaseToSnakeCase($data);
        return $result;
    }

    public function snakeCaseToCamelCase($data)
    {
        $result = \Magento\Framework\Api\SimpleDataObjectConverter::snakeCaseToCamelCase($data);
        return $result;
    }

    public function snakeCaseToUpperCamelCase($data)
    {
        $result = \Magento\Framework\Api\SimpleDataObjectConverter::snakeCaseToUpperCamelCase($data);
        return $result;
    }

    /**
     * @inheritdoc
     *
     * @SuppressWarnings(PHPMD.ShortVariable)
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
        } elseif (is_null($data)) {
            $result = new \DateTime();
        } else {
            $result = \DateTime::createFromFormat(Cfg::FORMAT_DATETIME, trim($data));
        }
        return $result;
    }
}