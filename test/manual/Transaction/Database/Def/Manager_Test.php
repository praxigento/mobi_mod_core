<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Transaction\Database\Def;

use Magento\Framework\App\ObjectManager;

include_once(__DIR__ . '/../../../phpunit_bootstrap.php');

class Manager_ManualTest extends \Praxigento\Core\Test\BaseMockeryCase
{


    public function test_constructor()
    {
        $obm = ObjectManager::getInstance();
        /** @var  $obj \Praxigento\Core\Transaction\Database\IManager */
        $obj = $obm->get(\Praxigento\Core\Transaction\Database\Def\Manager::class);
        $this->assertInstanceOf(\Praxigento\Core\Transaction\Database\IManager::class, $obj);
    }

    public function test_begin_default_commit_commit()
    {
        $obm = ObjectManager::getInstance();
        /** @var  $obj \Praxigento\Core\Transaction\Database\IManager */
        $obj = $obm->get(\Praxigento\Core\Transaction\Database\Def\Manager::class);
        $this->assertInstanceOf(\Praxigento\Core\Transaction\Database\IManager::class, $obj);
        /* begin level 0 transaction */
        $def0 = $obj->begin();
        $this->assertEquals(\Praxigento\Core\Transaction\Database\Def\Manager::DEF_TRANSACTION,
            $def0->getTransactionName());
        $this->assertEquals(\Praxigento\Core\Transaction\Database\Def\Manager::DEF_CONNECTION,
            $def0->getConnectionName());
        $this->assertEquals(\Praxigento\Core\Transaction\Database\Def\Manager::ZERO_LEVEL + 1, $def0->getLevel());
        /* begin level 1 transaction */
        $def1 = $obj->begin();
        $this->assertEquals(\Praxigento\Core\Transaction\Database\Def\Manager::ZERO_LEVEL + 2, $def1->getLevel());
        /* rollback level 1 transaction */
        $obj->commit($def1);
        /* commit level 0 transaction */
        $obj->commit($def0);

    }

    public function test_commit_end()
    {
        $obm = ObjectManager::getInstance();
        /** @var  $obj \Praxigento\Core\Transaction\Database\IManager */
        $obj = $obm->get(\Praxigento\Core\Transaction\Database\Def\Manager::class);
        $this->assertInstanceOf(\Praxigento\Core\Transaction\Database\IManager::class, $obj);
        /* begin level 0 transaction */
        $def0 = $obj->begin();
        $obj->commit($def0);
        $obj->end($def0);
    }

}