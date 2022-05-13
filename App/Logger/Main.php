<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2018
 */

namespace Praxigento\Core\App\Logger;


class Main
    extends \JustBetter\Sentry\Plugin\MonologPlugin
    implements \Praxigento\Core\Api\App\Logger\Main
{
    const FILENAME = 'mobi.main.log';
    const NAME = 'MOBI';

    /** @var \Monolog\Handler\StreamHandler */
    private $hndlInMemory;

    public function __construct(
        \JustBetter\Sentry\Helper\Data $data,
        \JustBetter\Sentry\Model\SentryLog $sentryLog,
        \Magento\Framework\App\DeploymentConfig $deploymentConfig
    ) {
        $handlers = $this->initHandlers();
        $processors = [];
        parent::__construct(static::NAME, $data, $sentryLog, $deploymentConfig, $handlers, $processors);
    }

    /**
     * Wrapper to catch calls to \JustBetter\Sentry\Plugin\MonologPlugin::addRecord
     *
     * @inheritdoc
     */
//    public function addRecord(int $level, string $message, array $context = []): bool
    public function addRecord($level, $message, array $context = [])
    {
        return parent::addRecord($level, $message, $context);
    }

    public function getHandlerMemory(): \Monolog\Handler\StreamHandler
    {
        return $this->hndlInMemory;
    }

    private function initFormatter()
    {
        $dateFormat = "Ymd/His";
        $msgFormat = "%datetime%-%channel%.%level_name% - %message%\n";
        $result = new \Monolog\Formatter\LineFormatter($msgFormat, $dateFormat);
        return $result;
    }

    private function initHandlers()
    {
        $result = [];
        $formatter = $this->initFormatter();

        /* add file handler */
        $path = BP . '/var/log/' . static::FILENAME;
        $handler = new \Monolog\Handler\StreamHandler($path);
        $handler->setFormatter($formatter);
        $result[] = $handler;

        /* add memory handler */
        $path = 'php://memory';
        $this->hndlInMemory = new \Monolog\Handler\StreamHandler($path);
        $this->hndlInMemory->setFormatter($formatter);
        $result[] = $this->hndlInMemory;

        return $result;
    }
}
