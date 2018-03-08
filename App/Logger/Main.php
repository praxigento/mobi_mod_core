<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2018
 */

namespace Praxigento\Core\App\Logger;


class Main
    extends \Monolog\Logger
    implements \Praxigento\Core\Api\App\Logger\Main
{
    const FILENAME = 'mobi.main.log';
    const NAME = 'MOBI';

    public function __construct()
    {
        $handlers = $this->initHandlers();
        $processors = [];
        parent::__construct(static::NAME, $handlers, $processors);
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
        $path = BP . '/var/log/' . static::FILENAME;
        $handler = new \Monolog\Handler\StreamHandler($path);
        $formatter = $this->initFormatter();
        $handler->setFormatter($formatter);
        $result[] = $handler;
        return $result;
    }
}