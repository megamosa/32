<?php
/**
 * MagoArab WhatsApp Icon Extension
 * Icon Position Source Model
 */

namespace MagoArab\WhatsappIcon\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class IconPosition implements ArrayInterface
{
    /**
     * Return array of options as value-label pairs
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'bottom-right', 'label' => __('Bottom Right')],
            ['value' => 'bottom-left', 'label' => __('Bottom Left')],
            ['value' => 'top-right', 'label' => __('Top Right')],
            ['value' => 'top-left', 'label' => __('Top Left')]
        ];
    }
}