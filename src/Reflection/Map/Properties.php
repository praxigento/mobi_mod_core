<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Reflection\Map;

/**
 * Create and cache methods map used in JSON2DO conversion.
 * (see \Magento\Framework\Reflection\TypeProcessor::register)
 *
 * TODO: this is reserved class for Reflection optimization (see MOBI-416)
 *
 */
class Properties
    extends \Praxigento\Core\Reflection\Map\Base
{
    /**
     * Prefix for keys to store parsed data in the app. cache. We use the same prefix, so we need have the same
     * data structure with \Magento\Framework\Reflection\MethodsMap.
     */
    const CACHE_PREFIX = \Magento\Framework\Reflection\MethodsMap::SERVICE_INTERFACE_METHODS_CACHE_PREFIX;
    /**
     * Praxigento analyzer to parse types consider annotated methods.
     *
     * @var \Praxigento\Core\Reflection\Analyzer\Type
     */
    protected $_analyzer;
    /**
     * Application cache that stores previously analyzed results.
     *
     * @var \Magento\Framework\Cache\FrontendInterface
     */
    protected $_cache;
    /**
     * Internal registry for mapped types (uses type name as key instead of md5-hash).
     *
     * @var array
     */
    protected $_map = [];

    /** @inheritdoc */
    public function _parseMetaData($saved)
    {
        $result = 'na';
        return $result;
    }
}