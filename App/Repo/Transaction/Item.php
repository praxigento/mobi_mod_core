<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Repo\Transaction;

/**
 * Default implementation for Database Transaction Item.
 */
class Item
    implements \Praxigento\Core\Api\App\Repo\Transaction\Item
{
    /** @var  \Magento\Framework\DB\Adapter\AdapterInterface */
    private $conn;
    /** @var  int */
    private $level = \Praxigento\Core\Api\App\Repo\Transaction\Manager::ZERO_LEVEL;
    /** @var  string */
    private $nameConn = \Praxigento\Core\Api\App\Repo\Transaction\Manager::DEF_CONNECTION;
    /** @var  string */
    private $nameTran = \Praxigento\Core\Api\App\Repo\Transaction\Manager::DEF_TRANSACTION;
    /** @var  \Magento\Framework\App\ResourceConnection */
    private $resource;

    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource
    ) {
        $this->resource = $resource;
    }

    public function getConnection()
    {
        if (!$this->conn) {
            $this->conn = $this->resource->getConnectionByName($this->nameConn);
        }
        return $this->conn;
    }

    public function getConnectionName()
    {
        return $this->nameConn;
    }

    public function getDefinition()
    {
        $result = new \Praxigento\Core\App\Repo\Transaction\Definition(
            $this->nameTran,
            $this->nameConn,
            $this->level
        );
        return $result;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function getTransactionName()
    {
        return $this->nameTran;
    }

    public function levelDecrease()
    {
        $this->level--;
        return $this->level;
    }

    public function levelIncrease()
    {
        $this->level++;
        return $this->level;
    }

    /** @param string $data */
    public function setConnection($data)
    {
        $this->conn = $data;
    }

    /** @param string $data */
    public function setConnectionName($data)
    {
        $this->nameConn = $data;
    }

    /** @param int $data */
    public function setLevel($data)
    {
        $this->level = $data;
    }

    /** @param \Magento\Framework\App\ResourceConnection $data */
    public function setResource(\Magento\Framework\App\ResourceConnection $data)
    {
        $this->resource = $data;
    }

    /** @param string $data */
    public function setTransactionName($data)
    {
        $this->nameTran = $data;
    }
}