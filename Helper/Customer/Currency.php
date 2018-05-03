<?php
/**
 * Formatting tool default implementation.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Helper;

use Praxigento\Core\Config as Cfg;

/**
 * Default implementation of the customer currency converter.
 */
class Currency
    implements \Praxigento\Core\Api\Helper\Customer\Currency
{

    public function convertFromBase($amount, $customer = null, $round = true)
    {
        return $amount;
    }

    public function convertToBase($amount, $customer = null, $round = true)
    {
        return $amount;
    }

    public function getCurrency($customer)
    {
        return Cfg::CODE_CUR_USD;
    }
}