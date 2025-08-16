<?php
/**
 * MagoArab WhatsApp Icon Extension
 * Working Days Source Model
 */

namespace MagoArab\WhatsappIcon\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class WorkingDays implements ArrayInterface
{
    /**
     * Return array of options as value-label pairs
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'monday', 'label' => __('Monday')],
            ['value' => 'tuesday', 'label' => __('Tuesday')],
            ['value' => 'wednesday', 'label' => __('Wednesday')],
            ['value' => 'thursday', 'label' => __('Thursday')],
            ['value' => 'friday', 'label' => __('Friday')],
            ['value' => 'saturday', 'label' => __('Saturday')],
            ['value' => 'sunday', 'label' => __('Sunday')]
        ];
    }
}