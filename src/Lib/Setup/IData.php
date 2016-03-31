<?php
/**
 * Interface for classes that creates initial database data in MOBI common modules.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Setup;

interface IData {
    /**
     * Install initial module's data.
     * @return mixed
     */
    public function install();
}