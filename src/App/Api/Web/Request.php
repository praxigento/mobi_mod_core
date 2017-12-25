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
     * Development mode data (acts only if app is in DEV MODE).
     */
    const DEV = 'dev';
    /**
     * 'true' - request is sent from admin app and should be authorized according to current admin.
     *  skipped (or !true) - request is sent from frontend (authorize according to current customer).
     */
    const IS_ADMIN = 'isAdmin';

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
     * Development mode data (acts only if app is in DEV MODE).
     *
     * @return \Praxigento\Core\App\Api\Web\Request\Dev|null
     */
    public function getDev() {
        $result = parent::get(self::DEV);
        return $result;
    }

    /**
     * 'true' - request is sent from admin app and should be authorized according to current admin.
     *  skipped (or !true) - request is sent from frontend (authorize according to current customer).
     *
     * @return string|null
     */
    public function getIsAdmin() {
        $result = parent::get(self::IS_ADMIN);
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
     * Development mode data (acts only if app is in DEV MODE).
     *
     * @param \Praxigento\Core\App\Api\Web\Request\Dev $data
     */
    public function setDev($data) {
        parent::set(self::DEV, $data);
    }

    /**
     * 'true' - request is sent from admin app and should be authorized according to current admin.
     *  skipped (or !true) - request is sent from frontend (authorize according to current customer).
     *
     * @param string $data
     */
    public function setIsAdmin($data) {
        parent::set(self::IS_ADMIN, $data);
    }

}