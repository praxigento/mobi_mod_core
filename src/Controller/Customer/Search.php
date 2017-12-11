<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Controller\Customer;

/**
 * Web API action to search customer by key (name, email, MLM ID).
 */
class Search
    extends \Praxigento\Core\App\Action\Front\Api\Base
{
    /** @var \Praxigento\Core\Api\Service\Customer\Search */
    private $callSearch;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Webapi\ServiceInputProcessor $inputProcessor,
        \Magento\Framework\Webapi\ServiceOutputProcessor $outputProcessor,
        \Praxigento\Core\App\Logger\App $logger,
        \Praxigento\Core\App\Web\IAuthenticator $authenticator,
        \Praxigento\Core\Api\Service\Customer\Search $callSearch
    )
    {
        parent::__construct($context, $inputProcessor, $outputProcessor, $logger, $authenticator);
        $this->callSearch = $callSearch;
    }

    protected function getInDataType(): string
    {
        return \Praxigento\Core\Api\Service\Customer\Search\Request::class;
    }

    protected function getOutDataType(): string
    {
        return \Praxigento\Core\Api\Service\Customer\Search\Response::class;
    }

    protected function process($request)
    {
        /* define local working data */
        assert($request instanceof \Praxigento\Core\Api\Service\Customer\Search\Request);
        $customerId = $request->getCustomerId();

        /* perform processing */
        $this->authenticator->getCurrentCustomerId($customerId);
        $result = $this->callSearch->exec($request);

        /* compose result */
        return $result;
    }


}