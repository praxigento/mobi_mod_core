<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Api\Web;

/**
 * Base for Web API responses.
 */
class Response
    extends \Praxigento\Core\Data
{
    /**
     * Name for inner 'data' attribute cause getData & setData are abstract methods.
     * Use "parent::get(self::ATTR_DATA)" & "parent::set(self::ATTR_DATA, $data)" in child classes.
     */
    const ATTR_DATA = 'data';
    /**#@+
     * Common result codes.
     */
    const CODE_FAILED = 'FAILED';
    const CODE_NOT_IMPLEMENTED = 'IS_NOT_IMPLEMENTED';
    const CODE_SUCCESS = 'SUCCESS';
    const CODE_UNDEF = 'UNDEFINED';

    /**#@- */

    public function __construct($data = null)
    {
        if ($data instanceof \Praxigento\Core\Data) {
            /* init object with given $data */
            $arg = $data->get();
            parent::__construct($arg);
        } else {
            /* init empty response object*/
            $rs = new \Praxigento\Core\App\Api\Web\Response\Result();
            $this->setResult($rs);
        }
    }

    /**
     * Override to get appropriate JSON structure in response.
     *
     * @return \Praxigento\Core\Data|null
     */
    public function getData()
    {
        $result = parent::getData();
        return $result;
    }

    /**
     * @return \Praxigento\Core\App\Api\Web\Response\Result
     */
    public function getResult()
    {
        $result = parent::getResult();
        return $result;
    }

    /**
     * Override to get appropriate JSON structure in response.
     *
     * @param \Praxigento\Core\Data $data
     */
    public function setData($data)
    {
        parent::setData($data);
    }

    /**
     * @param \Praxigento\Core\App\Api\Web\Response\Result $data
     */
    public function setResult(\Praxigento\Core\App\Api\Web\Response\Result $data)
    {
        parent::setResult($data);
    }
}