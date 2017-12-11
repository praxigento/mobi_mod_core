<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Transaction\Database\Def;


class Definition
    implements \Praxigento\Core\App\Transaction\Database\IDefinition
{

    /** @var  int */
    private $_level;
    /** @var  string */
    private $_nameConn;
    /** @var  string */
    private $_nameTran;

    /**
     * Definition constructor.
     * @param string $trans Transaction name
     * @param string $conn Connection name
     * @param lvel $level Level for nested transactions.
     */
    public function __construct($trans, $conn, $level)
    {
        $this->_nameTran = $trans;
        $this->_nameConn = $conn;
        $this->_level = $level;
    }

    /** @inheritdoc */
    public function getConnectionName()
    {
        return $this->_nameConn;
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
}