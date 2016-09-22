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
    protected $_manObj;
    /** @var  \Praxigento\Core\Transaction\Database\IManager */
    protected $_manTrans;


    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->_manObj = \Magento\Framework\App\ObjectManager::getInstance();
        $this->_manTrans = $this->_manObj->get(\Praxigento\Core\Transaction\Database\IManager::class);
    }
}