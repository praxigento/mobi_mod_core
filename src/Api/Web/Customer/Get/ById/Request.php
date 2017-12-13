<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Web\Customer\Get\ById;

class Request
    extends \Praxigento\Core\App\Api\Web\Request
{
    /**
     * @return \Praxigento\Core\Api\Web\Customer\Get\ById\Request\Data
     *
     * Magento 2 WebAPI requires full names in documentation (aliases are not allowed).
     */
    public function getData() {
        return parent::getData();
    }

    /**
     * @param \Praxigento\Core\Api\Web\Customer\Get\ById\Request\Data $data
     *
     * Magento 2 WebAPI requires full names in documentation (aliases are not allowed).
     */
    public function setData($data) {
        parent::setData($data);
    }

}