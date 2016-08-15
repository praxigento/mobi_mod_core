<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Transaction\Business\Def;

/**
 * Default implementation for Transaction items factory used by Business Transaction Manager.
 */
class Factory
    implements \Praxigento\Core\Transaction\Business\IFactory
{

    /** @var \Magento\Framework\ObjectManagerInterface */
    private $_manObj;

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $maObj
    ) {
        $this->_manObj = $maObj;
    }

    /**
     * @param string $name
     * @return \Praxigento\Core\Transaction\Business\IItem
     */
    public function create($name)
    {
        $result = $this->_manObj->create(\Praxigento\Core\Transaction\Business\Def\Item::class);
        $result->setName($name);
        return $result;
    }

}