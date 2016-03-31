<?php
/**
 * Map M2 database entities to M1 entities.
 * ('sales_order' => 'sales_flat_order')
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Lib\Context\Map;


class EntityName {

    private static $_map = [
        'quote'                 => 'sales_flat_quote',
        'quote_address'         => 'sales_flat_quote_address',
        'quote_address_item'    => 'sales_flat_quote_address_item',
        'quote_item'            => 'sales_flat_quote_item',
        'sales_creditmemo'      => 'sales_flat_creditmemo',
        'sales_creditmemo_item' => 'sales_flat_creditmemo_item',
        'sales_invoice'         => 'sales_flat_invoice',
        'sales_invoice_item'    => 'sales_flat_invoice_item',
        'sales_order'           => 'sales_flat_order',
        'sales_order_item'      => 'sales_flat_order_item'
    ];

    /**
     * Map M2 name for entity to M1 name.
     *
     * @param $m2Entity string 'sales_order'
     *
     * @return string M1 name for entity ('sales_flat_order).
     */
    public static function getM1Name($m2Entity) {
        $result = strtolower(trim($m2Entity));
        if(isset(self::$_map[$result])) {
            $result = self::$_map[$result];
        }
        return $result;
    }
}