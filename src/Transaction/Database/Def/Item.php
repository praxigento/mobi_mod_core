<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Transaction\Database\Def;

/**
 * Default implementation for Database Transaction Item.
 */
class Item
    implements \Praxigento\Core\Transaction\Database\IItem
{
    /** @var  \Magento\Framework\DB\Adapter\AdapterInterface */
    private $_conn;
    /** @var  int */
    private $_level = \Praxigento\Core\Transaction\Database\IManager::ZERO_LEVEL;
    /** @var  string */
    private $_nameConn = \Praxigento\Core\Transaction\Database\IManager::DEF_CONNECTION;
    /** @var  string */
    private $_nameTran = \Praxigento\Core\Transaction\Database\IManager::DEF_TRANSACTION;
    /** @var  \Magento\Framework\App\ResourceConnection */
    private $_resource;

    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource
    ) {
        $this->_resource = $resource;
    }

    /** @inheritdoc */
    public function getConnection()
    {
        if (!$this->_conn) {
            $this->_conn = $this->_resource->getConnectionByName($this->_nameConn);
        }
        return $this->_conn;
    }

    /** @inheritdoc */
    public function getConnectionName()
    {
        return $this->_nameConn;
    }

    /** @inheritdoc */
    public function getDefinition()
    {
        $result = new \Praxigento\Core\Transaction\Database\Def\Definition(
            $this->_nameTran,
            $this->_nameConn,
            $this->_level
        );
        return $result;
    }

    /** @inheritdoc */
    public function getLevel()
    {
        return $this->_level;
    }

    /** @inheritdoc */
    public function getTransactionName()
    {
        return $this->_nameTran;
    }

    /** @inheritdoc */
    public function levelDecrease()
    {
        $this->_level--;
        return $this->_level;
    }

    /** @inheritdoc */
    public function levelIncrease()
    {
        $this->_level++;
        return $this->_level;
    }

    /**
     * @param string $data
     */
    public function setConnection($data)
    {
        $this->_conn = $data;
    }

    /**
     * @param string $data
     */
    public function setConnectionName($data)
    {
        $this->_nameConn = $data;
    }

    /**
     * @param int $data
     */
    public function setLevel($data)
    {
        $this->_level = $data;
    }

    /**
     * @param \Magento\Framework\App\ResourceConnection $data
     */
    public function setResource(\Magento\Framework\App\ResourceConnection $data)
    {
        $this->_resource = $data;
    }

    /**
     * @param string $data
     */
    public function setTransactionName($data)
    {
        $this->_nameTran = $data;
    }
}