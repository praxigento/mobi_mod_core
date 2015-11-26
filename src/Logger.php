<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core;


use Magento\Framework\App\ObjectManager;

class Logger implements \Psr\Log\LoggerInterface {
    /** @var \Psr\Log\LoggerInterface */
    private $_logger;
    private $_fs;

    /**
     * Logger constructor.
     *
     * @param null $configFile
     */
    public function __construct(
        $configFile = 'bubuka',
        $loggerName = 'main'
    ) {
        if(is_null($configFile)) {
            /* use default Magento 2 logger */
            $this->_initLoggerMagento();
        } else {
            /* use Cascaded Monolog */
            $this->_initLoggerCascade($configFile);
        }
    }

    /**
     * Use Magento 2 default logger.
     */
    private function  _initLoggerMagento() {
        $this->_logger = ObjectManager::getInstance()->get('Magento\Framework\Logger\Monolog');
    }

    /**
     * This is a dirty hack to get Filesystem component that can be mocked in tests.
     *
     * @return \Symfony\Component\Filesystem\Filesystem
     */
    public function getFilesystem() {
        $result = new \Symfony\Component\Filesystem\Filesystem();
        return $result;
    }

    /**
     * Configure Cascaded Monolog logger and use it.
     *
     * @param        $configFile
     * @param string $loggerName
     */
    private function  _initLoggerCascade($configFile, $loggerName) {
        $fs = $this->getFilesystem();
        if($fs->exists($configFile)) {
            Cascade::fileConfig($configFile);
            $this->_logger = Cascade::getLogger($loggerName);
        } else {
            $this->_initLoggerMagento();
            $this->warning("Cannot open logging configuration file '$configFile'. Default Magento logger is used.");
        }
    }

    public function emergency($message, array $context = [ ]) {
        $this->_logger->emergency($message, $context);
    }

    public function alert($message, array $context = [ ]) {
        $this->_logger->alert($message, $context);
    }

    public function critical($message, array $context = [ ]) {
        $this->_logger->critical($message, $context);
    }

    public function error($message, array $context = [ ]) {
        $this->_logger->error($message, $context);
    }

    public function warning($message, array $context = [ ]) {
        $this->_logger->warning($message, $context);
    }

    public function notice($message, array $context = [ ]) {
        $this->_logger->notice($message, $context);
    }

    public function info($message, array $context = [ ]) {
        $this->_logger->info($message, $context);
    }

    public function debug($message, array $context = [ ]) {
        $this->_logger->debug($message, $context);
    }

    public function log($level, $message, array $context = [ ]) {
        $this->_logger->log($level, $message, $context);
    }
}