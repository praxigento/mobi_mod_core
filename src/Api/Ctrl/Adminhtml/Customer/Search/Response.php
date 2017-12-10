<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Ctrl\Adminhtml\Customer\Search;

/**
 * Response to search customers from adminhtml.
 */
class Response
    extends \Praxigento\Core\App\Api\Ctrl\Response {

    /**
     * @return Response\Data
     */
    public function getData() {
        return parent::getData();
    }

    /**
     * @param Response\Data $data
     */
    public function setData($data) {
        parent::setData($data);
    }
}