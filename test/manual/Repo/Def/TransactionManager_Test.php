<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;

use Magento\Framework\App\ObjectManager;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class DbAdapter_ManualTest extends \Praxigento\Core\Test\BaseMockeryCase
{

    public function test_transactionManager_closeAfterCommit()
    {
        $obm = ObjectManager::getInstance();
        /** @var  $manTrans \Praxigento\Core\Repo\Transaction\IManager */
        $manTrans = $obm->get(\Praxigento\Core\Repo\Transaction\IManager::class);
        $trans = $manTrans->transactionBegin();
        $manTrans->transactionCommit($trans);
        $manTrans->transactionClose($trans);
    }

    public function test_transactionManager_closeWithoutCommit()
    {
        $obm = ObjectManager::getInstance();
        /** @var  $manTrans \Praxigento\Core\Repo\Transaction\IManager */
        $manTrans = $obm->get(\Praxigento\Core\Repo\Transaction\IManager::class);
        $trans = $manTrans->transactionBegin();
        $manTrans->transactionClose($trans);
    }

    public function test_transactionManager_commit()
    {
        $obm = ObjectManager::getInstance();
        /** @var  $manTrans \Praxigento\Core\Repo\Transaction\IManager */
        $manTrans = $obm->get(\Praxigento\Core\Repo\Transaction\IManager::class);
        $trans = $manTrans->transactionBegin();
        $manTrans->transactionCommit($trans);
    }

    public function test_transactionManager_rollback()
    {
        $obm = ObjectManager::getInstance();
        /** @var  $manTrans \Praxigento\Core\Repo\Transaction\IManager */
        $manTrans = $obm->get(\Praxigento\Core\Repo\Transaction\IManager::class);
        $trans = $manTrans->transactionBegin();
        $manTrans->transactionRollback($trans);
    }
}