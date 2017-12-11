<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Web\Processor;

abstract class WithQuery
{
    const CTX_BIND = 'bind'; // SQL query bindings
    const CTX_QUERY = 'query'; // SQL query itself
    const CTX_REQ = 'request'; // API request data
    const CTX_RESULT = 'result'; // data to place to response
    const CTX_VARS = 'vars'; // working variables

    const VAR_CONDITIONS = 'conditions'; // query conditions (filter, order, paging)

    /** @var \Praxigento\Core\Helper\Config */
    protected $hlpCfg;
    /** @var  \Magento\Framework\ObjectManagerInterface */
    protected $manObj;
    /** @var  \Praxigento\Core\App\Repo\Query\IBuilder */
    protected $qbld;
    /** @var  \Praxigento\Core\App\Web\Processor\WithQuery\Conditions */
    protected $subCond;

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $manObj,
        \Praxigento\Core\App\Repo\Query\IBuilder $qbld = null,
        \Praxigento\Core\Helper\Config $hlpCfg
    )
    {
        $this->manObj = $manObj;
        $this->qbld = $qbld;
        $this->hlpCfg = $hlpCfg;
        /* use Object Manager to create this class internal subs. Don't expand constructor */
        $this->subCond = $this->manObj->get(\Praxigento\Core\App\Web\Processor\WithQuery\Conditions::class);
    }

    /**
     * Check right of the current customer to perform requested operation.
     * This method should throws "\Magento\Framework\Exception\AuthorizationException" if customer is not authorized
     * to perform operation.
     *
     * @param \Praxigento\Core\Data $ctx execution context
     * @throws \Magento\Framework\Exception\AuthorizationException
     */
    protected abstract function authorize(\Praxigento\Core\Data $ctx);

    /**
     * Create query to select data and place it to context.
     *
     * This method should be overridden in the children classes if query is depended from the request params.
     *
     * @param \Praxigento\Core\Data $ctx execution context
     */
    protected function createQuerySelect(\Praxigento\Core\Data $ctx)
    {
        if ($this->qbld instanceof \Praxigento\Core\App\Repo\Query\IBuilder) {
            $query = $this->qbld->build();
        } else {
            $query = $this->qbld->getSelectQuery();
        }
        $ctx->set(self::CTX_QUERY, $query);
    }

    /**
     * Get query from context, execute it and place results back into context.
     *
     * @param \Praxigento\Core\Data $ctx execution context
     */
    protected function performQuery(\Praxigento\Core\Data $ctx)
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
     * @param \Praxigento\Core\Data $ctx execution context
     */
    protected abstract function populateQuery(\Praxigento\Core\Data $ctx);

    /**
     * @param \Praxigento\Core\Data $ctx execution context
     */
    protected function populateQueryConditions(\Praxigento\Core\Data $ctx)
    {
        /* get working vars from context */
        /** @var \Praxigento\Core\Data $vars */
        $vars = $ctx->get(self::CTX_VARS);
        /** @var \Magento\Framework\DB\Select $query */
        $query = $ctx->get(self::CTX_QUERY);
        /** @var \Praxigento\Core\Data $cond */
        $cond = $vars->get(self::VAR_CONDITIONS);

        /* perform action */
        $ctxCond = new \Praxigento\Core\App\Web\Processor\WithQuery\Conditions\Context();
        $ctxCond->setQuery($query);
        $ctxCond->setConditions($cond);
        $this->subCond->exec($ctxCond);
    }

    /**
     * Get query conditions from request and place it into the VARS section of the execution context.
     * @param \Praxigento\Core\Data $ctx execution context
     */
    protected function prepareQueryConditions(\Praxigento\Core\Data $ctx)
    {
        /* get working vars from context */
        $vars = $ctx->get(self::CTX_VARS);
        /** @var \Praxigento\Core\App\Web\Request\WithCond $req */
        $req = $ctx->get(self::CTX_REQ);

        /* perform action */
        $conditions = $req->getConditions();
        $vars->set(self::VAR_CONDITIONS, $conditions);
    }

    /**
     * Analyze API request data, collect expected parameters and place its into execution context.
     *
     * @param \Praxigento\Core\Data $ctx execution context
     */
    protected abstract function prepareQueryParameters(\Praxigento\Core\Data $ctx);

    /**
     * Internal method to be used in 'exec' decorator. This decorator allows Magento 2 to perform
     * JSON2OBJ transformation of the input data by request's class.
     *
     * @param \Praxigento\Core\App\Web\Request $data
     * @return \Praxigento\Core\App\Web\Response
     */
    protected function process(\Praxigento\Core\App\Web\Request $data)
    {
        /* create context for request processing */
        $ctx = new \Praxigento\Core\Data();
        $ctx->set(self::CTX_REQ, $data);
        $ctx->set(self::CTX_QUERY, null);
        $ctx->set(self::CTX_BIND, new \Praxigento\Core\Data());
        $ctx->set(self::CTX_VARS, new \Praxigento\Core\Data());
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
        /** @var \Praxigento\Core\App\Web\Response $result */
        $result = new \Praxigento\Core\App\Web\Response();
        $rs = $ctx->get(self::CTX_RESULT);
        $result->setData($rs);
        return $result;
    }

}