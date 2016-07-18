<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Transaction\Business\Def;


final class Item
    implements \Praxigento\Core\Transaction\Business\IItem
{
    private $_callsCommit = [];
    private $_callsRollback = [];
    /** @var \Psr\Log\LoggerInterface */
    protected $_logger;

    public function __construct(
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->_logger = $logger;
    }

    public function addCommitCall($callable)
    {
        $this->_callsCommit[] = $callable;
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

    public function addRollbackCall($callable)
    {
        $this->_callsRollback[] = $callable;
    }

    /** @var  string */
    private $_name;
    /** @var  int */
    private $_level = \Praxigento\Core\Transaction\Business\Def\Manager::ZERO_LEVEL;

    public function setName($data)
    {
        $this->_name = $data;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function getLevel()
    {
        return $this->_level;
    }

    public function setLevel($data)
    {
        $this->_level = $data;
    }

    public function getResource($resourceName)
    {
        // TODO: Implement getResource() method.
    }


}