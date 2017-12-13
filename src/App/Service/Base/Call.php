<?php
/**
 * Base class to create service calls. These services use logging.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Service\Base;

/**
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
abstract class Call
{
    /**
     * @var \Psr\Log\LoggerInterface
     *
     * @deprecated use $this->_logger
     */
    protected $_logger;
    /**
     * @var  \Magento\Framework\ObjectManagerInterface
     *
     * @deprecated use $this->_manObj
     */
    protected $_manObj;
    /** @var \Psr\Log\LoggerInterface */
    protected $logger;
    /** @var  \Magento\Framework\ObjectManagerInterface */
    protected $manObj;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\ObjectManagerInterface $manObj
    ) {
        $this->logger = $logger;
        $this->manObj = $manObj;
        $this->_logger = $logger;
        $this->_manObj = $manObj;
    }

    /**
     * @deprecated use logMemoryUsage()
     */
    protected function _logMemoryUsage()
    {
        $this->logMemoryUsage();
    }

    protected function logMemoryUsage()
    {
        $memPeak = number_format(memory_get_peak_usage(), 0, '.', ',');
        $memCurrent = number_format(memory_get_usage(), 0, '.', ',');
        $this->logger->debug("Current memory usage: $memCurrent bytes (peak: $memPeak bytes). Service: "
            . get_class($this) . '.');
    }
}