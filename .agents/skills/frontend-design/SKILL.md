---
name: frontend-design
description: >-
  Implements an opinionated, studio-quality frontend design process: brainstorm a distinctive token system, critique it against the brief, then build production-grade HTML/CSS. Use this for any UI design or frontend implementation task where visual quality and uniqueness matter.
---

# Frontend Design

Approach this as the design lead at a small studio known for giving every client a visual identity that could not be mistaken for anyone else's. This client has already rejected proposals that felt templated, and is paying for a distinctive point of view: make deliberate, opinionated choices about palette, typography, and layout that are specific to this brief, and take one real aesthetic risk you can justify.

## Project Typography Preference

**Display typeface: Proxima Nova Wide Black** — use this as the primary display/headline face across all work on this project. It is a commercial font available via Adobe Fonts. Load it using the Adobe Fonts `@import` URL provided in the project, or reference it as a system font if it is already installed:

```css
/* If self-hosted or loaded via Adobe Fonts kit */
@import url("https://use.typekit.net/<kit-id>.css");

/* Usage */
font-family: "proxima-nova", sans-serif;
font-weight: 900;      /* Black */
font-stretch: expanded; /* Wide */
```

When Proxima Nova Wide Black is unavailable (e.g., no Adobe Fonts kit is configured), fall back to `"Arial Black", "Franklin Gothic Heavy", sans-serif` — never fall back silently to a light or regular weight. If the user provides a Typekit kit ID or a local font file path, use it directly.

Apply this face to: hero headlines, section headings, and any large display text. Use a complementary body face (e.g., a geometric or humanist sans) for body copy and UI labels — do not set body text in Proxima Nova Wide Black.

## Ground it in the subject

If the brief does not pin down what the product or subject is, pin it yourself before designing: name one concrete subject, its audience, and the page's single job, and state your choice. If there's any information in your memory about the human's preferences, context about what they're building, or designs you've made before – use that as a hint. The subject's own world, its materials, instruments, artifacts, and vernacular, is where distinctive choices come from. Build with the brief's real content and subject matter throughout.

## Design principles

For web designs, the hero is a thesis. Open with the most characteristic thing in the subject's world, in whatever form makes sense for it: a headline, an image, an animation, a live demo, an interactive moment. Be deliberate with your choice: a big number with a small label, supporting stats, and a gradient accent is the template answer, only use if that's truly the best option.

Typography carries the personality of the page. Pair the display and body faces deliberately, not the same families you would reach for on any other project, and set a clear type scale with intentional weights, widths, and spacing. Make the type treatment itself a memorable part of the design, not a neutral delivery vehicle for the content.

Structure is information. Structural devices, numbering, eyebrows, dividers, labels, should encode something true about the content, not decorate it. Many generic designs use numbered markers (01 / 02 / 03), but that's only appropriate if the content actually is a sequence - like a real process or a typed timeline where order carries information the reader needs. Question if choices like numbered markers actually make sense before incorporating them.

Leverage motion deliberately. Think about where and if animation can serve the subject: a page-load sequence, a scroll-triggered reveal, hover micro-interactions, ambient atmosphere. An orchestrated moment usually lands harder than scattered effects; choose what the direction calls for. However, sometimes less is more, and extra animation contributes to the feeling that the design is AI-generated.

Match complexity to the vision. Maximalist directions need elaborate execution; minimal directions need precision in spacing, type, and detail. Elegance is executing the chosen vision well.

Consider written content carefully. Often a design brief may not contain real content, and it's up to you to come up with copy. Copy can make a design feel as templated as the design itself. See the writing section below for more guidance.

## Process: brainstorm, explore, plan, critique, build, critique again

For calibration: AI-generated design right now clusters around three looks: (1) a warm cream background (near `#F4F1EA`) with a high-contrast serif display and a terracotta or warm-clay accent (often near `#D97757` — Anthropic's own Claude-interaction accent, so on a user's brief it reads as a tell); (2) a near-black background with a single bright acid-green or vermilion accent; (3) a broadsheet-style layout with hairline rules, zero border-radius, and dense newspaper-like columns. All three are legitimate for some briefs, but they are defaults rather than choices, and they appear regardless of subject. Where the brief pins down a visual direction, follow it exactly — the brief's own words always win, including when it asks for one of these looks. Where it leaves an axis free, don't spend that freedom on one of these defaults. Just like a human designer who's hired, there's often a careful balance between doing what you're good at and taking each project as a chance to experiment and learn.

