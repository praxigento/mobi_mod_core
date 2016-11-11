<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Service\Base;

/**
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class Response
    extends \Flancer32\Lib\DataObject
    implements \Praxigento\Core\Service\IResponse
{
    /** @var string */
    private $_errorCode = \Praxigento\Core\Service\IResponse::ERR_UNDEFINED;
    /** @var  string */
    private $_errorMessage;

    /**
     * @return string (required for Magento API transformations)
     */
    public function getErrorCode()
    {
        return $this->_errorCode;
    }

    /**
     * @return string (required for Magento API transformations)
     */
    public function getErrorMessage()
    {
        return $this->_errorMessage;
    }

    /**
     * @return bool
     */
    public function isSucceed()
    {
        $result = ($this->_errorCode == self::ERR_NO_ERROR);
        return $result;
    }

    public function markSucceed()
    {
        $this->_errorCode = \Praxigento\Core\Service\IResponse::ERR_NO_ERROR;
    }

    public function setErrorCode($code)
    {
        $this->_errorCode = $code;
    }

    public function setErrorMessage($message)
    {
        $this->_errorMessage = $message;
    }
}