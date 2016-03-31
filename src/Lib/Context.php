<?php
/**
 * Execution environment context (Magento 1 / Magento 2).
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib;

use Praxigento\Core\Config as Cfg;
use Praxigento\Core\Lib\Context\Map\ClassName;

class Context
{
    /**
     * Type of the execution environment.
     */
    const TYPE_MAGE_1 = 'M1';
    const TYPE_MAGE_2_CLI = 'M2_CLI';
    const TYPE_MAGE_2_WEB = 'M2_WEB';
    const TYPE_TEST_M1 = 'TEST_M1';
    const TYPE_TEST_M2 = 'TEST_M2';
    /**
     * Itself. Singleton.
     *
     * @var Context
     */
    private static $_instance;
    /**
     * Flag for current execution context type.
     * @var string
     */
    private $_contextType;
    /**
     * Cached Object Manager.
     *
     * @var  Context\ObjectManager
     */
    private $_objectManager;

    /**
     * Context constructor.
     *
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        /* analyze current runtime environment Magento 1 | Magento 2 */
        if (class_exists(\Mage::class, false)) {
            /* this is Magento 1 */
            $this->_contextType = self::TYPE_MAGE_1;
        } elseif (
            isset($GLOBALS['bootstrap']) &&
            ($GLOBALS['bootstrap'] instanceof \Magento\Framework\App\Bootstrap)
        ) {
            if (
                isset($GLOBALS['app']) &&
                ($GLOBALS['app'] instanceof \Praxigento\Test\App)
            ) {
                /* this is Magento 2 functional/integration tests  */
                $this->_contextType = self::TYPE_TEST_M2;
            } else {
                /* this is Magento 2 web application  */
                $this->_contextType = self::TYPE_MAGE_2_WEB;
            }
        } elseif (
            isset($GLOBALS['application']) &&
            ($GLOBALS['application'] instanceof \Magento\Framework\Console\Cli)
        ) {
            /* this is Magento 2 CLI application (./htdocs/bin/magento) */
            $this->_contextType = self::TYPE_MAGE_2_CLI;
        } elseif (defined('IS_M1_TESTS')) {
            $this->_contextType = self::TYPE_TEST_M1;
        } elseif (defined('IS_M2_TESTS')) {
            $this->_contextType = self::TYPE_TEST_M2;
        }
    }

    /**
     * For M1 only. Extract DI configuration from 'config.xml' files and save in ClassName mapper.
     *
     * @codeCoverageIgnore static Mage::app() method is used inside. Not for unit tests.
     */
    private function _extractDiMapFromConfig()
    {
        $app = \Mage::app();
        $cfg = $app->getConfig();
        $node = $cfg->getNode(Cfg::CFG_PATH_DI);
        $map = [];
        if (isset($node)) {
            $diModules = $node->asArray();
            foreach ($diModules as $module) {
                foreach ($module as $item) {
                    $for = $item[Cfg::CFG_NODE_DI_DEPENDENCY_FOR];
                    $type = $item[Cfg::CFG_NODE_DI_DEPENDENCY_TYPE];
                    $map[$for] = $type;
                }
            }
        }
        ClassName::getInstance()->merge($map);
    }

    /**
     * Map M2 classes to M1 classes.
     * The static method is used to prevent method mocking in tests.
     *
     * @param $m2name M2 class name (Magento\Framework\DB\Adapter\Pdo\Mysql)
     *
     * @return string mapped M1 class (Magento_Db_Adapter_Pdo_Mysql)
     */
    public static function getMappedClassName($m2name)
    {
        $result = $m2name;
        /* truncate leading '\' from distinguished class name */
        if (is_string($result) && (substr($result, 0, 1) == '\\')) {
            $len = strlen($result) - 1;
            $result = substr($result, 1, $len);
        }
        if (!self::instance()->isMage2()) {
            $result = Context\Map\ClassName::getInstance()->getM1Name($result);
        }
        return $result;
    }

    /**
     * Map M2 entities to M1 entities ('sales_order' => 'sales_flat_order') in M1 context.
     * The static method is used to prevent method mocking in tests.
     *
     * @param $m2name M2 entity name ('sales_order')
     *
     * @return string mapped M1 entity name ('sales_flat_order')
     */
    public static function getMappedEntityName($m2name)
    {
        $result = $m2name;
        if (!self::instance()->isMage2()) {
            $result = Context\Map\EntityName::getM1Name($m2name);
        }
        return $result;
    }

    /**
     * Get context specific Object Manager (Zend_Di based for M1 or Magento 2 Object Manager).
     *
     * @codeCoverageIgnore
     *
     * @return Context\IObjectManager
     */
    public function getObjectManager()
    {
        if (is_null($this->_objectManager)) {
            if ($this->isMage2()) {
                /** \Magento\Framework\ObjectManager\ObjectManager */
                $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            } else {
                /* create Class Names mapper from 'config.xml' files */
                $this->_extractDiMapFromConfig();
                /* create Object Manager for M1 and initialize common objects (shared instances) */
                $this->_objectManager = new Context\ObjectManager();
                /* setup DbAdapter */
                $resource = \Mage::getModel('core/resource');
                $dbAdapter = new Context\DbAdapter($resource);
                $this->_objectManager->addSharedInstance($dbAdapter, \Praxigento\Core\Lib\Context\IDbAdapter::class);
            }
        }
        return $this->_objectManager;
    }

    /**
     * Get singleton instance.
     *
     * @return Context
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Context();
        }
        return self::$_instance;
    }

    /**
     * 'true' if execution context is Magento 2 application (web, CLI or test).
     *
     * @return bool
     */
    public function isMage2()
    {
        $result =
            ($this->_contextType == self::TYPE_MAGE_2_CLI) ||
            ($this->_contextType == self::TYPE_MAGE_2_WEB) ||
            ($this->_contextType == self::TYPE_TEST_M2);
        return $result;
    }

    /**
     * Reset instance.
     */
    public static function reset()
    {
        self::set();
    }

    /**
     * Set test unit instance with mocked methods.
     *
     * @param Context $instance
     */
    public static function set(Context $instance = null)
    {
        self::$_instance = $instance;
    }
}