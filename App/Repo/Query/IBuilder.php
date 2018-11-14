<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Repo\Query;

/**
 * Interface for DB query builders. Queries can be based on other queries.
 */
interface  IBuilder
{
    /**
     * Build query optionally based on other query. Builder modifies $source query.
     *
     * @param \Magento\Framework\DB\Select $source
     * @return \Magento\Framework\DB\Select
     */
    public function build(\Magento\Framework\DB\Select $source = null);

}