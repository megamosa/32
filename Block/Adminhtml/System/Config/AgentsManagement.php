<?php
/**
 * MagoArab WhatsApp Icon Extension
 * Agents Management Block for Admin Configuration
 */

namespace MagoArab\WhatsappIcon\Block\Adminhtml\System\Config;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use MagoArab\WhatsappIcon\Api\AgentRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

class AgentsManagement extends Field
{
    /**
     * @var string
     */
    protected $_template = 'MagoArab_WhatsappIcon::system/config/agents_management.phtml';

    /**
     * @var AgentRepositoryInterface
     */
    protected $agentRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @param Context $context
     * @param AgentRepositoryInterface $agentRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param array $data
     */
    public function __construct(
        Context $context,
        AgentRepositoryInterface $agentRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        array $data = []
    ) {
        $this->agentRepository = $agentRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        parent::__construct($context, $data);
    }

    /**
     * Remove scope label
     *
     * @param  AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    /**
     * Return element html
     *
     * @param  AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        return $this->_toHtml();
    }

    /**
     * Get agents management URL
     *
     * @return string
     */
    public function getAgentsManagementUrl()
    {
        return $this->getUrl('magoarab_whatsapp/agents/index');
    }

    /**
     * Get agents count
     *
     * @return int
     */
    public function getAgentsCount()
    {
        try {
            $searchCriteria = $this->searchCriteriaBuilder->create();
            $agents = $this->agentRepository->getList($searchCriteria);
            return count($agents->getItems());
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Get recent agents (limit 5)
     *
     * @return array
     */
    public function getRecentAgents()
    {
        try {
            $searchCriteria = $this->searchCriteriaBuilder
                ->setPageSize(5)
                ->setCurrentPage(1)
                ->create();
            $agents = $this->agentRepository->getList($searchCriteria);
            
            $agentsArray = [];
            foreach ($agents->getItems() as $agent) {
                $agentsArray[] = [
                    'name' => $agent->getName(),
                    'phone' => $agent->getPhone(),
                    'status' => $agent->getStatus(),
                    'is_active' => $agent->getIsActive()
                ];
            }
            
            return $agentsArray;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Check if multi-agent is enabled
     *
     * @return bool
     */
    public function isMultiAgentEnabled()
    {
        return $this->_scopeConfig->isSetFlag(
            'magoarab_whatsapp/multi_agent/multi_agent_enabled',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}