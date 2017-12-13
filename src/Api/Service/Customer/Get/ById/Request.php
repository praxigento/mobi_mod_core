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
    /** ID of the customer that sends request */
    const REQUESTER_ID = 'requesterId';
    /** 'true' if this is admin's request - return info about any customer */
    const IGNORE_REQUESTER = 'ignoreRequester';

    /**
     * @return int|null
     */
    public function getCustomerId()
    {
        $result = parent::get(self::CUSTOMER_ID);
        return $result;
    }

    /**
     * @return bool|null
     */
    public function getIgnoreRequester() {
        $result = parent::get(self::IGNORE_REQUESTER);
        return $result;
    }

    /**
     * @return string|null
     */
    public function getEmail() {
        $result = parent::get(self::EMAIL);
        return $result;
    }

    /**
     * @return int|null
     */
    public function getRequesterId() {
        $result = parent::get(self::REQUESTER_ID);
        return $result;
    }

    /**
     * @param int $data
     */
    public function setCustomerId($data)
    {
        parent::set(self::CUSTOMER_ID, $data);
    }

    /**
     * @param string $data
     */
    public function setEmail($data) {
        parent::set(self::EMAIL, $data);
    }

    /**
     * @param int $data
     */
    public function setRequesterId($data) {
        parent::set(self::REQUESTER_ID, $data);
    }

    /**
     * @param bool $data
     */
    public function setIgnoreRequester($data) {
        parent::set(self::IGNORE_REQUESTER, $data);
    }
}