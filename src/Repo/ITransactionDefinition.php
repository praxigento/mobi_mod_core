<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo;

/**
 * Transaction definition to use in Transaction Manager.
 *
 * TODO: move interface to ...\Transaction\IDefinition
 */
interface ITransactionDefinition
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