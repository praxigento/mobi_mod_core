<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\App\Web;

/**
 * This interface is used by Web API services/controllers that should process requests in restricted mode
 * (according to currently logged in customer or admin user).
 */
interface Authenticator
{
    /**
     * Return ID for currently logged in user (customer or admin) or offered ID if MOBI API Developer Mode is on.
     * Return 'null' if DevMode is off and user is not logged in.
     *
     * @param \Praxigento\Core\Api\App\Web\Request $request
     * @return int|null
     */
    public function getCurrentUserId(\Praxigento\Core\Api\App\Web\Request $request = null);

}