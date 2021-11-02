<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2021
 */

namespace Praxigento\Core\Model\Config\Source;

use Praxigento\Downline\Config as Cfg;

/**
 * Select options source for stores (store groups).
 */
class Stores
    implements \Magento\Framework\Data\OptionSourceInterface {
    /** @var \Praxigento\Core\Api\App\Repo\Generic */
    private $daoGeneric;
    /** @var array */
    private $options;

    public function __construct(
        \Praxigento\Core\Api\App\Repo\Generic $daoGeneric
    ) {
        $this->daoGeneric = $daoGeneric;
    }

    private function init() {
        if (is_null($this->options)) {
            $this->options = [];
            $groups = $this->daoGeneric->getEntities(Cfg::ENTITY_MAGE_STORE_GROUP);
            foreach ($groups as $one) {
                $name = $one[Cfg::E_STORE_GROUP_A_NAME];
                $this->options[] = ['label' => $name, 'value' => $name];
            }
        }
    }

    public function toOptionArray() {
        $this->init();
        return $this->options;
    }
}
