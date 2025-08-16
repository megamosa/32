/**
 * MagoArab WhatsApp Icon Extension
 * Admin Configuration JavaScript
 */

define([
    'jquery',
    'mage/translate'
], function ($, $t) {
    'use strict';

    return function (config) {
        $(document).ready(function () {
            
            // Style preview functionality
            function initStylePreviews() {
                var $styleField = $('#magoarab_whatsapp_general_icon_style');
                var $styleContainer = $styleField.closest('.field-row');
                
                if ($styleField.length && $styleContainer.length) {
                    // Create preview container
                    var $previewContainer = $('<div class="style-preview-container"></div>');
                    
                    // Add preview items for each style
                    var styles = [
                        {value: 'style_1', label: 'Modern Floating Chat Widget'},
                        {value: 'style_2', label: 'Simple Floating Button'},
                        {value: 'style_3', label: 'Chat Bubble with Text'},
                        {value: 'style_4', label: 'Modern Chat Box'},
                        {value: 'style_5', label: 'Floating Action Button'},
                        {value: 'style_6', label: 'Pill Shape Button'},
                        {value: 'style_7', label: 'Notification Badge'},
                        {value: 'style_8', label: 'Help Text Style'},
                        {value: 'style_9', label: 'Gradient Button'},
                        {value: 'style_10', label: 'Shadow Effect'}
                    ];
                    
                    styles.forEach(function(style) {
                        var $previewItem = $('<div class="style-preview-item" data-style="' + style.value + '"></div>');
                        var $label = $('<div class="preview-label">' + style.label + '</div>');
                        $previewItem.append($label);
                        $previewContainer.append($previewItem);
                        
                        // Click handler
                        $previewItem.on('click', function() {
                            $styleField.val(style.value).trigger('change');
                            updateStyleSelection();
                        });
                    });
                    
                    $styleContainer.append($previewContainer);
                    updateStyleSelection();
                }
            }
            
            function updateStyleSelection() {
                var selectedStyle = $('#magoarab_whatsapp_general_icon_style').val();
                $('.style-preview-item').removeClass('selected');
                $('.style-preview-item[data-style="' + selectedStyle + '"]').addClass('selected');
            }
            
            // Position preview functionality
            function initPositionPreviews() {
                var $positionField = $('#magoarab_whatsapp_general_icon_position');
                var $positionContainer = $positionField.closest('.field-row');
                
                if ($positionField.length && $positionContainer.length) {
                    // Create preview container
                    var $previewContainer = $('<div class="position-preview-container"></div>');
                
                    // Add preview items for each position
                    var positions = [
                        {value: 'bottom-right', label: 'Bottom Right'},
                        {value: 'bottom-left', label: 'Bottom Left'},
                        {value: 'top-right', label: 'Top Right'},
                        {value: 'top-left', label: 'Top Left'}
                    ];
                    
                    positions.forEach(function(position) {
                        var $previewItem = $('<div class="position-preview-item" data-position="' + position.value + '"></div>');
                        var $label = $('<div class="preview-label">' + position.label + '</div>');
                        $previewItem.append($label);
                        $previewContainer.append($previewItem);
                        
                        // Click handler
                        $previewItem.on('click', function() {
                            $positionField.val(position.value).trigger('change');
                            updatePositionSelection();
                        });
                    });
                    
                    $positionContainer.append($previewContainer);
                    updatePositionSelection();
                }
            }
            
            function updatePositionSelection() {
                var selectedPosition = $('#magoarab_whatsapp_general_icon_position').val();
                $('.position-preview-item').removeClass('selected');
                $('.position-preview-item[data-position="' + selectedPosition + '"]').addClass('selected');
            }
            
            // Initialize previews
            initStylePreviews();
            initPositionPreviews();
            
            // Handle field changes
            $('#magoarab_whatsapp_general_icon_style').on('change', updateStyleSelection);
            $('#magoarab_whatsapp_general_icon_position').on('change', updatePositionSelection);
            
            // Add helpful tooltips
            $('[data-comment]').each(function() {
                var $this = $(this);
                var comment = $this.data('comment');
                if (comment) {
                    $this.attr('title', comment);
                }
            });
            
            // Enhanced field dependencies
            function handleDependencies() {
                $('select, input[type="checkbox"]').on('change', function() {
                    var $this = $(this);
                    var fieldId = $this.attr('id');
                    var value = $this.val();
                    
                    // Handle multi-agent dependencies
                    if (fieldId === 'magoarab_whatsapp_multi_agent_enabled') {
                        var $multiAgentFields = $('[id*="multi_agent"]').not('#' + fieldId);
                        if (value === '1') {
                            $multiAgentFields.closest('.field').show();
                        } else {
                            $multiAgentFields.closest('.field').hide();
                        }
                    }
                });
                
                // Trigger initial state
                $('select, input[type="checkbox"]').trigger('change');
            }
            
            handleDependencies();
        });
    };
});
