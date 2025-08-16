<?php
/**
 * MagoArab WhatsApp Icon Extension
 * 
 * @category    MagoArab
 * @package     MagoArab_WhatsappIcon
 * @author      MagoArab Development Team
 * @copyright   Copyright (c) 2024 MagoArab (https://magoarab.com)
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace MagoArab\WhatsappIcon\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Request\Http;
use MagoArab\WhatsappIcon\Api\AgentRepositoryInterface;
use Psr\Log\LoggerInterface;

class Data extends AbstractHelper
{
    const XML_PATH_ENABLED = 'magoarab_whatsapp/general/enabled';
    const XML_PATH_PHONE_NUMBER = 'magoarab_whatsapp/general/phone_number';
    const XML_PATH_DEFAULT_MESSAGE = 'magoarab_whatsapp/general/default_message';
    const XML_PATH_ICON_STYLE = 'magoarab_whatsapp/appearance/icon_style';
    const XML_PATH_ICON_POSITION = 'magoarab_whatsapp/appearance/icon_position';
    const XML_PATH_ICON_SIZE = 'magoarab_whatsapp/appearance/icon_size';
    const XML_PATH_ANIMATION_EFFECT = 'magoarab_whatsapp/appearance/animation_effect';
    const XML_PATH_SHOW_ON_PAGES = 'magoarab_whatsapp/display/show_on_pages';
    const XML_PATH_SPECIFIC_CMS_PAGES = 'magoarab_whatsapp/display/specific_cms_pages';
    const XML_PATH_ENABLE_SCHEDULING = 'magoarab_whatsapp/advanced/enable_scheduling';
    const XML_PATH_WORKING_HOURS_START = 'magoarab_whatsapp/advanced/working_hours_start';
    const XML_PATH_WORKING_HOURS_END = 'magoarab_whatsapp/advanced/working_hours_end';
    const XML_PATH_WORKING_DAYS = 'magoarab_whatsapp/advanced/working_days';
    const XML_PATH_MULTI_AGENT_ENABLED = 'magoarab_whatsapp/multi_agent/multi_agent_enabled';
    const XML_PATH_AGENTS_DATA = 'magoarab_whatsapp/advanced/agents_data';

    /**
     * @var TimezoneInterface
     */
    protected $timezone;

    /**
     * @var PageRepositoryInterface
     */
    protected $pageRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var Http
     */
    protected $request;

    /**
     * @var AgentRepositoryInterface
     */
    protected $agentRepository;

    /**
     * @var LoggerInterface
     */
    protected $_logger;

    /**
     * @param Context $context
     * @param TimezoneInterface $timezone
     * @param PageRepositoryInterface $pageRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param Http $request
     * @param AgentRepositoryInterface $agentRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        TimezoneInterface $timezone,
        PageRepositoryInterface $pageRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Http $request,
        AgentRepositoryInterface $agentRepository,
        LoggerInterface $logger
    ) {
        $this->timezone = $timezone;
        $this->pageRepository = $pageRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->request = $request;
        $this->agentRepository = $agentRepository;
        $this->_logger = $logger;
        parent::__construct($context);
    }

    /**
     * Check if WhatsApp icon is enabled
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isEnabled($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get WhatsApp phone number
     *
     * @param int|null $storeId
     * @return string
     */
    public function getPhoneNumber($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_PHONE_NUMBER,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get default message
     *
     * @param int|null $storeId
     * @return string
     */
    public function getDefaultMessage($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_DEFAULT_MESSAGE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get icon style
     *
     * @param int|null $storeId
     * @return string
     */
    public function getIconStyle($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ICON_STYLE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get icon position
     *
     * @param int|null $storeId
     * @return string
     */
    public function getIconPosition($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ICON_POSITION,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get icon size
     *
     * @param int|null $storeId
     * @return string
     */
    public function getIconSize($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ICON_SIZE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get animation effect
     *
     * @param int|null $storeId
     * @return string
     */
    public function getAnimationEffect($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ANIMATION_EFFECT,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get show on pages setting
     *
     * @param int|null $storeId
     * @return string
     */
    public function getShowOnPages($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SHOW_ON_PAGES,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get specific CMS pages
     *
     * @param int|null $storeId
     * @return array
     */
    public function getSpecificCmsPages($storeId = null)
    {
        $pages = $this->scopeConfig->getValue(
            self::XML_PATH_SPECIFIC_CMS_PAGES,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
        return $pages ? explode(',', $pages) : [];
    }

    /**
     * Check if scheduling is enabled
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isSchedulingEnabled($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ENABLE_SCHEDULING,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Check if multi-agent is enabled
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isMultiAgentEnabled($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_MULTI_AGENT_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get agents data
     *
     * @param int|null $storeId
     * @return array
     */
    public function getAgentsData($storeId = null)
    {
        $agentsJson = $this->scopeConfig->getValue(
            self::XML_PATH_AGENTS_DATA,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
        
        if ($agentsJson) {
            try {
                return json_decode($agentsJson, true) ?: [];
            } catch (\Exception $e) {
                return [];
            }
        }
        
        return [];
    }

    /**
     * Check if WhatsApp icon should be displayed based on current time and working hours
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isWithinWorkingHours($storeId = null)
    {
        if (!$this->isSchedulingEnabled($storeId)) {
            return true;
        }

        $currentTime = $this->timezone->date();
        $currentDay = $currentTime->format('N'); // 1 (Monday) to 7 (Sunday)
        $currentHour = $currentTime->format('H:i');

        // Check working days
        $workingDays = $this->scopeConfig->getValue(
            self::XML_PATH_WORKING_DAYS,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
        
        if ($workingDays) {
            $workingDaysArray = explode(',', $workingDays);
            if (!in_array($currentDay, $workingDaysArray)) {
                return false;
            }
        }

        // Check working hours
        $startTime = $this->scopeConfig->getValue(
            self::XML_PATH_WORKING_HOURS_START,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
        
        $endTime = $this->scopeConfig->getValue(
            self::XML_PATH_WORKING_HOURS_END,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

        if ($startTime && $endTime) {
            return ($currentHour >= $startTime && $currentHour <= $endTime);
        }

        return true;
    }

    /**
     * Check if WhatsApp icon should be displayed on current page
     *
     * @param int|null $storeId
     * @return bool
     */
    public function shouldDisplayOnCurrentPage($storeId = null)
    {
        $showOnPages = $this->getShowOnPages($storeId);
        $fullActionName = $this->request->getFullActionName();
        $currentPageId = $this->request->getParam('page_id');
        
        // Debug logging
        $this->_logger->info('WhatsApp Display Check', [
            'show_on_pages' => $showOnPages,
            'full_action_name' => $fullActionName,
            'current_page_id' => $currentPageId,
            'current_url' => $this->request->getUriString()
        ]);
        
        switch ($showOnPages) {
            case 'all_pages':
                return true;
                
            case 'specific_cms':
                $specificPages = $this->getSpecificCmsPages($storeId);
                $result = in_array($currentPageId, $specificPages);
                $this->_logger->info('Specific CMS Check', [
                    'specific_pages' => $specificPages,
                    'current_page_id' => $currentPageId,
                    'result' => $result
                ]);
                return $result;
                
            case 'category_product':
                $result = in_array($fullActionName, [
                    'catalog_category_view',
                    'catalog_product_view'
                ]);
                $this->_logger->info('Category/Product Check', [
                    'full_action_name' => $fullActionName,
                    'result' => $result
                ]);
                return $result;
                
            default:
                $this->_logger->info('Default case - returning false');
                return false;
        }
    }

    /**
     * Get WhatsApp URL
     *
     * @param string|null $phoneNumber
     * @param string|null $message
     * @return string
     */
    public function getWhatsAppUrl($phoneNumber = null, $message = null)
    {
        $phone = $phoneNumber ?: $this->getPhoneNumber();
        $msg = $message ?: $this->getDefaultMessage();
        
        $phone = preg_replace('/[^0-9+]/', '', $phone);
        $encodedMessage = urlencode($msg);
        
        return "https://wa.me/{$phone}?text={$encodedMessage}";
    }

    /**
     * Get current agent for multi-agent support
     *
     * @param int|null $storeId
     * @return array|null
     */
    public function getCurrentAgent($storeId = null)
    {
        if (!$this->isMultiAgentEnabled($storeId)) {
            return null;
        }
        
        try {
            $agent = $this->agentRepository->getCurrentAgent();
            if ($agent) {
                return [
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
        } catch (\Exception $e) {
            // Log error if needed
        }
        
        return null;
    }

    /**
     * Get all agents for multi-agent support
     *
     * @param int|null $storeId
     * @return array
     */
    public function getAgents($storeId = null)
    {
        if (!$this->isMultiAgentEnabled($storeId)) {
            return [];
        }
        
        try {
            $searchCriteria = $this->searchCriteriaBuilder->create();
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
     * Get default agent name
     *
     * @return string
     */
    public function getDefaultAgentName()
    {
        return __('Support Agent');
    }
}