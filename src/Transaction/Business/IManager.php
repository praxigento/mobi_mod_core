<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Transaction\Business;

/**
 * Business transaction manager.
 */
interface IManager
{
    /**
     * Create new business transaction for given name. If there is transaction with the requested name level will be increased for this transaction.
     *
     * @param string $transactionName
     * @return \Praxigento\Core\Transaction\Business\IItem
     */
    public function begin($transactionName);

    /**
     * Commit this transaction if it does not contain nested uncommitted transactions.
     *
     * @param string $transactionName
     * @param int $transactionlevel
     */
    public function commit($transactionName, $transactionlevel);

    /**
     * Close transaction (rollback all uncommitted transactions or do nothing if all nested transactions were committed).
     *
     * @param string $transactionName
     */
    public function end($transactionName);

    /**
     * Rollback all transactions with given name from given level (including this level).
     *
     * @param string $transactionName
     * @param int $transactionLevel
     * @return mixed
     */
    public function rollback($transactionName, $transactionLevel);

}