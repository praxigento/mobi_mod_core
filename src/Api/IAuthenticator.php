<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api;

/**
 * This interface is used by REST API handlers that should process requests in restricted mode (user based).
 */
interface IAuthenticator
{
    /**
     * @param int|null $offer proposal ID got from request (see MOBI API DevMode).
     * @return \Flancer32\Lib\Data
     */
    public function getCurrentCustomerData($offer = null);

    /**
     * Return ID for currently logged in customer of $offer if MOBI API Developer Mode is on.
     * Return 'null' if DevMode is off and customer is not logged in.
     *
     * @param int|null $offer proposal ID got from request (see MOBI API DevMode).
     * @return int
     */
    public function getCurrentCustomerId($offer = null);

    /**
     * Return 'true' if user is logged in.
     *
     * @return boolean
     * @deprecated this method is never used. use it or remove it.
     */
    public function isAuthenticated();
}