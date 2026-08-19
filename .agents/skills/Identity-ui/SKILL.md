---
name: identity-ui
description: UI/UX design identity instructions and guidelines for creating distinct, accessible, and responsive user interfaces.
---

# UI/UX Design Identity — AI Instructions

These are standing instructions for any AI assistant (chat-based, IDE-integrated, or agentic) that designs, builds, or modifies user interfaces for this project — web apps, dashboards, admin tools, landing pages, mobile screens, or full products, in any stack (React, Vue, plain HTML/CSS, React Native, Flutter, SwiftUI, etc.).

Apply these instructions any time you are asked to build, redesign, or extend UI — including requests that don't use the words "UI," "UX," or "design," such as "build me a dashboard," "make this app," "add a settings page," or "create a mockup."

Compatible with any AI tool: paste this file into a system prompt, project rules file (e.g. `.cursorrules`, `AGENTS.md`, `CLAUDE.md`, Copilot custom instructions, a custom GPT's instructions), or reference it directly in a prompt.

---

## Core principle

**Don't just display information — organize and present it so the user understands, decides, and acts faster.**

Every UI/UX decision must answer: does this help the user understand information faster, make a better decision, or complete their task in fewer steps? If a choice is just decoration or default habit, cut it or justify it.

---

## Step 0: Identify the existing identity before designing anything

Before choosing a single color, font, or spacing value, check whether the project already has a visual identity. Look for:
- CSS custom properties / theme files (`globals.css`, `:root` variables, `tailwind.config.*` theme.colors/theme.fontFamily, `theme.ts`/`theme.json`)
- Existing components' inline styles or classnames (what colors, radii, fonts are actually in use)
- A design-tokens or brand file (`brand.json`, `design-tokens.json`, style guide docs)
- Logo files, favicons, or brand assets (colors/shapes to extract)
- Fonts already loaded (`<link>` tags, `@font-face`, font imports in package config)
- README/docs mentioning brand name, tone, or target audience
- Screenshots, mockups, or design references already shared

**If an identity already exists**: treat it as fixed. Extract its actual colors, type, spacing, and icon choices and build with those — don't override them with a different palette or font just because it doesn't match the illustrative example below. Apply the structural discipline in this document on top of their identity: one accent used sparingly (not decoratively), a consistent spacing grid, one consistent icon system, and the five required states below — these apply regardless of whose palette it is.

**If no identity exists yet** (new project, or existing UI that's genuinely generic/default-template with nothing worth preserving): generate a new one using the framework below. Do not default to the same fixed palette/font pairing every time — derive something distinctive from *this* project's domain, name, and purpose. Two different projects should not end up with the same accent color and type pairing unless there's a real reason they should.

---

## Generating a new identity (when none exists)

Work through these in order and ground each choice in the actual project, not habit:

1. **Domain and tone**: What does the product do, and who is it for? Place it on a few axes: precise/analytical vs. warm/human; high-stakes/professional vs. playful/consumer; information-dense (power tools, internal ops) vs. spacious (consumer-facing, marketing-adjacent). Let the project's name, purpose, and target user drive this.
2. **Pick one accent hue with a reason**: choose a hue/saturation that fits the tone axes above, and avoid the reflexive choice for that domain (avoid: blue/indigo for "trustworthy/enterprise," purple for "AI/creative," green for "finance/growth" — these are exactly what generic templates default to). Prefer a slightly unusual, desaturated, confident tone over a bright saturated "brand" color. Keep it to one accent, reserved for primary actions, active/selected states, and focus — never used decoratively.
3. **Pick a neutral base** deliberately: warm off-whites/grays read considered and human; cool grays read clinical/precise; true black/white reads stark/high-contrast.
4. **Pick a type pairing with a reason**: a single grotesque throughout reads clean/neutral/dense-friendly; a serif-for-display + grotesque-for-UI pairing reads editorial/considered and suits products with fewer, larger information moments; a mono-forward system suits developer/technical tools.
5. **Pick a layout signature** that fits how users will navigate: a nav-rail + slide-in detail panel suits multi-entity tools with lots of navigation; a focused single-column flow suits linear/task-based products; a spacious full-width canvas suits creative/visual tools. Apply the same pattern system-wide so it becomes recognizable.
6. **Sanity check**: would a different type of product, run through this same process, plausibly land on different choices at steps 2–5? If every project converges on the same palette and pairing regardless of domain, the choices aren't actually grounded in context — revisit them.

### Illustrative example (not a default to reuse)

One possible output of this process, for a hypothetical precise/professional, information-dense internal tool — shown to demonstrate the *kind* of specificity expected, not to copy onto unrelated projects:

**Point of view**: restrained, architectural, confident — warm neutrals instead of clinical white/black, a single deep accent used sparingly, sharp structural elements paired with softer content containers, one consistent icon system.

**Colors**
```
canvas:          #FAFAF7   warm paper background, not pure white
surface:         #FFFFFF
surface-sunken:  #F1F0EB
border:          #E4E2DA
ink-primary:     #14171F
ink-secondary:   #565A66
ink-tertiary:    #8A8D96
accent:          #1F5F5B   deep teal, one color, sparing use
accent-hover:    #164742
accent-subtle:   #E4EEED
success:         #3F7D4C
warning:         #B8842E
danger:          #B23B33
(each semantic color with a matching -subtle tint for backgrounds)
```

**Typography**
```
display: "Fraunces"/serif — page titles, empty-state headlines only
ui:      "Inter"/system-ui — everything else
mono:    "IBM Plex Mono" — tabular numerals, IDs, timestamps, prices
scale:   12 / 14 / 16 / 20 / 24 / 32 / 48 (px)
```

**Spacing**: 8px grid — 4, 8, 12, 16, 24, 32, 48, 64, 96.

**Radius**: sm 4px (inputs/buttons), md 8px (cards), lg 12px (modals), 0px for structural chrome (nav, headers, table containers) — don't round everything the same amount; never `rounded-full` except on things genuinely round by function (avatars, dots, pills).

**Elevation**: prefer 1px borders over shadows; reserve shadow for things actually floating above content (modals, popovers, dropdowns, toasts).

**Icons**: one library or custom set only, consistent stroke width throughout, never mix filled and outlined in the same context.

---

## Anti-generic test

Before finalizing any screen, ask: **"If I removed the logo, would this look like any other SaaS dashboard?"** If yes, revise. Avoid, unless there's a deliberate reason tied to actual product needs:
- The reflexive "4 stat cards + line chart + data table" homepage
- Gradients, glassmorphism, or neumorphism used decoratively rather than functionally
- Mixed icon libraries or inconsistent stroke widths
- Rounded-full / heavy-shadow "bubbly SaaS" styling on every element
- Illustrations or imagery that carry no information
- Animation that doesn't clarify a state change
- More than one accent color competing for attention
- A modal for every interaction, including ones that don't need to interrupt

---

## Layout & information architecture

Design around user goals and workflows, not database entities or field inventories.

**Before laying out any screen**, answer: What is the user trying to accomplish here? What's the one piece of information they need first to decide their next move? What's the one action they'll take most often?

- Exactly one primary action per screen, visually dominant; everything else secondary/tertiary.
- Most decision-relevant information first and largest — not the most recently-added field.
- Group related information with space, not just borders. Auto-prioritize: surface only what matters for the current task by default; put the rest behind progressive disclosure.
- **Progressive disclosure**: default view = summary/decision-relevant info only; details on demand (expandable rows, detail panels, "show more"). Don't force linear wizards for things that aren't inherently linear.

**Reduce clicks, screens, and repetition**:
- Inline edit over navigate-to-a-separate-edit-page for simple fields.
- Bulk actions wherever a list of items exists.
- Smart defaults: pre-fill from context (previous values, current filters, logged-in user).
- Persistent context: filters/search/scroll position survive navigating away and back.
- Undo (toast with an "Undo" action) instead of blocking confirm-dialogs for reversible actions; reserve blocking confirmation for genuinely destructive, hard-to-reverse actions.
- Merge screens that are always visited back-to-back instead of forcing two navigations.
- Search/command palette for systems with many destinations.

**Error prevention**:
- Validate inline, at the field, at the moment of input — not only on submit.
- Disable/hide actions that can't currently succeed, and explain why near the control.
- For destructive actions, show the cost before commit ("This will remove 14 items," not just "Delete?").
- Make correct usage the path of least resistance: sensible defaults, constrained inputs where format matters, disabled states over silent failure.

**Making complex information simple**:
- Prefer a few well-chosen summary numbers/visuals over dense raw tables when the user needs to *decide* something.
- Use comparison and change (vs. last period, vs. target) rather than raw absolute numbers alone.
- Reserve dense tables for when the user genuinely needs to scan/sort/export many rows.

---

## Components & the five required states

Build a small, reused component set — never a one-off variant of a button, card, or input for a single screen. Extend existing components with a variant rather than duplicating them.

Core set to establish early: button (primary/secondary/tertiary/destructive), input, select, table, card, tag/badge, tabs, modal, detail panel, toast, tooltip, empty state, skeleton loader.

Every view that loads or mutates data needs all five states designed — treat missing states as incomplete work, not later polish:

- **Loading**: skeleton mirroring the final layout's shape for content-heavy views; small inline spinner for quick discrete actions. Never a blank screen.
- **Empty**: explain *why* it's empty (no data yet vs. no results match filters vs. no access — different messaging each) and pair with the relevant next action. Distinguish "genuinely empty" from "filtered to nothing" (offer to clear filters for the latter).
- **Success**: inline confirmation for actions the user is directly watching; toast for actions where the result isn't visible on screen. Don't overuse toasts.
- **Warning**: non-blocking, inline, near the relevant control, always actionable.
- **Error**: specific and actionable, placed near the point of failure, never a bare "Something went wrong." Preserve the user's input on failed submit. Distinguish user-fixable errors (give the fix) from system errors (offer retry / a way to get help).

Any user action should produce visible feedback within ~100ms — silence after a click reads as broken, not fast.

---

## Responsive behavior

```
mobile:  < 640px
tablet:  640–1024px
desktop: > 1024px
```

Rethink structure at each breakpoint — don't just shrink the desktop layout:
- Nav rail/sidebar collapses to a bottom tab bar or slide-out drawer on mobile.
- Tables become stacked cards or a condensed list on mobile, not a horizontally-scrolling shrunken table.
- Detail panels become full-screen on mobile, not a tiny sliver.
- Multi-column layouts collapse to single column in task-priority order, not raw DOM order.
- Minimum 44×44px touch targets on mobile/tablet with adequate spacing.
- Primary action reachable by thumb on mobile (bottom-anchored or easy reach).
- Test at real widths: ~375px, ~768px, ~1440px minimum.

---

## Motion

- Duration: 120–180ms for most UI transitions (hover, expand/collapse, panel slide-in).
- Easing: ease-out for entering/appearing, ease-in for leaving. Avoid bouncy/spring/elastic easing.
- Motion must clarify a state change — never add animation purely for flair.
- Respect `prefers-reduced-motion`.
- Loading states are the one place slightly longer/looping motion is expected (shimmer, spinner) — keep even these subtle.

---

## Decision checklist (run before finishing any screen or flow)

- [ ] **Goal clarity**: Is the single most important action obvious within ~2 seconds?
- [ ] **Hierarchy**: Is the most important information visually first, not just first in the markup?
- [ ] **Step count**: Could this be fewer clicks/screens, or use a smarter default?
- [ ] **Error prevention**: Can the user do something wrong/destructive without a clear warning appropriate to the stakes?
- [ ] **All five states**: loading, empty, success, warning, error are all designed — not just the happy path.
- [ ] **Consistency**: Do components, spacing, color usage, and icons match the rest of the system?
- [ ] **Responsive**: Does it hold up at ~375px, ~768px, and ~1440px without being a naive shrink?
- [ ] **Accessibility**: Sufficient contrast, visible focus states, keyboard reachable, state never conveyed by color alone.
- [ ] **Anti-generic test**: Passes the "remove the logo" test above.

If any box fails, fix it before considering the work done.