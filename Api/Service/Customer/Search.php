<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Service\Customer;

use Praxigento\Core\Api\Service\Customer\Search\Request as ARequest;
use Praxigento\Core\Api\Service\Customer\Search\Response as AResponse;

/**
 * Search customers by some criteria (name, email, etc.).
 *
 * This service has no default implementation - there is one implementation in 'Downline' module.
 */
interface Search
{
    /**
     * @param ARequest $request
     * @return AResponse
     */
    public function exec($request);
}