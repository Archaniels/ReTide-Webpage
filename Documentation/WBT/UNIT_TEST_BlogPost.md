# Unit Test: BlogPost

This document outlines the unit test cases executed for the `BlogPost` feature.

| Test ID | Description | Test Steps | Test Data | Expected Result | Actual Result | Pass/Fail |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| TC001 | Verify BlogPost model fillable attributes | 1. Instantiate `BlogPost` model.<br>2. Retrieve fillable attributes. | None | Fillable attributes should exactly match: `['title', 'content', 'image_path']`. | | |
| TC002 | Verify BlogPost model table and primary key | 1. Instantiate `BlogPost` model.<br>2. Retrieve table name.<br>3. Retrieve primary key name. | None | Table name should be `'blog_posts'`. Primary key name should be `'id'`. | | |
| TC003 | Verify successful creation and persistence of a BlogPost | 1. Provide valid post data.<br>2. Call `BlogPost::create()` with the data.<br>3. Verify the returned object type.<br>4. Check the database for the inserted record.<br>5. Validate the model's properties against the provided data. | `['title' => 'Sample Blog Title', 'content' => 'This is the sample blog content. It must have at least ten characters.', 'image_path' => 'https://res.cloudinary.com/dummy.jpg']` | A `BlogPost` instance is returned. The record is successfully stored in the `blog_posts` database table. The object attributes match the input data exactly. | | |
