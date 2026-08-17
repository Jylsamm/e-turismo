## 2026-08-17 - Missing aria-label for modal close buttons
**Learning:** Found several close buttons (`✕` and `<i class="ti ti-x"></i>`) in modals across the application without an `aria-label`. Without this label, screen reader users would not understand what these icon-only buttons do.
**Action:** Always add `aria-label="Close"` or a similarly descriptive text to icon-only buttons.
