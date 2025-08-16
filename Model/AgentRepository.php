<?php
/**
 * MagoArab WhatsApp Icon Extension
 * Agent Repository
 */

namespace MagoArab\WhatsappIcon\Model;

use MagoArab\WhatsappIcon\Api\AgentRepositoryInterface;
use MagoArab\WhatsappIcon\Api\Data\AgentInterface;
use MagoArab\WhatsappIcon\Model\ResourceModel\Agent as AgentResource;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\ObjectManagerInterface;

class AgentRepository implements AgentRepositoryInterface
{
    /**
     * @var AgentResource
     */
    protected $resource;

    /**
     * @var SearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @param AgentResource $resource
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        AgentResource $resource,
        SearchResultsInterfaceFactory $searchResultsFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->resource = $resource;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * Save agent with validation
     *
     * @param \MagoArab\WhatsappIcon\Api\Data\AgentInterface $agent
     * @return \MagoArab\WhatsappIcon\Api\Data\AgentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\MagoArab\WhatsappIcon\Api\Data\AgentInterface $agent)
    {
        try {
            // Additional business logic validation
            $this->validateBusinessRules($agent);
            
            $this->resource->save($agent);
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            throw $e;
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the agent: %1', $exception->getMessage()),
                $exception
            );
        }
        return $agent;
    }
    
    /**
     * Validate business rules
     *
     * @param \MagoArab\WhatsappIcon\Api\Data\AgentInterface $agent
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function validateBusinessRules($agent)
    {
        // Check for duplicate phone numbers
        if ($this->isDuplicatePhone($agent)) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('An agent with this phone number already exists.')
            );
        }
        
        // Check for duplicate names
        if ($this->isDuplicateName($agent)) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('An agent with this name already exists.')
            );
        }
    }
    
    /**
     * Check for duplicate phone number
     *
     * @param \MagoArab\WhatsappIcon\Api\Data\AgentInterface $agent
     * @return bool
     */
    private function isDuplicatePhone($agent)
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('phone', $agent->getPhone())
            ->create();
            
        if ($agent->getAgentId()) {
            $searchCriteria = $this->searchCriteriaBuilder
                ->addFilter('phone', $agent->getPhone())
                ->addFilter('agent_id', $agent->getAgentId(), 'neq')
                ->create();
        }
        
        $result = $this->getList($searchCriteria);
        return $result->getTotalCount() > 0;
    }
    
    /**
     * Check for duplicate name
     *
     * @param \MagoArab\WhatsappIcon\Api\Data\AgentInterface $agent
     * @return bool
     */
    private function isDuplicateName($agent)
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('name', $agent->getName())
            ->create();
            
        if ($agent->getAgentId()) {
            $searchCriteria = $this->searchCriteriaBuilder
                ->addFilter('name', $agent->getName())
                ->addFilter('agent_id', $agent->getAgentId(), 'neq')
                ->create();
        }
        
        $result = $this->getList($searchCriteria);
        return $result->getTotalCount() > 0;
    }

    /**
     * Get agent by ID
     *
     * @param int $agentId
     * @return AgentInterface
     * @throws NoSuchEntityException
     */
    public function getById($agentId)
    {
        $agent = \Magento\Framework\App\ObjectManager::getInstance()->create(\MagoArab\WhatsappIcon\Model\Agent::class);
        $this->resource->load($agent, $agentId);
        if (!$agent->getId()) {
            throw new NoSuchEntityException(__('Agent with id "%1" does not exist.', $agentId));
        }
        return $agent;
    }

    /**
     * Get agents list
     *
     * @param SearchCriteriaInterface $criteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria)
    {
        $collection = \Magento\Framework\App\ObjectManager::getInstance()->create(\MagoArab\WhatsappIcon\Model\ResourceModel\Agent\Collection::class);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        // Apply filters from search criteria
        $filterGroups = $criteria->getFilterGroups();
        if ($filterGroups) {
            foreach ($filterGroups as $filterGroup) {
                $filters = $filterGroup->getFilters();
                if ($filters) {
                    foreach ($filters as $filter) {
                        $condition = [$filter->getConditionType() => $filter->getValue()];
                        $collection->addFieldToFilter($filter->getField(), $condition);
                    }
                }
            }
        }
        
        // Apply sorting
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    $sortOrder->getDirection()
                );
            }
        }
        
        // Apply pagination
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($collection->getItems());
        
        return $searchResults;
    }

    /**
     * Delete agent
     *
     * @param AgentInterface $agent
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(AgentInterface $agent)
    {
        try {
            $this->resource->delete($agent);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Delete agent by ID
     *
     * @param int $agentId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($agentId)
    {
        return $this->delete($this->getById($agentId));
    }

    /**
     * Get all agents
     *
     * @return array
     */
    public function getAllAgents()
    {
        try {
            $searchCriteria = $this->searchCriteriaBuilder->create();
            $agents = $this->getList($searchCriteria);
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
     * Get current agent
     *
     * @return AgentInterface|null
     */
    public function getCurrentAgent()
    {
        $collection = \Magento\Framework\App\ObjectManager::getInstance()->create(\MagoArab\WhatsappIcon\Model\ResourceModel\Agent\Collection::class);
        $collection->addActiveFilter()
                  ->addStatusFilter('online')
                  ->addSortOrderFilter()
                  ->setPageSize(1);
        
        return $collection->getFirstItem()->getId() ? $collection->getFirstItem() : null;
    }
}
