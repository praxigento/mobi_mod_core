<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Context;

use Praxigento\Core\Lib\Context;

include_once(__DIR__ . '/../phpunit_bootstrap.php');

class DbAdapter_ManualTest extends \Praxigento\Core\Lib\Test\BaseTestCase
{

    public function test_transactionManager_closeAfterCommit()
    {
        $obm = Context::instance()->getObjectManager();
        /** @var  $manTrans \Praxigento\Core\Lib\Context\ITransactionManager */
        $manTrans = $obm->get(\Praxigento\Core\Lib\Context\ITransactionManager::class);
        $trans = $manTrans->transactionBegin();
        $manTrans->transactionCommit($trans);
        $manTrans->transactionClose($trans);
    }

    public function test_transactionManager_closeWithoutCommit()
    {
        $obm = Context::instance()->getObjectManager();
        /** @var  $manTrans \Praxigento\Core\Lib\Context\ITransactionManager */
        $manTrans = $obm->get(\Praxigento\Core\Lib\Context\ITransactionManager::class);
        $trans = $manTrans->transactionBegin();
        $manTrans->transactionClose($trans);
    }

    public function test_transactionManager_commit()
    {
        $obm = Context::instance()->getObjectManager();
        /** @var  $manTrans \Praxigento\Core\Lib\Context\ITransactionManager */
        $manTrans = $obm->get(\Praxigento\Core\Lib\Context\ITransactionManager::class);
        $trans = $manTrans->transactionBegin();
        $manTrans->transactionCommit($trans);
    }

    public function test_transactionManager_rollback()
    {
        $obm = Context::instance()->getObjectManager();
        /** @var  $manTrans \Praxigento\Core\Lib\Context\ITransactionManager */
        $manTrans = $obm->get(\Praxigento\Core\Lib\Context\ITransactionManager::class);
        $trans = $manTrans->transactionBegin();
        $manTrans->transactionRollback($trans);
    }
}