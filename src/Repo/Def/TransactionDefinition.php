<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Repo\Def;

class TransactionDefinition
    extends \Flancer32\Lib\DataObject
    implements \Praxigento\Core\Repo\Transaction\IDefinition
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