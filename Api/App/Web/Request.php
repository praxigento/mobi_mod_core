<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\App\Web;

/**
 * Base API request.
 *
 * (Define getters explicitly to use with Swagger tool)
 * (Define setters explicitly to use with Magento JSON2PHP conversion tool)
 *
 */
class Request
    extends \Praxigento\Core\Data
{
    /**
     * Name for inner attribute that contains request's useful data (w/o service attributes of the request).
     */
    const DATA = 'data';
    /**
     * Development mode data (acts only if app is in DEV MODE).
     */
    const DEV = 'dev';

    /**
     * Data structure for the Web API request.
     *
     * Override to get appropriate JSON structure for concrete request.
     *
     * @return \Praxigento\Core\Data
     */
    public function getData()
    {
        $result = parent::get(self::DATA);
        return $result;
    }

    /**
     * Development mode data (acts only if app is in DEV MODE).
     *
     * @return \Praxigento\Core\Api\App\Web\Request\Dev|null
     */
    public function getDev()
    {
        $result = parent::get(self::DEV);
        return $result;
    }

    /**
     * Data structure for the Web API request.
     *
     * Override to get appropriate JSON structure for concrete request.
     *
     * @param \Praxigento\Core\Data $data
     * @return null
     */
    public function setData($data)
    {
        parent::set(self::DATA, $data);
    }

    /**
     * Development mode data (acts only if app is in DEV MODE).
     *
     * @param \Praxigento\Core\Api\App\Web\Request\Dev $data
     * @return null
     */
    public function setDev($data)
    {
        parent::set(self::DEV, $data);
    }

}