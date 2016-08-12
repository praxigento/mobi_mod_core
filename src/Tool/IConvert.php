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
     * Convert 'some_data' to 'someData'.
     *
     * @param string $data
     * @return string
     */
    public function snakeCaseToCamelCase($data);

    /**
     * Convert 'some_data' to 'SomeData'.
     *
     * @param $data
     * @return string
     */
    public function snakeCaseToUpperCamelCase($data);

    /**
     * Convert 'SomeData' to 'some_data'.
     *
     * @param $data
     * @return string
     */
    public function camelCaseToSnakeCase($data);

    /**
     * @param $data int|\DateTime|string Date as unix time or DateTime or string in format 'Y-m-d H:i:s'.
     *
     * @return \DateTime
     */
    public function toDateTime($data);
}