<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Ctrl\Adminhtml\Customer\Search\Response;

/**
 * Response data to search customers.
 */
class Data
    extends \Praxigento\Core\Data {

    const ITEMS = 'items';

    /**
     * @return \Praxigento\Core\Api\Data\Customer\Search\Result\Item[]
     */
    public function getItems() {
        $result = parent::get(self::ITEMS);
        return $result;
    }

    /**
     * @param \Praxigento\Core\Api\Data\Customer\Search\Result\Item[] $data
     */
    public function setItems($data) {
        parent::set(self::ITEMS, $data);
    }
}