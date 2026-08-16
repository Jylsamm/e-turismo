# Performance Reference

## Core Web Vitals Budgets

| Metric | Good | Needs Improvement | Poor |
|--------|------|-------------------|------|
| LCP (Largest Contentful Paint) | ≤ 2.5s | 2.5s – 4.0s | > 4.0s |
| CLS (Cumulative Layout Shift) | ≤ 0.1 | 0.1 – 0.25 | > 0.25 |
| INP (Interaction to Next Paint) | ≤ 200ms | 200ms – 500ms | > 500ms |

### Improving LCP
- Identify the LCP element (usually the hero image or largest above-fold text block) and prioritize its load.
- Preload the LCP image: `<link rel="preload" as="image" href="hero.webp">`.
- Serve images in modern formats (WebP, AVIF). Use `<picture>` with format fallbacks.
- Ensure the LCP resource is not blocked by render-blocking scripts or stylesheets.
- Host critical assets on the same origin or use a CDN with low TTFB.

### Preventing CLS
- Always set explicit `width` and `height` attributes on `<img>` and `<video>` elements so the browser reserves space before loading.
- Reserve space for dynamically injected content (ads, embeds, banners) using `min-height` or aspect-ratio CSS.
- Use `font-display: swap` or `font-display: optional` for web fonts to prevent invisible text during load (FOIT).
- Avoid inserting content above existing content after load.

### Improving INP
- Keep main-thread tasks under 50ms. Break up long tasks with `scheduler.yield()` or `setTimeout(..., 0)` chunking.
- Debounce expensive event handlers (scroll, resize, input).
- Defer non-critical JavaScript using `defer` or `type="module"`.
- Avoid synchronous layout reads (`.offsetWidth`, `.getBoundingClientRect()`) inside event loops without batching.

## Image Optimization

- **Formats**: AVIF > WebP > JPEG/PNG. Use `<picture>` with `<source type="image/avif">` and `<source type="image/webp">` fallbacks.
- **Responsive images**: use `srcset` with width descriptors and `sizes` attribute matching your CSS layout breakpoints.
- **Lazy loading**: add `loading="lazy"` to all below-fold images. Never lazy-load the LCP image.
- **Dimensions**: always specify `width` and `height` to prevent layout shift. CSS can override display size.
- **Compression**: target < 200KB for hero images, < 50KB for thumbnails after compression.
- **Placeholder**: use a low-quality placeholder (LQIP) or a dominant-color CSS background while the full image loads.

## Font Loading

- Use `<link rel="preconnect" href="https://fonts.googleapis.com">` and `<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>` before Google Fonts `<link>` tags.
- Preload the most critical font file (display face, regular weight): `<link rel="preload" as="font" type="font/woff2" href="..." crossorigin>`.
- Use `font-display: swap` to show fallback text immediately; use `font-display: optional` for non-critical fonts to avoid CLS.
- Subset fonts to only the characters/scripts you need (Latin subset is usually sufficient for English content).
- Self-host fonts when latency to external CDN is a concern; use `@font-face` with `woff2` format.
- Define a system font fallback stack that approximates the loaded font's metrics to minimize layout shift on swap.

## Perceived Performance Patterns

### Skeleton Screens
- Show structural placeholders (grey-shaded shapes matching the layout) while content loads.
- Animate skeletons with a subtle shimmer (`background: linear-gradient(...)` animated with `@keyframes`), respecting `prefers-reduced-motion`.
- Replace skeletons with real content in a single DOM update to avoid flash.

### Optimistic UI
- Immediately reflect the user's action in the UI before the server response confirms it.
- Roll back to the previous state and display an error if the request fails.
- Use `aria-busy="true"` and a subtle loading indicator during the pending period.

### Transition States for Async Fetches
- Disable the triggering control and show a spinner or progress indicator during submission.
- Provide a clear success or error state once the request settles.
- Avoid full-page loading spinners for partial updates — update only the affected region.

## Script Loading Strategy

- `defer`: for scripts that need the DOM but aren't immediately interactive. Executes in order after HTML parse.
- `async`: for independent scripts (analytics, ads) that don't depend on DOM or other scripts. Executes as soon as loaded, out of order.
- `type="module"`: deferred by default, supports ES module syntax, always strict mode.
- Critical CSS: inline above-fold styles in `<style>` tags; load the full stylesheet with `<link rel="stylesheet" media="print" onload="this.media='all'">` pattern to prevent render-blocking.
