<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Helper\Customer;

/**
 * Convert base currency into/from customer currency.
 * Default implementation returns amount w/o changes.
 *
 * (Santegra project legacy, should not be used in other projects).
 */
interface Currency
{
    /**
     * @param float $amount
     * @param int|array|\Praxigento\Core\Data|null $customer
     * @return float
     */
    public function convertFromBase($amount, $customer = null);

    /**
     * @param float $amount
     * @param int|array|\Praxigento\Core\Data|null $customer
     * @return float
     */
    public function convertToBase($amount, $customer = null);
}