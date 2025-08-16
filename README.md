# MagoArab WhatsApp Icon Extension

A professional Magento 2 extension that adds a customizable WhatsApp floating icon to your website with multi-agent support.

## 🚀 Features

- **Multiple Icon Styles**: 10 different modern styles to choose from
- **Multi-Agent Support**: Manage multiple WhatsApp agents with individual settings
- **Responsive Design**: Works perfectly on all devices
- **Customizable Appearance**: Position, size, animation effects
- **Scheduling**: Show/hide based on working hours and days
- **Page Targeting**: Display on specific pages or all pages
- **Admin Management**: Easy-to-use admin interface for agent management
- **Real-time Status**: Show agent availability status
- **Image Upload**: Support for agent avatars with base64 encoding

## 📋 Requirements

- Magento 2.4.x
- PHP 8.1+
- MySQL 5.7+

## 🛠 Installation

1. **Upload the extension** to your Magento installation:
   ```
   app/code/MagoArab/WhatsappIcon/
   ```

2. **Enable the module**:
   ```bash
   php bin/magento module:enable MagoArab_WhatsappIcon
   ```

3. **Run setup upgrade**:
   ```bash
   php bin/magento setup:upgrade
   php bin/magento setup:di:compile
   php bin/magento setup:static-content:deploy -f
   php bin/magento cache:flush
   ```

4. **Configure the extension**:
   - Go to **Admin Panel** → **Stores** → **Configuration** → **MagoArab Extensions** → **WhatsApp Icon**
   - Enable the extension and configure settings

## ⚙️ Configuration

### General Settings
- **Enable WhatsApp Icon**: Turn the extension on/off
- **Phone Number**: Default WhatsApp number with country code
- **Default Message**: Pre-filled message for customers

### Appearance Settings
- **Icon Style**: Choose from 10 different styles
- **Icon Position**: Bottom-right, bottom-left, top-right, top-left
- **Icon Size**: Small, medium, large
- **Animation Effect**: Pulse, bounce, fade, etc.

### Multi-Agent Settings
- **Enable Multi-Agent Support**: Enable multiple agents
- **Agents Management**: Link to agent management page

### Display Settings
- **Show on Pages**: All pages, specific CMS pages, category/product pages
- **Specific CMS Pages**: Select individual CMS pages

### Advanced Settings
- **Enable Scheduling**: Time-based display
- **Working Hours**: Start and end times
- **Working Days**: Select working days

## 👥 Multi-Agent Management

### Adding Agents
1. Go to **Admin Panel** → **Stores** → **Configuration** → **MagoArab Extensions** → **WhatsApp Icon** → **Multi-Agent Settings**
2. Click **"Manage Agents"**
3. Click **"Add New Agent"**
4. Fill in agent details:
   - **Name**: Agent's display name
   - **Phone**: WhatsApp number with country code
   - **Title**: Job title or role
   - **Avatar**: Upload agent photo
   - **Status**: Online, offline, busy
   - **Working Hours**: HH:MM-HH:MM format
   - **Working Days**: Select working days
   - **Timezone**: Agent's timezone
   - **Welcome Message**: Custom greeting
   - **Sort Order**: Display priority

### Agent Features
- **Real-time Status**: Shows current availability
- **Working Hours**: Automatic availability based on time
- **Avatar Support**: Upload and display agent photos
- **Individual Messages**: Custom welcome messages per agent
- **Sort Order**: Control display order

## 🎨 Icon Styles

1. **Modern Floating Chat Widget**: Full chat interface with agent list
2. **Simple Floating Button**: Clean circular button
3. **Chat Bubble with Text**: Button with text overlay
4. **Modern Chat Box**: Card-style chat interface
5. **Floating Action Button**: Material design FAB
6. **Pill Shape Button**: Rounded rectangle design
7. **Notification Badge**: Button with notification indicator
8. **Help Text Style**: Button with help text
9. **Gradient Button**: Animated gradient background
10. **Shadow Effect**: Button with enhanced shadows

## 🔧 Technical Details

