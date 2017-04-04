<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Processor;

abstract class WithQuery
{
    const CTX_BIND = 'bind'; // SQL query bindings
    const CTX_QUERY = 'query'; // SQL query itself
    const CTX_REQ = 'request'; // API request data
    const CTX_RESULT = 'result'; // data to place to response
    const CTX_VARS = 'vars'; // working variables

    /** @var  \Praxigento\Core\Repo\Query\IBuilder */
    protected $qbld;

    public function __construct(
        \Praxigento\Core\Repo\Query\IBuilder $qbld
    ) {
        $this->qbld = $qbld;
    }

    /**
     * Check right of the current customer to perform requested operation.
     * This method should throws "\Magento\Framework\Exception\AuthorizationException" if customer is not authorized
     * to perform operation.
     *
     * @param \Flancer32\Lib\Data $ctx
     * @throws \Magento\Framework\Exception\AuthorizationException
     */
    protected abstract function authorize(\Flancer32\Lib\Data $ctx);

    /**
     * Create query to select data and place it to context.
     *
     * @param \Flancer32\Lib\Data $ctx
     */
    protected function createQuerySelect(\Flancer32\Lib\Data $ctx)
    {
        $query = $this->qbld->getSelectQuery();
        $ctx->set(self::CTX_QUERY, $query);
    }

    /**
     * Get query from context, execute it and place results back into context.
     *
     * @param \Flancer32\Lib\Data $ctx
     */
    protected function performQuery(\Flancer32\Lib\Data $ctx)
    {
        /* get working vars from context */
        $bind = $ctx->get(self::CTX_BIND);
        /** @var \Magento\Framework\DB\Select $query */
        $query = $ctx->get(self::CTX_QUERY);

        $conn = $query->getConnection();
        $rs = $conn->fetchAll($query, (array)$bind->get());

        $ctx->set(self::CTX_RESULT, $rs);
    }

    /**
     * Populate query and bound parameters according to request data (from $bind).
     *
     * @param \Flancer32\Lib\Data $ctx
     */
    protected abstract function populateQuery(\Flancer32\Lib\Data $ctx);

    /**
     * Analyze request data, collect expected parameters and place its to execution context.
     *
     * @param \Flancer32\Lib\Data $ctx
     */
    protected abstract function prepareQueryParameters(\Flancer32\Lib\Data $ctx);

    /**
     * Internal method to be used in 'exec' decorator. This decorator allows Magento 2 to perform
     * JSON2OBJ transformation of the input data by request's class.
     *
     * @param \Praxigento\Core\Api\Request $data
     * @return \Praxigento\Core\Api\Response
     */
    protected function process(\Praxigento\Core\Api\Request $data)
    {
        /* create context for request processing */
        $ctx = new \Flancer32\Lib\Data();
        $ctx->set(self::CTX_REQ, $data);
        $ctx->set(self::CTX_QUERY, null);
        $ctx->set(self::CTX_BIND, new \Flancer32\Lib\Data());
        $ctx->set(self::CTX_VARS, new \Flancer32\Lib\Data());
        $ctx->set(self::CTX_RESULT, null);

        /* parse request, authorize customer, prepare query and fetch data */
        $this->prepareQueryParameters($ctx);
        $this->authorize($ctx);
        $this->createQuerySelect($ctx);
        $this->populateQuery($ctx);
        $this->performQuery($ctx);

        /* get query results from context and add to API response */
        /** @var \Praxigento\Core\Api\Response $result */
        $result = new \Praxigento\Core\Api\Response();
        $rs = $ctx->get(self::CTX_RESULT);
        $result->setData($rs);
        return $result;
    }

}