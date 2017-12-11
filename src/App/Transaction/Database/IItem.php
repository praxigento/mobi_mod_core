<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Transaction\Database;

/**
 * Database Transaction (Done Right, MOBI-337)
 */
interface IItem
{
    /**
     * @return \Magento\Framework\DB\Adapter\AdapterInterface
     */
    public function getConnection();

    /**
     * @return \Praxigento\Core\App\Transaction\Database\IDefinition
     */
    public function getDefinition();

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

    /**
     * Decrease transaction level.
     * @return int changed level
     */
    public function levelDecrease();

    /**
     * Increase transaction level.
     * @return int changed level
     */
    public function levelIncrease();

}