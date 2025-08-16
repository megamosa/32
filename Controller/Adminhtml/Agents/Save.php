<?php
/**
 * MagoArab WhatsApp Icon Extension
 * Admin Agents Save Controller
 */

namespace MagoArab\WhatsappIcon\Controller\Adminhtml\Agents;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\LocalizedException;
use MagoArab\WhatsappIcon\Api\AgentRepositoryInterface;
use MagoArab\WhatsappIcon\Api\Data\AgentInterface;
use MagoArab\WhatsappIcon\Api\Data\AgentInterfaceFactory;
use Magento\Framework\Serialize\Serializer\Json;
use Psr\Log\LoggerInterface;

class Save extends Action
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
     * @var Json
     */
    protected $json;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param AgentRepositoryInterface $agentRepository
     * @param AgentInterfaceFactory $agentFactory
     * @param Json $json
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        AgentRepositoryInterface $agentRepository,
        AgentInterfaceFactory $agentFactory,
        Json $json,
        LoggerInterface $logger
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->agentRepository = $agentRepository;
        $this->agentFactory = $agentFactory;
        $this->json = $json;
        $this->logger = $logger;
    }

    /**
     * Save agents data
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        
        try {
            $agents = $this->getRequest()->getParam('agents');
            
            if ($agents) {
                // Validate and decode JSON
                try {
                    $agentsArray = $this->json->unserialize($agents);
                } catch (\Exception $e) {
                    throw new LocalizedException(__('Invalid JSON format for agents data.'));
                }
                
                // Clear existing agents first
                $this->clearAllAgents();
                
                $savedCount = 0;
                
                // Save each agent
                foreach ($agentsArray as $agentData) {
                    $this->validateAgentData($agentData);
                    
                    /** @var AgentInterface $agent */
                    $agent = \Magento\Framework\App\ObjectManager::getInstance()->create(\MagoArab\WhatsappIcon\Model\Agent::class);
                    $agent->setName($agentData['name']);
                    $agent->setPhone($agentData['phone']);
                    $agent->setTitle($agentData['title'] ?? '');
                    $agent->setAvatarUrl($agentData['avatar_url'] ?? ''); // Fixed field name
                    $agent->setStatus($agentData['status'] ?? 'online');
                    $agent->setWorkingHours($agentData['working_hours'] ?? '09:00-17:00');
                    $agent->setWorkingDays($agentData['working_days'] ?? 'monday,tuesday,wednesday,thursday,friday');
                    $agent->setTimezone($agentData['timezone'] ?? 'UTC');
                    $agent->setWelcomeMessage($agentData['welcome_message'] ?? '');
                    $agent->setSortOrder($agentData['sort_order'] ?? 0);
                    $agent->setIsActive($agentData['is_active'] ?? true);
                    
                    $this->agentRepository->save($agent);
                    $savedCount++;
                }
                
                return $result->setData([
                    'success' => true,
                    'message' => __('%1 agent(s) saved successfully.', $savedCount)
                ]);
            } else {
                // Clear all agents
                $deletedCount = $this->clearAllAgents();
                
                return $result->setData([
                    'success' => true,
                    'message' => __('%1 agent(s) cleared successfully.', $deletedCount)
                ]);
            }
        } catch (LocalizedException $e) {
            $this->logger->error('Agent save error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return $result->setData([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        } catch (\Exception $e) {
            $this->logger->critical('Critical error saving agents: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return $result->setData([
                'success' => false,
                'message' => __('An error occurred while saving agents. Please try again. Error: %1', $e->getMessage())
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
            throw new LocalizedException(__('Invalid phone number format for agent: %1', $agentData['name']));
        }
        
        // Validate working hours format
        if (!empty($agentData['working_hours'])) {
            if (!preg_match('/^\d{2}:\d{2}-\d{2}:\d{2}$/', $agentData['working_hours'])) {
                throw new LocalizedException(__('Invalid working hours format for agent: %1. Use HH:MM-HH:MM format.', $agentData['name']));
            }
        }
    }

    /**
     * Clear all existing agents
     *
     * @return int Number of deleted agents
     */
    private function clearAllAgents()
    {
        try {
            $searchCriteria = $this->agentRepository->getList();
            $agents = $searchCriteria->getItems();
            $deletedCount = 0;
            
            foreach ($agents as $agent) {
                $this->agentRepository->delete($agent);
                $deletedCount++;
            }
            
            return $deletedCount;
        } catch (\Exception $e) {
            $this->logger->error('Error clearing agents: ' . $e->getMessage());
            return 0;
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
