# JomKid Kids-First Design Contract

## Design read

JomKid should feel like a bright playroom with one activity ready on the floor, not a SaaS page, workbook, or bordered editorial poster. Parents should understand the offer immediately; children should recognize a simple game surface immediately. Yellow is the core brand signal, used for the sun, active progress, primary actions, and selected states. The page itself remains warm cream with open breathing room. Rounded sky-blue, coral, lavender, and leaf-green play surfaces support the yellow without competing with it.

## Visual evidence inspected on UIZZE

Five actual screens were visually inspected from the public Drops catalogue at `https://uizze.com/apps/69b962ab002a236f4d01`:

1. **Goal selection**: one question, vertically stacked large rounded answers, a slim progress rail, and a persistent bottom continue action. Transfer: one decision per surface and large touch targets. Do not copy purple palette, wording, or exact list geometry.
2. **Practice-time selection**: large open middle area, one simple line illustration, one dominant value, and one wide bottom CTA. Transfer: generous whitespace and one focal interaction. Do not copy skyline art, time slider, neon-lime-on-purple palette, or copy.
3. **Letter-path lesson**: instruction at top, one central subject illustration, oversized circular letter targets, and compact progress at the bottom. Transfer: make the playable demo the visual hero and keep controls child-sized. Do not copy city art, letter arrangement, trail geometry, or blue palette.
4. **Starter-pack home**: a clear current lesson, short progress, a single continue action, and future content visually subordinate/locked. Transfer: show JomABC as the active world and upcoming worlds as secondary. Do not copy pack names, locks, tabs, badges, or artwork.
5. **Answer-checking state**: a single full-screen status message inside a large progress ring with no competing controls. Transfer: payment and game states should communicate one status and one next action. Do not copy teal color, ring proportions, or wording.

Checkout-flow evidence from UIZZE index:
- Udemy `Shopping cart > Completing checkout` (`69b96edf0006415fad2b`): ordered checkout flow with button, card, and text field patterns.
- Luma `Pricing` (`69b95aae000d3d59630d`): plan choice before payment detail.
- Luma `Adding a payment method` (`69b95aad0026065afe75`): payment details remain visually quieter than the purchase decision.

Some public flow-detail routes returned incomplete direct views, so only indexed flow structure is used from those sources. No uninspected visual expression is claimed or copied.

## Contract

| Field | Decision |
| --- | --- |
| Primary user | Malaysian parent evaluating a Bahasa Melayu game-first web app for a child. |
| Primary action | Choose Basic RM69 lifetime or Premium RM99 lifetime and continue to CHIP. |
| Landing hierarchy | 1. Value proposition + RM69 starting price. 2. Large playable JomABC demo. 3. Short session loop. 4. Available/future worlds. 5. Parent progress. 6. Package decision. |
| Checkout hierarchy | 1. Small journey header. 2. Two large package choices. 3. Stable order summary. 4. Name and purchase-bound email. 5. One CHIP CTA. |
| Core palette | Warm cream `#FFF9E8`; sunny yellow `#FFD84D`; deep navy `#17213B`; sky `#78C9FF`; coral `#FF8F78`; leaf `#8ED39F`; lavender `#B8A7F5`; white. |
| Geometry | 24–36px friendly radii, circular game controls, soft 1px tinted outlines only where grouping is required. No thick black borders, clipped speech corners, ticket cards, or stacked offset panels. |
| Typography | Heavy friendly display headings with restrained tracking; readable 16–18px body text; short child-facing instructions. |
| Illustration | Original CSS/SVG-like geometric learning objects only: letter blocks, sun, clouds, pencil, book, headphones, progress path. No mascot and no copied character or scenery. |
| Interaction states | Demo idle, listening, wrong, retry, correct. Package Basic/Premium selected with check + label, not color alone. Form idle, validation error, processing. Result paid, processing, failed. |
| Motion | Small lift/scale on game choices and gentle floating background shapes; disabled under reduced motion. No constant bouncing CTA or decorative motion overload. |
| Responsive | At 390px, headline and primary CTA fit the first viewport; demo stacks below. Package choice and buyer form become one column. All controls remain at least 44px. No horizontal overflow. |
| Truth constraints | No testimonials, ratings, child counts, awards, safety claims, fake game counts, urgency, discounts, or installable-PWA claim. PWA support remains forthcoming until manifest/service worker/offline behavior are verified. |
| Business constraints | Basic RM69 lifetime, max 3 profiles, no affiliate. Premium RM99 lifetime, unlimited profiles, reseller/affiliate, direct 50% commission. Server controls prices. Verified CHIP webhook controls access-code issuance. |

## Acceptance criteria

- Landing, checkout, and result pages are visibly one kids-friendly system.
- Yellow is the core signal but does not flood every surface.
- No owl/Oji mascot, thick black outlines, editorial ticket cards, or generic SaaS feature grid.
- Hero has one dominant CTA and truthful RM69 lifetime entry price.
- Demo supports wrong, retry, and correct feedback with accessible announcements.
- Checkout package state is semantic and visibly selected without color alone.
- RM69/RM99 values match selector, summary, CTA, and server catalogue.
- Desktop and 390px QA show no clipping, overlap, horizontal overflow, console errors, dead links, or controls below 44px.
- Full frontend checks, PHP checks, Laravel tests, and GitHub Actions pass.
