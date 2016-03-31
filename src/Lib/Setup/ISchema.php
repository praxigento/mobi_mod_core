<?php
/**
 * Interface for classes that creates database schema in MOBI common modules.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Setup;

interface ISchema {
    /**
     * Setup module's database structure.
     * @return mixed
     */
    public function setup();
}