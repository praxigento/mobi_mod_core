<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Transaction\Database;

/**
 * Database Transaction Manager (Done Right, MOBI-337)
 */
interface IManager
{
    /**
     * Name for default connection.
     */
    const DEF_CONNECTION = 'default';
    /**
     * Name for default transaction.
     */
    const DEF_TRANSACTION = 'default_trans';
    /**
     * Starting level for the first transaction.
     */
    const ZERO_LEVEL = 0;

    /**
     * Create new transaction for connection.
     *
     * @param string $transactionName
     * @param string $connectionName
     * @return \Praxigento\Core\App\Transaction\Database\IDefinition
     */
    public function begin($transactionName = self::DEF_TRANSACTION, $connectionName = self::DEF_CONNECTION);

    /**
     * Commit transaction for given definition.
     *
     * @param \Praxigento\Core\App\Transaction\Database\IDefinition $definition
     */
    public function commit(\Praxigento\Core\App\Transaction\Database\IDefinition $definition);

    /**
     * Close transaction (rollback all nested levels including current if any uncommitted transactions exist or do nothing).
     *
     * @param \Praxigento\Core\App\Transaction\Database\IDefinition $definition
     */
    public function end(\Praxigento\Core\App\Transaction\Database\IDefinition $definition);

    /**
     * Get connection for transaction definition.
     *
     * @param \Praxigento\Core\App\Transaction\Database\IDefinition $definition
     * @return \Magento\Framework\DB\Adapter\AdapterInterface
     */
    public function getConnection(\Praxigento\Core\App\Transaction\Database\IDefinition $definition);

    /**
     * Rollback transaction for given definition.
     *
     * @param \Praxigento\Core\App\Transaction\Database\IDefinition $definition
     */
    public function rollback(\Praxigento\Core\App\Transaction\Database\IDefinition $definition);

}