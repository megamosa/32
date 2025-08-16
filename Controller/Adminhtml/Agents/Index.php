<?php
/**
 * MagoArab WhatsApp Icon Extension
 * Admin Agents Controller
 */

namespace MagoArab\WhatsappIcon\Controller\Adminhtml\Agents;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Agents list page
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('MagoArab_WhatsappIcon::agents');
        $resultPage->addBreadcrumb(__('WhatsApp Icon'), __('WhatsApp Icon'));
        $resultPage->addBreadcrumb(__('Manage Agents'), __('Manage Agents'));
        $resultPage->getConfig()->getTitle()->prepend(__('Manage WhatsApp Agents'));

        return $resultPage;
    }

    /**
     * Check if user has permissions to access this controller
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('MagoArab_WhatsappIcon::config');
    }
}
