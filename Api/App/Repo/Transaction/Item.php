<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\App\Repo\Transaction;

/**
 * Database Transaction (Done Right, MOBI-337)
 */
interface Item
{
    /**
     * @return \Magento\Framework\DB\Adapter\AdapterInterface
     */
    public function getConnection();

    /**
     * @return string
     */
    public function getConnectionName();

    /**
     * @return \Praxigento\Core\Api\App\Repo\Transaction\Definition
     */
    public function getDefinition();

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