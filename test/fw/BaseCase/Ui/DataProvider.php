<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Test\BaseCase\Ui;


/**
 * Base class to create units to test UI Data Providers
 * based on \Praxigento\Core\Ui\DataProvider\Base.
 */
abstract class DataProvider
    extends \Praxigento\Core\Test\BaseCase\Mockery
{
    /** @var  \Mockery\MockInterface */
    protected $mCritAdapter;
    /** @var  \Mockery\MockInterface */
    protected $mFilterBuilder;
    /** @var  \Mockery\MockInterface */
    protected $mReporting;
    /** @var  \Mockery\MockInterface */
    protected $mRequest;
    /** @var  \Mockery\MockInterface */
    protected $mSearchCritBuilder;
    /** @var  \Mockery\MockInterface */
    protected $mUrl;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mCritAdapter = $this->_mock(\Praxigento\Core\Repo\Query\Criteria\IAdapter::class);
        $this->mFilterBuilder = $this->_mock(\Magento\Framework\Api\FilterBuilder::class);
        $this->mReporting = $this->_mock(\Magento\Framework\View\Element\UiComponent\DataProvider\Reporting::class);
        $this->mRequest = $this->_mock(\Magento\Framework\App\RequestInterface::class);
        $this->mSearchCritBuilder = $this->_mock(\Magento\Framework\Api\Search\SearchCriteriaBuilder::class);
        $this->mUrl = $this->_mock(\Magento\Framework\UrlInterface::class);
        /** setup mocks for constructor */
        $this->mUrl->shouldReceive('getRouteUrl')->once();
    }
}