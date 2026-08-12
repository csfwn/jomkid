# JomKid

JomKid is an interactive learning platform for Malaysian children, parents, affiliates, and administrators at [jomkid.com](https://jomkid.com). JomABC is the first learning module; JomMengaji and JomMengira are planned as additional modules.

## Stack

- Laravel 13
- Vue 3 + TypeScript
- Inertia 3
- Tailwind CSS 4 + shadcn-vue
- SQLite locally; production database is configurable
- Pest/PHPUnit, PHPStan, ESLint, Prettier, and Vue TypeScript checks

## Product surfaces

- Public conversion-focused landing page
- Basic RM69 lifetime: maximum 3 child profiles, no reseller/affiliate rights
- Premium RM99 lifetime: unlimited child profiles and reseller/affiliate rights
- Registration is blocked without a valid unused code bound to the purchase email
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

## CHIP Collect payment setup

Checkout uses CHIP Collect's hosted payment page. Configure these values only in the deployment environment; never commit live credentials:

```dotenv
CHIP_BASE_URL=https://gate.chip-in.asia/api/v1
CHIP_SECRET_KEY=
CHIP_BRAND_ID=
CHIP_PUBLIC_KEY=
CHIP_TIMEOUT=15
```

`CHIP_PUBLIC_KEY` is optional. When omitted, JomKid retrieves and caches the company callback public key from CHIP's authenticated `/public_key/` endpoint.

In the CHIP merchant portal, register this public HTTPS endpoint:

```text
https://jomkid.com/webhooks/chip
```

Subscribe it to at least `purchase.paid`, `purchase.payment_failure`, and `purchase.cancelled`. The webhook verifies `X-Signature` against the exact raw request body before changing payment, access-code, lifetime-access, or affiliate commission state. Browser redirects are never treated as proof of payment.

Only Premium buyers receive an affiliate code and reseller license. Affiliate sales use `?ref=AFFILIATE_CODE` and earn 50% of the directly referred customer's package price (RM34.50 for Basic or RM49.50 for Premium). A verified payment creates exactly one one-time registration code and one commission that is available immediately for payout. The plaintext code is sent by email and only its SHA-256 hash is stored. Redeeming it once activates lifetime access. Every completed purchase is a final sale and cannot be refunded.

## Quality gates

```bash
composer ci:check
```

The repository CI runs the same checks for every push to `main` and every pull request.
