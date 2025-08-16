<?php
/**
 * MagoArab WhatsApp Icon Extension
 * Agent Collection
 */

namespace MagoArab\WhatsappIcon\Model\ResourceModel\Agent;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use MagoArab\WhatsappIcon\Model\Agent as AgentModel;
use MagoArab\WhatsappIcon\Model\ResourceModel\Agent as AgentResourceModel;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'agent_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(AgentModel::class, AgentResourceModel::class);
    }

    /**
     * Get active agents
     *
     * @return $this
     */
    public function addActiveFilter()
    {
        return $this->addFieldToFilter('is_active', 1);
    }

    /**
     * Add status filter
     *
     * @param string $status
     * @return $this
     */
    public function addStatusFilter($status)
    {
        return $this->addFieldToFilter('status', $status);
    }

    /**
     * Order by sort order
     *
     * @return $this
     */
    public function addSortOrderFilter()
    {
        return $this->setOrder('sort_order', 'ASC');
    }
}