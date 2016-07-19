<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Transaction\Business;

/**
 * Transaction items factory used by Business Transaction Manager.
 */
interface IFactory
{
    /**
     * @param string $name
     * @return \Praxigento\Core\Transaction\Business\IItem
     */
    public function create($name);

}