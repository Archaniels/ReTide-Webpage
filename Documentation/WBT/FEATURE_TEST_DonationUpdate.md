# Feature Test: DonationUpdate

This document outlines the feature test cases executed for the `DonationUpdate` feature.

| Test ID | Description | Test Steps | Test Data | Expected Result | Actual Result | Pass/Fail |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| TC001 | Admin can view donation updates index | 1. Login as Admin.<br>2. Access GET `/admin/donations/{id}/updates`. | Admin User, Valid `Donation` and `DonationUpdate` | Return 200 OK. View is `admin.donation_updates.index` with bound updates. | | |
| TC002 | Admin can view donation updates index via AJAX | 1. Login as Admin.<br>2. Access GET `/admin/donations/{id}/updates` via AJAX request. | Admin User, Valid `Donation` | Return 200 OK. View is partial `admin.donation_updates.partials.updates_list`. | | |
| TC003 | Admin can view create donation update page | 1. Login as Admin.<br>2. Access GET `/admin/donations/{id}/updates/create`. | Admin User, Valid `Donation` | Return 200 OK. View is `admin.donation_updates.create`. | | |
| TC004 | Admin can store donation update | 1. Login as Admin.<br>2. Submit POST `/admin/donations/{id}/updates` with valid details. | Admin User, Valid Title, Description, Status | Redirect to updates index with success message. DB has `DonationUpdate` record. | | |
| TC005 | Donation update validation fails on empty fields | 1. Login as Admin.<br>2. Submit POST `/admin/donations/{id}/updates` with empty fields. | Empty Title, Empty Description, Empty Status | Validation error for title, description, and status. DB has no new records. | | |
