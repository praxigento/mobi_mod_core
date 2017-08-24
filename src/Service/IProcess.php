<?php
/**
 * Interface for services responses implementations.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Service;

/**
 * Interface for processes (services that can be chained one-by-one, like promises in JavaScript).
 */
interface IProcess
{
    /**
     * Execute some operation in the given context ($ctx). Input & output data are placed in the context.
     *
     * @param \Praxigento\Core\Data $ctx
     */
    public function exec(\Praxigento\Core\Data $ctx);
}