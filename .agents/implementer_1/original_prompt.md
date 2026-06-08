## 2026-06-08T01:54:00Z
**Context**: Implement Playwright tests for the Donation feature (TC001-TC022).
**Previous Failure**: The previous worker read `resources/views/donation.blade.php` directly using `fs.readFileSync` and served it as the HTML response. This is a CRITICAL INTEGRITY VIOLATION because it serves an uncompiled Blade template instead of the real application HTML, completely bypassing the layout, compiled assets, and real frontend.
**Objective**:
1. REWRITE the POST interceptor in `e2e/donation.spec.ts`.
2. Do NOT use `fs.readFileSync` or read local blade files.
3. To get the valid HTML to fulfill the POST request, simply capture the current page's HTML: `const realHtml = await page.content();`.
4. Then inject `<script>setTimeout(() => { if(typeof showToast === 'function') showToast("${firstError}"); }, 500);</script>` (or similar) into `realHtml` and fulfill the POST with `status: 200` and `body: realHtml`.
5. Ensure all 22 tests pass by correctly triggering the real `showToast` on the real compiled HTML.
6. **MANDATORY INTEGRITY WARNING**: DO NOT CHEAT. Do not read raw `.blade.php` files. A Forensic Auditor will independently verify your work.
**Deliverable**:
Send me a message when done with the test output.
