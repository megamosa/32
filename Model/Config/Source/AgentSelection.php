<?php
/**
 * MagoArab WhatsApp Icon Extension
 * Agent Selection Source Model
 */

namespace MagoArab\WhatsappIcon\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class AgentSelection implements ArrayInterface
{
    /**
     * Return array of options as value-label pairs
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'random', 'label' => __('Random')],
            ['value' => 'round_robin', 'label' => __('Round Robin')]
        ];
    }
}