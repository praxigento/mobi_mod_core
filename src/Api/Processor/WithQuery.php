<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Api\Processor;

abstract class WithQuery
{
    const CTX_BIND = 'bind';
    const CTX_QUERY = 'query';
    const CTX_REQ = 'request';
    const CTX_RESULT = 'result';
    const CTX_VARS = 'vars';

    /** Name of the class to create API response. */
    const RESPONSE_CLASS = \Praxigento\Core\Api\Response::class;

    protected function process(\Praxigento\Core\Api\Request $data)
    {
        /* create context for request processing */
        $ctx = new \Flancer32\Lib\Data();
        $ctx->set(self::CTX_REQ, $data);
        $ctx->set(self::CTX_QUERY, null);
        $ctx->set(self::CTX_BIND, new \Flancer32\Lib\Data());
        $ctx->set(self::CTX_VARS, new \Flancer32\Lib\Data());
        $ctx->set(self::CTX_RESULT, null);

        /* parse request, prepare query and fetch data */
        $this->prepareQueryParameters($ctx);
        $this->getSelectQuery($ctx);
        $this->populateQuery($ctx);
        $this->performQuery($ctx);

        /* get query results from context and add to API response */
        /** @var \Praxigento\Core\Api\Response $result */
        $result = new \Praxigento\Core\Api\Response();
        $rs = $ctx->get(self::CTX_RESULT);
        $result->setData($rs);
        return $result;
    }

    /**
     * Create query to select data and place it to context.
     *
     * @param \Flancer32\Lib\Data $ctx
     */
    protected abstract function getSelectQuery(\Flancer32\Lib\Data $ctx);

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

}