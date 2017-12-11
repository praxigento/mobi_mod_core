<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Transaction\Business\Def;

/**
 * Business transaction item.
 */
class Item
    implements \Praxigento\Core\App\Transaction\Business\IItem
{
    /**
     * Registry for commit functions.
     * @var array
     */
    private $_callsCommit = [];
    /**
     * Registry for rollback functions.
     * @var array
     */
    private $_callsRollback = [];
    /** @var  int */
    private $_level = \Praxigento\Core\App\Transaction\Business\Def\Manager::ZERO_LEVEL;
    /** @var \Psr\Log\LoggerInterface */
    protected $_logger;
    /** @var  string */
    private $_name;

    public function __construct(
        \Praxigento\Core\App\Logger\App $logger
    ) {
        $this->_logger = $logger;
    }

    public function addCommitCall($callable)
    {
        $this->_callsCommit[] = $callable;
    }

    public function addRollbackCall($callable)
    {
        $this->_callsRollback[] = $callable;
    }

    public function commit()
    {
        $reversed = array_reverse($this->_callsCommit);
        foreach ($reversed as $item) {
            try {
                call_user_func($item);
            } catch (\Exception $e) {
                $this->_logger->error("Cannot perform commit call for transaction '{$this->getName()}'. Error: " . $e->getMessage());
            }
        }
    }

    public function getLevel()
    {
        return $this->_level;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function rollback()
    {
        $reversed = array_reverse($this->_callsRollback);
        foreach ($reversed as $item) {
            try {
                call_user_func($item);
            } catch (\Exception $e) {
                $this->_logger->error("Cannot perform rollback call for transaction '{$this->getName()}'. Error: " . $e->getMessage());
            }
        }
    }

    public function setLevel($data)
    {
        $this->_level = $data;
    }

    public function setName($data)
    {
        $this->_name = $data;
    }


}