<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Repo\Def;


use Flancer32\Lib\DataObject;
use Praxigento\Core\Repo\ITransactionDefinition;

class TransactionDefinition extends DataObject implements ITransactionDefinition
{
    public function getLevel()
    {
        $result = parent::getLevel();
        return $result;
    }

    public function setLevel($data)
    {
        parent::setLevel($data);
    }

}