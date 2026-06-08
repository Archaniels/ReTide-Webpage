# Original User Request

## Initial Request — 2026-06-08T08:12:28+07:00

Create Playwright tests for the Donation feature (TC001-TC022) based on the `Documentation/BBT/Donation BBT Testing.md` file. The tests must be written in JS/TS and run in isolation by mocking backend dependencies so they do not touch the real database or external APIs.

Working directory: c:\Users\sxpix\Downloads\ovnw\retide - Copy - Copy - Copy\ReTide-Webpage
Integrity mode: development

## Requirements

### R1. Implement Test Cases
Write Playwright tests (JS/TS) for test cases TC001 to TC022 from the Donation BBT Testing markdown file. Use the Arrange, Act, and Assert pattern for each test.

### R2. Test Isolation
Ensure the tests do not touch a real database or external APIs. Use Playwright's network interception (`page.route()`) or component mocking to mock the necessary responses.

### R3. Dummy Data
Incorporate dummy data and account details from `e2e/DUMMIES.md` for Admin and Normal User roles in your tests.

### R4. File Placement
Place the new test files in the `e2e` folder so that Playwright can execute them.

## Acceptance Criteria

### Test Execution & Structure
- [ ] All 22 test cases (TC001-TC022) are explicitly implemented and identifiable in the test files.
- [ ] The tests successfully execute via Playwright (e.g., `npx playwright test`).
- [ ] The test files are located in the `e2e` folder.
- [ ] Network requests to the backend/external APIs are successfully intercepted and mocked.
- [ ] The Arrange, Act, Assert pattern is used for test structuring.
