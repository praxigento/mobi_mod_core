<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo;

/**
 * Transaction Manager interface for MOBI implementation of the Transaction Manager.
 *
 * TODO: move interface to ...\Transaction\IManager
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