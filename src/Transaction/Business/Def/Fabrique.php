<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Transaction\Business\Def;

/**
 * Default implementation for Transaction items factory used by Business Transaction Manager.
 */
class Fabrique
    implements \Praxigento\Core\Transaction\Business\IFabrique
{

    /** @var \Magento\Framework\ObjectManagerInterface */
    private $manObj;

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $maObj
    ) {
        $this->manObj = $maObj;
    }

    /**
     * @param string $name
     * @return \Praxigento\Core\Transaction\Business\IItem
     */
    public function create($name)
    {
        $logger = $this->manObj->get(\Praxigento\Core\Fw\Logger\App::class);
        $result = new \Praxigento\Core\Transaction\Business\Def\Item($logger);
        $result->setName($name);
        return $result;
    }

}