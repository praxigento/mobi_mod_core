<?php
/**
 * Setup schema (create tables in DB) for common core module.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Setup;

use Praxigento\Core\Lib\Setup\Db as Db;

class Schema extends \Praxigento\Core\Lib\Setup\Schema\Base {

    public function setup() {
        /* there is no database structure in core module yet. */
    }
}