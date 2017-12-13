<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Web\Customer\Get\ById\Request;

/**
 * Request parameters.
 *
 * (Define getters explicitly to use with Swagger tool)
 *
 */
class Data
    extends \Praxigento\Core\Data
{
    /** Customer ID to search by */
    const CUSTOMER_ID = 'customerId';
    /** Email to search by */
    const EMAIL = 'email';

    /**
     * @return int|null
     */
    public function getCustomerId() {
        $result = parent::get(self::CUSTOMER_ID);
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
     * @param int $data
     */
    public function setCustomerId($data) {
        parent::set(self::CUSTOMER_ID, $data);
    }

    /**
     * @param string $data
     */
    public function setEmail($data) {
        parent::set(self::EMAIL, $data);
    }
}