<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2018
 */

namespace Praxigento\Core\Api\App\Logger;


/**
 * Main logger for MOBI classes.
 */
interface Main
    extends \Psr\Log\LoggerInterface
{
    public function getHandlerMemory(): \Monolog\Handler\StreamHandler;
}