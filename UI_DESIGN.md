# UI/UX Design Documentation

## Overview

The Ticket Processor now includes a complete web-based user interface for managing receipt data. The interface is built with **Laravel Blade templates** and **Tailwind CSS v4**, featuring a responsive, dark-mode-compatible design.

---

## Features

### 1. Dashboard (`/dashboard`)
- **Overview statistics** showing total tickets, processed count, processing count, and failed count
- **Paginated ticket table** with filtering by store, date, status, and category
- Quick access to view or edit tickets
- Responsive design for mobile and desktop

### 2. Upload Receipts (`/tickets/create`)
- **Drag-and-drop image upload** with visual feedback
- **Multipart form** for uploading receipt images
- **Store and category selection** with form validation
- File preview before submission
- Redirects to ticket detail view after upload
- Async processing via queue system

### 3. View Ticket (`/tickets/{ticket}`)
- **Ticket metadata display** (store, date, category, total)
- **Processing status indicators** with color-coded badges
- **Product table** showing extracted items with quantities and prices
- **Raw JSON view** for debugging extracted data
- **Metadata panel** with creation/update timestamps

### 4. Edit Ticket (`/tickets/{ticket}/edit`)
- **Form to correct ticket data** after extraction
- **Edit store, category, date, and total amount**
- **Product listing** (read-only, edit via aliases)
- Only available for successfully processed tickets

### 5. Product Aliases (`/aliases`)
- **CRUD interface** for managing product name mappings
- **Paginated alias listing** with search
- **Create/Edit/Delete aliases** for product normalization
- Maps abbreviated product names to canonical names
- Helps normalize products across tickets

---

## Architecture

### Controllers

#### `DashboardController`
- `index()` - Returns paginated list of tickets with statistics

#### `TicketUIController`
- `create()` - Shows upload form
- `store()` - Handles form submission, creates ticket, dispatches job
- `show()` - Displays ticket details
- `edit()` - Shows edit form
- `update()` - Saves corrected ticket data
- `destroy()` - Deletes ticket

#### `ProductAliasController`
- `index()` - Lists all aliases (paginated)
- `create()` - Shows create form
- `store()` - Saves new alias
- `edit()` - Shows edit form
- `update()` - Updates existing alias
- `destroy()` - Deletes alias

### Views

```
resources/views/
├── layouts/
│   └── app.blade.php           # Main layout with navigation
├── dashboard/
│   └── index.blade.php         # Dashboard/listing page
├── tickets/
│   ├── create.blade.php        # Upload form
│   ├── show.blade.php          # Ticket detail view
│   └── edit.blade.php          # Edit form
└── aliases/
    ├── index.blade.php         # Aliases listing
    ├── create.blade.php        # Create alias form
    └── edit.blade.php          # Edit alias form
```

### Routes

```php
// Dashboard & Tickets
GET    /dashboard                     → dashboard.index
GET    /tickets/create               → tickets.create
POST   /tickets                       → tickets.store
GET    /tickets/{ticket}             → tickets.show
GET    /tickets/{ticket}/edit        → tickets.edit
PATCH  /tickets/{ticket}             → tickets.update
DELETE /tickets/{ticket}             → tickets.destroy

// Product Aliases
GET    /aliases                       → aliases.index
GET    /aliases/create               → aliases.create
POST   /aliases                       → aliases.store
GET    /aliases/{alias}/edit         → aliases.edit
PATCH  /aliases/{alias}              → aliases.update
DELETE /aliases/{alias}              → aliases.destroy
```

---

## Design & Styling

### Color Scheme
- **Primary**: Blue (`bg-blue-600`, `text-blue-600`)
- **Success**: Green (`bg-green-*`, `text-green-*`)
- **Warning**: Yellow/Amber (`bg-yellow-*`, `text-yellow-*`)
- **Error**: Red (`bg-red-*`, `text-red-*`)
- **Neutral**: Gray (`bg-gray-*`, `text-gray-*`)

