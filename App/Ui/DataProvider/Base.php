<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2018
 */
namespace Praxigento\Core\App\Ui\DataProvider;

/**
 * Wrapper for UI data provider.
 *
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class Base
    extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    public function getData()
    {
        return [];
    }

    public function addFilter(\Magento\Framework\Api\Filter $filter)
    {
        return null;
    }
}