<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;

/**
 * Default implementation for CRUD repository to do read-write operations with database. All methods throw exceptions.
 */
abstract class Crud
    extends Db
    implements \Praxigento\Core\Repo\ICrud
{
    public function create($data)
    {
        /* override this method in the children classes */
        throw new \Exception('Method is not implemented yet.');
    }

    public function delete($where)
    {
        /* override this method in the children classes */
        throw new \Exception('Method is not implemented yet.');
    }

    public function deleteById($id)
    {
        /* override this method in the children classes */
        throw new \Exception('Method is not implemented yet.');
    }

    public function get(
        $where = null,
        $order = null,
        $limit = null,
        $offset = null,
        $columns = null,
        $group = null,
        $having = null
    ) {
        /* override this method in the children classes */
        throw new \Exception('Method is not implemented yet.');
    }

    public function getById($id)
    {
        /* override this method in the children classes */
        throw new \Exception('Method is not implemented yet.');
    }

    public function getQueryToSelect()
    {
        /* override this method in the children classes */
        throw new \Exception('Method is not implemented yet.');
    }

    public function getQueryToSelectCount()
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

    public function updateById($id, $data)
    {
        /* override this method in the children classes */
        throw new \Exception('Method is not implemented yet.');
    }
}