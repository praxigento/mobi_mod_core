<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Api;

/**
 * Base for API responses.
 */
abstract class Response
    extends \Flancer32\Lib\DataObject
{
    /**
     * Name for inner 'data' attribute cause getData & setData are abstract methods.
     * Use "parent::get(self::ATTR_DATA)" & "parent::set(self::ATTR_DATA, $data)" in child classes.
     */
    const ATTR_DATA = 'data';

    /**#@+
     * Common result codes.
     */
    const CODE_SUCCESS = 'SUCCESS';
    const CODE_UNDEF = 'UNDEFINED';

    /**#@- */

    public function __construct()
    {
        $data = new \Praxigento\Core\Api\Response\Result();
        $this->setResult($data);
    }

    /**
     * @return mixed|null
     */
    public abstract function getData();

    /**
     * @return \Praxigento\Core\Api\Response\Result
     */
    public function getResult()
    {
        $result = parent::getResult();
        return $result;
    }

    /**
     * @param mixed $data
     */
    public abstract function setData($data);

    /**
     * @param \Praxigento\Core\Api\Response\Result $data
     */
    public function setResult(\Praxigento\Core\Api\Response\Result $data)
    {
        parent::setResult($data);
    }
}