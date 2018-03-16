<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Helper;

/**
 * Helper to get configuration parameters related to the module.
 */
class Config
    implements \Praxigento\Core\Api\Helper\Config
{

    /** @var \Magento\Framework\App\Config\ScopeConfigInterface */
    private $scopeConfig;

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

    /**
     * Comma separated list of emails to get intercepted emails.
     *
     * @return string
     */
    public function getSystemEmailDevEmails()
    {
        $result = $this->scopeConfig->getValue('praxigento_system/email/dev_emails');
        return $result;
    }

    /**
     * 'true' if all emails will be intercepted and sent to developer address.
     *
     * @return bool
     */
    public function getSystemEmailEnabledIntercept()
    {
        $result = $this->scopeConfig->getValue('praxigento_system/email/enabled_intercept');
        $result = filter_var($result, FILTER_VALIDATE_BOOLEAN);
        return $result;
    }

}