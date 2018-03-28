<?php
/**
 * Formatting tool default implementation.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Helper;

/**
 * Default implementation of the customer currency converter.
 */
class Currency
    implements \Praxigento\Core\Api\Helper\Customer\Currency
{

    public function convertFromBase($amount, $customer = null)
    {
        return $amount;
    }

    public function convertToBase($amount, $customer = null)
    {
        return $amount;
    }
}