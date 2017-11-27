<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Service\Customer;

use Praxigento\Core\Api\Service\Customer\Get\Request as ARequest;
use Praxigento\Core\Api\Service\Customer\Get\Response as AResponse;

/**
 * Get customer data by identifier (ID, email, MLM ID, ...).
 *
 * This service has no default implementation - there is one implementation in 'Downline' module.
 */
interface Get
{
    /**
     * @param ARequest $request
     * @return AResponse
     */
    public function exec($request);
}