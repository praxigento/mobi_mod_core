<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;

/**
 * Default implementation for CRUD repository to do read-write operations with database. All methods throw exceptions.
 */
class BaseCrud
    extends \Praxigento\Core\Repo\Def\BaseDataSource
    implements \Praxigento\Core\Repo\IBaseCrud
{
    /** @inheritdoc */
    public function create($data)
    {
        /* override this method in the children classes */
        throw new \Exception('Method is not implemented yet.');
    }

    /** @inheritdoc */
    public function delete($where)
    {
        /* override this method in the children classes */
        throw new \Exception('Method is not implemented yet.');
    }

    /** @inheritdoc */
    public function deleteById($id)
    {
        /* override this method in the children classes */
        throw new \Exception('Method is not implemented yet.');
    }

    /** @inheritdoc */
    public function updateById($id, $data)
    {
        /* override this method in the children classes */
        throw new \Exception('Method is not implemented yet.');
    }

    public function replace($data)
    {
        /* override this method in the children classes */
        throw new \Exception('Method is not implemented yet.');
    }

    public function update($data, $where)
    {
        /* override this method in the children classes */
        throw new \Exception('Method is not implemented yet.');
    }
}