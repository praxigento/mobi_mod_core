<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Helper;

/**
 * Access store configuration parameters related to the module.
 */
interface Config
{
    /**
     * @return bool
     */
    public function getApiAuthenticationEnabledDevMode();
}