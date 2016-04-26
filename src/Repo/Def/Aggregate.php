<?php
/**
 * Default implementation for aggregate repository to do universal operations with specific aggregation data (CRUD).
 * This parent class just
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;

use Flancer32\Lib\DataObject;
use Praxigento\Core\Repo\IAggregate;

abstract class Aggregate extends Base implements IAggregate
{
    /** @var  DataObject empty object to reference its attributes by consumers of the repository */
    protected $_refDataObject;

    /** @inheritdoc */
    public function create($data)
    {
        /* override this method in child class */
        throw new \Exception('Method is not implemented.');
    }

    /** @inheritdoc */
    public function delete($where)
    {
        /* override this method in child class */
        throw new \Exception('Method is not implemented.');
    }

    /** @inheritdoc */
    public function deleteById($id)
    {
        /* override this method in child class */
        throw new \Exception('Method is not implemented.');
    }

    /** @inheritdoc */
    public function getRef()
    {
        return $this->_refDataObject;
    }

}