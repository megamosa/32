<?php
/**
 * MagoArab WhatsApp Icon Extension
 * Agent Repository Interface
 */

namespace MagoArab\WhatsappIcon\Api;

use MagoArab\WhatsappIcon\Api\Data\AgentInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

interface AgentRepositoryInterface
{
    /**
     * Save agent
     *
     * @param AgentInterface $agent
     * @return AgentInterface
     * @throws LocalizedException
     */
    public function save(AgentInterface $agent);

    /**
     * Get agent by ID
     *
     * @param int $agentId
     * @return AgentInterface
     * @throws NoSuchEntityException
     */
    public function getById($agentId);

    /**
     * Get agents list
     *
     * @param SearchCriteriaInterface $criteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria);

    /**
     * Delete agent
     *
     * @param AgentInterface $agent
     * @return bool
     * @throws LocalizedException
     */
    public function delete(AgentInterface $agent);

    /**
     * Delete agent by ID
     *
     * @param int $agentId
     * @return bool
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function deleteById($agentId);

    /**
     * Get current available agent
     *
     * @return AgentInterface|null
     */
    public function getCurrentAgent();
}
