<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Service\Customer\Get;

use Praxigento\Core\Api\Service\Customer\Get\ById\Request as ARequest;
use Praxigento\Core\Api\Service\Customer\Get\ById\Response as AResponse;

/**
 * Get customer data by identifier (ID, email, MLM ID, ...).
 */
interface ById
{
    /**
     * @param ARequest $request
     * @return AResponse
     */
    public function exec($request);
}