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
    /** @var \Praxigento\Core\Api\App\Logger\Main */
    protected $logger;
    /** @var  \Magento\Framework\ObjectManagerInterface */
    protected $manObj;

    public function __construct(
        \Praxigento\Core\Api\App\Logger\Main $logger,
        \Magento\Framework\ObjectManagerInterface $manObj
    ) {
        $this->logger = $logger;
        $this->manObj = $manObj;
    }

}