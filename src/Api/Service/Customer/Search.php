<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Service\Customer;

use Praxigento\Core\Api\Service\Customer\Get\Request as ARequest;
use Praxigento\Core\Api\Service\Customer\Get\Response as AResponse;

/**
 * Search customers by some criteria (name, email, etc.).
 */
interface Search
{
    /**
     * @param ARequest $request
     * @return AResponse
     */
    public function exec($request);
}