<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Reflection\Map;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

/**
 * @SuppressWarnings(PHPMD.CamelCaseClassName)
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class Base_UnitTest
    extends \Praxigento\Core\Test\BaseCase\Mockery
{
    /** @var  \Mockery\MockInterface */
    private $mAnalyzer;
    /** @var  \Mockery\MockInterface */
    private $mCache;
    /** @var  Base */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mCache = $this->_mock(\Magento\Framework\App\Cache\Type\Reflection::class);
        $this->mAnalyzer = $this->_mock(\Praxigento\Core\Reflection\Analyzer\Type::class);
        /** create object to test */
        $this->obj = new ChildToTestBase(
            $this->mCache,
            $this->mAnalyzer
        );
    }

    public function test_constructor()
    {
        /** === Call and asserts  === */
        $this->assertInstanceOf(\Praxigento\Core\Reflection\Map\Base::class, $this->obj);
    }

    public function test_getMap_cached()
    {
        /** === Test Data === */
        $typeName = 'type name';
        $cacheKey = 'serviceInterfaceMethodsMap-a334dfe0a9d8161496df3d0eb3a1e954';
        $serialized = 's:4:"meta";';
        /** === Setup Mocks === */
        // $cached = $this->_cache->load($key);
        $mCached = $serialized;
        $this->mCache
            ->shouldReceive('load')->once()
            ->with($cacheKey)
            ->andReturn($mCached);
        // $meta = unserialize($cached);
        $mMeta = 'meta';
        // $parsed = $this->_parseMetaData($meta);
        // see \Praxigento\Core\Reflection\Map\ChildToTestBase in this unit
        /** === Call and asserts  === */
        $res = $this->obj->getMap($typeName);
        $this->assertEquals($mMeta, $res);
    }

    public function test_getMap_notCached()
    {
        /** === Test Data === */
        $typeName = 'type name';
        $cacheKey = 'serviceInterfaceMethodsMap-a334dfe0a9d8161496df3d0eb3a1e954';
        $serialized = 's:4:"meta";';
        /** === Setup Mocks === */
        // $cached = $this->_cache->load($key);
        $mCached = null;
        $this->mCache
            ->shouldReceive('load')->once()
            ->with($cacheKey)
            ->andReturn($mCached);
        // $meta = $this->_analyzer->getMethods($typeName);
        $mMeta = 'meta';
        $this->mAnalyzer
            ->shouldReceive('getMethods')->once()
            ->with($typeName)
            ->andReturn($mMeta);
        // $parsed = $this->_parseMetaData($meta);
        // see \Praxigento\Core\Reflection\Map\ChildToTestBase in this unit
        // $this->_cache->save($cached, $key);
        $this->mCache
            ->shouldReceive('save')->once()
            ->with($serialized, $cacheKey);
        /** === Call and asserts  === */
        $res = $this->obj->getMap($typeName);
        $this->assertEquals($mMeta, $res);
    }
}

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class ChildToTestBase extends Base
{
    public function _parseMetaData($saved)
    {
        return $saved;
    }

}