# ReTide - Comprehensive Test Cases

This document outlines the test cases for the core features of the ReTide application, including the Marketplace, Blog, and Donation systems.

## 1. Marketplace Feature

| Test ID | Description | Test Steps | Test Data | Expected Result | Actual Result | Pass/Fail |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| **TC-MP-01** | Create new product (Eloquent) | 1. Log in as Admin/User.<br>2. Navigate to Marketplace -> Create Product.<br>3. Fill in product details.<br>4. Upload an image.<br>5. Click 'Submit'. | Title: "Vintage Shirt"<br>Price: 25.00<br>Image: `shirt.jpg` | Product is saved in DB via Eloquent. Image is stored. Redirected to product list showing the new product. | | |
| **TC-MP-02** | View product details (Eloquent) | 1. Navigate to Marketplace.<br>2. Click on a specific product from the list. | Product ID: Existing ID | Product details page loads successfully, displaying correct title, price, description, and image. | | |
| **TC-MP-03** | Update product details and image (Node.js) | 1. Navigate to Edit Product page.<br>2. Modify title and price.<br>3. Upload a new image.<br>4. Click 'Update'. | Title: "Vintage Shirt - Updated"<br>New Image: `shirt2.jpg` | Node.js API successfully updates the database. The new image is processed and displayed on the product page. | | |
| **TC-MP-04** | Delete a product (Node.js) | 1. Navigate to product list or details.<br>2. Click 'Delete'.<br>3. Confirm deletion. | Product ID: Existing ID | Node.js API removes the product record from DB. Product no longer appears in the Marketplace. | | |

## 2. Blog Feature

| Test ID | Description | Test Steps | Test Data | Expected Result | Actual Result | Pass/Fail |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| **TC-BL-01** | Create new blog post (Eloquent) | 1. Log in as Admin.<br>2. Navigate to Blog -> Create Post.<br>3. Enter title, content.<br>4. Upload cover image.<br>5. Click 'Publish'. | Title: "Eco Tips"<br>Content: "..."<br>Image: `tips.jpg` | Post is saved in DB via Eloquent. Image is stored. Redirected to blog index showing the new post. | | |
| **TC-BL-02** | Read blog post (Eloquent) | 1. Navigate to Blog index.<br>2. Click 'Read More' on a post. | Post ID: Existing ID | Blog post page loads, showing correct title, content, author, and cover image. | | |
| **TC-BL-03** | Update blog post and image (Node.js) | 1. Navigate to Edit Post page.<br>2. Change content.<br>3. Upload a new cover image.<br>4. Click 'Update'. | Content: "Updated..."<br>New Image: `tips2.jpg` | Node.js API updates the post. The newly uploaded picture replaces the old one and displays correctly. | | |
| **TC-BL-04** | Delete blog post (Node.js) | 1. Navigate to blog list.<br>2. Click 'Delete' on a post.<br>3. Confirm deletion. | Post ID: Existing ID | Node.js API deletes the post. It is removed from the public blog index. | | |

## 3. Donation Feature

| Test ID | Description | Test Steps | Test Data | Expected Result | Actual Result | Pass/Fail |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| **TC-DN-01** | Make a donation (Authenticated) | 1. Log in as a User.<br>2. Navigate to Donations.<br>3. Enter donation amount.<br>4. Submit payment. | Amount: 50.00<br>User ID: Logged in User | Donation is recorded successfully with the correct `user_id` associated with the transaction. | | |
| **TC-DN-02** | View user donations | 1. Log in as User.<br>2. Navigate to User Profile / History. | User ID: Logged in User | List of previous donations made by the user is displayed accurately. | | |
| **TC-DN-03** | Update donation status (Node.js) | 1. Log in as Admin.<br>2. Navigate to Admin Donation Management.<br>3. Update status of a donation (e.g., Pending -> Completed). | Status: 'Completed' | Node.js API updates the donation status in the database successfully. | | |
