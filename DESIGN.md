# JomKid Game-First Web App Design Contract

## Evidence

| Reference | Transferable decision | Why it fits JomKid | Do not copy |
| --- | --- | --- | --- |
| [Duolingo: completing the first lesson](https://uizze.com/flows/69b9648e002f967a6694) | A lesson introduces one instruction, one answer action, immediate feedback, and a clear retry/continue loop. | JomABC games need to feel playable before purchase and understandable to young children. | Characters, green palette, illustrations, exact controls, rewards, or copy. |
| [Brilliant: completing the first lesson](https://uizze.com/flows/69b96062003e0dbf27ba) | Complex learning content is broken into focused steps with progress context rather than one dense page. | Supports JomKid's short listen, choose, match, and retry sessions. | Exact card geometry, typography, lesson content, or navigation.
| [Duolingo: Home to Courses](https://uizze.com/flows/69b96491001df5475af6) | Course/world selection exposes current availability and progress before deeper detail. | Fits JomABC as the first available world and JomMengaji/JomMengira as clearly unavailable future worlds. | Course map artwork, path shape, icons, achievements, or naming.
| [Luma: Pricing](https://uizze.com/flows/69b95aae000d3d59630d) | Plan choice, entitlement comparison, selected state, and next action stay within one decision flow. | Fits Basic/Premium lifetime selection without splitting package facts across several pages. | Exact pricing cards, color, wording, or subscription framing.
| [Luma: Adding a payment method](https://uizze.com/flows/69b95aad0026065afe75) | Payment input remains visually quieter than the order decision, with one dominant submit action and explicit status handling. | Fits JomKid's package selection plus buyer e-mail and CHIP redirect. | Payment-provider UI, accordion arrangement, fields, or exact composition.

UIZZE's interactive search returned an unrelated screen for one free-text query, and some indexed flow pages returned incomplete direct views. The public indexed flow metadata above is the available evidence; repository rules and rendered QA remain the primary implementation evidence.

## Contract

| Field | Decision |
| --- | --- |
| Screen job | Landing explains why JomKid is a game-first Bahasa Melayu web app and moves a parent to a truthful package choice. Checkout lets that parent select Basic/Premium, provide the purchase-bound e-mail, and continue to CHIP. |
| Primary user and action | Malaysian parent chooses a lifetime package and starts payment. The child-facing mini-game is a supporting demonstration, not the conversion action. |
| Content hierarchy | First: playable JomABC value and RM69 starting price. Second: game formats, available/future worlds, and parent controls. Third: Basic/Premium entitlements and checkout. |
| Navigation and controls | Four real landing anchors, one above-fold checkout CTA, semantic game buttons with retry/correct feedback, a semantic package radiogroup, two labelled inputs, and one payment submit. |
| Visual language | Mango yellow is the core surface and brand tile. Deep ink provides contrast. Sky blue, coral, and leaf green communicate game/state differences only. Thick ink borders and clipped speech-corner radii are used on product surfaces. No mascot. No gradients. |
| Required states | Mini-game: idle, sound feedback, incorrect, retry, correct. Package: Basic selected, Premium selected, processing, validation errors, CHIP initiation error. Result: paid, processing, failed. Auth/permission behavior stays server-controlled. |
| Responsive behavior | Desktop uses paired explanation/product surfaces and a sticky buyer form. Mobile keeps the primary CTA fully visible in a 390×577 viewport, stacks package controls in decision order, keeps inputs/CTA at least 44px, and avoids horizontal overflow. Keyboard focus and reduced motion remain supported. |
| Evidence used | Five UIZZE flows listed above plus current Laravel package, payment, access-code, child-profile, and role rules. |
| Forbidden defaults | Owl/character mascot; generic hero-feature-testimonial template; fake game counts, ratings, awards, testimonials, safety claims, or installability; inert game controls; subscription language; color-only plan state; multiple competing payment CTAs. |
| Acceptance criteria | No owl/Oji references on landing or checkout. Yellow is the dominant brand surface. Prices remain RM69/RM99 and server-authoritative. All anchors resolve. Mini-game wrong/retry/correct works. Both packages update summary and CTA. Landing/checkout/result pass desktop and 390px QA without overflow, clipping, console errors, or tap targets below 44px. Full frontend/backend gates and CI pass. |

## Product reality

JomKid currently has no web manifest or service worker in the repository. The landing therefore describes a mobile-first web app and labels installable PWA support as forthcoming, rather than claiming it is already installable.
