# Feature Test: Donation

This document outlines the feature test cases executed for the `Donation` feature.

| Test ID | Description | Test Steps | Test Data | Expected Result | Actual Result | Pass/Fail |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| TC001 | User can view donation page | 1. Login as User.<br>2. Access GET `/donation`. | None | Return 200 OK. View is `donation` with required data bound. | | |
| TC002 | User can submit donation | 1. Login as User.<br>2. Submit POST `/donation` with donation details.<br>3. Mock Midtrans Snap. | Valid amount, name, email, message | Redirect to Midtrans payment URL. DB has `Donation` and pending `Payment` records. | | |
| TC003 | Donation requires minimum amount | 1. Login as User.<br>2. Submit POST `/donation` with amount < 1000. | Amount `500` | Validation error for amount. DB has no new records. | | |
| TC004 | User can fetch donation updates via AJAX | 1. Login as User.<br>2. Access GET `/donation/updates/{id}`. | `Donation` and `DonationUpdate` record | Return 200 OK JSON response containing the update. | | |
| TC005 | User can view success page | 1. Login as User.<br>2. Access GET `/donation/success`. | None | Return 200 OK. View is `donation_success`. | | |
| TC006 | Admin can view donations index | 1. Login as Admin.<br>2. Access GET `/admin/donations`. | Admin User, `Donation` record | Return 200 OK. View is `admin.donations.index` showing donations. | | |
| TC007 | Admin can delete donation | 1. Login as Admin.<br>2. Submit DELETE `/admin/donations/{id}`. | Admin User, `Donation` record | Redirect to index with success message. DB record missing. | | |
| TC008 | Non-admin cannot view donations index | 1. Login as User.<br>2. Access GET `/admin/donations`. | Regular User | Return 403 Forbidden. | | |
