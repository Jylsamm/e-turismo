# Accessibility Reference

## Keyboard Navigation for Complex Widgets

### Focus Management
- Trap focus inside modals using a focus trap loop: query all focusable elements inside the dialog on open, store the previously focused element, and restore it on close.
- Use `tabindex="-1"` to programmatically focus containers (e.g., modal root, error summary) without adding them to the tab order.
- For roving `tabindex` patterns (toolbars, tab lists, radio groups, tree views): set `tabindex="0"` on the active item only; all others get `tabindex="-1"`. Move focus with arrow keys, update `tabindex` attributes on arrow key press.

### Modals / Dialogs
- Role: `role="dialog"` with `aria-modal="true"` and `aria-labelledby` pointing to the dialog's heading.
- On open: move focus to the first focusable element (or the dialog container if nothing else is focusable).
- On close: return focus to the trigger element that opened the dialog.
- Dismiss on Escape key; never close on backdrop click alone without also supporting Escape.
- Prevent scrolling the background (`overflow: hidden` on `<body>` or a scroll-lock utility) while the dialog is open.

### Carousels / Sliders
- Wrap in `role="region"` with a meaningful `aria-label` (e.g., "Featured products").
- Previous/next controls: `<button>` elements with descriptive `aria-label` (e.g., "Next slide").
- Slides: `role="group"` with `aria-roledescription="slide"` and `aria-label="Slide 1 of 5"`.
- Auto-advance: must pause on hover, focus, and when `prefers-reduced-motion` is set. Provide an explicit play/pause toggle.
- Hidden slides: use `aria-hidden="true"` on non-visible slides so screen readers skip them.

### Menus / Dropdowns
- Navigation menus that reveal sub-items: use `<button>` for the toggle with `aria-expanded="true/false"` and `aria-controls` pointing to the submenu ID.
- Application menus (action menus, context menus): use `role="menu"`, `role="menuitem"`, arrow key navigation, Home/End to jump to first/last item, character search.
- Comboboxes (autocomplete inputs): `role="combobox"`, `aria-autocomplete`, `aria-expanded`, `aria-activedescendant` pointing to the highlighted option. Listbox uses `role="listbox"` with `role="option"` children and `aria-selected`.

### Custom Toggles / Switches
- Use `role="switch"` with `aria-checked="true/false"` for on/off toggles.
- Prefer native `<input type="checkbox">` where possible — it carries semantics for free.
- Ensure the toggle label describes the controlled state, not the action ("Dark mode" not "Toggle dark mode").

## Complex ARIA State Management

### Live Regions
- `aria-live="polite"`: for non-urgent updates (success messages, search result counts). Screen reader announces after the current task.
- `aria-live="assertive"`: for urgent interruptions (critical errors, session expiry warnings). Announces immediately — use sparingly.
- `aria-atomic="true"`: the entire region is announced on any change. Use for status messages that should be read as a unit.
- Inject live regions into the DOM on page load (not dynamically) so screen readers register them before updates arrive.

### `aria-busy`
- Set `aria-busy="true"` on a region while it is loading/updating; remove (or set to `false`) when content is ready.
- Pair with a visible loading indicator so sighted users get the same signal.

### `aria-invalid` and `aria-errormessage`
- Set `aria-invalid="true"` on an input when it fails validation.
- Use `aria-errormessage="[id-of-error-element]"` to associate the visible error message. The error element must be visible (not hidden with `display:none`).
- Clear `aria-invalid` and remove the error message reference when the field becomes valid again.

### `aria-describedby` vs `aria-labelledby`
- `aria-labelledby`: provides the accessible name. Overrides the element's own text/label.
- `aria-describedby`: provides supplementary description, read after the name and role. Use for hint text, constraints, or contextual notes.

## Screen-Reader Validation Checklist

Beyond contrast and focus rings, verify:
- [ ] Every interactive element has an accessible name (via label, `aria-label`, or `aria-labelledby`).
- [ ] Icon-only buttons have `aria-label`; decorative icons have `aria-hidden="true"`.
- [ ] Images have meaningful `alt` text; purely decorative images have `alt=""`.
- [ ] Form inputs are associated with their labels via `<label for>` or `aria-labelledby`.
- [ ] Error messages are programmatically associated (`aria-errormessage` or `aria-describedby`).
- [ ] Dynamic content changes are announced via live regions where appropriate.
- [ ] Page has a single, descriptive `<title>`.
- [ ] Landmark structure is present: `<header>`, `<main>`, `<nav>`, `<footer>`, with `aria-label` on multiple `<nav>` elements to distinguish them.
- [ ] Heading hierarchy is logical (one `<h1>`, no skipped levels).
- [ ] Tab order follows visual reading order; no unexpected focus jumps.
- [ ] Modal/dialog focus trap and restore work correctly.
- [ ] Test with VoiceOver (Safari/macOS), NVDA (Chrome/Firefox/Windows), and axe DevTools browser extension.
