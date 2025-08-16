<?php
/**
 * MagoArab WhatsApp Icon Extension
 * WhatsApp Icon Block
 */

namespace MagoArab\WhatsappIcon\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use MagoArab\WhatsappIcon\Helper\Data as WhatsappHelper;
use Psr\Log\LoggerInterface;

class WhatsappIcon extends Template
{
    /**
     * @var WhatsappHelper
     */
    protected $whatsappHelper;

    /**
     * @var LoggerInterface
     */
    protected $_logger;

    /**
     * @param Context $context
     * @param WhatsappHelper $whatsappHelper
     * @param LoggerInterface $logger
     * @param array $data
     */
    public function __construct(
        Context $context,
        WhatsappHelper $whatsappHelper,
        LoggerInterface $logger,
        array $data = []
    ) {
        $this->whatsappHelper = $whatsappHelper;
        $this->_logger = $logger;
        parent::__construct($context, $data);
    }

    /**
     * Check if WhatsApp icon should be displayed
     *
     * @return bool
     */
    public function canShowWhatsappIcon()
    {
        $isEnabled = $this->whatsappHelper->isEnabled();
        $isWithinWorkingHours = $this->whatsappHelper->isWithinWorkingHours();
        $shouldDisplayOnCurrentPage = $this->whatsappHelper->shouldDisplayOnCurrentPage();
        $phoneNumber = $this->whatsappHelper->getPhoneNumber();
        
        // Debug logging
        $this->_logger->info('WhatsApp Icon Debug', [
            'is_enabled' => $isEnabled,
            'is_within_working_hours' => $isWithinWorkingHours,
            'should_display_on_current_page' => $shouldDisplayOnCurrentPage,
            'phone_number' => $phoneNumber ?: 'Not set',
            'current_url' => $this->_urlBuilder->getCurrentUrl(),
            'full_action_name' => $this->_request->getFullActionName()
        ]);
        
        return $isEnabled && $isWithinWorkingHours && $shouldDisplayOnCurrentPage && $phoneNumber;
    }

    /**
     * Get WhatsApp helper
     *
     * @return WhatsappHelper
     */
    public function getWhatsappHelper()
    {
        return $this->whatsappHelper;
    }

    /**
     * Get WhatsApp URL
     *
     * @return string
     */
    public function getWhatsappUrl()
    {
        $agent = $this->whatsappHelper->getCurrentAgent();
        
        if ($agent && isset($agent['phone'])) {
            $message = $this->whatsappHelper->getDefaultMessage();
            if (isset($agent['name'])) {
                $message = sprintf(__('Hello %s! '), $agent['name']) . $message;
            }
            return $this->whatsappHelper->getWhatsAppUrl($agent['phone'], $message);
        }
        
        return $this->whatsappHelper->getWhatsAppUrl();
    }

    /**
     * Get icon configuration as JSON
     *
     * @return string
     */
    public function getIconConfigJson()
    {
        $config = [
            'style' => $this->whatsappHelper->getIconStyle(),
            'position' => $this->whatsappHelper->getIconPosition(),
            'size' => $this->whatsappHelper->getIconSize(),
            'animation' => $this->whatsappHelper->getAnimationEffect(),
            'url' => $this->getWhatsappUrl(),
            'message' => $this->whatsappHelper->getDefaultMessage()
        ];
        
        return json_encode($config);
    }

    /**
     * Get current agent info
     *
     * @return array|null
     */
    public function getCurrentAgent()
    {
        return $this->whatsappHelper->getCurrentAgent();
    }

    /**
     * Get all agents
     *
     * @return array
     */
    public function getAgents()
    {
        return $this->whatsappHelper->getAgents();
    }
}