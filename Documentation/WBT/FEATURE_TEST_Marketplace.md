# Feature Test: Marketplace

This document outlines the feature test cases executed for the `Marketplace` feature.

| Test ID | Description | Test Steps | Test Data | Expected Result | Actual Result | Pass/Fail |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| TC001 | Guests are redirected to login for marketplace routes | 1. Access `/marketplace`.<br>2. Access `/admin/marketplace`. | Unauthenticated User | Redirect to `/login`. | | |
| TC002 | Regular users can access marketplace but blocked from admin | 1. Login as User.<br>2. Access `/marketplace`.<br>3. Access `/admin/marketplace` & POST create. | Regular User | `/marketplace` returns 200 OK. Admin routes return 403 Forbidden. | | |
| TC003 | Admins are redirected from public marketplace to dashboard | 1. Login as Admin.<br>2. Access `/marketplace`.<br>3. Access `/admin/marketplace`. | Admin User | Public route redirects to `/admin/dashboard`. Admin routes return 200 OK. | | |
| TC004 | Admin can create product with image | 1. Login as Admin.<br>2. Submit POST `/admin/marketplace` with valid data and image.<br>3. Mock Cloudinary. | Valid Product Data, Valid Image | Redirect to index with success message. DB has product record and image URL. | | |
| TC005 | Admin can create product without image | 1. Login as Admin.<br>2. Submit POST `/admin/marketplace` with valid data, no image. | Valid Product Data | Redirect to index with success. DB has product record with null image. | | |
| TC006 | Admin can update product with new image | 1. Login as Admin.<br>2. Submit PUT `/admin/marketplace/{id}` with new data and image.<br>3. Mock Cloudinary. | Valid `MarketplaceProduct`, New Data, New Image | Redirect to index with success. DB updated with new image URL. | | |
| TC007 | Admin can update product without new image | 1. Login as Admin.<br>2. Submit PUT `/admin/marketplace/{id}` with new text data. | Valid `MarketplaceProduct`, New Data | Redirect to index with success. DB updated, original image retained. | | |
| TC008 | Admin can delete product | 1. Login as Admin.<br>2. Submit DELETE `/admin/marketplace/{id}`. | Valid `MarketplaceProduct` | Redirect to index with success. DB record is missing. | | |
| TC009 | Create product validation fails for empty fields | 1. Login as Admin.<br>2. Submit POST `/admin/marketplace` with empty fields. | Empty Name, Description, Price | Validation errors for name, description, price. | | |
| TC010 | Create product validation fails for invalid name length | 1. Login as Admin.<br>2. Submit POST `/admin/marketplace` with name < 5 or > 100 chars. | Name < 5 chars, Name > 100 chars | Validation error for name. | | |
| TC011 | Create product validation fails for invalid description length | 1. Login as Admin.<br>2. Submit POST `/admin/marketplace` with description < 5 or > 3000 chars. | Description < 5 chars, Description > 3000 chars | Validation error for description. | | |
| TC012 | Create product validation fails for invalid price | 1. Login as Admin.<br>2. Submit POST `/admin/marketplace` with invalid price. | Non-numeric, Negative, > 99999999.99 | Validation error for price. | | |
| TC013 | Create product validation fails for invalid image | 1. Login as Admin.<br>2. Submit POST `/admin/marketplace` with invalid image file. | PDF file, > 2MB JPG file | Validation error for image_path. | | |
| TC014 | Update product validation fails for empty fields | 1. Login as Admin.<br>2. Submit PUT `/admin/marketplace/{id}` with empty fields. | Empty Name, Description, Price | Validation errors for name, description, price. | | |
| TC015 | Update product validation fails for invalid name length | 1. Login as Admin.<br>2. Submit PUT `/admin/marketplace/{id}` with name < 5 or > 100 chars. | Name < 5 chars, Name > 100 chars | Validation error for name. | | |
| TC016 | Update product validation fails for invalid description length | 1. Login as Admin.<br>2. Submit PUT `/admin/marketplace/{id}` with description < 5 or > 3000 chars. | Description < 5 chars, Description > 3000 chars | Validation error for description. | | |
| TC017 | Update product validation fails for invalid price | 1. Login as Admin.<br>2. Submit PUT `/admin/marketplace/{id}` with invalid price. | Non-numeric, Negative, > 99999999.99 | Validation error for price. | | |
| TC018 | Update product validation fails for invalid image | 1. Login as Admin.<br>2. Submit PUT `/admin/marketplace/{id}` with invalid image file. | PDF file, > 2MB JPG file | Validation error for image_path. | | |
