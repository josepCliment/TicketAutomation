# TicketAutomation

A Laravel application that processes purchase receipts using AI vision. Users can upload a photo of a receipt via the web UI or API, and the system automatically extracts the store, date, total, and products using the Gemini API.

---

## What it does

1. User uploads a receipt image via web UI (`/tickets/create`) or `POST /api/tickets`
2. The system queues a processing job
3. The job calls Gemini Vision to extract structured data
4. Products are normalized against an alias table
5. Data is persisted and available via the web dashboard or `GET /api/tickets/{id}`

---

## Quick Start

### Prerequisites
- Docker & Docker Compose
- `GEMINI_API_KEY` from [Google AI Studio](https://aistudio.google.com/app/apikey)

### Start

```bash
make up              # Start all services
make migrate         # Run migrations (included in Dockerfile.dev)
make seed            # Optional: seed product aliases
```

Then visit **http://localhost:8000/dashboard** to access the web UI.

---

## Web UI Features

The application includes a complete web interface for managing tickets and product aliases:

### 📊 Dashboard
- View all processed tickets with pagination
- Real-time status overview (Total, Processed, Processing, Failed)
- Quick access to ticket details

### 📤 Upload Receipts
- Drag-and-drop file upload
- Select store name and expense category
- Visual feedback during upload
- Automatic async processing

### 🔍 View & Edit Tickets
- Detailed ticket view with all extracted data
- Product listing with quantities and prices
- Edit extracted data (store, category, date, total)
- Raw JSON view for debugging

### 🏷️ Manage Product Aliases
- Create mappings between product name variants
- Normalize products across multiple tickets
- CRUD interface for alias management
- Example: "ESPUMA POLIURET 650ML" → "ESPUMA POLIURETANO EXPANDIBLE"

### 🎨 Design
- **Responsive** design for mobile and desktop
- **Dark mode** support with Tailwind CSS
- **Color-coded status** badges for quick identification
- **Accessible** forms and navigation

---

| Component | Technology |
|---|---|
| Backend | Laravel 11 (PHP 8.3) |
| Database | SQLite |
| Job Queue | Laravel Queue (database driver) |
| Process Supervisor | Supervisord |
| AI / OCR | Google Gemini 2.5 Flash |
| Web Server | Nginx |
| Containers | Docker + Docker Compose |

---

## Architecture

```
POST /api/tickets
       │
       ▼
TicketController         → Stores image, creates Ticket (status: queued), dispatches job
       │
       ▼
ProcessTicket (Job)      → Orchestrates the processing pipeline
       │
       ├─► TicketProcessorRegistry   → Resolves the correct processor by store name
       │         │
       │         ▼
       │   AbstractTicketProcessor   → Calls Gemini Vision with the image
       │         │
       │         ▼
       │   ObramatTicketProcessor    → Store-specific implementation
       │
       ├─► ProductNormalizer         → Normalizes product names via alias table
       │
       └─► TicketPersister           → Persists ticket and products to the database
```

### Models

**Ticket**
- `store` — store name
- `category` — expense category (enum)
- `purchased_at` — purchase date
- `total` — total amount
- `processor` — class that processed the ticket
- `raw_text` — raw JSON returned by Gemini
- `status` — processing status (enum: queued, processing, processed, failed)

**TicketProduct**
- `ticket_id` — FK to ticket
- `name` — normalized product name
- `original_name` — original name extracted by Gemini
- `quantity` — quantity
- `unit_price` — unit price
- `price` — line total

**ProductAlias**
- `alias` — abbreviated name as it appears on the receipt
- `canonical_name` — normalized canonical name

---

## Project Structure

```
app/
├── Enums/
│   ├── TicketCategoryEnum.php
│   └── TicketStatusEnum.php
├── Http/
│   ├── Controllers/TicketController.php
│   ├── Requests/StoreTicketRequest.php
│   └── Resources/
│       ├── TicketResource.php
│       └── TicketProductResource.php
├── Jobs/
│   └── ProcessTicket.php
├── Models/
│   ├── Ticket.php
│   ├── TicketProduct.php
│   └── ProductAlias.php
└── Services/
    ├── Normalizer/
    │   └── ProductNormalizer.php
    └── Tickets/
        ├── AbstractTicketProcessor.php
        ├── TicketDataDTO.php
        ├── TicketPersister.php
        ├── TicketProcessorRegistry.php
        └── Processors/
            └── ObramatTicketProcessor.php
```

---

## API

### `POST /api/tickets`

Upload a receipt for processing.

**Request** (multipart/form-data)

| Field | Type | Required | Description |
|---|---|---|---|
| image | file | ✅ | Receipt image (jpg, png) |
| store | string | ✅ | Store name |
| category | string | ❌ | Expense category |

**Response** `202 Accepted`
```json
{
  "id": 1,
  "status": "queued"
}
```

---

### `GET /api/tickets/{id}`

Retrieve the processed data for a ticket.

**Response** `200 OK`
```json
{
  "data": {
    "id": 1,
    "store": "Obramat",
    "category": "tejado",
    "purchased_at": "2026-04-08",
    "total": "93.60",
    "status": "processed",
    "products": [
      {
        "id": 1,
        "name": "ESPUMA POLIURETANO EXPANDIBLE",
        "original_name": "ESPUMA POLIURET 650ML MANUAL",
        "quantity": 24,
        "unit_price": 3.90,
        "price": 93.60
      }
    ]
  }
}
```

---

## Local Development

### Requirements
- Docker
- Docker Compose

### Start the environment

```bash
make up
```

### Available commands

```bash
make up              # Start containers
make down            # Stop containers
make restart         # Full restart
make shell           # Access the container
make migrate         # Run migrations
make migrate-fresh   # Reset the database
make seed            # Run seeders
make cache-clear     # Clear all caches
make latest-ticket   # Dump the latest processed ticket
make logs            # Tail logs in real time
```

### Relevant environment variables

```env
GEMINI_API_KEY=        # Google AI Studio API key
TELESCOPE_ENABLED=     # Enable/disable Laravel Telescope
```

---

## Adding Support for a New Store

1. Create a new processor in `app/Services/Tickets/Processors/`
2. Extend `AbstractTicketProcessor`
3. Implement `supports(string $storeName): bool`
4. Implement `storeName(): string`
5. Register it in `AppServiceProvider`

```php
$this->app->singleton(TicketProcessorRegistry::class, function ($app) {
    return new TicketProcessorRegistry([
        $app->make(ObramatTicketProcessor::class),
        $app->make(NewStoreTicketProcessor::class), // add here
    ]);
});
```

---

## Roadmap

### Features
- [x] **UI/UX** — Web interface to view tickets, edit incorrect data, and manage aliases
- [ ] **`GET /api/tickets`** — Paginated ticket listing with filters by store, category, and status
- [ ] **Bulk upload** — Upload multiple receipts at once
- [ ] **Statistics** — Charts and analytics dashboard
- [ ] **Automatic category detection** — Detect ticket category via Gemini instead of sending it manually
- [ ] **Multi-store support** — Add processors for more stores

### Infrastructure
- [ ] **Tests** — Coverage for `ProductNormalizer`, `TicketPersister`, and processors
- [ ] **Coolify deploy** — Configure production `docker-compose.yml`
- [ ] **Rate limiting** — Control Gemini API consumption
- [ ] **Smart retries** — Handle Gemini failures with exponential backoff
- [ ] **User authentication** — Multi-user support with roles
