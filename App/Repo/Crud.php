<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\App\Repo;

/**
 * Default implementation for CRUD repository to do read-write operations with database.
 * All methods throw exceptions.
 */
abstract class Crud
    implements \Praxigento\Core\Api\App\Repo\Crud
{
    /** @var  \Magento\Framework\DB\Adapter\AdapterInterface */
    protected $conn;
    /** @var \Magento\Framework\App\ResourceConnection */
    protected $resource;

    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource
    ) {
        $this->resource = $resource;
        $this->conn = $resource->getConnection();
    }

    public function create($data)
    {
        /* override this method in the children classes */
        throw new \Exception('Method is not implemented yet.');
    }

    public function delete($where = null)
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