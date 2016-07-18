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
     * @param \Praxigento\Core\Transaction\Business\IItem $transactionItem
     * @return mixed
     */
    public function commit(\Praxigento\Core\Transaction\Business\IItem $transactionItem);

    /**
     * Close transaction (rollback all uncommitted transactions).
     *
     * @param string $transactionName
     */
    public function end($transactionName);

}