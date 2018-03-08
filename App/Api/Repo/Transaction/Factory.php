<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Api\Repo\Transaction;

/**
 * Transaction items factory used by Database Transaction Manager.
 */
interface Factory
{
    /**
     * @param string $transactionName
     * @param string $connectionName
     * @return \Praxigento\Core\App\Api\Repo\Transaction\Item
     */
    public function create($transactionName, $connectionName);

}