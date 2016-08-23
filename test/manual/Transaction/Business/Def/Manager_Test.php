<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Transaction\Business\Def;

use Magento\Framework\App\ObjectManager;

include_once(__DIR__ . '/../../../phpunit_bootstrap.php');

class Manager_ManualTest extends \Praxigento\Core\Test\BaseCase\Mockery
{


    public function test_constructor()
    {
        $obm = ObjectManager::getInstance();
        /** @var  $obj \Praxigento\Core\Transaction\Business\IManager */
        $obj = $obm->get(\Praxigento\Core\Transaction\Business\Def\Manager::class);
        $this->assertInstanceOf(\Praxigento\Core\Transaction\Business\IManager::class, $obj);
    }

    public function test_begin()
    {
        $NAME = 'MyTransaction';
        $NAME_OTHER = 'AnotherTransaction';
        $obm = ObjectManager::getInstance();
        /** @var  $obj \Praxigento\Core\Transaction\Business\IManager */
        $obj = $obm->get(\Praxigento\Core\Transaction\Business\Def\Manager::class);
        $this->assertInstanceOf(\Praxigento\Core\Transaction\Business\IManager::class, $obj);
        /* begin level 0 transaction */
        $tran_0 = $obj->begin($NAME);
        $this->assertEquals(\Praxigento\Core\Transaction\Business\Def\Manager::ZERO_LEVEL, $tran_0->getLevel());
        /* begin level 1 transaction */
        $tran_1 = $obj->begin($NAME);
        $this->assertEquals(\Praxigento\Core\Transaction\Business\Def\Manager::ZERO_LEVEL + 1, $tran_1->getLevel());
        /* begin level 0 other transaction */
        $tran_2 = $obj->begin($NAME_OTHER);
        $this->assertEquals(\Praxigento\Core\Transaction\Business\Def\Manager::ZERO_LEVEL, $tran_2->getLevel());
    }

    public function test_end_wo_commit()
    {
        $NAME = 'MyTransaction';
        $obm = ObjectManager::getInstance();
        /** @var  $obj \Praxigento\Core\Transaction\Business\IManager */
        $obj = $obm->get(\Praxigento\Core\Transaction\Business\Def\Manager::class);
        $this->assertInstanceOf(\Praxigento\Core\Transaction\Business\IManager::class, $obj);
        /* begin level 0 transaction */
        $tran = $obj->begin($NAME);
        $tran->addRollbackCall(function () {
            echo "Transaction 0 rollback";
        });
        $tran_1 = $obj->begin($NAME);
        $tran_1->addRollbackCall(function () {
            echo "Transaction 1 rollback";
        });
        $tran_2 = $obj->begin($NAME);
        $tran_2->addRollbackCall(function () {
            echo "Transaction 2 rollback";
        });
        $obj->end($NAME);

    }

    public function test_end_commit()
    {
        $NAME = 'MyTransaction';
        $obm = ObjectManager::getInstance();
        /** @var  $obj \Praxigento\Core\Transaction\Business\IManager */
        $obj = $obm->get(\Praxigento\Core\Transaction\Business\Def\Manager::class);
        $this->assertInstanceOf(\Praxigento\Core\Transaction\Business\IManager::class, $obj);
        /* begin level 0 transaction */
        $tran = $obj->begin($NAME);
        $tran->addCommitCall(function () {
            echo "Transaction 0 commit";
        });
        $tran->addRollbackCall(function () {
            echo "Transaction 0 rollback";
        });
        $tran->commit();
        $obj->end($NAME);

    }
}