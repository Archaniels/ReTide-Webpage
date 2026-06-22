# Feature Test: PaymentWebhook

This document outlines the feature test cases executed for the `PaymentWebhook` feature.

| Test ID | Description | Test Steps | Test Data | Expected Result | Actual Result | Pass/Fail |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| TC001 | Webhook handles settlement status successfully | 1. Setup mock Midtrans notification (`settlement`).<br>2. Submit POST `/payment/notification` payload. | `Payment` with `pending` status, Settlement payload | Return 200 OK. DB payment status updated to `success`. | | |
| TC002 | Webhook handles pending status | 1. Setup mock Midtrans notification (`pending`).<br>2. Submit POST `/payment/notification` payload. | `Payment` with `pending` status, Pending payload | Return 200 OK. DB payment status remains `pending`. | | |
| TC003 | Webhook handles cancel status | 1. Setup mock Midtrans notification (`cancel`).<br>2. Submit POST `/payment/notification` payload. | `Payment` with `pending` status, Cancel payload | Return 200 OK. DB payment status updated to `cancelled`. | | |
| TC004 | Webhook handles expire status | 1. Setup mock Midtrans notification (`expire`).<br>2. Submit POST `/payment/notification` payload. | `Payment` with `pending` status, Expire payload | Return 200 OK. DB payment status updated to `expired`. | | |
| TC005 | Webhook handles deny status | 1. Setup mock Midtrans notification (`deny`).<br>2. Submit POST `/payment/notification` payload. | `Payment` with `pending` status, Deny payload | Return 200 OK. DB payment status updated to `denied`. | | |
| TC006 | Webhook handles capture challenge status | 1. Setup mock Midtrans notification (`challenge`).<br>2. Submit POST `/payment/notification` payload. | `Payment` with `pending` status, Challenge payload | Return 200 OK. DB payment status updated to `challenge`. | | |
| TC007 | Webhook handles capture accept status | 1. Setup mock Midtrans notification (`capture`, `accept`).<br>2. Submit POST `/payment/notification` payload. | `Payment` with `pending` status, Capture Accept payload | Return 200 OK. DB payment status updated to `success`. | | |
| TC008 | Webhook returns 404 for invalid order ID | 1. Setup mock Midtrans notification.<br>2. Submit POST `/payment/notification` with unknown Order ID. | Invalid Order ID (`MKT-NONEXISTENT`) | Return 404 Not Found. Error message: "Payment record not found". | | |
| TC009 | Webhook returns 400 for malformed payload | 1. Bind mock that throws Exception.<br>2. Submit POST `/payment/notification` payload. | Malformed payload | Return 400 Bad Request. Error message: "Invalid notification payload". | | |
| TC010 | Webhook with valid signature updates payment status | 1. Setup mock Midtrans notification with valid hash signature.<br>2. Submit POST `/payment/notification` payload. | Payload matching valid server key signature | Return 200 OK. DB payment status updated correctly. | | |
| TC011 | Webhook with invalid signature is rejected | 1. Setup mock Midtrans notification with mismatching/invalid hash signature.<br>2. Submit POST `/payment/notification` payload. | Payload with invalid signature key | Return 403 Forbidden. DB payment status remains unchanged. | | |
