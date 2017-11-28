<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Action\Front\Api;

use Magento\Framework\Controller\ResultFactory as AResultFactory;

/**
 * Base for frontend CTRL API actions.
 */
abstract class Base
    extends \Magento\Framework\App\Action\Action
{
    /** @var \Praxigento\Core\App\WebApi\IAuthenticator */
    protected $authenticator;
    /** @var \Magento\Framework\Webapi\ServiceInputProcessor */
    private $inputProcessor;
    /** @var \Psr\Log\LoggerInterface */
    protected $logger;
    /** @var \Magento\Framework\Webapi\ServiceOutputProcessor */
    private $outputProcessor;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Webapi\ServiceInputProcessor $inputProcessor,
        \Magento\Framework\Webapi\ServiceOutputProcessor $outputProcessor,
        \Praxigento\Core\Fw\Logger\App $logger,
        \Praxigento\Core\App\WebApi\IAuthenticator $authenticator
    )
    {
        parent::__construct($context);
        $this->inputProcessor = $inputProcessor;
        $this->outputProcessor = $outputProcessor;
        $this->logger = $logger;
        $this->authenticator = $authenticator;
    }

    public function execute()
    {
        $body = $this->parseInput();
        $result = $this->process($body);
        $resultPage = $this->prepareResultPage($result);
        return $resultPage;
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

    abstract protected function process($request);
}