<?php
/**
 * Base class to create service calls. These services use logging.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Service\Base;

/**
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
abstract class Call
{
    /** @var \Psr\Log\LoggerInterface */
    protected $_logger;
    /** @var  \Magento\Framework\ObjectManagerInterface */
    protected $_manObj;

    public function __construct(
        \Praxigento\Core\Fw\Logger\App $logger,
        \Magento\Framework\ObjectManagerInterface $manObj
    ) {
        $this->_logger = $logger;
        $this->_manObj = $manObj;
    }

    protected function _logMemoryUsage()
    {
        $memPeak = number_format(memory_get_peak_usage(), 0, '.', ',');
        $memCurrent = number_format(memory_get_usage(), 0, '.', ',');
        $this->_logger->debug("Current memory usage: $memCurrent bytes (peak: $memPeak bytes). Service: "
            . get_class($this) . '.');
    }
}