<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Web\Customer\Search\ByKey\Response;

/**
 * Contains suggestions for customers found by key (name/email/mlm_id).
 *
 * (Define getters explicitly to use with Swagger tool)
 *
 */
class Data
    extends \Praxigento\Core\Data
{
    const ITEMS = 'items';

    /**
     * @return \Praxigento\Core\Api\Data\Customer\Search\Response\Item[]
     */
    public function getItems() {
        $result = parent::get(self::ITEMS);
        return $result;
    }

    /**
     * @param \Praxigento\Core\Api\Data\Customer\Search\Response\Item[] $data
     */
    public function setItems($data) {
        parent::set(self::ITEMS, $data);
    }
}