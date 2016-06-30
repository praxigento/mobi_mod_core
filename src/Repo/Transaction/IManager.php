<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Transaction;

/**
 * Transaction Manager interface for MOBI implementation of the Transaction Manager.
 */
interface IManager
{
    /**
     * @return IDefinition
     */
    public function transactionBegin();

    /**
     * Rollback transaction if it is not committed before or do nothing otherwise.
     */
    public function transactionClose(IDefinition $data);

    public function transactionCommit(IDefinition $data);

    public function transactionRollback(IDefinition $data);
}