### File Structure
```
MagoArab_WhatsappIcon/
├── Api/
│   ├── AgentRepositoryInterface.php
│   └── Data/
│       └── AgentInterface.php
├── Block/
│   ├── Adminhtml/
│   │   ├── Agents.php
│   │   └── System/
│   │       └── Config/
│   │           ├── AgentsManagement.php
│   │           └── StylePreview.php
│   └── WhatsappIcon.php
├── Controller/
│   └── Adminhtml/
│       └── Agents/
│           ├── Delete.php
│           ├── Edit.php
│           ├── Index.php
│           ├── NewAction.php
│           └── Save.php
├── Helper/
│   └── Data.php
├── Model/
│   ├── Agent.php
│   ├── AgentRepository.php
│   ├── Config/
│   │   └── Source/
│   │       ├── AgentSelection.php
│   │       ├── AnimationEffect.php
│   │       ├── CmsPages.php
│   │       ├── IconPosition.php
│   │       ├── IconSize.php
│   │       ├── IconStyle.php
│   │       ├── ShowOnPages.php
│   │       └── WorkingDays.php
│   └── ResourceModel/
│       └── Agent/
│           ├── Collection.php
│           └── Agent.php
├── view/
│   ├── adminhtml/
│   │   ├── layout/
│   │   ├── templates/
│   │   └── web/
│   └── frontend/
│       ├── layout/
│       ├── templates/
│       └── web/
└── etc/
    ├── adminhtml/
    ├── config.xml
    ├── db_schema.xml
    ├── di.xml
    └── module.xml
```

### Database Schema
The extension creates a `magoarab_whatsapp_agents` table with the following fields:
- `agent_id` (Primary Key)
- `name`
- `phone`
- `title`
- `avatar_url`
- `status`
- `working_hours`
- `working_days`
- `timezone`
- `welcome_message`
- `sort_order`
- `is_active`
- `created_at`
- `updated_at`

## 🐛 Troubleshooting

### Common Issues

1. **Icon not appearing**:
   - Check if extension is enabled in configuration
   - Verify phone number is set
   - Check browser console for JavaScript errors
   - Add `?debug_whatsapp=1` to URL for debug info

2. **Multi-Agent showing "Disabled"**:
   - Ensure "Enable Multi-Agent Support" is set to "Yes"
   - Check configuration paths in system.xml
   - Clear cache after configuration changes

3. **Image upload not working**:
   - Verify file size (max 2MB)
   - Check file type (JPG, PNG, GIF)
   - Ensure proper permissions on media directory

4. **JavaScript errors**:
   - Check RequireJS configuration
   - Verify JavaScript files are loading
   - Clear browser cache

### Debug Mode
Add `?debug_whatsapp=1` to any page URL to see debug information in the page source.

## 📝 Changelog

### Version 1.0.2 (Latest)
- ✅ Added scrollbar to agent management modal
- ✅ Enhanced logging for save operations with detailed error tracking
- ✅ Added comprehensive debug mode for frontend display issues
- ✅ Improved style previews with emoji icons and better CSS
- ✅ Fixed AgentInterfaceFactory dependency issues
- ✅ Added detailed logging to Helper methods for troubleshooting
- ✅ Enhanced error handling in save controller

### Version 1.0.1
- ✅ Fixed dependency injection error in AgentsManagement Block
- ✅ Fixed AgentRepository constructor dependencies
- ✅ Removed AgentFactory and CollectionFactory dependencies
- ✅ Used ObjectManager for model creation
- ✅ Fixed SearchResultsInterfaceFactory import
- ✅ Updated return types for better compatibility

### Version 1.0.0
- ✅ Fixed ArgumentCountError in AgentRepository::getList()
- ✅ Fixed SearchCriteriaBuilder::addOrder() error
- ✅ Fixed RequireJS "Mismatched anonymous define() module" error
- ✅ Fixed 404 errors for CSS files
- ✅ Fixed foreach() null argument error
- ✅ Fixed avatar URL validation for base64 images
- ✅ Updated system configuration structure
- ✅ Added proper layout files for all page types
- ✅ Improved error handling and validation
- ✅ Enhanced admin interface with better styling
- ✅ Added debug functionality
- ✅ Fixed multi-agent status display
- ✅ Improved JavaScript loading and initialization

## 🤝 Support

For support and questions:
- **Email**: support@magoarab.com
- **Website**: https://magoarab.com
- **Documentation**: https://docs.magoarab.com

## 📄 License

This extension is licensed under the Open Software License (OSL 3.0).

## 🙏 Credits

Developed by MagoArab Development Team
Copyright © 2024 MagoArab (https://magoarab.com)
