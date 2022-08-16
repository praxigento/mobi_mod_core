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
interface Currency {
    /**
     * @param float $amount
     * @param int|array|\Praxigento\Core\Data|null $customer ID or data object.
     * @param bool $round 'false' - don't round result.
     * @param \DateTime|string $date to get rate (null - current date)
     * @return float
     */
    public function convertFromBase($amount, $customer = null, $round = true, $date = null);

    /**
     * @param float $amount
     * @param int|array|\Praxigento\Core\Data|null $customer ID or data object.
     * @param bool $round 'false' - don't round result.
     * @param \DateTime|string $date to get rate (null - current date)
     * @return float
     */
    public function convertToBase($amount, $customer = null, $round = true, $date = null);

    /**
     * Get customer's currency code.
     *
     * @param int|array|\Praxigento\Core\Data|null $customer ID or data object.
     * @return string
     */
    public function getCurrency($customer);

    /**
     * Get code base currency (USD).
     * @return string
     */
    public function getCurrencyBase();

    /**
     * Return conversion rate for EUR/USD for given $date.
     * @param \DateTime|string $date
     * @return float
     */
    public function getRateEur($date = null);
}
