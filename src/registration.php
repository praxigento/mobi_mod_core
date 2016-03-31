<?php
/**
 * Script to register module in Magento 2 (see "autoload.files" in module's composer,json).
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
use Magento\Framework\Component\ComponentRegistrar as Registrar;
use Praxigento\Core\Config as Config;

Registrar::register(Registrar::MODULE, Config::MODULE, __DIR__);