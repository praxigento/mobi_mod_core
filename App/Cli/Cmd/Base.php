<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Cli\Cmd;

use Praxigento\BonusReferral\Api\Service\Bonus\Collect\Request as ARequest;

/**
 * Base class to create console commands.
 */
abstract class Base
    extends \Symfony\Component\Console\Command\Command
{
    private $conn;
    /** @var \Psr\Log\LoggerInterface */
    private $logger;
    /** @var \Symfony\Component\Console\Output\OutputInterface */
    private $out;

    public function __construct($name = null, $description = null)
    {
        /* this is a base class, we need not add $manObj in the every child constructor as an argument */
        $manObj = \Magento\Framework\App\ObjectManager::getInstance();
        $this->logger = $manObj->get(\Psr\Log\LoggerInterface::class);
        /** @var \Magento\Framework\App\ResourceConnection $resource */
        $resource = $manObj->get(\Magento\Framework\App\ResourceConnection::class);
        $this->conn = $resource->getConnection();
        /* props initialization should be above parent constructor cause $this->configure() will be called inside */
        parent::__construct($name);
        if ($description) {
            $this->setDescription($description);
        }
    }

    /**
     * Check area code in commands that require code to be set.
     */
    protected function checkAreaCode()
    {
        /* Magento related config (Object Manager) */
        $manObj = \Magento\Framework\App\ObjectManager::getInstance();
        /** @var \Magento\Framework\App\State $appState */
        $appState = $manObj->get(\Magento\Framework\App\State::class);
        try {
            /* area code should be set only once */
            $appState->getAreaCode();
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            /* exception will be thrown if no area code is set */
            $areaCode = \Magento\Framework\App\Area::AREA_GLOBAL;
            $appState->setAreaCode($areaCode);
            /** @var \Magento\Framework\ObjectManager\ConfigLoaderInterface $configLoader */
            $configLoader = $manObj->get(\Magento\Framework\ObjectManager\ConfigLoaderInterface::class);
            $config = $configLoader->load($areaCode);
            $manObj->configure($config);
        }
    }

    /**
     * Wrap main process function with try-catch & transaction.
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int|void|null
     */
    protected function execute(
        \Symfony\Component\Console\Input\InputInterface $input,
        \Symfony\Component\Console\Output\OutputInterface $output
    ) {
        /* save console output locally (command context) */
        $this->out = $output;
        $this->logInfo("Command '" . $this->getName() . "' is started.");
        $this->conn->beginTransaction();
        try {
            $this->checkAreaCode();
            /* all children must implement 'process' method */
            $this->process($input);
            $this->conn->commit();
        } catch (\Throwable $e) {
            $this->logError("Command '" . $this->getName() . "' failed. Reason: " . $e->getMessage());
            $this->conn->rollBack();
        }
        $this->logInfo("Command '" . $this->getName() . "' is completed.");
    }

    /**
     * Write out $msg to log file and to console as error message.
     *
     * @param string $msg
     */
    protected function logError(string $msg)
    {
        $this->logger->error($msg);
        $this->out->writeln("<error>$msg<error>");
    }

    /**
     * Write out $msg to log file and to console as info message.
     *
     * @param string $msg
     */
    protected function logInfo(string $msg)
    {
        $this->logger->info($msg);
        $this->out->writeln("<info>$msg<info>");
    }

    /**
     * Do the main job here.
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     */
    abstract protected function process(\Symfony\Component\Console\Input\InputInterface $input);
}