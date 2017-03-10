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
     *
     * @return boolean
     */
    public function isAuthenticated();

    /**
     * @return \Flancer32\Lib\Data
     */
    public function getCurrentUserData();
}