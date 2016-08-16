<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Transaction\Database\Def;

/**
 * Default implementation for Database Transaction Manager.
 */
class Manager
    implements \Praxigento\Core\Transaction\Database\IManager
{
    /** @var  \Praxigento\Core\Transaction\Database\IFactory */
    private $_factoryTrans;
    /** @var array Registry to store transaction by connection & transaction names ([conn][trans]=>$item). */
    private $_registry = [];

    public function __construct(
        \Praxigento\Core\Transaction\Database\IFactory $factoryTrans
    ) {
        $this->_factoryTrans = $factoryTrans;
        /* init default connection for default transaction */
        $trans = $this->_factoryTrans->create(self::DEF_TRANSACTION, self::DEF_CONNECTION);
        $this->_registry[self::DEF_CONNECTION][self::DEF_TRANSACTION] = $trans;
    }

    /** @inheritdoc */
    public function begin($transactionName = self::DEF_TRANSACTION, $connectionName = self::DEF_CONNECTION)
    {
        if (isset($this->_registry[$connectionName][$transactionName])) {
            $trans = $this->_registry[$connectionName][$transactionName];
        } else {
            $trans = $this->_factoryTrans->create($transactionName, $connectionName);
            $this->_registry[$connectionName][$transactionName] = $trans;
        }
        /** @var \Magento\Framework\DB\Adapter\AdapterInterface $conn */
        $conn = $trans->getConnection();
        $conn->beginTransaction();
        $trans->levelIncrease();
        $result = $trans->getDefinition();
        return $result;
    }

    /** @inheritdoc */
    public function commit(\Praxigento\Core\Transaction\Database\IDefinition $definition)
    {
        $conn = $definition->getConnectionName();
        $trans = $definition->getTransactionName();
        $level = $definition->getLevel();
        if (isset($this->_registry[$conn][$trans])) {
            /** @var \Praxigento\Core\Transaction\Database\Def\Item $item */
            $item = $this->_registry[$conn][$trans];
            $maxLevel = $item->getLevel();
            if ($maxLevel > $level) {
                /* rollback all nested levels and current level */
                for ($i = $maxLevel; $i >= $level; $i--) {
                    $conn = $item->getConnection();
                    $conn->rollBack();
                    $item->levelDecrease();
                }
            } else {
                /* there is one only uncommitted level */
                $conn = $item->getConnection();
                $conn->commit();
                $item->levelDecrease();
            }
        } else {
            throw new\Exception("There is no database transaction named as '$trans' for connection '$conn'.");
        }
    }

    /** @inheritdoc */
    public function end(\Praxigento\Core\Transaction\Database\IDefinition $definition)
    {
        $conn = $definition->getConnectionName();
        $trans = $definition->getTransactionName();
        $level = $definition->getLevel();
        if (isset($this->_registry[$conn][$trans])) {
            /** @var \Praxigento\Core\Transaction\Database\Def\Item $item */
            $item = $this->_registry[$conn][$trans];
            $maxLevel = $item->getLevel();
            if ($maxLevel >= $level) {
                /* rollback all nested levels and current level */
                for ($i = $maxLevel; $i >= $level; $i--) {
                    $conn = $item->getConnection();
                    $conn->rollBack();
                    $item->levelDecrease();
                }
            }
        } else {
            throw new\Exception("There is no database transaction named as '$trans' for connection '$conn'.");
        }
    }

    /** @inheritdoc */
    public function getConnection(\Praxigento\Core\Transaction\Database\IDefinition $definition)
    {
        $trans = $definition->getTransactionName();
        $conn = $definition->getConnectionName();

        if (isset($this->_registry[$conn][$trans])) {
            /** @var \Praxigento\Core\Transaction\Database\IItem $registered */
            $registered = $this->_registry[$conn][$trans];
            $result = $registered->getConnection();
        } else {
            $result = null;
        }
        return $result;
    }

    /** @inheritdoc */
    public function rollback(\Praxigento\Core\Transaction\Database\IDefinition $definition)
    {
        $conn = $definition->getConnectionName();
        $trans = $definition->getTransactionName();
        $level = $definition->getLevel();
        if (isset($this->_registry[$conn][$trans])) {
            /** @var \Praxigento\Core\Transaction\Database\Def\Item $item */
            $item = $this->_registry[$conn][$trans];
            $maxLevel = $item->getLevel();
            /* rollback all nested levels and current level */
            for ($i = $maxLevel; $i >= $level; $i--) {
                $conn = $item->getConnection();
                $conn->rollBack();
                $item->levelDecrease();
            }
        } else {
            throw new\Exception("There is no database transaction named as '$trans' for connection '$conn'.");
        }
    }
}