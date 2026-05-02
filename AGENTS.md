# AGENTS.md - AI Agent Guide for Ticket Processor

## Project Overview

**Ticket Processor** is a Laravel 12 API service that automates receipt/ticket data extraction using Google Gemini AI. The system processes scanned ticket images, extracts product information, and persists structured data to a SQLite database.

**Core Tech Stack:** Laravel 12, PHP 8.2+, Google Gemini 2.5 Flash, Tesseract OCR, SQLite

---

## Architecture & Data Flow

### Key Components

1. **HTTP API Layer** (`app/Http/Controllers/TicketController.php`)
   - `POST /tickets` - Creates ticket, stores image, queues async processing
   - `GET /tickets/{id}` - Returns ticket with products (via Resource layer)

2. **Async Job Processing** (`app/Jobs/ProcessTicket.php`)
   - Listens via queue listener (see `composer.json` dev script)
   - Coordinates AI extraction and data persistence
   - Status transitions: `Queued → Processing → Processed/Failed`

3. **Processor Registry Pattern** (`app/Services/Tickets/TicketProcessorRegistry.php`)
   - **Registry** resolves store-specific processor (e.g., `ObramatTicketProcessor`)
   - Each processor extends `AbstractTicketProcessor` with:
     - `supports(storeName)` - Declares which store it handles
     - `storeName()` - Returns canonical store identifier
     - `prompt()` - Overridable Gemini extraction prompt
   - **Adding new stores:** Create `app/Services/Tickets/Processors/{Store}TicketProcessor.php` extending `AbstractTicketProcessor`, register in `AppServiceProvider`

4. **AI Extraction** (`AbstractTicketProcessor::process()`)
   - Encodes image to base64, sends to Gemini with JSON extraction prompt
   - Strips markdown formatting from response
   - Returns `TicketDataDTO` with structured data

5. **Data Persistence** (`app/Services/Tickets/TicketPersister.php`)
   - Normalizes products via `ProductNormalizer` (deduplica via aliases)
   - Creates ticket record + related `TicketProduct` entries
   - Updates status to `Processed`

### Data Model

- **Tickets** table: Stores metadata (`store`, `category`, `total`, `purchased_at`, `status`, `raw_text`)
- **TicketProducts** table: Individual line items (FK to `tickets`)
- **ProductAliases** table: Maps similar product names for normalization
- **Enums:** `TicketStatusEnum` (queued, processing, processed, failed), `TicketCategoryEnum` (tejado, fontaneria, etc.)

---

## Developer Workflows

### Local Setup & Running

```bash
# Use provided Makefile for Docker-based dev environment
make up              # Start all services (app, queue, vite, logs)
make migrate         # Run migrations
make seed            # Seed database with product aliases
make down            # Stop all services
```

Or use `npm run dev` script for concurrent server/queue/logs/vite process.

### Testing & Debugging

```bash
npm run test         # Run PHPUnit (clears config, runs tests)
make tinker          # Interactive REPL in container
make latest-ticket   # Dump last processed ticket
make logs            # Stream app logs
```

### Key Config

- **Queue Driver:** Redis or sync (config/queue.php) - ProcessTicket jobs dispatched asynchronously
- **Gemini API:** Configure `GEMINI_API_KEY` in `.env` (config/gemini.php)
- **Image Storage:** `storage/app/tickets/` (local disk)
- **Database:** SQLite at `database/database.sqlite`

---

## Project-Specific Patterns & Conventions

### Service-Oriented Design
- Services handle business logic, not controllers (clean separation)
- Use constructor injection throughout (Laravel container manages DI)

### DTO Pattern
- `TicketDataDTO` transfers data between processor and persister (immutable value object)
- Ensures type safety across async boundary

### Registry Pattern for Store-Specific Logic
- New store support **doesn't require** controller/route changes
- Processors auto-discovered and registered via service container
- Supports multiple simultaneous ticket sources

### Enum-Based Status & Category Management
- Backed enums (string-based) ensure type safety and database consistency
- `TicketStatusEnum::Processing->value` yields `'processing'` for DB storage

### Resource Layer for API Responses
- `TicketResource` transforms models to JSON (eager-loads relations)
- Consistent API response format

---

## Integration Points & External Dependencies

### Google Gemini API
- **Dependency:** `google-gemini-php/laravel` (^2.0)
- **Used in:** `AbstractTicketProcessor::process()` - `Gemini::generativeModel('models/gemini-2.5-flash')`
- **Fallback:** No built-in fallback; job fails if API unreachable (retry via queue config)

### Tesseract OCR
- **Dependency:** `thiagoalessio/tesseract_ocr` (^2.13)
- **Current Status:** Available but **not directly integrated** (Gemini does vision analysis instead)
- **Future Use:** Could augment extraction if Gemini fails

### Image Processing
- **Imagick Extension:** Required (`ext-imagick` in composer.json) for possible future image manipulation

### Product Alias Normalization
- **Seeder:** `ProductAliasSeeder` populates `product_aliases` table
- **Integration:** `ProductNormalizer` uses aliases during `TicketPersister::persist()` to deduplicate products

---

## Critical Assumptions & Gotchas

1. **Synchronous Gemini Calls in Queue Jobs:** If Gemini times out, entire job fails (see `ProcessTicket::$timeout = 120`)
2. **Markdown Stripping:** Gemini response must return JSON within markdown code blocks (regex removes `` ```json `` delimiters)
3. **Store Resolution:** If no processor `supports()` a store name, `TicketProcessorRegistry::resolve()` throws RuntimeException
4. **Image Cleanup:** No explicit cleanup of uploaded images; rely on storage cleanup policy
5. **Status Transitions:** Only support sequential states; no rollback if persister fails mid-transaction

---

## Files to Know

- **Core Flow:** `TicketController` → `ProcessTicket` job → `TicketProcessorRegistry` → `AbstractTicketProcessor` → `TicketPersister`
- **Models:** `app/Models/{Ticket, TicketProduct, ProductAlias, User}`
- **Enums:** `app/Enums/{TicketStatusEnum, TicketCategoryEnum}`
- **Processors:** `app/Services/Tickets/Processors/` (extend `AbstractTicketProcessor`)
- **Config:** `config/gemini.php`, `config/queue.php`
- **Tests:** `tests/Feature/` and `tests/Unit/`

---

## When Adding Features

- **New Ticket Source?** Create processor + register in service container (no routes needed)
- **New Product Normalization Logic?** Extend `ProductNormalizer`
- **New API Endpoint?** Add to `TicketController`, return via `TicketResource`
- **Job Changes?** Remember `$timeout` and `$tries` config on `ProcessTicket`
- **Database Schema?** Create migration with proper `$fillable` model updates + seeders if needed

