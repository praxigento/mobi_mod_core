<?php
/**
 * Base class to create subs that use database connection. Subs are internal units that are used by it's own
 * service only.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Lib\Service\Base\Sub;


use Praxigento\Core\Lib\Context;

abstract class Db extends Base {
    /** @var \Praxigento\Core\Lib\Service\IRepo */
    protected $_callRepo;
    /** @var  \Praxigento\Core\Lib\Context\IDbAdapter */
    protected $_dba;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Praxigento\Core\Lib\Context\IDbAdapter $dba,
        \Praxigento\Core\Lib\IToolbox $toolbox,
        \Praxigento\Core\Lib\Service\IRepo $callRepo
    ) {
        parent::__construct($logger, $toolbox);
        $this->_dba = $dba;
        $this->_callRepo = $callRepo;
    }

    protected function _getConn() {
        return $this->_dba->getDefaultConnection();
    }

    protected function _getTableName($entityName) {
        $result = $this->_dba->getTableName($entityName);
        return $result;
    }
}