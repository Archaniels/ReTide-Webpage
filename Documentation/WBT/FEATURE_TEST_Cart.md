# Feature Test: Cart

This document outlines the feature test cases executed for the `Cart` feature.

| Test ID | Description | Test Steps | Test Data | Expected Result | Actual Result | Pass/Fail |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| TC001 | User can add product to cart | 1. Login as User.<br>2. Submit POST `/cart/add` with valid product ID. | Valid `MarketplaceProduct` | Return 200 OK JSON success. Session cart has product with quantity 1. | | |
| TC002 | Add to cart fails for non-existent product | 1. Login as User.<br>2. Submit POST `/cart/add` with invalid product ID. | Invalid Product ID (`99999`) | Return 404 Not Found. | | |
| TC003 | User can sync cart | 1. Login as User.<br>2. Submit POST `/cart/sync` with cart payload. | Valid `MarketplaceProduct`, Cart payload array | Return 200 OK JSON success. Session cart reflects synced data. | | |
| TC004 | User cannot manipulate price during sync | 1. Login as User.<br>2. Submit POST `/cart/sync` with manipulated price and name. | Valid `MarketplaceProduct`, Cart payload with changed price/name | Return 200 OK JSON success. Session cart uses DB canonical price and name, ignoring payload falsification. | | |
| TC005 | Checkout redirects if cart is empty | 1. Login as User.<br>2. Access GET `/cart/checkout` with empty cart. | Empty session cart | Redirect to `/marketplace` with error message. | | |
| TC006 | Checkout creates payment and returns Snap token | 1. Login as User.<br>2. Fill session cart.<br>3. Access GET `/cart/checkout`.<br>4. Mock Midtrans Snap token. | Session cart with items | Return 200 OK. View has `snapToken`. DB has pending `Payment` record. | | |
| TC007 | Process cart redirects if cart is empty | 1. Login as User.<br>2. Submit POST `/cart/process` with empty cart. | Empty session cart | Redirect to `/marketplace` with error message. | | |
| TC008 | Process cart creates payment and returns JSON | 1. Login as User.<br>2. Fill session cart.<br>3. Submit POST `/cart/process`.<br>4. Mock Midtrans Snap token. | Session cart with items | Return 200 OK JSON success with `snap_token`. DB has pending `Payment` record. | | |
| TC009 | Adding existing product to cart increments quantity | 1. Login as User.<br>2. Submit POST `/cart/add` twice for the same product. | Valid `MarketplaceProduct` | Session cart has 1 entry for the product, with quantity = 2. | | |
| TC010 | Unauthenticated guests are redirected to login for cart | 1. Access `/cart/add`, `/cart/sync`, `/cart/checkout`, `/cart/process`. | Unauthenticated User | Redirect to `/login`. | | |
