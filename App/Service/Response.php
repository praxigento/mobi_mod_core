<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Service;

class Response
    extends \Praxigento\Core\Data
    implements \Praxigento\Core\Api\App\Service\Response
{
    /** @var string */
    private $errorCode = \Praxigento\Core\Api\App\Service\Response::ERR_UNDEFINED;
    /** @var  string */
    private $errorMessage;

    /**
     * @return string (required for Magento API transformations)
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @return string (required for Magento API transformations)
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
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
        $this->errorCode = \Praxigento\Core\Api\App\Service\Response::ERR_NO_ERROR;
    }

    public function setErrorCode($code)
    {
        $this->errorCode = $code;
    }

    public function setErrorMessage($message)
    {
        $this->errorMessage = $message;
    }
}