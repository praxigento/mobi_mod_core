<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Cli\Cmd;

/**
 * Base class to create console commands.
 */
abstract class BaseWithArea
    extends \Praxigento\Core\Cli\Cmd\Base
{

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $manObj,
        $cmdName,
        $cmdDesc
    ) {
        $this->manObj = $manObj;
        $this->cmdName = $cmdName;
        $this->cmdDesc = $cmdDesc;
        /* props initialization should be above parent constructor cause $this->configure() will be called inside */
        parent::__construct();
    }

    /**
     * Sets area code to start a adminhtml session and configure Object Manager.
     */
    protected function configure()
    {
        parent::configure();
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