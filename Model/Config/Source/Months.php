<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2018
 */

namespace Praxigento\Core\Model\Config\Source;

/**
 * Select options source for months.
 */
class Months
    implements \Magento\Framework\Data\OptionSourceInterface
{

    public function toOptionArray()
    {
        $result = [
            ['label' => __('January'), 'value' => '1'],
            ['label' => __('February'), 'value' => '2'],
            ['label' => __('March'), 'value' => '3'],
            ['label' => __('April'), 'value' => '4'],
            ['label' => __('May'), 'value' => '5'],
            ['label' => __('June'), 'value' => '6'],
            ['label' => __('July'), 'value' => '7'],
            ['label' => __('August'), 'value' => '8'],
            ['label' => __('September'), 'value' => '9'],
            ['label' => __('October'), 'value' => '10'],
            ['label' => __('November'), 'value' => '11'],
            ['label' => __('December'), 'value' => '12']
        ];
        return $result;
    }
}