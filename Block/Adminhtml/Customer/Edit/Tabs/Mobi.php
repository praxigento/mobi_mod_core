<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2018
 */

namespace Praxigento\Core\Block\Adminhtml\Customer\Edit\Tabs;

/**
 * Tab to add more MOBI related fields to customer details form.
 *
 * @see \Magento\Customer\Block\Adminhtml\Edit\Tab\View
 */
class Mobi
    extends \Magento\Backend\Block\Template
    implements \Magento\Ui\Component\Layout\Tabs\TabInterface
{

    public function canShowTab()
    {
        return true;
    }

    public function getTabClass()
    {
        return '';
    }

    public function getTabLabel()
    {
        return __('MOBI Info');
    }

    public function getTabTitle()
    {
        return __('MOBI Info');
    }

    public function getTabUrl()
    {
        return '';
    }

    public function isAjaxLoaded()
    {
        return false;
    }

    public function isHidden()
    {
        $result = !$this->canShowTab();
        return $result;
    }
}