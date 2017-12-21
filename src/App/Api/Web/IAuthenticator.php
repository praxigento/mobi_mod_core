<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Api\Web;

/**
 * This interface is used by REST API handlers that should process requests in restricted mode (user based).
 */
interface IAuthenticator
{
    /**
     * Return ID for currently logged in admin user or /dev/admin_id if MOBI API Developer Mode is on.
     * Return 'null' if DevMode is off and admin user is not logged in.
     *
     * @param \Praxigento\Core\App\Api\Web\Request $request
     * @return int|null
     */
    public function getCurrentAdminId(\Praxigento\Core\App\Api\Web\Request $request = null);

    /**
     * Return ID for currently logged in customer or $offer if MOBI API Developer Mode is on.
     * Return 'null' if DevMode is off and customer is not logged in.
     *
     * @param \Praxigento\Core\App\Api\Web\Request $request
     * @return int|null
     */
    public function getCurrentCustomerId(\Praxigento\Core\App\Api\Web\Request $request = null);

}