<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Transaction\Business;

/**
 * Transaction items factory used by Business Transaction Manager.
 *
 * MOBI-502: cannot use IFactory name for the interface, it conflicts with Magento naming conventions.
 */
interface IFabrique
{
    /**
     * @param string $name
     * @return \Praxigento\Core\Transaction\Business\IItem
     */
    public function create($name);

}