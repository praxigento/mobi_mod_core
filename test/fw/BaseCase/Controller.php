<?php
/**
 * Base class to create units to test Controllers.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Test\BaseCase;

use Mockery as m;

abstract class Controller
    extends \Praxigento\Core\Test\BaseMockeryCase
{
    /** @var  \Mockery\MockInterface */
    protected $mContext;
    /** @var  \Mockery\MockInterface */
    protected $mCtxActionFlag;
    /** @var  \Mockery\MockInterface */
    protected $mCtxAuth;
    /** @var  \Mockery\MockInterface */
    protected $mCtxAuthorization;
    /** @var  \Mockery\MockInterface */
    protected $mCtxBackendUrl;
    /** @var  \Mockery\MockInterface */
    protected $mCtxCanUseBaseUrl;
    /** @var  \Mockery\MockInterface */
    protected $mCtxEventManager;
    /** @var  \Mockery\MockInterface */
    protected $mCtxFormKeyValidator;
    /** @var  \Mockery\MockInterface */
    protected $mCtxHelper;
    /** @var  \Mockery\MockInterface */
    protected $mCtxLocaleResolver;
    /** @var  \Mockery\MockInterface */
    protected $mCtxMessageManager;
    /** @var  \Mockery\MockInterface */
    protected $mCtxObjectManager;
    /** @var  \Mockery\MockInterface */
    protected $mCtxRedirect;
    /** @var  \Mockery\MockInterface */
    protected $mCtxRequest;
    /** @var  \Mockery\MockInterface */
    protected $mCtxResponse;
    /** @var  \Mockery\MockInterface */
    protected $mCtxResultFactory;
    /** @var  \Mockery\MockInterface */
    protected $mCtxResultRedirectFactory;
    /** @var  \Mockery\MockInterface */
    protected $mCtxSession;
    /** @var  \Mockery\MockInterface */
    protected $mCtxUrl;
    /** @var  \Mockery\MockInterface */
    protected $mCtxView;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mContext = $this->_mock(\Magento\Backend\App\Action\Context::class);
        /* for \Magento\Framework\App\Action\AbstractAction */
        $this->mCtxRequest = $this->_mock(\Magento\Framework\App\RequestInterface::class);
        $this->mCtxResponse = $this->_mock(\Magento\Framework\App\ResponseInterface::class);
        $this->mCtxResultFactory = $this->_mock(\Magento\Framework\Controller\ResultFactory::class);
        $this->mCtxResultRedirectFactory = $this->_mock(\Magento\Framework\Controller\Result\RedirectFactory::class);
        /* for \Magento\Framework\App\Action\Action */
        $this->mCtxObjectManager = $this->_mock(\Magento\Framework\ObjectManagerInterface::class);
        $this->mCtxEventManager = $this->_mock(\Magento\Framework\Event\ManagerInterface::class);
        $this->mCtxUrl = $this->_mock(\Magento\Framework\UrlInterface::class);
        $this->mCtxActionFlag = $this->_mock(\Magento\Framework\App\ActionFlag::class);
        $this->mCtxRedirect = $this->_mock(\Magento\Framework\App\Response\RedirectInterface::class);
        $this->mCtxView = $this->_mock(\Magento\Framework\App\ViewInterface::class);
        $this->mCtxMessageManager = $this->_mock(\Magento\Framework\Message\ManagerInterface::class);
        /* for \Magento\Backend\App\AbstractAction */
        $this->mCtxAuthorization = $this->_mock(\Magento\Framework\AuthorizationInterface::class);
        $this->mCtxAuth = $this->_mock(\Magento\Backend\Model\Auth::class);
        $this->mCtxHelper = $this->_mock(\Magento\Backend\Helper\Data::class);
        $this->mCtxBackendUrl = $this->_mock(\Magento\Backend\Model\UrlInterface::class);
        $this->mCtxFormKeyValidator = $this->_mock(\Magento\Framework\Data\Form\FormKey\Validator::class);
        $this->mCtxLocaleResolver = $this->_mock(\Magento\Framework\Locale\ResolverInterface::class);
        $this->mCtxCanUseBaseUrl = true;
        $this->mCtxSession = $this->_mock(\Magento\Backend\Model\Session::class);
        /* setup context for \Magento\Framework\App\Action\AbstractAction */
        $this->mContext
            ->shouldReceive('getRequest')
            ->andReturn($this->mCtxRequest);
        $this->mContext
            ->shouldReceive('getResponse')
            ->andReturn($this->mCtxResponse);
        $this->mContext
            ->shouldReceive('getResultFactory')
            ->andReturn($this->mCtxResultFactory);
        $this->mContext
            ->shouldReceive('getResultRedirectFactory')
            ->andReturn($this->mCtxResultRedirectFactory);
        /* setup context for \Magento\Framework\App\Action\Action */
        $this->mContext
            ->shouldReceive('getObjectManager')
            ->andReturn($this->mCtxObjectManager);
        $this->mContext
            ->shouldReceive('getEventManager')
            ->andReturn($this->mCtxEventManager);
        $this->mContext
            ->shouldReceive('getUrl')
            ->andReturn($this->mCtxUrl);
        $this->mContext
            ->shouldReceive('getActionFlag')
            ->andReturn($this->mCtxActionFlag);
        $this->mContext
            ->shouldReceive('getRedirect')
            ->andReturn($this->mCtxRedirect);
        $this->mContext
            ->shouldReceive('getView')
            ->andReturn($this->mCtxView);
        $this->mContext
            ->shouldReceive('getMessageManager')
            ->andReturn($this->mCtxMessageManager);
        /* setup context for \Magento\Backend\App\AbstractAction */
        $this->mContext
            ->shouldReceive('getAuthorization')
            ->andReturn($this->mCtxAuthorization);
        $this->mContext
            ->shouldReceive('getAuth')
            ->andReturn($this->mCtxAuth);
        $this->mContext
            ->shouldReceive('getHelper')
            ->andReturn($this->mCtxHelper);
        $this->mContext
            ->shouldReceive('getBackendUrl')
            ->andReturn($this->mCtxBackendUrl);
        $this->mContext
            ->shouldReceive('getFormKeyValidator')
            ->andReturn($this->mCtxFormKeyValidator);
        $this->mContext
            ->shouldReceive('getLocaleResolver')
            ->andReturn($this->mCtxView);
        $this->mContext
            ->shouldReceive('getCanUseBaseUrl')
            ->andReturn($this->mCtxCanUseBaseUrl);
        $this->mContext
            ->shouldReceive('getSession')
            ->andReturn($this->mCtxSession);
    }

}

/* create localization function stub */
if (!function_exists('__')) {
    include_once(__DIR__ . '/../../../../magento/magento2-base/app/functions.php');
}