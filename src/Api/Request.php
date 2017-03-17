<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Api;

/**
 * Base API request.
 *
 * (Define getters explicitly to use with Swagger tool)
 * (Define setters explicitly to use with Magento JSON2PHP conversion tool)
 *
 */
class Request
    extends \Flancer32\Lib\Data
{
    /**
     * Flag to return request in response.
     *
     * @return bool|null
     */
    public function getRequestReturn()
    {
        $result = parent::getRequestReturn();
        return $result;
    }

    /**
     * Flag to return request in response.
     *
     * @param bool $data
     */
    public function setRequestReturn($data)
    {
        parent::setRequestReturn($data);
    }

}