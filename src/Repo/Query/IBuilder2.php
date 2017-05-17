<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Repo\Query;

/**
 * Interface for DB query builders. Queries can be based on other queries.
 */
interface  IBuilder2
{
    /**
     * Build query optionally based on other query.
     *
     * @param \Magento\Framework\DB\Select $source
     * @return \Magento\Framework\DB\Select
     */
    public function build($source = null);

}