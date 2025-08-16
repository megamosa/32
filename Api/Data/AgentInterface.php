<?php
/**
 * MagoArab WhatsApp Icon Extension
 * Agent Data Interface
 */

namespace MagoArab\WhatsappIcon\Api\Data;

interface AgentInterface
{
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

    /**
     * Get agent ID
     *
     * @return int|null
     */
    public function getAgentId();

    /**
     * Set agent ID
     *
     * @param int $agentId
     * @return $this
     */
    public function setAgentId($agentId);

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName();

    /**
     * Set name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * Get phone
     *
     * @return string|null
     */
    public function getPhone();

    /**
     * Set phone
     *
     * @param string $phone
     * @return $this
     */
    public function setPhone($phone);

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle();

    /**
     * Set title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title);

    /**
     * Get avatar URL
     *
     * @return string|null
     */
    public function getAvatarUrl();

    /**
     * Set avatar URL
     *
     * @param string $avatarUrl
     * @return $this
     */
    public function setAvatarUrl($avatarUrl);

    /**
     * Get status
     *
     * @return string|null
     */
    public function getStatus();

    /**
     * Set status
     *
     * @param string $status
     * @return $this
     */
    public function setStatus($status);

    /**
     * Get working hours
     *
     * @return string|null
     */
    public function getWorkingHours();

    /**
     * Set working hours
     *
     * @param string $workingHours
     * @return $this
     */
    public function setWorkingHours($workingHours);

    /**
     * Get working days
     *
     * @return string|null
     */
    public function getWorkingDays();

    /**
     * Set working days
     *
     * @param string $workingDays
     * @return $this
     */
    public function setWorkingDays($workingDays);

    /**
     * Get timezone
     *
     * @return string|null
     */
    public function getTimezone();

    /**
     * Set timezone
     *
     * @param string $timezone
     * @return $this
     */
    public function setTimezone($timezone);

    /**
     * Get welcome message
     *
     * @return string|null
     */
    public function getWelcomeMessage();

    /**
     * Set welcome message
     *
     * @param string $welcomeMessage
     * @return $this
     */
    public function setWelcomeMessage($welcomeMessage);

    /**
     * Get sort order
     *
     * @return int
     */
    public function getSortOrder();

    /**
     * Set sort order
     *
     * @param int $sortOrder
     * @return $this
     */
    public function setSortOrder($sortOrder);

    /**
     * Get is active
     *
     * @return bool
     */
    public function getIsActive();

    /**
     * Set is active
     *
     * @param bool $isActive
     * @return $this
     */
    public function setIsActive($isActive);

    /**
     * Get created at
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created at
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * Get updated at
     *
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Set updated at
     *
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt);

    /**
     * Check if agent is currently available
     *
     * @return bool
     */
    public function isAvailable();
}