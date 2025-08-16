<?php
/**
 * MagoArab WhatsApp Icon Extension
 * Animation Effect Source Model
 */

namespace MagoArab\WhatsappIcon\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class AnimationEffect implements ArrayInterface
{
    /**
     * Return array of options as value-label pairs
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'none', 'label' => __('None')],
            ['value' => 'pulse', 'label' => __('Pulse')],
            ['value' => 'bounce', 'label' => __('Bounce')],
            ['value' => 'float', 'label' => __('Float')]
        ];
    }
}