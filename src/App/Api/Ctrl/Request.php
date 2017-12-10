<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Api\Ctrl;

/**
 * Base for Ctrl API requests.
 */
abstract class Request
    extends \Praxigento\Core\Data {

    const DATA = 'data';
    const DEV_AUTH_ID = 'devAuthId';

    /**
     * Get request data (w/o additional information).
     * Override to get appropriate JSON structure in request.
     *
     * @return \Praxigento\Core\Data|null
     */
    public function getData() {
        $result = parent::get(self::DATA);
        return $result;
    }

    /**
     * Get ID of the "current" customer/admin if app is in dev mode (for development purposes).
     *
     * @return int
     */
    public function getDevAuthId() {
        $result = parent::get(self::DEV_AUTH_ID);
        return $result;
    }

    /**
     * Set request data (w/o additional information).
     * Override to get appropriate JSON structure in request.
     *
     * @param \Praxigento\Core\Data $data
     */
    public function setData($data) {
        parent::set($data, self::DATA);
    }

    /**
     * Set ID of the "current" customer/admin if app is in dev mode (for development purposes).
     *
     * @param int $data
     */
    public function setDevAuthId($data) {
        parent::set($data, self::DEV_AUTH_ID);
    }
}