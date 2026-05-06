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

The ReTide Marketplace is a core module that allows users to view, add to cart, and purchase products. It follows a **hybrid architectural pattern**, splitting data operations between Laravel's Eloquent ORM and a dedicated Node.js microservice.

{% hint style="info" %}
This hybrid approach delegates **Read and Create** operations to Laravel Eloquent, while **Update and Delete** operations are offloaded to the Node.js REST API.
{% endhint %}

---

## 🏗️ Architectural Overview

The Marketplace feature operates across three primary domains:

1. **Frontend View Layer (Blade & Tailwind CSS)**
2. **Laravel Application Layer (PHP 8.2+)**
3. **Node.js Microservice Layer (Express & MySQL)**

### Operation Matrix

{% columns %}
{% column %}
### Laravel (Eloquent)
* **Read (Index):** Fetches all products.
* **Create (Store):** Inserts new products into the database.
* **Cart:** Session-based cart management.
{% endcolumn %}

{% column %}
### Node.js (Express API)
* **Read (Edit/Show):** Fetches single product details for updates.
* **Update:** Modifies existing product records.
* **Delete:** Removes product records from the database.
{% endcolumn %}
{% endcolumns %}

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

The Laravel application handles routing and rendering for the marketplace.

#### `MarketplaceProductController`

This controller manages the primary product catalog and administration.

{% tabs %}
{% tab title="Index & Store (Laravel Eloquent)" %}
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
    // Redirect...
}
```
{% endtab %}

{% tab title="Update & Destroy (Node.js API)" %}
```php
// app/Http/Controllers/MarketplaceProductController.php

public function update(Request $request, string $id) {
    // Validation...
    Http::put("http://localhost:3000/products/$id", [
        // Payload...
    ]);
    // Redirect...
}

public function destroy(string $id) {
    Http::delete("http://localhost:3000/products/$id");
    // Redirect...
}
```
{% endtab %}
{% endtabs %}

#### `CartController`

The cart system operates purely within the Laravel application using session state.

* **`add()`**: Appends a product to the `cart` session array, handling quantity increments.
* **`checkout()`**: Simulates a checkout by clearing the session data.

{% hint style="warning" %}
Cart data is transient and tied to the user's current session. It does not currently persist in the database.
{% endhint %}

### 3. Node.js API Service

The Node.js microservice provides a RESTful interface for product management, used primarily by the admin backend.

**Location:** `app/node/controller/productController.js`

* **`getProductById`**: Retrieves a specific product.
* **`updateProduct`**: Updates an existing product.
* **`deleteProduct`**: Removes a product from the database.

---

## 🚀 Workflows

### Purchasing a Product

{% stepper %}
{% step %}
### Browse Catalog
The user navigates to the marketplace. Laravel fetches products via `MarketplaceProduct::orderBy('created_at', 'desc')->get()`.
{% endstep %}

{% step %}
### Add to Cart
The user clicks "Add to Cart". An asynchronous request is sent to `CartController@add`, which updates the PHP session.
{% endstep %}

{% step %}
### Checkout
The user completes the purchase. `CartController@checkout` flushes the cart session and redirects with a success message.
{% endstep %}
{% endstepper %}

### Modifying a Product (Admin)

{% stepper %}
{% step %}
### Access Edit Form
The admin requests to edit a product. Laravel makes a `GET` request to the Node API `http://localhost:3000/products/{id}` to fetch the current product data.
{% endstep %}

{% step %}
### Submit Changes
The admin submits the form. Laravel validates the input and sends a `PUT` request to `http://localhost:3000/products/{id}`.
{% endstep %}

{% step %}
### Database Update
The Node.js service updates the MySQL database directly using the `mysql` driver.
{% endstep %}
{% endstepper %}

---

## ⚠️ Known Constraints & Best Practices

1. **Service Dependency:** The Laravel application relies on the Node.js service running on `http://localhost:3000`. If the Node service is down, operations like updating or deleting products will fail.
2. **Image Handling:** Image uploads are processed by Laravel (`$request->file('image_path')->store('marketplace_products', 'public')`) and the resulting path is stored in the database. When updating via the Node API, Laravel passes this path payload.
3. **Routing:** Ensure `routes/web.php` protects update and delete routes with the `AdminMiddleware`.
