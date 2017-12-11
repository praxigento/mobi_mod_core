<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Test\BaseCase;


/**
 * Base class for manual test cases.
 */
abstract class Manual
    extends \Praxigento\Core\Test\BaseCase\Mockery
{
    /** @var  \Magento\Framework\ObjectManagerInterface */
    protected $manObj;
    /** @var  \Praxigento\Core\App\Transaction\Database\IManager */
    protected $manTrans;


    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->manObj = \Magento\Framework\App\ObjectManager::getInstance();
        $this->manTrans = $this->manObj->get(\Praxigento\Core\App\Transaction\Database\IManager::class);
    }
}