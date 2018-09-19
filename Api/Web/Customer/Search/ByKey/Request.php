<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Web\Customer\Search\ByKey;

class Request
    extends \Praxigento\Core\Api\App\Web\Request
{
    /**
     * @return \Praxigento\Core\Api\Web\Customer\Search\ByKey\Request\Data
     *
     * Magento 2 WebAPI requires full names in documentation (aliases are not allowed).
     */
    public function getData() {
        return parent::getData();
    }

    /**
     * @param \Praxigento\Core\Api\Web\Customer\Search\ByKey\Request\Data $data
     * @return null
     *
     * Magento 2 WebAPI requires full names in documentation (aliases are not allowed).
     */
    public function setData($data) {
        parent::setData($data);
    }

}