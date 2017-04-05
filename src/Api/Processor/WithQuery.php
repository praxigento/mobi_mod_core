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

    const VAR_CONDITIONS = 'conditions'; // query conditions (filter, order, paging)
    /** @var  \Magento\Framework\ObjectManagerInterface */
    protected $manObj;
    /** @var  \Praxigento\Core\Repo\Query\IBuilder */
    protected $qbld;
    /** @var  \Praxigento\Core\Api\Processor\WithQuery\Conditions */
    protected $subCond;

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $manObj,
        \Praxigento\Core\Repo\Query\IBuilder $qbld
    ) {
        $this->manObj = $manObj;
        $this->qbld = $qbld;
        /* use Object Manager to create this class internal subs. Don't expand constructor */
        $this->subCond = $this->manObj->get(\Praxigento\Core\Api\Processor\WithQuery\Conditions::class);
    }

    /**
     * Check right of the current customer to perform requested operation.
     * This method should throws "\Magento\Framework\Exception\AuthorizationException" if customer is not authorized
     * to perform operation.
     *
     * @param \Flancer32\Lib\Data $ctx execution context
     * @throws \Magento\Framework\Exception\AuthorizationException
     */
    protected abstract function authorize(\Flancer32\Lib\Data $ctx);

    /**
     * Create query to select data and place it to context.
     *
     * @param \Flancer32\Lib\Data $ctx execution context
     */
    protected function createQuerySelect(\Flancer32\Lib\Data $ctx)
    {
        $query = $this->qbld->getSelectQuery();
        $ctx->set(self::CTX_QUERY, $query);
    }

    /**
     * Get query from context, execute it and place results back into context.
     *
     * @param \Flancer32\Lib\Data $ctx execution context
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
     * @param \Flancer32\Lib\Data $ctx execution context
     */
    protected abstract function populateQuery(\Flancer32\Lib\Data $ctx);

    /**
     * @param \Flancer32\Lib\Data $ctx execution context
     */
    protected function populateQueryConditions(\Flancer32\Lib\Data $ctx)
    {
        /* get working vars from context */
        /** @var \Flancer32\Lib\Data $vars */
        $vars = $ctx->get(self::CTX_VARS);
        /** @var \Magento\Framework\DB\Select $query */
        $query = $ctx->get(self::CTX_QUERY);
        /** @var \Flancer32\Lib\Data $cond */
        $cond = $vars->get(self::VAR_CONDITIONS);

        /* perform action */
        $ctxCond = new \Praxigento\Core\Api\Processor\WithQuery\Conditions\Context();
        $ctxCond->setQuery($query);
        $ctxCond->setConditions($cond);
        $this->subCond->exec($ctxCond);
    }

    /**
     * Get query conditions from request and place it into the VARS section of the execution context.
     * @param \Flancer32\Lib\Data $ctx execution context
     */
    protected function prepareQueryConditions(\Flancer32\Lib\Data $ctx)
    {
        /* get working vars from context */
        $vars = $ctx->get(self::CTX_VARS);
        /** @var \Praxigento\BonusHybrid\Api\Stats\Plain\Request $req */
        $req = $ctx->get(self::CTX_REQ);

        /* perform action */
        $conditions = $req->getConditions();
        $vars->set(self::VAR_CONDITIONS, $conditions);
    }

    /**
     * Analyze API request data, collect expected parameters and place its into execution context.
     *
     * @param \Flancer32\Lib\Data $ctx execution context
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
        $this->prepareQueryConditions($ctx);
        $this->authorize($ctx);
        $this->createQuerySelect($ctx);
        $this->populateQuery($ctx);
        $this->populateQueryConditions($ctx);
        $this->performQuery($ctx);

        /* get query results from context and add to API response */
        /** @var \Praxigento\Core\Api\Response $result */
        $result = new \Praxigento\Core\Api\Response();
        $rs = $ctx->get(self::CTX_RESULT);
        $result->setData($rs);
        return $result;
    }

}