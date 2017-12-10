<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Api\Ctrl;

/**
 * Base for Ctrl API responses.
 */
abstract class Response
    extends \Praxigento\Core\Data {

    const DATA = 'data';

    /**
     * Get response data (w/o additional information).
     * Override to get appropriate JSON structure in response.
     *
     * @return \Praxigento\Core\Data|null
     */
    public function getData() {
        $result = parent::get(self::DATA);
        return $result;
    }

    /**
     * Set response data (w/o additional information).
     * Override to get appropriate JSON structure in response.
     *
     * @param \Praxigento\Core\Data $data
     */
    public function setData($data) {
        parent::set($data, self::DATA);
    }
}