<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\App\Repo\Transaction;

/**
 * Database Transaction Definition (address of the transaction for the Transaction Manager).
 */
interface Definition
{
    /**
     * @return string
     */
    public function getConnectionName();

    /**
     * @return int
     */
    public function getLevel();

    /**
     * @return string
     */
    public function getTransactionName();

}