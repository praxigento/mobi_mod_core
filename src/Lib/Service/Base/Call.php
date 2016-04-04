<?php
/**
 * Base class to create service calls.
 * These services use logging.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Lib\Service\Base;

abstract class Call
{
    /** @var \Psr\Log\LoggerInterface */
    protected $_logger;

    public function __construct(
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->_logger = $logger;
    }

    protected function _logMemoryUsage()
    {
        $memPeak = number_format(memory_get_peak_usage(), 0, '.', ',');
        $memCurrent = number_format(memory_get_usage(), 0, '.', ',');
        $this->_logger->debug("Current memory usage: $memCurrent bytes (peak: $memPeak bytes). Service: " . get_class($this) . '.');
    }
}