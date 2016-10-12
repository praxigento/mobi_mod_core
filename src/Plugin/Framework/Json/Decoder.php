<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Plugin\Framework\Json;


class Decoder
{
    const FORM_KEY = 'form_key';

    public function aroundDecode(
        \Magento\Framework\Json\Decoder $subject,
        \Closure $proceed,
        $data
    ) {
        $formKey = null;
        $clearData = $data;
        $search = '&' . self::FORM_KEY . '=';
        $pos = strpos($data, $search);
        if ($pos) {
            $clearData = substr($data, 0, $pos);
            $formKey = substr($data, $pos + strlen($search));
        }
        $result = $proceed($clearData);
        if ($formKey) {
            $result[self::FORM_KEY] = $formKey;
        }
        return $result;
    }
}