<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Transaction\Database;

/**
 * Transaction items factory used by Database Transaction Manager.
 */
interface IFactory
{
    /**
     * @param string $transactionName
     * @param string $connectionName
     * @return \Praxigento\Core\Transaction\Database\IItem
     */
    public function create($transactionName, $connectionName);

}