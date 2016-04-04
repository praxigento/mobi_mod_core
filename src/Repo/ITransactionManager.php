<?php
/**
 * Transaction Manager interface for MOBI implementation of the Transaction Manager.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Repo;

/**
 * Transaction manager to use in the services.
 */
interface ITransactionManager
{
    /**
     * @return ITransactionDefinition
     */
    public function transactionBegin();

    /**
     * Rollback transaction if it is not committed before or do nothing otherwise.
     */
    public function transactionClose(ITransactionDefinition $data);

    public function transactionCommit(ITransactionDefinition $data);

    public function transactionRollback(ITransactionDefinition $data);
}