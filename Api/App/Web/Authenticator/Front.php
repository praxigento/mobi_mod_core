<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\App\Web\Authenticator;

/**
 * MOBI Authenticator for frontend (regular customer authentication).
 */
interface Front
    extends \Praxigento\Core\Api\App\Web\Authenticator
{
    /**
     * Force developer mode for the authenticator.
     * @return void
     */
    public function forceDevAuthentication();
}