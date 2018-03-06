<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Cli\Cmd;

/**
 * Base class to create console commands.
 */
abstract class Base
    extends \Symfony\Component\Console\Command\Command
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     * @deprecated I suppose it is better to use static methods to get Object Manager cause we don't use tests.
     */
    protected $manObj;

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $manObj,
        $cmdName,
        $cmdDesc
    ) {
        $this->manObj = $manObj;
        /* props initialization should be above parent constructor cause $this->configure() will be called inside */
        parent::__construct($cmdName);
        $this->setDescription($cmdDesc);
    }

    /**
     * Check area code in commands that require code to be set.
     */
    protected function checkAreaCode()
    {
        /* Magento related config (Object Manager) */
        /** @var \Magento\Framework\App\State $appState */
        $appState = $this->manObj->get(\Magento\Framework\App\State::class);
        try {
            /* area code should be set only once */
            $appState->getAreaCode();
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            /* exception will be thrown if no area code is set */
            $areaCode = \Magento\Framework\App\Area::AREA_GLOBAL;
            $appState->setAreaCode($areaCode);
            /** @var \Magento\Framework\ObjectManager\ConfigLoaderInterface $configLoader */
            $configLoader = $this->manObj->get(\Magento\Framework\ObjectManager\ConfigLoaderInterface::class);
            $config = $configLoader->load($areaCode);
            $this->manObj->configure($config);
        }
    }
}