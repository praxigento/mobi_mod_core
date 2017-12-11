<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Web\Customer\Search;

/**
 * Search customers by some criteria (name, email, etc.).
 */
interface ByKeyInterface
{
    /**
     * @param \Praxigento\Core\Api\Web\Customer\Search\ByKey\Request $request
     * @return \Praxigento\Core\Api\Web\Customer\Search\ByKey\Response
     *
     * Magento 2 WebAPI requires full names in documentation (aliases are not allowed).
     */
    public function exec($request);
}