<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Transaction\Business;

/**
 * Business Transaction.
 */
interface IItem
{
    public function addCommitCall($callable);

    public function addRollbackCall($callable);

    public function commit();

    /**
     * Get transaction level.
     * @return int
     */
    public function getLevel();

    /**
     * Get transaction name.
     * @return string
     */
    public function getName();

    /**
     * @param string $resourceName
     * @return mixed
     */
    public function getResource($resourceName);

    public function rollback();

}