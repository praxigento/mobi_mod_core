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
     * @param int|null $offer proposal ID got from request (see MOBI API DevMode).
     * @return \Praxigento\Core\Data
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
     * Return 'true' if MOBI API Developer Mode is enabled.
     *
     * @return boolean
     */
    public function isEnabledDevMode();
}