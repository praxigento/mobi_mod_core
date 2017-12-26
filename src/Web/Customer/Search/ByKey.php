<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Web\Customer\Search;

class ByKey
    implements \Praxigento\Core\Api\Web\Customer\Search\ByKeyInterface
{

    public function exec($request)
    {
        /* customer cannot perform search in core service */
        $phrase = new \Magento\Framework\Phrase('User is not authorized to perform this operation.');
        /** @noinspection PhpUnhandledExceptionInspection */
        throw new \Magento\Framework\Exception\AuthorizationException($phrase);
    }
}