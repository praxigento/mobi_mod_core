<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Repo\Transaction;

/**
 * Default implementation for Database Transaction Manager.
 */
class Manager
    implements \Praxigento\Core\App\Api\Repo\Transaction\Manager
{
    /** @var  \Praxigento\Core\App\Api\Repo\Transaction\Fabrica */
    private $factoryTrans;
    /** @var array Registry to store transaction by connection & transaction names ([conn][trans]=>$item). */
    private $registry = [];

    public function __construct(
        \Praxigento\Core\App\Api\Repo\Transaction\Fabrica $factoryTrans
    ) {
        $this->factoryTrans = $factoryTrans;
        /* init default connection for default transaction */
        $trans = $this->factoryTrans->create(self::DEF_TRANSACTION, self::DEF_CONNECTION);
        $this->registry[self::DEF_CONNECTION][self::DEF_TRANSACTION] = $trans;
    }

    public function begin($transactionName = self::DEF_TRANSACTION, $connectionName = self::DEF_CONNECTION)
    {
        if (isset($this->registry[$connectionName][$transactionName])) {
            $trans = $this->registry[$connectionName][$transactionName];
        } else {
            $trans = $this->factoryTrans->create($transactionName, $connectionName);
            $this->registry[$connectionName][$transactionName] = $trans;
        }
        /** @var \Magento\Framework\DB\Adapter\AdapterInterface $conn */
        $conn = $trans->getConnection();
        $conn->beginTransaction();
        $trans->levelIncrease();
        $result = $trans->getDefinition();
        return $result;
    }

    public function commit(\Praxigento\Core\App\Api\Repo\Transaction\Definition $definition)
    {
        $conn = $definition->getConnectionName();
        $trans = $definition->getTransactionName();
        $level = $definition->getLevel();
        if (isset($this->registry[$conn][$trans])) {
            /** @var \Praxigento\Core\App\Repo\Transaction\Item $item */
            $item = $this->registry[$conn][$trans];
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
            throw new \Exception("There is no database transaction named as '$trans' for connection '$conn'.");
        }
    }

    public function end(\Praxigento\Core\App\Api\Repo\Transaction\Definition $definition)
    {
        $conn = $definition->getConnectionName();
        $trans = $definition->getTransactionName();
        $level = $definition->getLevel();
        if (isset($this->registry[$conn][$trans])) {
            /** @var \Praxigento\Core\App\Repo\Transaction\Item $item */
            $item = $this->registry[$conn][$trans];
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
            throw new \Exception("There is no database transaction named as '$trans' for connection '$conn'.");
        }
    }

    public function getConnection(\Praxigento\Core\App\Api\Repo\Transaction\Definition $definition)
    {
        $trans = $definition->getTransactionName();
        $conn = $definition->getConnectionName();

        if (isset($this->registry[$conn][$trans])) {
            /** @var \Praxigento\Core\App\Api\Repo\Transaction\Item $registered */
            $registered = $this->registry[$conn][$trans];
            $result = $registered->getConnection();
        } else {
            $result = null;
        }
        return $result;
    }

    public function rollback(\Praxigento\Core\App\Api\Repo\Transaction\Definition $definition)
    {
        $conn = $definition->getConnectionName();
        $trans = $definition->getTransactionName();
        $level = $definition->getLevel();
        if (isset($this->registry[$conn][$trans])) {
            /** @var \Praxigento\Core\App\Repo\Transaction\Item $item */
            $item = $this->registry[$conn][$trans];
            $maxLevel = $item->getLevel();
            /* rollback all nested levels and current level */
            for ($i = $maxLevel; $i >= $level; $i--) {
                $conn = $item->getConnection();
                $conn->rollBack();
                $item->levelDecrease();
            }
        } else {
            throw new \Exception("There is no database transaction named as '$trans' for connection '$conn'.");
        }
    }
}