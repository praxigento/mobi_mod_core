<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Helper;

/**
 * Helper to get configuration parameters related to the module.
 */
class Config
{

    /** @var \Magento\Framework\App\Config\ScopeConfigInterface */
    protected $scopeConfig;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Return 'true' if Developer Mode is enabled for MOBI API Authentication.
     *
     * @return bool
     */
    public function getApiAuthenticationEnabledDevMode()
    {
        $result = $this->scopeConfig->getValue('praxigento_api/authentication/enabled_dev_mode');
        $result = filter_var($result, FILTER_VALIDATE_BOOLEAN);
        return $result;
    }

}