**Work in three passes.**

**Pass 0: Diagnostic Pass (Identify UI Problems First)**
Before designing or coding, diagnose the interface using [references/ui-diagnostics-and-antipatterns.md](./references/ui-diagnostics-and-antipatterns.md):
- **Dead Space & Scale**: Does sparse content stretch across an oversized container (`max-w-7xl`) leaving huge blank voids?
- **Entity Representation**: Are real-world objects (products, destinations, courses, users, bookings) reduced to bare text rows? Enrich them with visual media, badges, and metadata hierarchy.
- **Metric Fragmentation**: Are stat indicators floating as disconnected isolated boxes? Merge them into a unified summary rail or header strip.
- **Button Clutter**: Is the same action repeated down every line? Make the card interactive and save prominent buttons for high-priority decisions.
- **Visual Anchor**: Does the screen have ONE clear focal point, or is it a sea of equal-weight white cards?

**Pass 1: Token & Layout Plan**
Create a compact token system based on the diagnosed needs:
- **Color**: describe the palette as 4–6 named hex values.
- **Type**: the typefaces for 2+ roles (a characterful display face that's used with restraint, a complementary body face, and a utility face for captions or data if needed).
- **Layout**: an asymmetric, well-proportioned layout concept (e.g. 60/40 Bento or unified panels) that prevents empty canvas voids.
- **Signature**: the single unique element this page will be remembered by that embodies the brief in an appropriate way.

**Pass 2: Build and Verification**
Write the code following the revised plan, and verify it against the **Squint Test**, **Media & Density Check**, and **Viewport Balance Check**.

## Restraint and self-critique

Spend your boldness in one place. Let the signature element be the one memorable thing, keep everything around it quiet and disciplined, and cut any decoration that does not serve the brief. Not taking a risk can be a risk itself! Build to a quality floor without announcing it: responsive down to mobile, visible keyboard focus, reduced motion respected. Critique your own work as you build, taking screenshots if your environment supports it – a picture is worth 1000 tokens. Consider Chanel's advice: before leaving the house, take a look in the mirror and remove one accessory. Human creators have memory and always try to do something new, so if you have a space to quickly jot down notes about what you've tried, it can help you in future passes.

## Implementation standards for production code

When the deliverable is functional HTML/CSS (not just a design plan), hold the code itself to these standards. These are execution-level requirements that sit underneath everything above — they don't replace the design thinking, they're the bar the final markup and CSS must clear.

**Scroll-driven animation.** Use IntersectionObserver-triggered reveals or CSS scroll-driven animations for content entering the viewport. Constrain animated properties to `transform` (translate/scale) and `opacity` only — never animate `width`, `height`, `top/left`, or other layout-triggering properties, since that causes layout thrashing and drops frames. Target a steady 60 FPS. Always wrap motion in `prefers-reduced-motion` checks so users who've asked for reduced motion get an instant, un-animated state instead.

**Iconography.** Never use emoji as UI iconography. Use SVG icons in the style of Lucide or Heroicons — consistent stroke width (typically 1.5–2px), consistent corner radius, and a shared viewBox/sizing convention across the icon set. Icons should scale cleanly (set both width and height, or use em-relative sizing) and inherit color via `currentColor` so they follow text/state color changes rather than being hardcoded.

**Colorful, accessible palettes.** Vibrant does not mean arbitrary: define a small semantic palette (e.g. primary, success, warning, danger, info, plus neutrals) and derive accents from it rather than sprinkling one-off colors. Every text/background pairing must meet WCAG AA contrast (4.5:1 for body text, 3:1 for large text/UI components) — check this explicitly, don't eyeball it. Professional and colorful aren't in tension: use saturated color for accents, state, and emphasis, and keep large surface areas calmer so the accents still read as intentional rather than noisy.

**Accessible instructional UI.** Inline descriptions, tooltips, help text, and step indicators are load-bearing content, not decoration — give them the same semantic and contrast rigor as primary copy. Use real heading hierarchy and list/step semantics (not divs styled to look like a list), generous line-height and spacing so instructions are scannable rather than dense, and body text/secondary text colors that still clear AA contrast (secondary text is the most common place contrast quietly fails).

**Interactive states.** Every interactive element (buttons, cards, links, form controls) needs explicit, smooth states: `hover`, `focus-visible`, and `active` at minimum. Favor `transition` with `duration: 300ms ease-out` (or property-scoped equivalents) and express state changes through scale, elevation/shadow, border color, or background shift — not layout-affecting properties. Focus states must be visible via `focus-visible` (never suppress the focus ring outright) since keyboard and screen-reader users depend on it.

**Output discipline.** When the user's request is implementation-focused (e.g. "output ONLY the code" or a spec of exactly what to build), give clean semantic HTML with ARIA labels where roles/state aren't implicit from the HTML element, and full responsiveness — but do not add features, sections, or refactors beyond what was explicitly asked for. Scope creep on an implementation request is its own kind of unwanted noise, same as an unjustified design flourish.

## Extended engineering standards

The sections above cover aesthetic direction and the code-level basics (motion, icons, color, instructional UI, interactive states). For anything beyond that — the build is non-trivial, production-bound, or the user's request touches one of these areas — read the relevant reference file before proceeding, since each has specific technical directives that matter and are easy to get subtly wrong from general knowledge alone:

- [references/ui-diagnostics-and-antipatterns.md](./references/ui-diagnostics-and-antipatterns.md) — Pre-design diagnostic checklist and universal anti-pattern detection (canvas dead space, database dump lists, floating stat islands, visual anchors).
- [references/accessibility.md](./references/accessibility.md) — keyboard navigation models for complex widgets (carousels, modals, menus), complex ARIA state management (live regions, aria-busy, aria-invalid), and screen-reader validation checks beyond contrast/focus rings. Read this whenever building modals, carousels, comboboxes, custom toggles, or any widget richer than a static page.
- [references/performance.md](./references/performance.md) — Core Web Vitals budgets (LCP/CLS/INP), image optimization (formats, lazy-loading, srcset), font-loading (font-display: swap, preloading), and perceived-performance patterns (skeleton screens, optimistic UI, transition states for async fetches). Read this for anything involving images, webfonts, or data fetching.
- [references/responsive-and-theming.md](./references/responsive-and-theming.md) — mobile touch-target sizing and gesture support, fluid typography (`clamp()`) and container queries, dark mode / `prefers-color-scheme` theming architecture, and RTL/i18n (logical properties, text-expansion tolerance). Read this whenever the build needs to support multiple viewports, a dark mode, or non-English locales.
- [references/resilience-and-security.md](./references/resilience-and-security.md) — defensive CSS for broken images/empty states/offline states/content overflow, and frontend security basics (masking sensitive inputs, safe autocomplete, avoiding XSS via unsanitized innerHTML). Read this for anything handling real data, user input, or network calls.
- [references/engineering-practices.md](./references/engineering-practices.md) — cross-browser quirks (especially Safari), testing strategy (unit vs. e2e, what to prioritize), component architecture/design-system integration, print stylesheets, and analytics/telemetry hooks. Read this when the work is going into a larger codebase rather than a standalone page.

## More on writing in design

Words appear in a design for one reason: to make it easier to understand, and therefore easier to use. They are design material, not decoration. Bring the same intentionality to copy that you would bring to spacing and color. Before writing anything, ask what the design needs to say, and how it can best be said to help the person navigate the experience.

Write from the end user's side of the screen. Name things by what people control and recognize, never by how the system is built. A person manages notifications, not webhook config. Describe what something does in plain terms rather than selling it. Being specific is always better than being clever.

Use active voice as default. A control should say exactly what happens when it's used: "Save changes," not "Submit." An action keeps the same name through the whole flow, so the button that says "Publish" produces a toast that says "Published." The vocabulary of an interface is the signposting for someone navigating the product. Cohesion and consistency are how people learn their way around.

Treat failure and emptiness as moments for direction, not mood. Explain what went wrong and how to fix it, in the interface's voice rather than a person's. Errors don't apologize, and they are never vague about what happened. An empty screen is an invitation to act.

Keep the register conversational and tuned: plain verbs, sentence case, no filler, with tone matched to the brand and the audience. Let each element do exactly one job. A label labels, an example demonstrates, and nothing quietly does double duty.
