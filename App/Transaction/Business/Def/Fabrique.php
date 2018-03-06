<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Transaction\Business\Def;

/**
 * Default implementation for Transaction items factory used by Business Transaction Manager.
 */
class Fabrique
    implements \Praxigento\Core\App\Transaction\Business\IFabrique
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
     * @return \Praxigento\Core\App\Transaction\Business\IItem
     */
    public function create($name)
    {
        $logger = $this->manObj->get(\Psr\Log\LoggerInterface::class);
        $result = new \Praxigento\Core\App\Transaction\Business\Def\Item($logger);
        $result->setName($name);
        return $result;
    }

}