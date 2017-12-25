<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Web\Customer\Get;

/**
 * Get customer data by ID.
 */
interface ByIdInterface
{
    /**
     * @param \Praxigento\Core\Api\Web\Customer\Get\ById\Request $request
     * @return \Praxigento\Core\Api\Web\Customer\Get\ById\Response
     * @throws \Magento\Framework\Exception\AuthorizationException
     *
     * Magento 2 WebAPI requires full names in documentation (aliases are not allowed).
     */
    public function exec($request);
}