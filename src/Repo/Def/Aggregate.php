<?php
/**
 * Default implementation for aggregate repository to do universal operations with specific aggregation data (CRUD).
 * This parent class just   
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;

use Praxigento\Core\Repo\IAggregate;

abstract class Aggregate extends Base implements IAggregate
{
    /**
     * @inheritdoc
     */
    public function create($data)
    {
        /* override this method in child class */
        throw new \Exception('Method is not implemented.');
    }

    /**
     * @inheritdoc
     */
    public function delete($where)
    {
        /* override this method in child class */
        throw new \Exception('Method is not implemented.');
    }

    /**
     * @inheritdoc
     */
    public function deleteById($id)
    {
        /* override this method in child class */
        throw new \Exception('Method is not implemented.');
    }

}