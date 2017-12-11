<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Api\Web;

/**
 * Base API request.
 *
 * (Define getters explicitly to use with Swagger tool)
 * (Define setters explicitly to use with Magento JSON2PHP conversion tool)
 *
 */
class Request
    extends \Praxigento\Core\Data
{
    /**
     * Name for inner attribute that contains request's useful data (w/o service attributes of the request).
     */
    const DATA = 'data';
    /**
     * ID of the 'currently logged in' admin user (acts only if app is in DEV MODE).
     */
    const DEV_ADMIN_ID = 'devAdminId';
    /**
     * ID of the 'currently logged in' customer user (acts only if app is in DEV MODE).
     */
    const DEV_CUST_ID = 'devCustId';

    /**
     * Data structure for the Web API request.
     *
     * Override to get appropriate JSON structure for concrete request.
     *
     * @return \Praxigento\Core\Data
     */
    public function getData() {
        $result = parent::get(self::DATA);
        return $result;
    }

    /**
     * ID of the 'currently logged in' admin user (acts only if app is in DEV MODE).
     *
     * @return int|null
     */
    public function getDevAdminId() {
        $result = parent::get(self::DEV_ADMIN_ID);
        return $result;
    }

    /**
     * ID of the 'currently logged in' customer user (acts only if app is in DEV MODE).
     *
     * @return int|null
     */
    public function getDevCustId() {
        $result = parent::get(self::DEV_CUST_ID);
        return $result;
    }

    /**
     * Data structure for the Web API request.
     *
     * Override to get appropriate JSON structure for concrete request.
     *
     * @param \Praxigento\Core\Data $data
     */
    public function setData($data) {
        parent::set(self::DATA, $data);
    }

    /**
     * ID of the 'currently logged in' admin user (acts only if app is in DEV MODE).
     *
     * @param int $data
     */
    public function setDevAdminId($data) {
        parent::set(self::DEV_ADMIN_ID, $data);
    }

    /**
     * ID of the 'currently logged in' customer user (acts only if app is in DEV MODE).
     *
     * @param int $data
     */
    public function setDevCustId($data) {
        parent::set(self::DEV_CUST_ID, $data);
    }

}