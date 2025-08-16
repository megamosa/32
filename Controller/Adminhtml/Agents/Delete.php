<?php
/**
 * MagoArab WhatsApp Icon Extension
 * Admin Agents Delete Controller
 */

namespace MagoArab\WhatsappIcon\Controller\Adminhtml\Agents;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use MagoArab\WhatsappIcon\Api\AgentRepositoryInterface;
use Psr\Log\LoggerInterface;

class Delete extends Action
{
    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var AgentRepositoryInterface
     */
    protected $agentRepository;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param AgentRepositoryInterface $agentRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        AgentRepositoryInterface $agentRepository,
        LoggerInterface $logger
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->agentRepository = $agentRepository;
        $this->logger = $logger;
    }

    /**
     * Delete agent
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        
        try {
            $agentId = (int)$this->getRequest()->getParam('agent_id');
            
            if (!$agentId) {
                throw new LocalizedException(__('Agent ID is required.'));
            }
            
            // Get agent to verify it exists
            try {
                $agent = $this->agentRepository->getById($agentId);
                $agentName = $agent->getName();
            } catch (NoSuchEntityException $e) {
                throw new LocalizedException(__('Agent not found.'));
            }
            
            // Delete agent
            $this->agentRepository->deleteById($agentId);
            
            return $result->setData([
                'success' => true,
                'message' => __('Agent "%1" deleted successfully.', $agentName)
            ]);
            
        } catch (LocalizedException $e) {
            $this->logger->error('Agent delete error: ' . $e->getMessage());
            return $result->setData([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        } catch (\Exception $e) {
            $this->logger->critical('Critical error deleting agent: ' . $e->getMessage());
            return $result->setData([
                'success' => false,
                'message' => __('An error occurred while deleting the agent. Please try again.')
            ]);
        }
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