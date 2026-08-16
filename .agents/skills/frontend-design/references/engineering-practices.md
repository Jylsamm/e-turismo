# Engineering Practices Reference

## Cross-Browser Quirks (especially Safari)

### Safari-Specific Issues
- **`position: sticky` inside `overflow: hidden/auto`**: sticky positioning breaks if any ancestor has `overflow` set. Remove `overflow` from ancestors or restructure the DOM.
- **Flexbox `gap` in older Safari** (< 14.1): use margin-based workarounds or confirm your target browser range.
- **`<input>` and `<button>` styling**: Safari applies system appearance by default. Use `-webkit-appearance: none; appearance: none` to fully control styling.
- **`100vh` on mobile Safari**: the viewport height includes the browser chrome, causing overflow. Use `100dvh` (dynamic viewport height) where supported, with `100vh` as fallback: `height: 100dvh`.
- **CSS grid subgrid**: check support table for your target Safari version before using.
- **Date/time inputs**: `<input type="date">` behavior differs across browsers. Verify the UX or use a custom datepicker.
- **Custom `@font-face` with `font-display: swap`**: supported in Safari 11.1+. Test for FOUT behaviour.
- **`backdrop-filter`**: requires `-webkit-backdrop-filter` prefix for Safari.

### Firefox-Specific Issues
- **Scrollbar width**: Firefox shows a scrollbar by default on overflow containers, shifting layout. Use `scrollbar-gutter: stable` to reserve space consistently.
- **`focus-visible` polyfill**: Firefox has historically handled `:focus-visible` differently. Test keyboard focus styles.

### General Cross-Browser
- Use `@supports` queries to progressively enhance with newer CSS features.
- Test on real devices (not just emulators) for touch behaviour, font rendering, and scroll performance.
- Use `autoprefixer` in your build pipeline to add vendor prefixes automatically.

## Testing Strategy

### What to Prioritize
1. **Critical user paths first**: the interactions that generate revenue or are core to the product's value (checkout, login, primary CTA).
2. **Unit tests**: pure utility functions, data transformations, validation logic — fast to write and run.
3. **Integration/component tests**: UI components in isolation with realistic data, verifying that they render and respond to interactions correctly.
4. **End-to-end (E2E) tests**: full user flows in a real browser. Expensive to maintain; limit to the most critical 5–10 paths.

### Tools
- **Unit/integration**: Vitest or Jest + Testing Library (React/Vue/etc.)
- **E2E**: Playwright (preferred for cross-browser), Cypress
- **Accessibility**: axe-core integrated into component tests; Pa11y for CI page-level checks
- **Visual regression**: Playwright screenshots or Chromatic (Storybook)

### Practical Rules
- Test behaviour, not implementation: assert what the user sees and can do, not internal function calls.
- Mock network requests at the integration level (MSW — Mock Service Worker); use real network in E2E.
- Keep tests fast. If a test suite takes > 5 minutes, engineers stop running it locally.
- Snapshot tests for UI components are fragile; prefer explicit assertions over snapshots.

## Component Architecture / Design System Integration

### Token Usage
- Always consume design tokens (custom properties or JS token objects) rather than hardcoded values. This ensures changes propagate correctly and theming works.
- Document token usage at the component level (which tokens a component consumes) so the design system relationship is explicit.

### Component Boundaries
- A component should own its internal layout but not impose external spacing. Let the parent/layout layer control margins between components.
- Avoid deeply nested component structures where a child needs to know about a grandparent's context — lift state up or use context/slots.
- Prefer composition over configuration: a component with ten boolean props for layout variants should instead expose slots or sub-components.

### Design System Contribution
- New patterns added to a one-off page should be evaluated for promotion to the design system if they'll recur.
- Before building custom, check whether the design system already provides the needed component — don't diverge unnecessarily.

## Print Stylesheets

```css
@media print {
  /* Hide navigation, footers, interactive controls */
  nav, footer, button, .no-print { display: none !important; }

  /* Expand truncated URLs */
  a[href]::after { content: " (" attr(href) ")"; font-size: 0.8em; }

  /* Prevent widows/orphans */
  p { orphans: 3; widows: 3; }
  h1, h2, h3 { page-break-after: avoid; }

  /* Use black on white for ink efficiency */
  body { color: #000; background: #fff; }

  /* Ensure tables don't split awkwardly */
  tr { page-break-inside: avoid; }
}
```

- Test print output in browser print preview before shipping content-heavy pages (articles, invoices, reports).
- Use `@page` to set margins and page size for documents intended for printing.

## Analytics and Telemetry Hooks

- Instrument meaningful events, not every click: track actions that map to user goals (form submitted, file downloaded, checkout completed).
- Use `data-analytics` or `data-track` attributes on elements to decouple tracking logic from component logic.
- Respect `Do Not Track` (`navigator.doNotTrack`) and cookie consent frameworks — do not fire analytics before consent is given where required (GDPR, CCPA).
- For Core Web Vitals telemetry, use the `web-vitals` library: it provides accurate LCP, CLS, and INP measurements you can pipe to your analytics endpoint.
- Avoid blocking the main thread with synchronous analytics calls; use `navigator.sendBeacon()` for reliable, non-blocking event dispatch on page unload.
