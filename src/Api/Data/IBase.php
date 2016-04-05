<?php
/**
 * Base interface for all data objects used in REST/SOAP API.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Data;


interface IBase
{
    /**
     * Any array data can be returned from internal data storage.
     *
     * @param string $path
     *
     * @return mixed|null
     */
    public function getData($path = null);

    /**
     * @param mixed $data
     */
    public function setData($data);

}