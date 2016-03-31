<?php
/**
 * Base interface for module's repositories to do module specific operations with data.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Lib\Repo;


interface IModule {
    /**
     * @return \Praxigento\Core\Lib\Repo\IBasic
     */
    public function getBasicRepo();

}