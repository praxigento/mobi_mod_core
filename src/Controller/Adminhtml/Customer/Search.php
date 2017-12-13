<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Controller\Adminhtml\Customer;

use Praxigento\Core\Api\Ctrl\Adminhtml\Customer\Search\Request as ARequest;
use Praxigento\Core\Api\Ctrl\Adminhtml\Customer\Search\Response as AResponse;

/**
 * Get suggestions for customers by key (name/email/mlm_id).
 */
class Search
    extends \Praxigento\Core\App\Action\Back\Api\Base
{
    const VAR_LIMIT = 'limit';
    const VAR_SEARCH_KEY = 'search_key';

    /** @var \Praxigento\Core\Api\Service\Customer\Search */
    private $callSearch;

    public function __construct
    (
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Webapi\ServiceInputProcessor $inputProcessor,
        \Magento\Framework\Webapi\ServiceOutputProcessor $outputProcessor,
        \Psr\Log\LoggerInterface $logger,
        \Praxigento\Core\Api\Service\Customer\Search $callSearch
    )
    {
        parent::__construct($context, $inputProcessor, $outputProcessor, $logger);
        $this->callSearch = $callSearch;
    }

    protected function getInDataType(): string
    {
        return ARequest::class;
    }

    protected function getOutDataType(): string
    {
        return AResponse::class;
    }

    protected function process($request)
    {
        /* define local working data */
        assert($request instanceof ARequest);

        /* perform processing */
        $result = $this->callSearch->exec($request);

        /* compose result */
        return $result;
    }
}