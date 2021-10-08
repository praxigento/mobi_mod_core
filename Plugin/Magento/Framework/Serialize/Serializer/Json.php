<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2018
 */

namespace Praxigento\Core\Plugin\Magento\Framework\Serialize\Serializer;

/**
 * MOBI-1358: Check UTF-8 chars in the response content to prevent "Unable to serialize value" error on Cyrillic.
 */
class Json
{

    public function beforeSerialize($subject, $data)
    {
        /* see \Magento\Framework\App\PageCache\Kernel::getPreparedData */
        if (is_array($data) && isset($data['content']) && is_string($data['content'])) {
            $data['content'] = mb_convert_encoding($data['content'], 'UTF-8', 'UTF-8');
        }
        return [$data];
    }
}
