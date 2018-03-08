<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Test\BaseCase;


/**
 * Base class for manual test cases.
 */
abstract class Manual
    extends \Praxigento\Core\Test\BaseCase\Mockery
{
    /** @var  \Magento\Framework\ObjectManagerInterface */
    protected $manObj;
    /** @var  \Praxigento\Core\Api\App\Repo\Transaction\Manager */
    protected $manTrans;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->manObj = \Magento\Framework\App\ObjectManager::getInstance();
        $this->manTrans = $this->manObj->get(\Praxigento\Core\Api\App\Repo\Transaction\Manager::class);
    }

    protected function setAreaCode()
    {
        /** @var \Magento\Framework\App\State $appState */
        $appState = $this->manObj->get(\Magento\Framework\App\State::class);
        try {
            $appState->getAreaCode();
        } catch (\Exception $e) {
            $areaCode = \Magento\Framework\App\Area::AREA_GLOBAL;
            $appState->setAreaCode($areaCode);
            /** @var \Magento\Framework\ObjectManager\ConfigLoaderInterface $configLoader */
            $configLoader = $this->manObj->get(\Magento\Framework\ObjectManager\ConfigLoaderInterface::class);
            $config = $configLoader->load($areaCode);
            $this->manObj->configure($config);
        }
    }
}