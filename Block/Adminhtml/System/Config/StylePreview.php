<?php
/**
 * MagoArab WhatsApp Icon Extension
 * Style Preview Block for Admin Configuration
 */

namespace MagoArab\WhatsappIcon\Block\Adminhtml\System\Config;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use MagoArab\WhatsappIcon\Model\Config\Source\IconStyle;
use MagoArab\WhatsappIcon\Helper\Data as WhatsappHelper;

class StylePreview extends Field
{
    /**
     * @var string
     */
    protected $_template = 'MagoArab_WhatsappIcon::system/config/style_preview.phtml';

    /**
     * @var IconStyle
     */
    protected $iconStyle;

    /**
     * @var WhatsappHelper
     */
    protected $whatsappHelper;

    /**
     * @param Context $context
     * @param IconStyle $iconStyle
     * @param WhatsappHelper $whatsappHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        IconStyle $iconStyle,
        WhatsappHelper $whatsappHelper,
        array $data = []
    ) {
        $this->iconStyle = $iconStyle;
        $this->whatsappHelper = $whatsappHelper;
        parent::__construct($context, $data);
    }

    /**
     * Remove scope label
     *
     * @param  AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    /**
     * Return element html
     *
     * @param  AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        return $this->_toHtml();
    }

    /**
     * Get all available icon styles
     *
     * @return array
     */
    public function getIconStyles()
    {
        return $this->iconStyle->toOptionArray();
    }

    /**
     * Get current selected style
     *
     * @return string
     */
    public function getCurrentStyle()
    {
        return $this->whatsappHelper->getIconStyle();
    }

    /**
     * Get style preview image URL
     *
     * @param string $style
     * @return string
     */
    public function getStylePreviewUrl($style)
    {
        return $this->getViewFileUrl('MagoArab_WhatsappIcon::images/style-previews/' . $style . '.png');
    }

    /**
     * Check if style has preview image
     *
     * @param string $style
     * @return bool
     */
    public function hasStylePreview($style)
    {
        $previewPath = $this->getViewFileUrl('MagoArab_WhatsappIcon::images/style-previews/' . $style . '.png');
        return !empty($previewPath);
    }
}