<?php
/**
 * MagoArab WhatsApp Icon Extension
 * Show On Pages Source Model
 */

namespace MagoArab\WhatsappIcon\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class ShowOnPages implements ArrayInterface
{
    /**
     * Return array of options as value-label pairs
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'all_pages', 'label' => __('All Pages')],
            ['value' => 'homepage_only', 'label' => __('Homepage Only')],
            ['value' => 'product_pages_only', 'label' => __('Product Pages Only')],
            ['value' => 'cart_checkout_only', 'label' => __('Cart & Checkout Only')],
            ['value' => 'specific_cms', 'label' => __('Specific CMS Pages')]
        ];
    }
}