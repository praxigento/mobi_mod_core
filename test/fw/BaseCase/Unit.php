<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Test\BaseCase;


/**
 * Base class for unit test cases.
 */
abstract class Unit
    extends \PHPUnit\Framework\TestCase
{
    /** @var  \Magento\Framework\ObjectManagerInterface */
    protected $manObj;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->manObj = \Magento\Framework\App\ObjectManager::getInstance();
       }

    protected function checkAreaCode()
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