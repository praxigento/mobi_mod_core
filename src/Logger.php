<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core;


use Magento\Framework\Webapi\Exception;

class Logger implements \Psr\Log\LoggerInterface {

    /**
     * Logger constructor.
     */
    public function __construct() {
        1 + 1;
    }

    public function emergency($message, array $context = [ ]) {
        throw (new Exception('Is not implemented yet.'));
    }

    public function alert($message, array $context = [ ]) {
        throw (new Exception('Is not implemented yet.'));
    }

    public function critical($message, array $context = [ ]) {
        throw (new Exception('Is not implemented yet.'));
    }

    public function error($message, array $context = [ ]) {
        throw (new Exception('Is not implemented yet.'));
    }

    public function warning($message, array $context = [ ]) {
        throw (new Exception('Is not implemented yet.'));
    }

    public function notice($message, array $context = [ ]) {
        throw (new Exception('Is not implemented yet.'));
    }

    public function info($message, array $context = [ ]) {
        throw (new Exception('Is not implemented yet.'));
    }

    public function debug($message, array $context = [ ]) {
        throw (new Exception('Is not implemented yet.'));
    }

    public function log($level, $message, array $context = [ ]) {
        throw (new Exception('Is not implemented yet.'));
    }
}