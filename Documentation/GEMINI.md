# ReTide Project Overview

ReTide is a web application built with **Laravel 12**. It features a blog, a marketplace, a donation system, and user account management.

## Architecture

- **Main Application (Laravel):** Handles routing, authentication, authorization (Admin/User), and primary views using Blade templates. It manages sessions and interacts with the database exclusively via **Eloquent ORM**.
- **Frontend:** Built with **Tailwind CSS 4.0** and bundled using **Vite**. Assets are located in `resources/` and compiled to `public/build/`.
- **Deployment:** The project is configured for deployment on **Vercel** using the `vercel.json` configuration and a bridge in `api/index.php`.

## Technologies

- **PHP 8.2+** / **Laravel 12**
- **MySQL** (Database name: `retide-database`)
- **Tailwind CSS 4**
- **Vite**

## Key Components

- **Controllers:**
  - `app/Http/Controllers/`: Primary Laravel controllers handling all CRUD operations.
- **Models:**
  - `app/Models/`: Laravel Eloquent models (User, BlogPost, Donation, MarketplaceProduct, DonationUpdate, etc.).
- **Routes:**
  - `routes/web.php`: Primary web routes and admin middleware application.
- **Admin Section:** Protected by `AdminMiddleware`, located under the `/admin` prefix.

## Building and Running

### Development Setup

To run the development environment:

1.  **Install Dependencies:**
    ```bash
    composer install
    npm install
    ```

2.  **Environment Configuration:**
    - Copy `.env.example` to `.env` and configure your database settings.
    - Ensure your MySQL server has a database named `retide-database`.

3.  **Run Services:**
    - Laravel: `php artisan serve`
    - Assets: `npm run dev`

### Testing

Run Laravel tests using:
```bash
php artisan test
```

## Development Conventions

- **CRUD:** All CRUD operations are implemented using Laravel Eloquent.
- **Styling:** Use Tailwind CSS utility classes. The project uses the latest Tailwind 4 features.
- **Authentication:** Standard Laravel Auth is used. Role-based access is implemented via a `role` column on the `users` table and `AdminMiddleware`.

