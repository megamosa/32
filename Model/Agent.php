<?php
/**
 * MagoArab WhatsApp Icon Extension
 * Agent Model
 */

namespace MagoArab\WhatsappIcon\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;
use MagoArab\WhatsappIcon\Api\Data\AgentInterface;

class Agent extends AbstractModel implements AgentInterface, IdentityInterface
{
    const CACHE_TAG = 'magoarab_whatsapp_agent';
    
    const STATUS_ONLINE = 'online';
    const STATUS_OFFLINE = 'offline';
    const STATUS_BUSY = 'busy';
    
    // Constants from interface
    const AGENT_ID = 'agent_id';
    const NAME = 'name';
    const PHONE = 'phone';
    const TITLE = 'title';
    const AVATAR_URL = 'avatar_url';
    const STATUS = 'status';
    const WORKING_HOURS = 'working_hours';
    const WORKING_DAYS = 'working_days';
    const TIMEZONE = 'timezone';
    const WELCOME_MESSAGE = 'welcome_message';
    const SORT_ORDER = 'sort_order';
    const IS_ACTIVE = 'is_active';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    protected $_cacheTag = 'magoarab_whatsapp_agent';
    protected $_eventPrefix = 'magoarab_whatsapp_agent';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\MagoArab\WhatsappIcon\Model\ResourceModel\Agent::class);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get agent ID
     *
     * @return int|null
     */
    public function getAgentId()
    {
        return $this->getData(self::AGENT_ID);
    }

    /**
     * Set agent ID
     *
     * @param int $agentId
     * @return $this
     */
    public function setAgentId($agentId)
    {
        return $this->setData(self::AGENT_ID, $agentId);
    }

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * Set name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Get phone
     *
     * @return string|null
     */
    public function getPhone()
    {
        return $this->getData(self::PHONE);
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return $this
     */
    public function setPhone($phone)
    {
        return $this->setData(self::PHONE, $phone);
    }

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Get avatar URL
     *
     * @return string|null
     */
    public function getAvatarUrl()
    {
        return $this->getData(self::AVATAR_URL);
    }

    /**
     * Set avatar URL
     *
     * @param string $avatarUrl
     * @return $this
     */
    public function setAvatarUrl($avatarUrl)
    {
        return $this->setData(self::AVATAR_URL, $avatarUrl);
    }

    /**
     * Get status
     *
     * @return string|null
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Set status
     *
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Get working hours
     *
     * @return string|null
     */
    public function getWorkingHours()
    {
        return $this->getData(self::WORKING_HOURS);
    }

    /**
     * Set working hours
     *
     * @param string $workingHours
     * @return $this
     */
    public function setWorkingHours($workingHours)
    {
        return $this->setData(self::WORKING_HOURS, $workingHours);
    }

    /**
     * Get working days
     *
     * @return string|null
     */
    public function getWorkingDays()
    {
        return $this->getData(self::WORKING_DAYS);
    }

    /**
     * Set working days
     *
     * @param string $workingDays
     * @return $this
     */
    public function setWorkingDays($workingDays)
    {
        return $this->setData(self::WORKING_DAYS, $workingDays);
    }

    /**
     * Get timezone
     *
     * @return string|null
     */
    public function getTimezone()
    {
        return $this->getData(self::TIMEZONE);
    }

    /**
     * Set timezone
     *
     * @param string $timezone
     * @return $this
     */
    public function setTimezone($timezone)
    {
        return $this->setData(self::TIMEZONE, $timezone);
    }

    /**
     * Get welcome message
     *
     * @return string|null
     */
    public function getWelcomeMessage()
    {
        return $this->getData(self::WELCOME_MESSAGE);
    }

    /**
     * Set welcome message
     *
     * @param string $welcomeMessage
     * @return $this
     */
    public function setWelcomeMessage($welcomeMessage)
    {
        return $this->setData(self::WELCOME_MESSAGE, $welcomeMessage);
    }

    /**
     * Get sort order
     *
     * @return int
     */
    public function getSortOrder()
    {
        return $this->getData(self::SORT_ORDER);
    }

    /**
     * Set sort order
     *
     * @param int $sortOrder
     * @return $this
     */
    public function setSortOrder($sortOrder)
    {
        return $this->setData(self::SORT_ORDER, $sortOrder);
    }

    /**
     * Get is active
     *
     * @return bool
     */
    public function getIsActive()
    {
        return (bool) $this->getData(self::IS_ACTIVE);
    }

    /**
     * Set is active
     *
     * @param bool $isActive
     * @return $this
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * Get created at
     *
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set created at
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Get updated at
     *
     * @return string|null
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * Set updated at
     *
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * Check if agent is currently available
     *
     * @return bool
     */
    public function isAvailable()
    {
        if (!$this->getIsActive() || $this->getStatus() === self::STATUS_OFFLINE) {
            return false;
        }

        // Check working hours and days
        $workingHours = $this->getWorkingHours();
        $workingDays = $this->getWorkingDays();
        
        if (empty($workingHours) || empty($workingDays)) {
            return true; // Available 24/7 if no restrictions
        }

        $timezone = $this->getTimezone() ?: 'UTC';
        $now = new \DateTime('now', new \DateTimeZone($timezone));
        $currentDay = strtolower($now->format('l'));
        $currentTime = $now->format('H:i');

        // Check if today is a working day
        $workingDaysArray = explode(',', $workingDays);
        if (!in_array($currentDay, $workingDaysArray)) {
            return false;
        }

        // Check if current time is within working hours
        if ($workingHours && strpos($workingHours, '-') !== false) {
            $hours = explode('-', $workingHours);
            if (count($hours) === 2) {
                $startTime = trim($hours[0]);
                $endTime = trim($hours[1]);
                return $currentTime >= $startTime && $currentTime <= $endTime;
            }
        }

        return true;
    }

    /**
     * Get available status options
     *
     * @return array
     */
    public static function getStatusOptions()
    {
        return [
            self::STATUS_ONLINE => __('Online'),
            self::STATUS_OFFLINE => __('Offline'),
            self::STATUS_BUSY => __('Busy')
        ];
    }

    /**
     * Validate agent data before save
     *
     * @return array
     */
    public function validateData()
    {
        $errors = [];
        
        // Validate name
        if (!$this->getName() || trim($this->getName()) === '') {
            $errors[] = __('Agent name is required.');
        } elseif (strlen(trim($this->getName())) < 2) {
            $errors[] = __('Agent name must be at least 2 characters long.');
        } elseif (strlen(trim($this->getName())) > 100) {
            $errors[] = __('Agent name cannot exceed 100 characters.');
        }
        
        // Validate phone number
        if (!$this->getPhone() || trim($this->getPhone()) === '') {
            $errors[] = __('Phone number is required.');
        } elseif (!$this->isValidPhoneNumber($this->getPhone())) {
            $errors[] = __('Please enter a valid phone number with country code (e.g., +1234567890).');
        }
        
        // Validate title
        if ($this->getTitle() && strlen(trim($this->getTitle())) > 150) {
            $errors[] = __('Agent title cannot exceed 150 characters.');
        }
        
        // Validate avatar URL
        if ($this->getAvatarUrl() && !$this->isValidUrl($this->getAvatarUrl())) {
            $errors[] = __('Please enter a valid avatar URL.');
        }
        
        // Validate status
        if ($this->getStatus() && !in_array($this->getStatus(), array_keys(self::getStatusOptions()))) {
            $errors[] = __('Invalid status selected.');
        }
        
        // Validate working hours format
        if ($this->getWorkingHours() && !$this->isValidWorkingHours($this->getWorkingHours())) {
            $errors[] = __('Please enter valid working hours in HH:MM-HH:MM format.');
        }
        
        // Validate timezone
        if ($this->getTimezone() && !$this->isValidTimezone($this->getTimezone())) {
            $errors[] = __('Please select a valid timezone.');
        }
        
        // Validate welcome message
        if ($this->getWelcomeMessage() && strlen(trim($this->getWelcomeMessage())) > 500) {
            $errors[] = __('Welcome message cannot exceed 500 characters.');
        }
        
        // Validate sort order
        if ($this->getSortOrder() !== null && (!is_numeric($this->getSortOrder()) || $this->getSortOrder() < 0)) {
            $errors[] = __('Sort order must be a positive number.');
        }
        
        return $errors;
    }
    
    /**
     * Validate phone number format
     *
     * @param string $phone
     * @return bool
     */
    private function isValidPhoneNumber($phone)
    {
        // Remove spaces and special characters except +
        $cleanPhone = preg_replace('/[^+0-9]/', '', $phone);
        
        // Check if it starts with + and has 10-15 digits
        return preg_match('/^\+[1-9]\d{9,14}$/', $cleanPhone);
    }
    
    /**
     * Validate URL format
     *
     * @param string $url
     * @return bool
     */
    private function isValidUrl($url)
    {
        // Accept base64 data URLs for uploaded images
        if (strpos($url, 'data:image/') === 0) {
            return true;
        }
        
        // Accept regular URLs
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }
    
    /**
     * Validate working hours format (HH:MM-HH:MM)
     *
     * @param string $workingHours
     * @return bool
     */
    private function isValidWorkingHours($workingHours)
    {
        if (!preg_match('/^\d{2}:\d{2}-\d{2}:\d{2}$/', $workingHours)) {
            return false;
        }
        
        $parts = explode('-', $workingHours);
        $startTime = $parts[0];
        $endTime = $parts[1];
        
        return $this->isValidTime($startTime) && $this->isValidTime($endTime) && $startTime < $endTime;
    }
    
    /**
     * Validate time format (HH:MM)
     *
     * @param string $time
     * @return bool
     */
    private function isValidTime($time)
    {
        return preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $time);
    }
    
    /**
     * Validate timezone
     *
     * @param string $timezone
     * @return bool
     */
    private function isValidTimezone($timezone)
    {
        return in_array($timezone, timezone_identifiers_list());
    }
    
    /**
     * Before save validation
     *
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function beforeSave()
    {
        $errors = $this->validateData();
        
        if (!empty($errors)) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __(implode(' ', $errors))
            );
        }
        
        // Clean and format data
        if ($this->getName()) {
            $this->setName(trim($this->getName()));
        }
        
        if ($this->getPhone()) {
            // Clean phone number
            $cleanPhone = preg_replace('/[^+0-9]/', '', $this->getPhone());
            $this->setPhone($cleanPhone);
        }
        
        if ($this->getTitle()) {
            $this->setTitle(trim($this->getTitle()));
        }
        
        if ($this->getWelcomeMessage()) {
            $this->setWelcomeMessage(trim($this->getWelcomeMessage()));
        }
        
        // Set default values
        if ($this->getSortOrder() === null) {
            $this->setSortOrder(0);
        }
        
        if ($this->getStatus() === null) {
            $this->setStatus(self::STATUS_ONLINE);
        }
        
        if ($this->getIsActive() === null) {
            $this->setIsActive(true);
        }
        
        return parent::beforeSave();
    }
}