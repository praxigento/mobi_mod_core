<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Service\Base;

class Response
    extends \Flancer32\Lib\Data
    implements \Praxigento\Core\Service\IResponse
{
    /** @var string */
    private $errorCode = \Praxigento\Core\Service\IResponse::ERR_UNDEFINED;
    /** @var  string */
    private $errorMessage;

    /**
     * @return string (required for Magento API transformations)
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    public function setErrorCode($code)
    {
        $this->errorCode = $code;
    }

    /**
     * @return string (required for Magento API transformations)
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    public function setErrorMessage($message)
    {
        $this->errorMessage = $message;
    }

    /**
     * @return bool
     */
    public function isSucceed()
    {
        $result = ($this->errorCode == self::ERR_NO_ERROR);
        return $result;
    }

    public function markSucceed()
    {
        $this->errorCode = \Praxigento\Core\Service\IResponse::ERR_NO_ERROR;
    }
}