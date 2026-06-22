# Feature Test: Blog

This document outlines the feature test cases executed for the `Blog` feature.

| Test ID | Description | Test Steps | Test Data | Expected Result | Actual Result | Pass/Fail |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| TC001 | Guests are redirected to login for public blog routes | 1. Access `/blog`.<br>2. Access `/blog/1`. | Unauthenticated User | Redirect to `/login`. | | |
| TC002 | Admins are redirected to dashboard from public blog routes | 1. Login as Admin.<br>2. Access `/blog`.<br>3. Access `/blog/1`. | Admin User | Redirect to `/admin/dashboard`. | | |
| TC003 | Non-admins receive 403 on admin blog routes | 1. Login as User.<br>2. Access `/admin/blogs` index, create, edit, store, update, destroy routes. | Regular User, Valid `BlogPost` | Return 403 Forbidden. | | |
| TC004 | Admins can access admin blog routes | 1. Login as Admin.<br>2. Access `/admin/blogs` index, create, edit routes. | Admin User, Valid `BlogPost` | Return 200 OK. | | |
| TC005 | List posts on blog ordered by latest | 1. Login as User.<br>2. Create 3 posts with different timestamps.<br>3. Access `/blog`. | 3 `BlogPost` records | Return 200 OK, posts ordered by `created_at` descending. | | |
| TC006 | View single post on blog | 1. Login as User.<br>2. Access `/blog/{id}`.<br>3. Access `/blog/9999` (invalid). | Valid `BlogPost` | Return 200 OK and show content. Return 404 for invalid ID. | | |
| TC007 | Admin can create blog post with image | 1. Login as Admin.<br>2. Submit POST `/admin/blogs` with valid data and image.<br>3. Mock Cloudinary upload. | Title, Content > 10 chars, valid Image file | Redirect to index with success message, DB has record, Image uploaded. | | |
| TC008 | Admin can create blog post without image | 1. Login as Admin.<br>2. Submit POST `/admin/blogs` with valid data, no image. | Title, Content > 10 chars | Redirect to index with success, DB has record with null image. | | |
| TC009 | Admin can update blog post with new image | 1. Login as Admin.<br>2. Submit PUT `/admin/blogs/{id}` with new data and image.<br>3. Mock Cloudinary upload. | Valid `BlogPost`, New Title, New Content, New Image | Redirect to index with success, DB updated with new image URL. | | |
| TC010 | Admin can update blog post without new image | 1. Login as Admin.<br>2. Submit PUT `/admin/blogs/{id}` with new text data. | Valid `BlogPost`, New Title, New Content | Redirect to index with success, DB updated, original image retained. | | |
| TC011 | Admin can delete blog post | 1. Login as Admin.<br>2. Submit DELETE `/admin/blogs/{id}`. | Valid `BlogPost` | Redirect to index with success, DB record missing. | | |
| TC012 | Create post validation fails for empty fields | 1. Login as Admin.<br>2. Submit POST `/admin/blogs` with empty fields. | Empty Title, Empty Content | Validation error for title and content. | | |
| TC013 | Create post validation fails for invalid title length | 1. Login as Admin.<br>2. Submit POST `/admin/blogs` with title < 5 or > 100 chars. | Title < 5 chars, Title > 100 chars | Validation error for title. | | |
| TC014 | Create post validation fails for invalid content length | 1. Login as Admin.<br>2. Submit POST `/admin/blogs` with content < 10 or > 5000 chars. | Content < 10 chars, Content > 5000 chars | Validation error for content. | | |
| TC015 | Create post validation fails for invalid image | 1. Login as Admin.<br>2. Submit POST `/admin/blogs` with non-image file or size > 5120 KB. | TXT file, > 5MB JPG file | Validation error for image_path. | | |
