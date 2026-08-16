# Resilience & Security Reference

## Defensive CSS

### Broken Images
- Always provide `alt` text so broken images degrade gracefully with descriptive text.
- Style the broken image state: `img { object-fit: cover; background: var(--color-surface); }` provides a colored block instead of a broken icon.
- For avatar images: use a CSS fallback with the user's initial or a generic icon silhouette.

### Empty States
- Every list, table, feed, or dynamic region must have an explicit empty state — not a blank space.
- Empty state structure: icon or illustration (decorative) + heading (what's missing) + body (why or what to do) + optional CTA.
- Style empty states to the same width/height as the populated state to prevent layout shift on data arrival.
- Use `aria-live="polite"` on dynamic regions so screen readers announce when content populates.

### Offline / Network Error States
- Detect offline with `window.addEventListener('offline', handler)`.
- Show a persistent banner or inline notice when the user loses connectivity; dismiss automatically on reconnect (`online` event).
- Cache critical assets and shell HTML using a Service Worker for offline resilience.
- For failed fetches: show an inline error with a retry button rather than a full-page error.

### Content Overflow
- Apply `overflow-wrap: break-word` and `word-break: break-word` to user-generated text containers to prevent layout breakage from long strings.
- Use `text-overflow: ellipsis` with `overflow: hidden` and `white-space: nowrap` for single-line truncation; provide a title attribute or tooltip with the full content.
- For multi-line truncation: use `-webkit-line-clamp` (widely supported) with a "Read more" control.
- Tables with user data: add `table-layout: fixed` and `overflow: hidden` on cells to prevent column blowout.

## Frontend Security

### Avoiding XSS via `innerHTML`
- **Never** set `element.innerHTML = userInput` directly. This is the primary XSS vector.
- Use `element.textContent = userInput` for plain text insertion — it is always safe.
- If HTML insertion is required (e.g., rendering Markdown), sanitize with a trusted library (DOMPurify) before setting innerHTML: `element.innerHTML = DOMPurify.sanitize(userInput)`.
- Avoid `eval()`, `Function()`, `setTimeout(string)`, and similar dynamic code execution with user-controlled data.

### Sensitive Input Handling
- Use `type="password"` for password fields — never `type="text"`.
- For sensitive data fields (SSN, card numbers, PINs): add `autocomplete="off"` or the appropriate `autocomplete` token (e.g., `autocomplete="cc-number"`) so password managers handle it correctly while browsers don't cache it in form history.
- Mask sensitive values in the UI by default; provide a show/hide toggle with an icon button and `aria-label="Show password"` / `aria-label="Hide password"`.
- Never log sensitive field values to the browser console.

### Safe `autocomplete` Values
- Use specific `autocomplete` attribute values so browsers autofill correctly and securely:
  - `autocomplete="username"` — login username
  - `autocomplete="current-password"` — existing password (login form)
  - `autocomplete="new-password"` — new password (signup/reset form) — browsers won't suggest the current password
  - `autocomplete="email"`, `autocomplete="name"`, `autocomplete="tel"` — contact fields
  - `autocomplete="one-time-code"` — OTP/2FA fields
- Use `autocomplete="off"` only when you have a genuine reason (e.g., search fields that shouldn't retain history); don't use it to suppress autofill on ordinary form fields.

### Content Security Policy (CSP) Considerations
- Avoid inline `<script>` and `<style>` blocks in production; move to external files so a CSP `script-src 'self'` policy can be applied.
- Never construct `<script src>` URLs from user input.
- Sanitize any URL parameters before using them as `href`, `src`, or `action` attribute values to prevent open redirect and protocol injection (`javascript:` URLs).
