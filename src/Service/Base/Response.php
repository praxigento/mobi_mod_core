<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Service\Base;

use Flancer32\Lib\DataObject;
use Praxigento\Core\Service\IResponse;

class Response extends DataObject implements IResponse
{

    private $_errorCode = IResponse::ERR_UNDEFINED;
    /** @var  string */
    private $_errorMessage;

    /**
     * @inheritdoc
     */
    public function getErrorCode()
    {
        return $this->_errorCode;
    }

    /**
     * @inheritdoc
     */
    public function getErrorMessage()
    {
        return $this->_errorMessage;
    }

    /**
     * @inheritdoc
     */
    public function isSucceed()
    {
        $result = ($this->_errorCode == self::ERR_NO_ERROR);
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function markSucceed()
    {
        $this->_errorCode = IResponse::ERR_NO_ERROR;
    }

    /**
     * Mark response as succeed.
     * @deprecated use markSucceed() instead.
     */
    public function setAsSucceed()
    {
        $this->markSucceed();

    }

    /**
     * @inheritdoc
     */
    public function setErrorCode($code)
    {
        $this->_errorCode = $code;
    }

    /**
     * @inheritdoc
     */
    public function setErrorMessage($message)
    {
        $this->_errorMessage = $message;
    }
}