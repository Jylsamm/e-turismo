## 2024-08-19 - Ensure `aria-pressed` stays synced with active state on view toggles

**Learning:** When creating view toggle buttons (e.g. grid/list views) that change appearance via an `.active` class, the `aria-pressed` attribute is often static in the HTML. As the user switches views, the accessibility state becomes incorrect.
**Action:** Always update the `aria-pressed` attribute simultaneously with the `.active` class in the JavaScript handler (e.g., `btn.setAttribute('aria-pressed', mode === 'grid' ? 'true' : 'false')`) to ensure screen readers announce the correct active state.
