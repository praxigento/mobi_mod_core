<?php
/**
 * Authors: Alex Gusev <flancer64@gmail.com>
 * Since: 2018
 */

namespace Praxigento\Core\Plugin\Framework\Api;


/**
 * MOBI-1148: disable error 500 (argument ... must be an instance of Magento\Quote\Api\Data\TotalsExtensionInterface)
 * TODO: remove it if fixed in Magneto later upgrades.
 */
class DataObjectHelper
{
    public function beforePopulateWithArray(
        \Magento\Framework\Api\DataObjectHelper $subject,
        $dataObject, array $data, $interfaceName
    ) {
        if ($interfaceName == \Magento\Quote\Api\Data\TotalsInterface::class) {
            if ($dataObject instanceof \Magento\Quote\Model\Cart\Totals) {
                if (
                    isset($data['extension_attributes']) &&
                    ($data['extension_attributes'] instanceof \Magento\Quote\Api\Data\AddressExtension)
                ) {
                    unset($data['extension_attributes']);
                }
            }
        }
        return [$dataObject, $data, $interfaceName];
    }
}