<?php
/**
 * Base class to create service calls.
 * These services use logging, database connection and Repo service (\Praxigento\Core\Lib\Service\IRepo).
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Lib\Service\Base;

abstract class Call {
    /** @var \Praxigento\Core\Lib\Service\IRepo */
    protected $_callRepo;
    /** @var  \Praxigento\Core\Lib\Context\IDbAdapter */
    protected $_dba;
    /** @var \Psr\Log\LoggerInterface */
    protected $_logger;
    /** @var  \Praxigento\Core\Lib\IToolbox */
    protected $_toolbox;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Praxigento\Core\Lib\Context\IDbAdapter $dba,
        \Praxigento\Core\Lib\IToolbox $toolbox,
        \Praxigento\Core\Lib\Service\IRepo $callRepo
    ) {
        $this->_logger = $logger;
        $this->_dba = $dba;
        $this->_toolbox = $toolbox;
        $this->_callRepo = $callRepo;
    }

    protected function _getConn() {
        $result = $this->_dba->getDefaultConnection();
        return $result;
    }

    protected function _getTableName($entityName) {
        $result = $this->_dba->getTableName($entityName);
        return $result;
    }

    protected function _logMemoryUsage() {
        $memPeak = number_format(memory_get_peak_usage(), 0, '.', ',');
        $memCurrent = number_format(memory_get_usage(), 0, '.', ',');
        $this->_logger->debug("Current memory usage: $memCurrent bytes (peak: $memPeak bytes).");
    }
}