<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Data;


interface BaseInterface
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
    /* TODO this is test code and should be removed after 2016/06/01 */
//    /**
//     * @return mixed|null
//     */
//    public function getCustomAttributes();
//
//    /**
//     * @param mixed $data
//     */
//    public function setCustomAttributes($data);

}