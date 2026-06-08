# Project: Donation Playwright E2E Tests

## Architecture
- e2e test suite located in `e2e/`
- Playwright config in root
- Single test file `e2e/donation.spec.ts`

## Milestones
| # | Name | Scope | Dependencies | Status |
|---|------|-------|-------------|--------|
| 1 | Donation Test Suite | Implement TC001-TC022 for Donation feature with mocked backend | none | PLANNED |

## Interface Contracts
- Tests must use `page.route` to mock backend API calls so no real db is touched.
- Dummy data from `e2e/DUMMIES.md` must be used.
- Arrange, Act, Assert pattern must be present.

## Code Layout
- Tests: `e2e/donation.spec.ts`
