<?php
namespace Praxigento\Core\Lib\Di;

use Praxigento\Core\Lib\Context\Map\ClassName;
use Zend\Code\Reflection\ClassReflection;

/**
 * User: Alex Gusev <alex@flancer64.com>
 */
class M1ParameterReflection extends \Zend\Code\Reflection\ParameterReflection {

    /**
     * Replace M2 classes by its M1 analogs in Magento 1 apps.
     *
     * See \Zend\Code\Reflection\ParameterReflection::getClass
     *
     * @codeCoverageIgnore
     *
     * @return void|ClassReflection
     */
    public function getClass() {
        try {
            $phpReflection = parent::getClass();
        } catch(\Exception $e) {
            $m2class = $e->getMessage();
            $m2class = str_replace('Class ', '', $m2class);
            $m2class = str_replace('does not exist', '', $m2class);
            $m1class = ClassName::getInstance()->getM1Name($m2class);
            $phpReflection = new \ReflectionClass($m1class);
        }
        if($phpReflection === null) {
            return;
        }

        /* MOBI-126 replace logger */
        if($phpReflection->getName() == 'Psr\Log\LoggerInterface') {
            $m1class = ClassName::getInstance()->getM1Name('Psr\Log\LoggerInterface');
            $phpReflection = new \ReflectionClass($m1class);
        }

        $zendReflection = new ClassReflection($phpReflection->getName());
        unset($phpReflection);

        return $zendReflection;
    }
}