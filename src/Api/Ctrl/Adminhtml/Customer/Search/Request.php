<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Ctrl\Adminhtml\Customer\Search;

/**
 * Request to search customers from adminhtml.
 */
class Request
    extends \Praxigento\Core\App\Api\Ctrl\Request {

    /**
     * @return Request\Data
     */
    public function getData() {
        return parent::getData();
    }

    /**
     * @param Request\Data $data
     */
    public function setData($data) {
        parent::setData($data);
    }


}