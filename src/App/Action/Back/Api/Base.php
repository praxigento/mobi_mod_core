<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Action\Back\Api;

use Magento\Framework\Controller\ResultFactory as AResultFactory;

/**
 * Base for backend CTRL API actions (Web API alternative for adminhtml).
 */
abstract class Base
    extends \Magento\Backend\App\Action
{
    /** @var \Praxigento\Core\App\Api\Web\IAuthenticator */
    private $authenticator;
    /** @var \Magento\Framework\Webapi\ServiceInputProcessor */
    private $inputProcessor;
    /** @var \Psr\Log\LoggerInterface */
    private $logger;
    /** @var \Magento\Framework\Webapi\ServiceOutputProcessor */
    private $outputProcessor;

    public function __construct(
        \Magento\Backend\App\Action\Context $context
    ) {
        parent::__construct($context);
        /* init own properties using Object Manager from Context */
        $obm = $context->getObjectManager();
        $this->authenticator = $obm->get(\Praxigento\Core\App\Api\Web\Authenticator\Back::class);
        $this->inputProcessor = $obm->get(\Magento\Framework\Webapi\ServiceInputProcessor::class);
        $this->outputProcessor = $obm->get(\Magento\Framework\Webapi\ServiceOutputProcessor::class);
        $this->logger = $obm->get(\Psr\Log\LoggerInterface::class);
    }

    /**
     * Administrative requests are allowed for authorized users only (logged in at least).
     * @param $request
     * @throws \Magento\Framework\Exception\AuthorizationException
     */
    private function authorize($request)
    {
        $currentUserId = $this->authenticator->getCurrentUserId($request);
        if (!$currentUserId) {
            $phrase = new \Magento\Framework\Phrase('User is not authorized to perform this operation.');
            /** @noinspection PhpUnhandledExceptionInspection */
            throw new \Magento\Framework\Exception\AuthorizationException($phrase);
        }
    }

    public function execute()
    {
        $body = $this->parseInput();
        $this->authorize($body);
        $result = $this->process($body);
        $resultPage = $this->prepareResultPage($result);
        return $resultPage;
    }

    protected function getAuthenticator(): \Praxigento\Core\App\Api\Web\IAuthenticator
    {
        return $this->authenticator;
    }

    /**
     * Get class name for output data to convert PHP object into JSON using WebAPI Input Processor.
     *
     * @return string
     */
    abstract protected function getInDataType(): string;

    /**
     * Get class name for output data to convert PHP object into JSON using WebAPI Output Processor.
     *
     * @return string
     */
    abstract protected function getOutDataType(): string;


    /**
     * Read POSTed data and convert it into PHP object.
     * @return mixed|null
     */
    private function parseInput()
    {
        $result = null;
        try {
            $rawBody = file_get_contents('php://input');
            if (strpos($rawBody, '&form_key=')) {
                $parts = explode('&form_key=', $rawBody);
                $rawBody = reset($parts);
            }
            $obj = json_decode($rawBody);
            if ($obj) {
                $type = $this->getInDataType();
                $result = $this->inputProcessor->convertValue($obj, $type);
            }
        } catch (\Throwable $t) {
            $this->logger->error("Cannot parse input data: " . $t->getMessage());
        }
        return $result;
    }

    /**
     * Convert PHP object from service into JSON result page.
     *
     * @param mixed $data
     * @return \Magento\Framework\Controller\ResultInterface
     */
    private function prepareResultPage($data)
    {
        /* convert service data object into stdClass/array */
        $type = $this->getOutDataType();
        $stdObj = $this->outputProcessor->convertValue($data, $type);
        /* prepare result page with JSON data */
        $result = $this->resultFactory->create(AResultFactory::TYPE_JSON);
        $result->setData($stdObj);
        return $result;
    }

    /**
     * Main class to validate permissions and to call internal service to perform operation.
     *
     * @param $request
     * @return mixed
     */
    abstract protected function process($request);
}