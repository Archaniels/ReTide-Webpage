# Marketplace Feature - Black Box Testing Suite

## Methodology Overview
This test suite utilizes **Equivalence Class Partitioning (EQP)** to identify valid and invalid input domains and **Boundary Value Analysis (BVA)** to test the limits of those domains (applying the six-point rule where applicable). 

### Assumed Constraints for BVA
* **Price:** Valid range is defined as `0.01` to `9999.99`.
* **Name Length:** Valid range is defined as `1` to `255` characters.

---

## Test Cases

| Test ID | Description | Test Steps | Test Data | Expected Result | Actual Result | Pass/Fail |
|---|---|---|---|---|---|---|
| TC001 | Verify product creation fails with empty required fields (EQP - Invalid) | 1. Navigate to Add Product form. <br> 2. Leave Name, Description, and Price fields empty. <br> 3. Click Submit. | `name: ""` <br> `description: ""` <br> `price: ""` | Validation error should be displayed for all required fields. Product is not created. | | |
| TC002 | Verify product creation with Price = Min-1 (BVA - Invalid) | 1. Navigate to Add Product form. <br> 2. Enter valid Name and Description. <br> 3. Enter Price as `0.00`. <br> 4. Click Submit. | `name: "Test Item"` <br> `price: 0.00` | Validation error: "Price must be at least 0.01". Product is not created. | | |
| TC003 | Verify product creation with Price = Min (BVA - Valid) | 1. Navigate to Add Product form. <br> 2. Enter valid Name and Description. <br> 3. Enter Price as `0.01`. <br> 4. Click Submit. | `name: "Test Item"` <br> `price: 0.01` | Product is created successfully and added to the database. | | |
| TC004 | Verify product creation with Price = Min+1 (BVA - Valid) | 1. Navigate to Add Product form. <br> 2. Enter valid Name and Description. <br> 3. Enter Price as `0.02`. <br> 4. Click Submit. | `name: "Test Item"` <br> `price: 0.02` | Product is created successfully and added to the database. | | |
| TC005 | Verify product creation with Price = Max-1 (BVA - Valid) | 1. Navigate to Add Product form. <br> 2. Enter valid Name and Description. <br> 3. Enter Price as `9999.98`. <br> 4. Click Submit. | `name: "Test Item"` <br> `price: 9999.98` | Product is created successfully and added to the database. | | |
| TC006 | Verify product creation with Price = Max (BVA - Valid) | 1. Navigate to Add Product form. <br> 2. Enter valid Name and Description. <br> 3. Enter Price as `9999.99`. <br> 4. Click Submit. | `name: "Test Item"` <br> `price: 9999.99` | Product is created successfully and added to the database. | | |
| TC007 | Verify product creation with Price = Max+1 (BVA - Invalid Edge Case) | 1. Navigate to Add Product form. <br> 2. Enter valid Name and Description. <br> 3. Enter Price as `10000.00`. <br> 4. Click Submit. | `name: "Test Item"` <br> `price: 10000.00` | Validation error indicating max price exceeded. Product is not created. | | |
| TC008 | Verify product creation rejects non-numeric string data in Price (EQP - Invalid Data Type) | 1. Navigate to Add Product form. <br> 2. Enter valid Name and Description. <br> 3. Enter alphabetic string in Price field. <br> 4. Click Submit. | `name: "Test Item"` <br> `price: "abc"` | Validation error indicating price must be a number. Product is not created. | | |
| TC009 | Verify product creation with Name length = 255 (BVA - Valid) | 1. Navigate to Add Product form. <br> 2. Enter 255-character string in Name field. <br> 3. Enter valid Description and Price. <br> 4. Click Submit. | `name: [255 char string]` <br> `price: 10.00` | Product is created successfully. | | |
| TC010 | Verify product creation with Name length = 256 (BVA - Invalid Edge Case) | 1. Navigate to Add Product form. <br> 2. Enter 256-character string in Name field. <br> 3. Enter valid Description and Price. <br> 4. Click Submit. | `name: [256 char string]` <br> `price: 10.00` | Validation error indicating name exceeds maximum length. | | |
| TC011 | Verify image upload with invalid file type (EQP - Invalid) | 1. Navigate to Add Product form. <br> 2. Fill all required fields with valid data. <br> 3. Upload a non-image file (e.g., .txt). <br> 4. Click Submit. | `image_path: "document.txt"` | Validation error indicating the file must be an image. | | |
| TC012 | Verify adding existing product to cart (EQP - Positive) | 1. Navigate to Marketplace catalog. <br> 2. Click "Add to Cart" on a displayed product. | `Product ID: 1` | Cart session is updated with the product. UI displays success message. | | |
| TC013 | Verify checkout process with items in cart (EQP - Positive) | 1. Ensure at least one item is in the cart. <br> 2. Click "Checkout". | `Cart items count > 0` | Checkout completes successfully. Cart session is flushed/empty. | | |
| TC014 | Verify checkout process with empty cart (EQP - Negative / Edge-case) | 1. Ensure cart is empty. <br> 2. Attempt to trigger checkout process. | `Cart items count = 0` | User is prevented from checking out. A message indicates the cart is empty. | | |
