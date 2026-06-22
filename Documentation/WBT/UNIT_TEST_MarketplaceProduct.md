# Unit Test: MarketplaceProduct

This document outlines the unit test cases executed for the `MarketplaceProduct` feature.

| Test ID | Description | Test Steps | Test Data | Expected Result | Actual Result | Pass/Fail |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| TC001 | Verify MarketplaceProduct can be instantiated and persisted | 1. Provide valid product data.<br>2. Call `MarketplaceProduct::create()` with the data.<br>3. Check the database for the inserted record.<br>4. Retrieve the table name and primary key.<br>5. Retrieve fillable attributes. | `['name' => 'Eco Bottle', 'description' => 'A bottle made of ocean plastic.', 'price' => 150000.00, 'image_path' => 'https://res.cloudinary.com/eco-bottle.jpg']` | Record is stored in `marketplace_products`. Table name is `marketplace_products`, primary key is `id`, and fillable attributes are `['name', 'description', 'price', 'image_path']`. | | |
