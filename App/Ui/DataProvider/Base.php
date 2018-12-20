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
    public function __construct(
        string $name,
        string $primaryFieldName = 'id',
        string $requestFieldName = 'id',
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        return [null => ['field' => 'value']];
    }

    public function addFilter(\Magento\Framework\Api\Filter $filter)
    {
        return null;
    }
}