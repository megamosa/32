<?php
/**
 * MagoArab WhatsApp Icon Extension
 * Admin Agents Block
 */

namespace MagoArab\WhatsappIcon\Block\Adminhtml;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use MagoArab\WhatsappIcon\Api\AgentRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;

class Agents extends Template
{
    /**
     * @var AgentRepositoryInterface
     */
    protected $agentRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var SortOrderBuilder
     */
    protected $sortOrderBuilder;

    /**
     * @param Context $context
     * @param AgentRepositoryInterface $agentRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     * @param array $data
     */
    public function __construct(
        Context $context,
        AgentRepositoryInterface $agentRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder,
        array $data = []
    ) {
        $this->agentRepository = $agentRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        parent::__construct($context, $data);
    }

    /**
     * Get agents data
     *
     * @return array
     */
    public function getAgents()
    {
        try {
            // Create sort orders
            $sortOrderSort = $this->sortOrderBuilder
                ->setField('sort_order')
                ->setDirection('ASC')
                ->create();
            
            $sortOrderName = $this->sortOrderBuilder
                ->setField('name')
                ->setDirection('ASC')
                ->create();
            
            // Build search criteria with sorting
            $searchCriteria = $this->searchCriteriaBuilder
                ->addSortOrder($sortOrderSort)
                ->addSortOrder($sortOrderName)
                ->create();
            
            $agents = $this->agentRepository->getList($searchCriteria);
            $agentsData = [];
            
            foreach ($agents->getItems() as $agent) {
                $agentsData[] = [
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
                ];
            }
            
            return $agentsData;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Get save URL
     *
     * @return string
     */
    public function getSaveUrl()
    {
        return $this->getUrl('magoarab_whatsapp/agents/save');
    }

    /**
     * Get delete URL
     *
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('magoarab_whatsapp/agents/delete');
    }
}
