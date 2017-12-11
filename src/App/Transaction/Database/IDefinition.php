<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Transaction\Database;

/**
 * Database Transaction Definition (address of the transaction for the Transaction Manager).
 */
interface IDefinition
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