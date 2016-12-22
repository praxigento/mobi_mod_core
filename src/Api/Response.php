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
     * @return \Praxigento\Core\Api\Response\Result
     */
    public function getResult()
    {
        $result = parent::getResult();
        return $result;
    }

    /**
     * @param \Praxigento\Core\Api\Response\Result $data
     */
    public function setResult(\Praxigento\Core\Api\Response\Result $data)
    {
        parent::setResult($data);
    }
}