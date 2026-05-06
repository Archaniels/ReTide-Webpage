---
description: >-
  Comprehensive documentation for the ReTide Marketplace feature, outlining its hybrid architecture, core components, and API integration.
icon: shop
layout:
  width: default
  title:
    visible: true
  description:
    visible: true
  tableOfContents:
    visible: true
  outline:
    visible: true
  pagination:
    visible: true
---

# Marketplace Feature Documentation

The ReTide Marketplace is a core module that allows users to view, add to cart, and purchase products. It uses Laravel's built-in Eloquent ORM for all data operations.

---

## 🏗️ Architectural Overview

The Marketplace feature operates entirely within the Laravel Application Layer (PHP 8.2+).

### Operation Matrix

* **Read (Index):** Fetches all products using `MarketplaceProduct::all()`.
* **Create (Store):** Inserts new products into the database.
* **Update:** Modifies existing product records via Eloquent.
* **Delete:** Removes product records from the database via Eloquent.
* **Cart:** Session-based cart management.

---

## 🧩 Core Components

### 1. Database Model

The core database model for the marketplace is `MarketplaceProduct`.

<details>
<summary>View the <code>MarketplaceProduct</code> Model details</summary>

**Location:** `app/Models/MarketplaceProduct.php`

**Attributes:**
* `id` (Primary Key)
* `name` (String, Required)
* `description` (Text, Required)
* `price` (Decimal/Numeric, Required)
* `image_path` (String, Optional)

</details>

### 2. Laravel Controllers

The `MarketplaceProductController` manages the product catalog and administration.

```php
// app/Http/Controllers/MarketplaceProductController.php

public function index() {
    $products = MarketplaceProduct::orderBy('created_at', 'desc')->get();
    return view('marketplace.index', ['products' => $products]);
}

public function store(Request $request) {
    // Validation...
    MarketplaceProduct::create([
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'image_path' => $imagePath,
    ]);
}

public function update(Request $request, string $id) {
    $product = MarketplaceProduct::findOrFail($id);
    // Update logic...
    $product->update($data);
}

public function destroy(string $id) {
    MarketplaceProduct::findOrFail($id)->delete();
}
```

#### `CartController`

The cart system operates within the Laravel application using session state.

* **`add()`**: Appends a product to the `cart` session array.
* **`checkout()`**: Simulates a checkout by clearing the session data.

---

## 🚀 Workflows

### Purchasing a Product

1. **Browse Catalog:** The user navigates to the marketplace. Laravel fetches products via Eloquent.
2. **Add to Cart:** The user clicks "Add to Cart". An asynchronous request updates the PHP session.
3. **Checkout:** The user completes the purchase. The cart session is flushed.

### Modifying a Product (Admin)

1. **Access Edit Form:** The admin requests to edit a product. Laravel fetches the record via `MarketplaceProduct::findOrFail($id)`.
2. **Submit Changes:** The admin submits the form. Laravel validates and updates the record via Eloquent.

---

## ⚠️ Best Practices

1. **Image Handling:** Image uploads are processed by Laravel and stored in the `public` storage disk.
2. **Authorization:** Ensure `routes/web.php` protects update and delete routes with the `admin` middleware.
