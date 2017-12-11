<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Web\Customer\Search\ByKey\Request;

/**
 * Search request parameters.
 *
 * (Define getters explicitly to use with Swagger tool)
 *
 */
class Data
    extends \Praxigento\Core\Data
{
    const LIMIT = 'limit';
    const SEARCH_KEY = 'searchKey';

    /**
     * @return int
     */
    public function getLimit() {
        $result = parent::get(self::LIMIT);
        return $result;
    }

    /**
     * @return string
     */
    public function getSearchKey() {
        $result = parent::get(self::SEARCH_KEY);
        return $result;
    }

    /**
     * @param int $data
     */
    public function setLimit($data) {
        parent::set(self::LIMIT, $data);
    }

    /**
     * @param string $data
     */
    public function setSearchKey($data) {
        parent::set(self::SEARCH_KEY, $data);
    }
}