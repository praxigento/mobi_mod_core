<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Repo\Transaction;


class Definition
    implements \Praxigento\Core\App\Api\Repo\Transaction\Definition
{

    /** @var  int */
    private $level;
    /** @var  string */
    private $nameConn;
    /** @var  string */
    private $nameTran;

    /**
     * @param string $trans Transaction name
     * @param string $conn Connection name
     * @param int $level Level for nested transactions.
     */
    public function __construct($trans, $conn, $level)
    {
        $this->nameTran = $trans;
        $this->nameConn = $conn;
        $this->level = $level;
    }

    public function getConnectionName()
    {
        return $this->nameConn;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function getTransactionName()
    {
        return $this->nameTran;
    }
}