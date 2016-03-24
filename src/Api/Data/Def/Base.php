<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Data\Def;


use Flancer32\Lib\DataObject;
use Praxigento\Core\Api\Data\BaseInterface;

class Base extends DataObject implements BaseInterface
{

    public function getCustomAttributes()
    {
        $result = $this->getData();
        return $result;
    }

    public function setCustomAttributes($data)
    {
        $this->setData($data);
    }
}