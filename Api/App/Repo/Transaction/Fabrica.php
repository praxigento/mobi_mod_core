<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\App\Repo\Transaction;

/**
 * Transaction items factory used by Database Transaction Manager.
 *
 * CAUTION: don't use 'Factory' name, it is reserved for Magento 2 auto-generated classes.
 */
interface Fabrica
{
    /**
     * @param string $transactionName
     * @param string $connectionName
     * @return \Praxigento\Core\Api\App\Repo\Transaction\Item
     */
    public function create($transactionName, $connectionName);

}