<?php
/**
 * MagoArab WhatsApp Icon Extension
 * Icon Style Source Model
 */

namespace MagoArab\WhatsappIcon\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class IconStyle implements ArrayInterface
{
    /**
     * Return array of options as value-label pairs
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'multi_agent_popup', 'label' => __('Multi-Agent Chat Popup - Multiple Representatives')],
            ['value' => 'chat_widget_green', 'label' => __('Chat Widget - Green Theme with Avatar')],
            ['value' => 'chat_widget_blue', 'label' => __('Chat Widget - Blue Theme with Avatar')],
            ['value' => 'chat_widget_purple', 'label' => __('Chat Widget - Purple Theme with Avatar')],
            ['value' => 'simple_button', 'label' => __('Simple WhatsApp Button - Click to Chat')],
            ['value' => 'floating_chat_bubble', 'label' => __('Floating Chat Bubble with Support Message')],
            ['value' => 'agent_list_widget', 'label' => __('Agent List Widget - Start a Conversation')]
        ];
    }
}