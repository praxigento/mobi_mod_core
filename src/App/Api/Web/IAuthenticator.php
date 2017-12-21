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
     * Return ID for currently logged in admin user or $offeredId if MOBI API Developer Mode is on.
     * Return 'null' if DevMode is off and admin user is not logged in.
     *
     * @param int|null $offeredId proposal ID got from request (see MOBI API DevMode).
     * @return int
     */
    public function getCurrentAdminId($offeredId = null);

    /**
     * Return ID for currently logged in customer or $offer if MOBI API Developer Mode is on.
     * Return 'null' if DevMode is off and customer is not logged in.
     *
     * @param int|null $offeredId proposal ID got from request (see MOBI API DevMode).
     * @return int
     */
    public function getCurrentCustomerId($offeredId = null);

}