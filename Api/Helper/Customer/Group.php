<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Helper\Customer;

/**
 * Customer groups related helper.
 */
interface Group
{
    /**
     * Quick way to get customer's group ID by customer ID (w/o Magento model/resource).
     *
     * @param int $custId
     * @return int|null
     */
    public function getIdByCustomerId($custId);

}