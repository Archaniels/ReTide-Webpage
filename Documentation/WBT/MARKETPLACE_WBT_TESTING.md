# White Box Testing: Marketplace Feature

**Target Controller:** `app/Http/Controllers/MarketplaceProductController.php`

## Methodology
- **Statement Coverage**: Ensures that every single line of code within the controller methods is executed at least once.
- **Branch Coverage**: Validates every possible path (true and false) from each decision point, such as `if` statements, validation passes/failures, and `findOrFail` exception handling.

## Test Cases

| Test ID | Description | Test Steps | Test Data | Expected Result | Actual Result | Pass/Fail |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| **TC001** | `index` Method - Full Statement Coverage | 1. Invoke the `index` method. | None | Returns the `marketplace.index` view with a collection of all products ordered by `created_at` descending. | | |
| **TC002** | `create` Method - Full Statement Coverage | 1. Invoke the `create` method. | None | Returns the `marketplace.create` view. | | |
| **TC003** | `store` Method - Validation Failure Branch | 1. Submit a `POST` request to `store` with invalid input. | `name` = "", `price` = -10, `image_path` = null | Throws `ValidationException`. Redirects back to the form with validation error messages. | | |
| **TC004** | `store` Method - Branch `hasFile('image_path')` is False | 1. Submit a `POST` request to `store` with valid data but no image file. | `name` = "Valid Product", `description` = "Detailed description", `price` = 150.00, `image_path` = null | Product is created in the database with `image_path` as `null`. Redirects to index route with a success message. | | |
| **TC005** | `store` Method - Branch `hasFile('image_path')` is True | 1. Submit a `POST` request to `store` with valid data and a valid image file. | `name` = "Valid Product", `description` = "Detailed description", `price` = 150.00, `image_path` = [valid_image.jpg] | Image is stored in `public/marketplace_products`. Product is created with the new `image_path`. Redirects to index route with a success message. | | |
| **TC006** | `show` Method - ID Exists Branch | 1. Invoke the `show` method with an existing product ID. | `id` = 1 (Exists in DB) | Product is successfully retrieved. Returns the `marketplace.show` view containing the product data. | | |
| **TC007** | `show` Method - ID Does Not Exist Branch | 1. Invoke the `show` method with a non-existing product ID. | `id` = 9999 (Does not exist) | `findOrFail` throws `ModelNotFoundException` (resulting in a 404 Not Found response). | | |
| **TC008** | `edit` Method - ID Exists Branch | 1. Invoke the `edit` method with an existing product ID. | `id` = 1 (Exists in DB) | Product is successfully retrieved. Returns the `marketplace.edit` view containing the product data. | | |
| **TC009** | `edit` Method - ID Does Not Exist Branch | 1. Invoke the `edit` method with a non-existing product ID. | `id` = 9999 (Does not exist) | `findOrFail` throws `ModelNotFoundException` (resulting in a 404 Not Found response). | | |
| **TC010** | `update` Method - Target ID Does Not Exist Branch | 1. Submit a `PUT` request to `update` for a non-existing ID. | `id` = 9999 (Does not exist) | Execution halts at `findOrFail` throwing `ModelNotFoundException` (404 Not Found response). | | |
| **TC011** | `update` Method - Validation Failure Branch | 1. Submit a `PUT` request to `update` for an existing ID with invalid data. | `id` = 1, `name` = "", `price` = "invalid" | Throws `ValidationException`. Redirects back to the edit form with validation error messages. | | |
| **TC012** | `update` Method - Branch `hasFile('image_path')` is False | 1. Submit a `PUT` request to `update` for an existing ID, valid data, but no new image. | `id` = 1, `name` = "Updated Product", `price` = 250.00, `image_path` = null | Product attributes are updated, but `image_path` remains unchanged. Redirects to index route with a success message. | | |
| **TC013** | `update` Method - Branch `hasFile('image_path')` is True | 1. Submit a `PUT` request to `update` for an existing ID, valid data, and a new image file. | `id` = 1, `name` = "Updated Product", `price` = 250.00, `image_path` = [new_image.png] | New image is stored. Product is updated with the new `image_path`. Redirects to index route with a success message. | | |
| **TC014** | `destroy` Method - ID Exists Branch | 1. Submit a `DELETE` request to `destroy` for an existing product ID. | `id` = 1 (Exists in DB) | Product is successfully retrieved and deleted from the database. Redirects to index route with a success message. | | |
| **TC015** | `destroy` Method - ID Does Not Exist Branch | 1. Submit a `DELETE` request to `destroy` for a non-existing product ID. | `id` = 9999 (Does not exist) | `findOrFail` throws `ModelNotFoundException` (resulting in a 404 Not Found response). | | |
