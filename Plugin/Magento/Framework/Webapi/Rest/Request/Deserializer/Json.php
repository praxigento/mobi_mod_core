<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Plugin\Magento\Framework\Webapi\Rest\Request\Deserializer;

class Json
{
    /**
     * Remove from key from Web API request sent using jQuery.ajax().
     *
     * @param \Magento\Framework\Webapi\Rest\Request\Deserializer\Json $subject
     * @param $encodedBody
     * @return array
     */
    public function beforeDeserialize(
        \Magento\Framework\Webapi\Rest\Request\Deserializer\Json $subject,
        $encodedBody
    ) {
        if (strpos($encodedBody, '&form_key=')) {
            $parts = explode('&form_key=', $encodedBody);
            $encodedBody = reset($parts);
        }
        return [$encodedBody];
    }
}