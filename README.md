# Cubik3

An open source self-hosted social network, built with Laravel, Vue.js, and Tailwind CSS.

**This project is still in early development and is not usable yet.**

## Installation

Clone the repository, then:

```bash
composer install
cp .env.example .env
```

Add your database connection information to the `.env` file, then continue:

```bash
php artisan migrate
npm run dev
```

Then, either set up a web server pointing to the `public/` directory, or run `php artisan serve` to start a local development server.
