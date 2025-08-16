<?php
/**
 * MagoArab WhatsApp Icon Extension
 * Admin Agents Edit Controller
 */

namespace MagoArab\WhatsappIcon\Controller\Adminhtml\Agents;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use MagoArab\WhatsappIcon\Api\AgentRepositoryInterface;
use MagoArab\WhatsappIcon\Api\Data\AgentInterface;
use Psr\Log\LoggerInterface;

class Edit extends Action
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
     * Edit agent data
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        
        try {
            $agentId = (int)$this->getRequest()->getParam('agent_id');
            $agentData = $this->getRequest()->getParams();
            
            if (!$agentId) {
                throw new LocalizedException(__('Agent ID is required.'));
            }
            
            // Get existing agent
            try {
                $agent = $this->agentRepository->getById($agentId);
            } catch (NoSuchEntityException $e) {
                throw new LocalizedException(__('Agent not found.'));
            }
            
            // Validate required fields
            $this->validateAgentData($agentData);
            
            // Update agent data
            $agent->setName($agentData['name']);
            $agent->setPhone($agentData['phone']);
            $agent->setTitle($agentData['title'] ?? $agent->getTitle());
            $agent->setAvatarUrl($agentData['avatar_url'] ?? $agent->getAvatarUrl());
            $agent->setStatus($agentData['status'] ?? $agent->getStatus());
            $agent->setWorkingHours($agentData['working_hours'] ?? $agent->getWorkingHours());
            $agent->setWorkingDays($agentData['working_days'] ?? $agent->getWorkingDays());
            $agent->setTimezone($agentData['timezone'] ?? $agent->getTimezone());
            $agent->setWelcomeMessage($agentData['welcome_message'] ?? $agent->getWelcomeMessage());
            $agent->setSortOrder($agentData['sort_order'] ?? $agent->getSortOrder());
            $agent->setIsActive($agentData['is_active'] ?? $agent->getIsActive());
            
            // Save agent
            $this->agentRepository->save($agent);
            
            return $result->setData([
                'success' => true,
                'message' => __('Agent updated successfully.'),
                'agent' => [
                    'agent_id' => $agent->getAgentId(),
                    'name' => $agent->getName(),
                    'phone' => $agent->getPhone(),
                    'title' => $agent->getTitle(),
                    'avatar_url' => $agent->getAvatarUrl(),
                    'status' => $agent->getStatus(),
                    'working_hours' => $agent->getWorkingHours(),
                    'working_days' => $agent->getWorkingDays(),
                    'timezone' => $agent->getTimezone(),
                    'welcome_message' => $agent->getWelcomeMessage(),
                    'sort_order' => $agent->getSortOrder(),
                    'is_active' => $agent->getIsActive()
                ]
            ]);
            
        } catch (LocalizedException $e) {
            $this->logger->error('Agent edit error: ' . $e->getMessage());
            return $result->setData([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        } catch (\Exception $e) {
            $this->logger->critical('Critical error editing agent: ' . $e->getMessage());
            return $result->setData([
                'success' => false,
                'message' => __('An error occurred while updating the agent. Please try again.')
            ]);
        }
    }

    /**
     * Validate agent data
     *
     * @param array $agentData
     * @throws LocalizedException
     */
    private function validateAgentData(array $agentData)
    {
        if (empty($agentData['name'])) {
            throw new LocalizedException(__('Agent name is required.'));
        }
        
        if (empty($agentData['phone'])) {
            throw new LocalizedException(__('Agent phone is required.'));
        }
        
        // Validate phone format (basic validation)
        $phone = preg_replace('/[^0-9+]/', '', $agentData['phone']);
        if (strlen($phone) < 10) {
            throw new LocalizedException(__('Invalid phone number format.'));
        }
        
        // Validate working hours format
        if (!empty($agentData['working_hours'])) {
            if (!preg_match('/^\d{2}:\d{2}-\d{2}:\d{2}$/', $agentData['working_hours'])) {
                throw new LocalizedException(__('Invalid working hours format. Use HH:MM-HH:MM format.'));
            }
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