<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Repo\Query;

/**
 * Interface for DB query builders. Queries can be based on other queries.
 */
interface  IBuilder
{
    /**
     * Build query optionally based on other query. Builder modifies $source query.
     *
     * @param \Magento\Framework\DB\Select $source
     */
    public function build(\Magento\Framework\DB\Select $source = null);

}