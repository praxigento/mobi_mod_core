<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Helper;


interface Config
{
    /**
     * @return bool
     */
    public function getApiAuthenticationEnabledDevMode();
}