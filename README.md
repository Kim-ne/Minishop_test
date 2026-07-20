# Minishop

A Laravel-based e-commerce application built as a hands-on learning project, applying production-grade backend patterns: Service Layer, Repository Pattern, and Event-Driven architecture (Events/Listeners/Queues).

This project started as a simple admin panel and evolved into a full-stack system with a versioned REST API, multi-guard authentication, and a complete Docker + CI/CD pipeline — each feature added deliberately to practice a specific engineering concept.

## Features

- **Role & Access Management** — role-based access control with custom middleware guards
- **Product & Category Management** — CRUD with self-referencing category hierarchy
- **Customer & User Management** — dual-guard system (`User` for admin/staff, `Customer` for storefront)
- **Authentication** — login, registration, forgot/reset password, and email verification, implemented separately for both guards across web and API
- **Order Processing** — cart, checkout, and order status flow with email notifications
- **REST API (`/api/v1`)** — Sanctum-authenticated, versioned, with dedicated Form Requests and API Resources for validation and response shaping, plus rate-limited endpoints
- **Event-driven notifications** — registration, order placement, and status updates dispatch queued emails via Events → Listeners → Mail
- **Route protection middleware** — custom middleware guarding email verification, login, password reset link, and password confirmation flows, on top of guard-specific auth middleware

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | PHP 8.3, Laravel 12 |
| Database | MySQL |
| Frontend | HTML, CSS, Bootstrap 4/5, JavaScript |
| API Auth | Laravel Sanctum |
| Containerization | Docker, Docker Compose (multi-stage builds) |
| CI/CD | GitHub Actions (matrix testing, dependency caching, Docker Hub deployment) |
| DB Admin | phpMyAdmin |

## Architecture

The codebase follows a layered architecture to keep controllers thin and business logic testable:

```
Controller → Service (business logic) → Repository (data access) → Model
```

- **Repositories** abstract database queries behind interfaces (e.g. `AuthRepositoryInterface`, `ProductRepositoryInterface`), bound in `AppServiceProvider`.
- **Services** hold business logic and orchestrate repositories, kept behind interfaces (`ProductServiceInterface`, `OrderServiceInterface`, etc.) for swappability and testing.
- **Events/Listeners** decouple side effects (sending emails) from the main request flow, dispatched onto queues.
- **Form Requests** (per API and web context) validate input before it reaches a Controller — e.g. `LoginApiRequest`, `StoreOrderApiRequest`, `ForgotPasswordApiRequest`.
- **API Resources** (`ProductResource`, `ProductCollection`, `OrderResource`) standardize JSON API responses.
- **Middleware** guards routes at the HTTP layer — separate concerns for guard auth (`AuthUserMiddleware`, `AuthCustomerMiddleware`), email verification, login state, password reset link validity, and password confirmation.

```
app/
├── Http/Controllers/   # Api/V1, Backend, Frontend — thin, delegate to Services
├── Services/           # Business logic, bound via Contracts/*Interface
├── Repositories/       # Data access, bound via Contracts/*Interface
├── Events/ + Listeners/# Decoupled side effects (registration, orders, verification)
├── Mail/                # Mailable classes
├── Models/
└── Http/Requests/      # Form Request validation (web + API)
```

## Getting Started

### Prerequisites
- Docker & Docker Compose

### Installation

```bash
# 1. Clone the repository
git clone https://github.com/Kim-ne/Minishop_test.git
cd Minishop_test

# 2. Copy environment file and configure DB credentials
cp .env.example .env

# 3. Build and start containers (app, nginx, mysql, phpmyadmin)
docker-compose up -d --build

# 4. Install dependencies and generate app key
docker-compose exec app composer install
docker-compose exec app php artisan key:generate

# 5. Run migrations
docker-compose exec app php artisan migrate
```

The app will be available at `http://localhost` and phpMyAdmin at `http://localhost:8080` (adjust ports to match your `docker-compose.yml`).

## CI/CD

GitHub Actions runs on every push/PR:
- **CI** (`ci.yaml`) — installs dependencies, runs the test suite against SQLite with matrix testing across PHP 8.2 / 8.3 / 8.4, with dependency caching via `actions/cache`
- **CD** (`cd.yaml`) — builds and pushes the Docker image to Docker Hub on merge to main

## Learning Focus

This project is a practical sandbox for backend engineering fundamentals, built incrementally:

1. Admin panel with Service/Repository pattern
2. REST API layer with Sanctum, versioning, and API Resources
3. Multi-guard authentication (password reset, email verification) with an Event/Listener/Queue pipeline
4. Dockerization (multi-stage builds, Compose stack)
5. CI/CD pipeline (caching, matrix testing, automated Docker deployment)

## License

This is a personal learning project and is not licensed for production use.
