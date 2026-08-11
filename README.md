# JomABC

JomABC is an interactive learning platform for Malaysian children, parents, affiliates, and administrators. The production domain is planned for [jomkid.com](https://jomkid.com).

## Stack

- Laravel 13
- Vue 3 + TypeScript
- Inertia 3
- Tailwind CSS 4 + shadcn-vue
- SQLite locally; production database is configurable
- Pest/PHPUnit, PHPStan, ESLint, Prettier, and Vue TypeScript checks

## Product surfaces

- Public conversion-focused landing page
- Parent/customer account and child profiles
- Interactive learning, scoring, and privacy-safe ranking
- Single-level affiliate dashboard
- Role-protected administration

## Local setup

```bash
composer setup
composer run dev
```

When PHP is not installed on the host, Composer and Artisan may be run through Docker. Frontend commands require Node.js 22 or newer.

## Quality gates

```bash
composer ci:check
```

The repository CI runs the same checks for every push to `main` and every pull request.