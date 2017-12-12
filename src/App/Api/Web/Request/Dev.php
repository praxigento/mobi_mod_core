<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Api\Web\Request;

/**
 * Container for development mode data (customer & admin IDs, etc.).
 *
 * (Define getters explicitly to use with Swagger tool)
 * (Define setters explicitly to use with Magento JSON2PHP conversion tool)
 *
 */
class Dev
    extends \Praxigento\Core\Data
{
    /**
     * ID of the 'currently logged in' admin user.
     */
    const ADMIN_ID = 'adminId';
    /**
     * ID of the 'currently logged in' customer user.
     */
    const CUST_ID = 'custId';

    /**
     * ID of the 'currently logged in' admin user.
     *
     * @return int|null
     */
    public function getAdminId() {
        $result = parent::get(self::ADMIN_ID);
        return $result;
    }

    /**
     * ID of the 'currently logged in' customer.
     *
     * @return int|null
     */
    public function getCustId() {
        $result = parent::get(self::CUST_ID);
        return $result;
    }

    /**
     * ID of the 'currently logged in' admin user.
     *
     * @param int $data
     */
    public function setAdminId($data) {
        parent::set(self::ADMIN_ID, $data);
    }

    /**
     * ID of the 'currently logged in' customer user.
     *
     * @param int $data
     */
    public function setCustId($data) {
        parent::set(self::CUST_ID, $data);
    }

}