# Blog Feature - White Box Testing

## Overview
This document outlines the White Box Testing suite for the Blog feature in the ReTide application. The testing methodology ensures **Statement Coverage** (every line of code is executed at least once) and **Branch Coverage** (every possible true/false path from each decision point is validated).

The testing primarily focuses on:
- Client-side CRUD operations handled in `public/assets/js/blog-crud.js`.
- Server-side data fetching handled in `app/Http/Controllers/Admin/BlogController.php`.

## Test Cases

| Test ID | Description | Test Steps | Test Data | Expected Result | Actual Result | Pass/Fail |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| **TC001** | **Backend Index Execution**<br>Verify statements in `BlogController::index` execute correctly. | 1. Navigate to the admin blog route. | Database with at least one `BlogPost` record. | The `admin.blog.index` view is returned with the `$blogs` collection sorted by `created_at` descending. | | |
| **TC002** | **Initial Page Load Rendering**<br>Verify `DOMContentLoaded` and `printPost` functions execute and render default posts. | 1. Open the blog page.<br>2. Observe the rendered list and hidden sections. | Default `blogPosts` array (2 posts). | Page loads, `printPost()` executes rendering 2 posts. Create form listener attached. `edit-section` and `delete-section` are hidden. | | |
| **TC003** | **Create Post (Valid)**<br>Validate true path of `if (title && content)` branch. | 1. Fill in Title.<br>2. Fill in Content.<br>3. Submit the form. | Title: "Ocean Setup"<br>Content: "Detailed setup." | New post is pushed to `blogPosts`. `printPost()` clears and re-renders the list. Inputs are cleared. Alert "Post berhasil dibuat!" appears. | | |
| **TC004** | **Create Post (Invalid)**<br>Validate false path of `if (title && content)` branch. | 1. Fill in Title only.<br>2. Submit the form. | Title: "Ocean Setup"<br>Content: "" (Empty) | Form submission prevented. Post is not added. No alert is shown. List does not re-render. | | |
| **TC005** | **Edit Post (Full Update)**<br>Validate true paths for post existence, title, and content condition branches. | 1. Click 'Edit' on a post.<br>2. Provide new title in prompt.<br>3. Provide new content in prompt. | Post ID: 1<br>New Title: "Updated Title"<br>New Content: "Updated Content" | Both post title and content are updated in memory. `printPost()` re-renders the DOM. Alert "Post berhasil di update!" is shown. | | |
| **TC006** | **Edit Post (Title Blank)**<br>Validate false path for `if (newTitle !== null && newTitle !== '')` and true for content. | 1. Click 'Edit' on a post.<br>2. Leave title prompt empty.<br>3. Provide new content in prompt. | Post ID: 1<br>New Title: ""<br>New Content: "Updated Content" | Post title remains unchanged. Content is updated. List re-renders. Alert "Post berhasil di update!" is shown. | | |
| **TC007** | **Edit Post (Content Cancelled)**<br>Validate true path for title and false path for `if (newContent !== null && newContent !== '')`. | 1. Click 'Edit' on a post.<br>2. Provide new title in prompt.<br>3. Click 'Cancel' on content prompt. | Post ID: 1<br>New Title: "Updated Title"<br>New Content: null (Cancelled) | Post title is updated. Content remains unchanged. List re-renders. Alert "Post berhasil di update!" is shown. | | |
| **TC008** | **Edit Post (Invalid ID)**<br>Validate false path for `if (post)` branch. | 1. Programmatically trigger `editPost` with a non-existent ID. | Post ID: 999 | No prompts appear. The function terminates early without updating anything or throwing an error. | | |
| **TC009** | **Delete Post (Confirmed)**<br>Validate true path of `if (confirm(...))` branch. | 1. Click 'Delete' on a post.<br>2. Click 'OK' on confirmation dialog. | Post ID: 1<br>Confirm: true | Post is filtered out of `blogPosts`. `printPost()` re-renders list without the post. Alert "Post berhasil dihapus!" appears. | | |
| **TC010** | **Delete Post (Cancelled)**<br>Validate false path of `if (confirm(...))` branch. | 1. Click 'Delete' on a post.<br>2. Click 'Cancel' on confirmation dialog. | Post ID: 1<br>Confirm: false | Array `blogPosts` is unmodified. Function ends without re-rendering or showing an alert. | | |
