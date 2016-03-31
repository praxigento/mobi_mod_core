<?php
/**
 * Base service for codified types.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Service;

use Praxigento\Core\Lib\Service\Type\Base\Request;
use Praxigento\Core\Lib\Service\Type\Base\Response;

interface ITypeBase {
    /**
     * Get codified type data by asset code.
     *
     * @param Request\GetByCode $request
     *
     * @return Response\GetByCode
     */
    public function getByCode(Request\GetByCode $request);
}