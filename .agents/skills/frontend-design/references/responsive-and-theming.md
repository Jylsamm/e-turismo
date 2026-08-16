# Responsive Design & Theming Reference

## Mobile Touch Targets and Gestures

- Minimum touch target size: 44×44px (Apple HIG) or 48×48dp (Material). Padding the visible element is acceptable; the hit area must meet the minimum.
- Ensure 8px minimum gap between adjacent touch targets to prevent mis-taps.
- For custom swipe/drag gestures: handle `pointerdown`, `pointermove`, `pointerup` (Pointer Events API) rather than touch events — this handles mouse, touch, and stylus in one handler.
- Add `touch-action: pan-y` (or `pan-x`) to scrollable containers to prevent browser interference with horizontal/vertical swipe gestures.
- Avoid hover-only interactions for any functionality that must be accessible on touch.

## Fluid Typography with `clamp()`

Use `clamp(min, preferred, max)` to scale type fluidly between breakpoints without media queries:

```css
/* Formula: clamp(min-size, min-size + (max-size - min-size) * (100vw - min-vw) / (max-vw - min-vw), max-size) */
font-size: clamp(1rem, 0.875rem + 0.625vw, 1.375rem);
```

- Set the `min` at mobile viewport, `max` at desktop viewport, and let `preferred` scale linearly between.
- Apply `clamp()` to the type scale root (`--fs-base`, `--fs-lg`, etc.) and use `rem` multiples for derived sizes.
- Avoid using `vw` units alone for font sizes — always clamp to prevent text from becoming unreadably large or small.

## Container Queries

Use container queries to make components respond to their container size, not the viewport:

```css
.card-wrapper {
  container-type: inline-size;
  container-name: card;
}

@container card (min-width: 400px) {
  .card { flex-direction: row; }
}
```

- Prefer `container-type: inline-size` (width-only) over `size` (width + height) to avoid circular dependencies.
- Use for reusable components (cards, sidebars, widgets) that may appear at different sizes across layouts.
- Combine with viewport media queries for page-level layout shifts.

## Dark Mode / `prefers-color-scheme`

### Architecture: CSS Custom Properties

Define your entire palette as CSS custom properties on `:root`, then override in a dark scheme block:

```css
:root {
  --color-bg: #ffffff;
  --color-surface: #f5f5f5;
  --color-text-primary: #111111;
  --color-text-secondary: #555555;
  --color-accent: #0066cc;
}

@media (prefers-color-scheme: dark) {
  :root {
    --color-bg: #0f0f0f;
    --color-surface: #1a1a1a;
    --color-text-primary: #f0f0f0;
    --color-text-secondary: #aaaaaa;
    --color-accent: #4da6ff;
  }
}

/* For user-toggled theme (add data-theme attribute to <html>) */
[data-theme="dark"] {
  /* same overrides as above */
}
```

- Never hardcode color values outside the custom property definitions.
- Re-check WCAG contrast ratios for both light and dark themes independently — a passing light palette often fails in dark.
- Images and media: use CSS `filter: brightness(0.8)` on `<img>` in dark mode to reduce harshness, or provide separate dark-mode image sources via `<picture>` with `prefers-color-scheme` media in `<source media>`.

### Respecting User Preference vs. System Toggle
- Detect preference on load with `window.matchMedia('(prefers-color-scheme: dark)')`.
- Persist user overrides in `localStorage`; apply the `data-theme` attribute before first paint (in a `<script>` in `<head>`) to prevent flash of wrong theme.

## RTL / Internationalization

### Logical Properties
Replace directional physical properties with logical equivalents so layout flips correctly in RTL:

| Physical | Logical |
|----------|---------|
| `margin-left` | `margin-inline-start` |
| `margin-right` | `margin-inline-end` |
| `padding-left` | `padding-inline-start` |
| `border-left` | `border-inline-start` |
| `text-align: left` | `text-align: start` |
| `float: left` | `float: inline-start` |

- Set `dir="rtl"` on `<html>` for RTL languages; CSS logical properties handle the rest automatically.
- Flexbox and Grid respect the document direction when using `flex-start`/`flex-end` — prefer these over `left`/`right`.

### Text Expansion Tolerance
- UI strings translated to German, French, or Finnish can be 30–50% longer than English equivalents.
- Never fix-width containers for label text; use `min-width` + `max-content` or allow wrapping.
- Test layouts with 150% string length to catch overflow issues early.
- Use `overflow-wrap: break-word` and `hyphens: auto` on body text regions as a safety net.
