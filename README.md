# Cubik3
[![FOSSA Status](https://app.fossa.com/api/projects/git%2Bgithub.com%2FAlanaktion%2Fcubik3.svg?type=shield)](https://app.fossa.com/projects/git%2Bgithub.com%2FAlanaktion%2Fcubik3?ref=badge_shield)


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
php artisan storage:link
npm run dev
```

Then, either set up a web server pointing to the `public/` directory, or run `php artisan serve` to start a local development server.


## License
[![FOSSA Status](https://app.fossa.com/api/projects/git%2Bgithub.com%2FAlanaktion%2Fcubik3.svg?type=large)](https://app.fossa.com/projects/git%2Bgithub.com%2FAlanaktion%2Fcubik3?ref=badge_large)