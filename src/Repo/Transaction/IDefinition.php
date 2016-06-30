<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Transaction;

/**
 * Transaction definition to use in DB Transaction Manager.
 */
interface IDefinition
{
    /**
     * @return int
     */
    public function getLevel();

    /**
     * @param int $data
     */
    public function setLevel($data);
}