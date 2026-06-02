# Blog Feature - Black Box Testing Suite

**Methodology:** Equivalence Class Partitioning (EQP) & Boundary Value Analysis (BVA)

This document outlines the test cases for the Blog feature, focusing on robust validation, edge-case handling, and data type integrity. Field boundaries are assumed as follows for demonstration:
- **Title:** 5 to 100 characters (String)
- **Content:** 10 to 5000 characters (Text)
- **Cover Image:** Max 5MB (MIME: image/jpeg, image/png)

---

## 1. Post Creation & Validation (Title & Content)

| Test ID | Description | Test Steps | Test Data | Expected Result | Actual Result | Pass/Fail |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| TC_BLG_001 | Verify valid post creation (EQP: Valid partition). | 1. Navigate to 'Create Post'.<br>2. Input valid Title and Content.<br>3. Click 'Publish'. | Title: "Tech Innovations" (16 chars)<br>Content: "This is a valid blog post content demonstrating normal behavior." (64 chars) | Post is successfully created and stored in the database. | | |
| TC_BLG_002 | Verify error at Title lower bound edge (BVA: Min-1). | 1. Navigate to 'Create Post'.<br>2. Input 4-character Title.<br>3. Click 'Publish'. | Title: "A-B-" (4 chars)<br>Content: "Valid content block..." | System displays validation error: "Title must be at least 5 characters." | | |
| TC_BLG_003 | Verify success at Title lower boundary (BVA: Min). | 1. Navigate to 'Create Post'.<br>2. Input exactly 5-character Title.<br>3. Click 'Publish'. | Title: "Alpha" (5 chars)<br>Content: "Valid content block..." | Post is successfully created. | | |
| TC_BLG_004 | Verify success at Title lower boundary plus one (BVA: Min+1). | 1. Navigate to 'Create Post'.<br>2. Input 6-character Title.<br>3. Click 'Publish'. | Title: "Alphas" (6 chars)<br>Content: "Valid content block..." | Post is successfully created. | | |
| TC_BLG_005 | Verify success at Title upper boundary minus one (BVA: Max-1). | 1. Navigate to 'Create Post'.<br>2. Input 99-character Title.<br>3. Click 'Publish'. | Title: 99 characters of "A"<br>Content: "Valid content block..." | Post is successfully created. | | |
| TC_BLG_006 | Verify success at Title upper boundary (BVA: Max). | 1. Navigate to 'Create Post'.<br>2. Input exactly 100-character Title.<br>3. Click 'Publish'. | Title: 100 characters of "A"<br>Content: "Valid content block..." | Post is successfully created. | | |
| TC_BLG_007 | Verify error at Title upper bound edge (BVA: Max+1). | 1. Navigate to 'Create Post'.<br>2. Input 101-character Title.<br>3. Click 'Publish'. | Title: 101 characters of "A"<br>Content: "Valid content block..." | System displays validation error: "Title must not exceed 100 characters." | | |
| TC_BLG_008 | Verify data type coverage: Numeric input in String field (EQP: Implicit type casting). | 1. Navigate to 'Create Post'.<br>2. Input strictly numeric string in Title.<br>3. Click 'Publish'. | Title: "1234567890"<br>Content: "Valid content block..." | System accepts input, parsing numeric characters as a valid string. | | |
| TC_BLG_009 | Verify cross-site scripting (XSS) prevention in Content (EQP: Invalid data content). | 1. Navigate to 'Create Post'.<br>2. Inject script tags into Content.<br>3. Click 'Publish'. | Title: "Security Test"<br>Content: `<script>alert('XSS')</script>` | System sanitizes input (e.g., escapes HTML entities) and prevents script execution on render. | | |

## 2. File Upload Handling (Cover Image)

| Test ID | Description | Test Steps | Test Data | Expected Result | Actual Result | Pass/Fail |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| TC_BLG_010 | Verify valid file upload (EQP: Valid partition). | 1. Click 'Upload Image'.<br>2. Select valid image.<br>3. Submit form. | File: `cover.jpg` (2.5MB, MIME: image/jpeg) | Image uploaded and attached successfully. | | |
| TC_BLG_011 | Verify error on unsupported file type (EQP: Invalid partition). | 1. Click 'Upload Image'.<br>2. Select non-image file.<br>3. Submit form. | File: `malicious.exe` (1MB, MIME: application/x-msdownload) | System rejects upload: "Invalid file format. Only JPG and PNG are allowed." | | |
| TC_BLG_012 | Verify success at file size upper boundary (BVA: Max). | 1. Click 'Upload Image'.<br>2. Select image exactly 5MB.<br>3. Submit form. | File: `max_limit.png` (5.0MB) | Image uploaded and attached successfully. | | |
| TC_BLG_013 | Verify error at file size boundary edge (BVA: Max+1). | 1. Click 'Upload Image'.<br>2. Select image slightly over 5MB.<br>3. Submit form. | File: `over_limit.jpg` (5.01MB) | System rejects upload: "File size exceeds the 5MB limit." | | |

## 3. Workflow & Edge Cases

| Test ID | Description | Test Steps | Test Data | Expected Result | Actual Result | Pass/Fail |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| TC_BLG_014 | Verify successful post update. | 1. Open existing post in Edit mode.<br>2. Modify Content.<br>3. Click 'Save'. | Target Post ID: 12<br>New Content: "Updated text here." | Changes are saved and reflected on the post view page. | | |
| TC_BLG_015 | Verify soft/hard delete functionality. | 1. Navigate to Dashboard.<br>2. Select post and click 'Delete'.<br>3. Confirm prompt. | Target Post ID: 12 | Post is removed from public view and database (or marked deleted). | | |
| TC_BLG_016 | Verify handling of concurrent duplicate submissions (Edge Case). | 1. Fill out 'Create Post' form.<br>2. Double-click or rapidly click 'Publish'. | Title: "Double Click Test"<br>Content: "Testing duplicate prevention." | System disables button after first click, preventing duplicate DB entries. Only one post is created. | | |
