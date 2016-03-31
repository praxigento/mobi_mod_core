<?php
/**
 * M1 wrapper for Zend Dependency Injection compatible with Magento 2 DI. Is used in M1 only.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Lib\Context;


use Praxigento\Core\Lib\Context;

/**
 * TODO: move implementation to 'Def' folder.
 */
class ObjectManager extends \Zend\Di\Di implements \Praxigento\Core\Lib\Context\IObjectManager
{
    
    /**
     * ObjectManager constructor.
     */
    public function __construct(
        \Zend\Di\DefinitionList $definitions = null,
        \Zend\Di\InstanceManager $instanceManager = null,
        \Zend\Di\Config $config = null
    ) {
        $defs = new \Zend\Di\DefinitionList(new \Praxigento\Core\Lib\Di\M1RuntimeDefinition());
        parent::__construct($defs, $instanceManager, $config);
    }

    /**
     * This method is used in M1 Context to initialize Zend_Di and is not used in M2.
     *
     * @codeCoverageIgnore
     *
     * @param $instance
     * @param $classOrAlias
     */
    public function addSharedInstance($instance, $classOrAlias)
    {
        $this->instanceManager()->addSharedInstance($instance, $classOrAlias);
    }

    public function create($type, array $arguments = [])
    {
        $m1Type = Context::getMappedClassName($type);
        $result = $this->newInstance($m1Type, $arguments, $isShared = false);
        return $result;
    }

    public function get($name, array $params = [])
    {
        $m1Type = Context::getMappedClassName($name);
        return parent::get($m1Type, $params);
    }
}