### Dark Mode Support
- All components support light and dark modes
- Uses Tailwind's `dark:` variant for dark theme styling
- CSS custom properties for theming

### Responsive Design
- **Mobile-first** approach
- Breakpoints: `sm`, `md`, `lg`, `xl`, `2xl`
- Flexible layouts using CSS Grid and Flexbox
- Tables become cards on mobile (if needed)

### Component Features
- **Navigation bar** with links to Dashboard, Upload, and Aliases
- **Flash messages** for success/error feedback
- **Form validation** error display
- **Status badges** for ticket processing states
- **Pagination** for large datasets

---

## Usage

### Starting the Development Server

```bash
# Terminal 1: Start Laravel server + queue listener
npm run dev

# Or use Make command
make up
make logs
```

Then visit `http://localhost:8000` to access the UI.

### Common Workflows

#### Upload a Receipt
1. Navigate to `/dashboard`
2. Click **"+ Upload Ticket"**
3. Drag/drop or select an image
4. Enter store name and category
5. Click **"Upload & Process"**
6. Wait for async processing
7. View results on ticket detail page

#### Correct Extracted Data
1. View a processed ticket at `/tickets/{id}`
2. Click **"Edit"** button
3. Correct store, category, date, or total
4. Click **"Save Changes"**

#### Manage Product Aliases
1. Navigate to `/aliases`
2. Click **"+ Add Alias"**
3. Enter abbreviated name and canonical name
4. Click **"Create Alias"**
5. Future extractions will use canonical names

---

## Testing

### Manual Testing Checklist

- [ ] Dashboard loads with stats
- [ ] Upload form accepts images (JPG, PNG, WebP)
- [ ] Drag/drop functionality works
- [ ] Form validation shows errors
- [ ] Ticket appears in dashboard after upload
- [ ] Status transitions visible (queued → processing → processed)
- [ ] Ticket detail view displays all data
- [ ] Edit form pre-fills ticket data
- [ ] Updates save correctly
- [ ] Products display with quantities and prices
- [ ] Dark mode toggle works (browser preference)
- [ ] Pagination works on listings
- [ ] Delete buttons prompt for confirmation

### Automated Tests (To Be Added)
- Controller unit tests for CRUD operations
- Feature tests for complete workflows
- View tests for rendering

---

## Future Enhancements

- [ ] **Bulk upload** - Upload multiple receipts at once
- [ ] **Search & filters** - Advanced ticket filtering
- [ ] **Export** - Download tickets as CSV/PDF
- [ ] **User authentication** - Multi-user support
- [ ] **Role-based access** - Admin vs. user roles
- [ ] **Statistics dashboard** - Charts and analytics
- [ ] **Image preview** - Show uploaded receipt thumbnail
- [ ] **Inline editing** - Edit products directly in table
- [ ] **API integration** - Frontend client library for API
- [ ] **Mobile app** - Native mobile application

---

## File Structure Summary

```
app/Http/Controllers/
├── DashboardController.php
├── TicketUIController.php
└── ProductAliasController.php

routes/
└── web.php (updated with UI routes)

resources/views/
├── layouts/app.blade.php
├── dashboard/index.blade.php
├── tickets/
│   ├── create.blade.php
│   ├── show.blade.php
│   └── edit.blade.php
└── aliases/
    ├── index.blade.php
    ├── create.blade.php
    └── edit.blade.php
```

---

## Notes for Development

1. **Authentication**: Currently, all routes are public. Add authentication middleware in production.
2. **Validation**: Forms use Laravel's built-in validation. Extend as needed.
3. **Pagination**: Set items per page in controller if needed.
4. **CSRF Protection**: All forms include `@csrf` token automatically.
5. **Timestamps**: All models use Laravel's timestamps automatically.
6. **File Storage**: Images stored in `storage/app/tickets/` directory.


