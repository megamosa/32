<?php
/**
 * MagoArab WhatsApp Icon Extension
 * Admin Agents New Controller
 */

namespace MagoArab\WhatsappIcon\Controller\Adminhtml\Agents;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\LocalizedException;
use MagoArab\WhatsappIcon\Api\AgentRepositoryInterface;
use MagoArab\WhatsappIcon\Api\Data\AgentInterface;
use MagoArab\WhatsappIcon\Api\Data\AgentInterfaceFactory;
use Psr\Log\LoggerInterface;

class NewAction extends Action
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
     * @var AgentInterfaceFactory
     */
    protected $agentFactory;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param AgentRepositoryInterface $agentRepository
     * @param AgentInterfaceFactory $agentFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        AgentRepositoryInterface $agentRepository,
        AgentInterfaceFactory $agentFactory,
        LoggerInterface $logger
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->agentRepository = $agentRepository;
        $this->agentFactory = $agentFactory;
        $this->logger = $logger;
    }

    /**
     * Create new agent
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        
        try {
            $agentData = $this->getRequest()->getParams();
            
            // Validate required fields
            $this->validateAgentData($agentData);
            
            // Create new agent
            /** @var AgentInterface $agent */
            $agent = $this->agentFactory->create();
            $agent->setName($agentData['name']);
            $agent->setPhone($agentData['phone']);
            $agent->setTitle($agentData['title'] ?? '');
            $agent->setAvatarUrl($agentData['avatar_url'] ?? '');
            $agent->setStatus($agentData['status'] ?? 'online');
            $agent->setWorkingHours($agentData['working_hours'] ?? '09:00-17:00');
            $agent->setWorkingDays($agentData['working_days'] ?? 'monday,tuesday,wednesday,thursday,friday');
            $agent->setTimezone($agentData['timezone'] ?? 'UTC');
            $agent->setWelcomeMessage($agentData['welcome_message'] ?? '');
            $agent->setSortOrder($agentData['sort_order'] ?? 0);
            $agent->setIsActive($agentData['is_active'] ?? true);
            
            // Save agent
            $savedAgent = $this->agentRepository->save($agent);
            
            return $result->setData([
                'success' => true,
                'message' => __('Agent "%1" created successfully.', $savedAgent->getName()),
                'agent' => [
                    'agent_id' => $savedAgent->getAgentId(),
                    'name' => $savedAgent->getName(),
                    'phone' => $savedAgent->getPhone(),
                    'title' => $savedAgent->getTitle(),
                    'avatar_url' => $savedAgent->getAvatarUrl(),
                    'status' => $savedAgent->getStatus(),
                    'working_hours' => $savedAgent->getWorkingHours(),
                    'working_days' => $savedAgent->getWorkingDays(),
                    'timezone' => $savedAgent->getTimezone(),
                    'welcome_message' => $savedAgent->getWelcomeMessage(),
                    'sort_order' => $savedAgent->getSortOrder(),
                    'is_active' => $savedAgent->getIsActive()
                ]
            ]);
            
        } catch (LocalizedException $e) {
            $this->logger->error('Agent creation error: ' . $e->getMessage());
            return $result->setData([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        } catch (\Exception $e) {
            $this->logger->critical('Critical error creating agent: ' . $e->getMessage());
            return $result->setData([
                'success' => false,
                'message' => __('An error occurred while creating the agent. Please try again.')
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