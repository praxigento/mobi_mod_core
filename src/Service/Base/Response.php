<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Service\Base;


use Flancer32\Lib\DataObject;

class Response extends DataObject
{
    const ERR_NO_ERROR = 'no_error';
    const ERR_UNDEFINED = 'undefined';
    private $_errorCode = self::ERR_UNDEFINED;
    /** @var  string */
    private $_errorMessage;

    /**
     * @return mixed
     */
    public function getErrorCode()
    {
        return $this->_errorCode;
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->_errorMessage;
    }

    /**
     * Return 'true' if this response is corresponded to successfully completed operation.
     * @return bool
     */
    public function isSucceed()
    {
        $result = ($this->_errorCode == self::ERR_NO_ERROR);
        return $result;
    }

    /**
     * Mark response as succeed.
     */
    public function setAsSucceed()
    {
        $this->_errorCode = self::ERR_NO_ERROR;

    }

    /**
     * @param mixed $code
     */
    public function setErrorCode($code)
    {
        $this->_errorCode = $code;
    }

    /**
     * @param string $message
     */
    public function setErrorMessage($message)
    {
        $this->_errorMessage = $message;
    }
}