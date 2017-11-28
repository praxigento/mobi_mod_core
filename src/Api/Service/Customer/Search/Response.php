<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Service\Customer\Search;

class Response
    extends \Praxigento\Core\Data
{
    const ATTR_DATA = 'data';

    /**
     * @return \Praxigento\Core\Api\Service\Customer\Search\Response\Data
     */
    public function getData()
    {
        $result = parent::get(self::ATTR_DATA);
        return $result;
    }

    /**
     * @param \Praxigento\Core\Api\Service\Customer\Search\Response\Data $data
     */
    public function setData($data)
    {
        parent::set(self::ATTR_DATA, $data);
    }
}