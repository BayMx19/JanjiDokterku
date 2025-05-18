<p align="center">
  <a href="https://laravel.com" target="_blank" style="margin-right: 30px;">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="250" alt="Laravel Logo">
  </a>
  <a href="https://vuejs.org" target="_blank">
    <img src="https://upload.wikimedia.org/wikipedia/commons/f/f1/Vue.png" width="120" alt="Vue.js Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About This Project

This project is built on **Laravel** as the backend framework combined with **Vue.js** on the frontend, integrated through **Inertia.js** to provide a seamless single-page application experience.

We use Laravel for robust API and server-side logic, and Vue.js for interactive and reactive user interfaces.

## Key Features

- **Laravel** for backend with expressive syntax and powerful tools:
  - Routing
  - Eloquent ORM
  - Migrations
  - Queues and broadcasting
- **Vue.js** for frontend reactive components
- **Inertia.js** to connect Laravel backend and Vue frontend without the need for a separate API
- Modern frontend tooling with Vite (or Laravel Mix) for asset bundling

## Getting Started

### Prerequisites

- PHP >= 8.0
- Composer
- Node.js & npm/yarn
- Database (MySQL, PostgreSQL, etc.)

### Installation

```bash
git clone https://github.com/your-repo/your-project.git
cd your-project

# Install backend dependencies
composer install

# Install frontend dependencies
npm install

# Copy environment file and generate app key
cp .env.example .env
php artisan key:generate

# Setup database configuration in .env file

# Run migrations and seeders
php artisan migrate --seed

# Build frontend assets and start development server
npm run dev

# Or build production assets
npm run build

# Serve Laravel app
php artisan serve
