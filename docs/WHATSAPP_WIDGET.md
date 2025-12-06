# WhatsApp Floating Contact Widget

## Overview
A floating WhatsApp contact button with an expandable agent list that allows visitors to easily contact your team via WhatsApp.

## Features

### Frontend
- **Floating Button**: A green WhatsApp button fixed at the bottom-right corner of the page
- **Expandable Agent List**: Click the button to see a list of available agents
- **Beautiful UI**: Modern design with smooth animations and transitions
- **Responsive**: Works perfectly on all devices
- **Direct WhatsApp Links**: Each agent links directly to WhatsApp chat

### Admin Panel
- **Full CRUD Management**: Create, Read, Update, and Delete WhatsApp agents
- **Agent Details**:
  - Name: Display name of the agent
  - Phone Number: WhatsApp phone number (with country code)
  - Active Status: Toggle to show/hide agents
  - Display Order: Control the order agents appear in the list
- **Activity Logging**: All changes are logged in the admin activity log

## Usage

### Admin Management

1. **Access WhatsApp Agents**:
   - Navigate to Admin Panel → WhatsApp Agents
   - Or visit: `/admin/whatsapp-agents`

2. **Add New Agent**:
   - Click "Add Agent" button
   - Fill in:
     - Agent Name (e.g., "Customer Support")
     - WhatsApp Phone Number (e.g., "+628123456789")
     - Display Order (lower numbers appear first)
     - Active checkbox (check to show in widget)
   - Click "Create Agent"

3. **Edit Agent**:
   - Click the edit icon next to any agent
   - Update the details
   - Click "Update Agent"

4. **Delete Agent**:
   - Click the delete icon next to any agent
   - Confirm deletion

### Phone Number Format
- Include country code (e.g., +62 for Indonesia)
- Examples:
  - `+628123456789`
  - `628123456789`
  - `+1234567890`

### Frontend Display
- The floating button appears on all frontend pages
- Shows a badge with the number of active agents
- Click to expand and see the agent list
- Click any agent to open WhatsApp chat
- Click outside or the X button to close

## File Structure

```
app/
├── Http/Controllers/Admin/
│   └── WhatsAppAgentController.php      # CRUD controller
└── Models/
    └── WhatsAppAgent.php                # Agent model

database/
├── migrations/
│   └── 2025_12_06_000003_create_whatsapp_agents_table.php
└── seeders/
    └── WhatsAppAgentSeeder.php          # Sample data

resources/views/
├── admin/
│   └── whatsapp-agents/
│       ├── index.blade.php              # Agent list
│       ├── create.blade.php             # Create form
│       └── edit.blade.php               # Edit form
└── frontend/
    ├── layouts/
    │   └── app.blade.php                # Includes widget
    └── partials/
        └── whatsapp-float.blade.php     # Floating widget

routes/
└── admin.php                            # Admin routes
```

## Database Schema

**Table**: `whatsapp_agents`

| Column       | Type    | Description                    |
|--------------|---------|--------------------------------|
| id           | bigint  | Primary key                    |
| name         | string  | Agent display name             |
| phone_number | string  | WhatsApp phone number          |
| is_active    | boolean | Whether agent is visible       |
| order        | integer | Display order (ascending)      |
| created_at   | timestamp | Creation timestamp          |
| updated_at   | timestamp | Last update timestamp       |

## Technical Details

### Model Methods

**WhatsAppAgent.php**:
- `getActiveAgents()`: Static method to get all active agents ordered by display order
- `getWhatsAppUrlAttribute()`: Accessor that generates WhatsApp chat URL

### Routes

- `GET /admin/whatsapp-agents` - List all agents
- `GET /admin/whatsapp-agents/create` - Show create form
- `POST /admin/whatsapp-agents` - Store new agent
- `GET /admin/whatsapp-agents/{id}/edit` - Show edit form
- `PUT /admin/whatsapp-agents/{id}` - Update agent
- `DELETE /admin/whatsapp-agents/{id}` - Delete agent

### Styling
- Uses Tailwind CSS for styling
- Uses Alpine.js for interactivity
- Animated with Tailwind transitions
- Green color scheme matching WhatsApp branding

## Sample Data

The seeder creates 3 sample agents:
1. Customer Support - +628123456789
2. Sales Team - +628987654321
3. Technical Support - +628555666777

You can run the seeder with:
```bash
php artisan db:seed --class=WhatsAppAgentSeeder
```

## Customization

### Change Colors
Edit `resources/views/frontend/partials/whatsapp-float.blade.php`:
- Replace `green-600` with your preferred color
- Update `from-green-600 to-emerald-600` gradient

### Change Position
In `whatsapp-float.blade.php`, modify:
- `bottom-6 right-6` to `bottom-6 left-6` (left side)
- `bottom-20 right-6` (higher position)

### Disable Notification Badge
Remove or comment out the badge section:
```blade
@if($agents->count() > 0)
<span class="absolute -top-1 -right-1 ...">
    {{ $agents->count() }}
</span>
@endif
```

## Testing

1. Add agents via admin panel
2. Visit any frontend page
3. Click the floating WhatsApp button
4. Verify agents appear in the list
5. Click an agent to test WhatsApp link
6. Toggle agent active status to hide/show

## Notes

- Only active agents are displayed in the widget
- Agents are ordered by the `order` field (ascending)
- Phone numbers are sanitized when generating WhatsApp URLs
- All admin actions are logged in the activity log
- The widget uses Alpine.js (already included in the project)
