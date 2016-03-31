<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Service\Type\Base\Response;

use Praxigento\Core\Lib\Entity\Type\Base as BaseType;

abstract class GetByCode extends \Praxigento\Core\Lib\Service\Base\Response {
    /**
     * @return int|null
     */
    public function getId() {
        $result = $this->getData(BaseType::ATTR_ID);
        return $result;
    }

    /**
     * @param $val int
     */
    public function setId($val) {
        $this->setData(BaseType::ATTR_ID, $val);
    }

    /**
     * @return string|null
     */
    public function getCode() {
        $result = $this->getData(BaseType::ATTR_CODE);
        return $result;
    }


    /**
     * @return string|null
     */
    public function getNote() {
        $result = $this->getData(BaseType::ATTR_NOTE);
        return $result;
    }
}