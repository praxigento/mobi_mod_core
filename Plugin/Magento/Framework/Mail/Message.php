<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2018
 */

namespace Praxigento\Core\Plugin\Magento\Framework\Mail;

/**
 * Process recipients emails and replace its by parent's or developer's emails.
 */
class Message
{

    /** @var \Praxigento\Core\Helper\Config */
    private $hlpConfig;
    /** @var \Praxigento\Core\Api\Helper\Email */
    private $hlpEmail;

    public function __construct(
        \Praxigento\Core\Helper\Config $hlpConfig,
        \Praxigento\Core\Api\Helper\Email $hlpEmail
    ) {
        $this->hlpConfig = $hlpConfig;
        $this->hlpEmail = $hlpEmail;
    }

    public function aroundAddTo(
        \Magento\Framework\Mail\Message $subject,
        \Closure $proceed,
        $email, $name = ''
    ) {
        /* convert input to universal form (see \Zend_Mail::addTo) */
        if (!is_array($email)) {
            $email = array($name => $email);
        }
        $validated = [];
        /* use project validator/transformer */
        foreach ($email as $key => $value) {
            list($emailValid, $nameValid) = $this->hlpEmail->validateRecipient($value, $key);
            $validated[$nameValid] = $emailValid;
        }
        /* replace original emails by development ones */
        $replaced = [];
        $needReplace = $this->hlpConfig->getSystemEmailEnabledIntercept();
        if ($needReplace) {
            /* compose name */
            $allNames = '';
            foreach ($validated as $nameOrig => $emailOrig) {
                $part = "$nameOrig::$emailOrig";
                $part = str_replace('@', '.at.', $part);
                $allNames .= "$part ";
            }
            $allNames = trim($allNames);
            /* compose emails */
            $addrs = $this->hlpConfig->getSystemEmailDevEmails();
            $addrs = explode(',', $addrs);
            foreach ($addrs as $key => $one) {
                $newEmail = trim($one);
                $replaced[$newEmail] = $allNames;
            }
        } else {
            $replaced = $validated;
        }
        /* add processed emails to the message */
        $result = $proceed($replaced);
        return $result;
    }
}