<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Service\Customer\Get\ById;

class Request
    extends \Praxigento\Core\Data
{
    /** Customer ID to search by */
    const CUSTOMER_ID = 'customerId';
    /** Email to search by */
    const EMAIL = 'email';

    /**
     * @return int|null
     */
    public function getCustomerId()
    {
        $result = parent::get(self::CUSTOMER_ID);
        return $result;
    }

    /**
     * @return string|null
     */
    public function getEmail()
    {
        $result = parent::get(self::EMAIL);
        return $result;
    }

    /**
     * @param int $data
     * @return void
     */
    public function setCustomerId($data)
    {
        parent::set(self::CUSTOMER_ID, $data);
    }

    /**
     * @param string $data
     * @return void
     */
    public function setEmail($data)
    {
        parent::set(self::EMAIL, $data);
    }

}