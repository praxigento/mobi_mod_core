<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Service\Repo;

use Praxigento\Accounting\Lib\Entity\Account;
use Praxigento\Accounting\Lib\Entity\Transaction;
use Praxigento\Core\Lib\Context;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class Call_ManualTest extends \Praxigento\Core\Lib\Test\BaseTestCase {

    public function test_getEntityByPk() {
        $obm = Context::instance()->getObjectManager();
        /** @var  $call \Praxigento\Core\Lib\Service\IRepo */
        $call = $obm->get('Praxigento\Core\Lib\Service\IRepo');
        $request = new Request\GetEntityByPk(Account::ENTITY_NAME, [ Account::ATTR_ID => 6 ]);
        /** @var  $response  Response\GetEntityByPk */
        $response = $call->getEntityByPk($request);
        $this->assertTrue($response->isSucceed());
    }

    public function test_getEntities() {
        $obm = Context::instance()->getObjectManager();
        /** @var  $call \Praxigento\Core\Lib\Service\IRepo */
        $call = $obm->get('Praxigento\Core\Lib\Service\IRepo');
        $where = Transaction::ATTR_VALUE . '<15';
        $request = new Request\GetEntities(Transaction::ENTITY_NAME, $where);
        /** @var  $response  Response\GetEntities */
        $response = $call->getEntities($request);
        $this->assertTrue($response->isSucceed());
    }
}