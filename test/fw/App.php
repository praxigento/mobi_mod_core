<?php
/**
 * Test application to connect to DB. Used in functional tests.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Test;

class App
    implements \Magento\Framework\AppInterface
{
    /** @var \Magento\Framework\App\Console\Response */
    protected $response;
    /** @var \Magento\Store\Model\StoreManagerInterface */
    protected $storeManager;

    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Console\Response $response
    ) {
        $this->storeManager = $storeManager;
        $this->response = $response;
    }


    public function catchException(
        \Magento\Framework\App\Bootstrap $bootstrap,
        \Exception $exception
    ) {
        /* we don't handle exceptions in test */
        return false;
    }

    /**
     * Launch application. Prevent application termination on sent response, initialize DB connection.
     *
     * @inheritdoc
     */
    public function launch()
    {
        $this->response->terminateOnSend(false);
        $this->storeManager->getStores(false, true);
        return $this->response;
    }
}