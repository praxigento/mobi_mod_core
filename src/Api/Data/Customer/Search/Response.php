<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Data\Customer\Search;


class Response
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