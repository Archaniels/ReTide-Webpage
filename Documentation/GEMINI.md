# ReTide Project Overview

ReTide is a web application built with **Laravel 12** that incorporates a hybrid architecture, delegating some of its core CRUD operations to a secondary **Node.js (Express)** microservice. It features a blog, a marketplace, a donation system, and user account management.

## Architecture

- **Main Application (Laravel):** Handles routing, authentication, authorization (Admin/User), and primary views using Blade templates. It manages sessions and interacts with the database via Eloquent for some models, while using the `Illuminate\Support\Facades\Http` client to communicate with the Node.js API for others.
- **Node.js API (Express):** Located in `app/node/`, this service provides a RESTful API for handling Blogs, Products, and Donation Updates. it connects directly to a MySQL database using the `mysql` driver.
- **Frontend:** Built with **Tailwind CSS 4.0** and bundled using **Vite**. Assets are located in `resources/` and compiled to `public/build/`.
- **Deployment:** The project is configured for deployment on **Vercel** using the `vercel.json` configuration and a bridge in `api/index.php`.

## Technologies

- **PHP 8.2+** / **Laravel 12**
- **Node.js 20+** / **Express 5**
- **MySQL** (Database name: `retide-database`)
- **Tailwind CSS 4**
- **Vite**
- **Axios**

## Key Components

- **Controllers:**
  - `app/Http/Controllers/`: Primary Laravel controllers. Note that some controllers (e.g., `BlogPostsController`) use the Node.js API for `edit`, `update`, and `destroy` operations.
  - `app/node/controller/`: Controllers for the Express API.
- **Models:**
  - `app/Models/`: Laravel Eloquent models (User, BlogPost, Donation, etc.).
- **Routes:**
  - `routes/web.php`: Primary web routes and admin middleware application.
  - `app/node/routes/`: API routes for the Node.js service.
- **Admin Section:** Protected by `AdminMiddleware`, located under the `/admin` prefix.

## Building and Running

### Development Setup

To run the full development environment, you need to start the Laravel server, the Node.js API, and the Vite dev server.

1.  **Install Dependencies:**
    ```bash
    composer install
    npm install
    cd app/node && npm install && cd ../..
    ```

2.  **Environment Configuration:**
    - Copy `.env.example` to `.env` and configure your database settings.
    - Ensure your MySQL server has a database named `retide-database`.
    - Note that `app/node/config/db.js` has hardcoded credentials which may need updating for your local environment.

3.  **Run All Services (using Concurrently):**
    The project provides a convenience command in `composer.json`:
    ```bash
    npm run dev
    ```
    *Alternatively, run them separately:*
    - Laravel: `php artisan serve`
    - Node API: `node app/node/app.js`
    - Assets: `npm run dev`

### Testing

Run Laravel tests using:
```bash
php artisan test
```

## Development Conventions

- **Hybrid CRUD:** When modifying Blog or Marketplace logic, check both the Laravel controller (`app/Http/Controllers`) and the Node.js service (`app/node`) as logic may be split or delegated.
- **Styling:** Use Tailwind CSS utility classes. The project uses the latest Tailwind 4 features.
- **Authentication:** Standard Laravel Auth is used. Role-based access is implemented via a `role` column on the `users` table and `AdminMiddleware`.
- **API Communication:** Laravel uses internal HTTP calls to `http://localhost:3000` for certain data operations. Ensure the Node service is running for these features to work.
