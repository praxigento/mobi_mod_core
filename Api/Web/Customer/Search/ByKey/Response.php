<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Web\Customer\Search\ByKey;

class Response
    extends \Praxigento\Core\Api\App\Web\Response
{
    /**
     * @return \Praxigento\Core\Api\Service\Customer\Search\Response
     *
     * Magento 2 WebAPI requires full names in documentation (aliases are not allowed).
     */
    public function getData() {
        return parent::getData();

    }

    /**
     * @param \Praxigento\Core\Api\Service\Customer\Search\Response $data
     * @return null
     *
     * Magento 2 WebAPI requires full names in documentation (aliases are not allowed).
     */
    public function setData($data) {
        parent::setData($data);
    }

}