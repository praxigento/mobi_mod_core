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