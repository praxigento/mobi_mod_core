<?php
/**
 * Factory to get Object Manager.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Lib\Context;


use Praxigento\Core\Lib\Context as Ctx;


class ObjectManagerFactory
{
    /**
     * @var IObjectManager
     */
    protected $_manObj;

    public function __construct()
    {
        $this->_manObj = Ctx::instance()->getObjectManager();
    }

    /**
     * @return IObjectManager
     */
    public function create()
    {
        return $this->_manObj;
    }
}