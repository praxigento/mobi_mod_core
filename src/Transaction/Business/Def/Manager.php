<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Transaction\Business\Def;


class Manager
    implements \Praxigento\Core\Transaction\Business\IManager
{
    /**
     * Starting level for the first transaction.
     */
    const ZERO_LEVEL = 0;
    /** @var \Praxigento\Core\Transaction\Business\IFactory */
    private $_factoryTrans;
    /**
     * @var array [$transactionName][$level] => \Praxigento\Core\Transaction\Business\IItem
     */
    private $_registry = [];

    public function __construct(
        \Praxigento\Core\Transaction\Business\IFactory $factoryTrans
    ) {
        $this->_factoryTrans = $factoryTrans;
    }

    /** @inheritdoc */
    public function begin($transactionName)
    {
        $result = $this->_factoryTrans->create($transactionName);
        if (!isset($this->_registry[$transactionName])) {
            $level = self::ZERO_LEVEL;
        } else {
            $level = count($this->_registry[$transactionName]);
        }
        $result->setLevel($level);
        $this->_registry[$transactionName][$level] = $result;
        return $result;
    }

    /** @inheritdoc */
    public function commit($transactionName, $transactionLevel)
    {
        if (isset($this->_registry[$transactionName])) {
            $regData = $this->_registry[$transactionName];
            $count = count($regData);
            if ($count > ($transactionLevel + 1)) {
                /* rollback all nested levels and current level */
                for ($i = $count - 1; $i > $transactionLevel; $i--) {
                    $tran = $regData[$i];
                    $tran->rollback();
                    unset($regData[$i]);
                }
            } else {
                /* commit current level */
                $regData[$transactionLevel]->commit();
                unset($regData[$transactionLevel]);
            }
        } else {
            throw new\Exception("There is no transaction named as '$transactionName'.");
        }
    }

    /** @inheritdoc */
    public function end($transactionName)
    {
        if (isset($this->_registry[$transactionName])) {
            $regData = $this->_registry[$transactionName];
            $count = count($regData);
            if ($count > 0) {
                /* rollback all nested levels and current level */
                for ($i = $count - 1; $i >= 0; $i--) {
                    $tran = $regData[$i];
                    $tran->rollback();
                    unset($regData[$i]);
                }
            }
        } else {
            throw new\Exception("There is no transaction named as '$transactionName'.");
        }
    }

    /** @inheritdoc */
    public function rollback($transactionName, $transactionLevel)
    {
        if (isset($this->_registry[$transactionName])) {
            $regData = $this->_registry[$transactionName];
            $count = count($regData);
            /* rollback all nested levels and current level */
            for ($i = $count - 1; $i >= $transactionLevel; $i--) {
                $tran = $regData[$i];
                $tran->rollback();
                unset($regData[$i]);
            }
        } else {
            throw new\Exception("There is no transaction named as '$transactionName'.");
        }
    }
}