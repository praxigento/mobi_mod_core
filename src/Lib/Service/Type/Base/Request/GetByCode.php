<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Service\Type\Base\Request;

/**
 * @method string getCode()
 * @method void setCode(string $data)
 */
abstract class GetByCode extends \Praxigento\Core\Lib\Service\Base\Request {
    const CODE = 'Code';

    /**
     * Usage: "$reqTypeCalc = new TypeCalcRequestGetByCode($calcTypeCode);"
     *
     * @param null $data
     */
    public function __construct($data = null) {
        $this->setCode($data);
    }

}