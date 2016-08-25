<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Reflection\Map;

/**
 * Create and cache methods map used in DO2JSON conversion.
 * (see * \Magento\Framework\Reflection\MethodsMap)
 *
 */
class Methods
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

    public function __construct(
        \Magento\Framework\App\Cache\Type\Reflection $cache,
        \Praxigento\Core\Reflection\Analyzer\Type $analyzer
    ) {
        $this->_cache = $cache;
        $this->_analyzer = $analyzer;
    }

    /**
     * Get methods map for the type: [methodName=>[type,isRequired, description,parameterCount], ...]
     *
     * @param string $typeName class/interface name (\Vendor\Package\Space\Type)
     * @return array
     */
    public function getMap($typeName)
    {
        if (!isset($this->_map[$typeName])) {
            /* try to load from cache */
            $key = self::CACHE_PREFIX . "-" . md5($typeName);
            $cached = $this->_cache->load($key);
            if ($cached) {
                /* get, un-serialize and register cached data */
                $methods = unserialize($cached);
                $this->_map[$typeName] = $methods;
            } else {
                /* launch type methods analyzer  and save results to the cache */
                $data = $this->_analyzer->getMethods($typeName);
                $asArray = [];
                foreach ($data as $item) {
                    $methodName = $item->getName();
                    $entry = [
                        'type' => $item->getType(),
                        'isRequired' => $item->getIsRequired(),
                        'description' => $item->getDescription(),
                        'parameterCount' => $item->getParameterCount()
                    ];
                    $asArray[$methodName] = $entry;
                }

                $this->_map[$typeName] = $asArray;
                $cached = serialize($data);
                $this->_cache->save($cached, $key);
            }
        }
        $result = $this->_map[$typeName];
        return $result;
    }
}