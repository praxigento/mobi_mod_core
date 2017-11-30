<?php
/**
 * Interface for services responses implementations.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Service;

/**
 * Interface for processes (services that can be chained one-by-one, like promises in JavaScript).
 *
 * TODO: it was a bad idea w/o process engine, remove this interface.
 */
interface IProcess
{


    /**
     * Context path to success processing flag.
     *
     * if($ctx->get(CTX_OUT_SUCCESS)) => "process is complete successfully"
     */
    const CTX_OUT_SUCCESS = 'out.success';

    /**
     * Execute some operation in the given context ($ctx). Input & output data are placed in the context.
     *
     * @param \Praxigento\Core\Data $ctx
     * @return \Praxigento\Core\Data|null
     */
    public function exec(\Praxigento\Core\Data $ctx);
}