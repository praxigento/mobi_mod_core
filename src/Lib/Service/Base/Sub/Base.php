<?php
/**
 * Base class to create subs that use logger and toolbox only. Subs are internal units that are used by it's own
 * service only.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Lib\Service\Base\Sub;


abstract class Base
{
    /** @var \Psr\Log\LoggerInterface */
    protected $_logger;

    public function __construct(
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->_logger = $logger;
    }
}