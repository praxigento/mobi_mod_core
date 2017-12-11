<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\App\Logger;

/**
 * Decorator for application logger. Use this logger to log application level messages.
 *
 * This logger is used with the following default configuration parameters:
 *  - Monolog Cascade YAML config: 'var/log/logging.yaml'
 *  - YAML config logger name:     'app'
 */
class App
    implements \Psr\Log\LoggerInterface
{
    /** Default configuration file for the logger */
    const DEF_CONFG_FILE = 'var/log/logging.yaml';
    /** Defalt name of the logger from configuration */
    const LOGGER_NAME = 'app';
    /** @var \Praxigento\Logging\Logger */
    protected $logger;

    public function __construct(
        \Praxigento\Logging\Logger $logger = null
    ) {
        if (is_null($logger)) {
            /* */
            $obm = \Magento\Framework\App\ObjectManager::getInstance();
            $this->logger = new  \Praxigento\Logging\Logger($obm, static::DEF_CONFG_FILE, static::LOGGER_NAME);
        } else {
            /* use pre-configured Praxigento logger from constructor */
            $this->logger = $logger;
        }
    }

    public function alert($message, array $context = [])
    {
        $this->logger->alert($message, $context);
    }

    public function critical($message, array $context = [])
    {
        $this->logger->critical($message, $context);
    }

    public function debug($message, array $context = [])
    {
        $this->logger->debug($message, $context);
    }

    public function emergency($message, array $context = [])
    {
        $this->logger->emergency($message, $context);
    }

    public function error($message, array $context = [])
    {
        $this->logger->error($message, $context);
    }

    public function info($message, array $context = [])
    {
        $this->logger->info($message, $context);
    }

    public function log($level, $message, array $context = [])
    {
        $this->logger->log($level, $message, $context);
    }

    public function notice($message, array $context = [])
    {
        $this->logger->notice($message, $context);
    }

    public function warning($message, array $context = [])
    {
        $this->logger->warning($message, $context);
    }

}