# Unit Test: Donation

This document outlines the unit test cases executed for the `Donation` feature.

| Test ID | Description | Test Steps | Test Data | Expected Result | Actual Result | Pass/Fail |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| TC001 | Verify Donation model fillable attributes | 1. Instantiate `Donation` model.<br>2. Retrieve fillable attributes. | None | Fillable attributes should exactly match: `['name', 'email', 'amount', 'message', 'user_id']`. | | |
| TC002 | Verify successful creation and persistence of a Donation | 1. Create a dummy user via factory.<br>2. Provide valid donation data associated with the user.<br>3. Call `Donation::create()` with the data.<br>4. Verify the returned object type.<br>5. Check the database for the inserted record.<br>6. Validate the model's properties. | A generated `User`. Donation data: `['name' => 'John Doe', 'email' => 'john@example.com', 'amount' => 50000, 'message' => 'Keep up the good work!', 'user_id' => $user->id]` | A `Donation` instance is returned. The record is successfully stored in the `donations` database table. The object attributes match the input data. | | |
| TC003 | Verify Donation belongs to a User | 1. Create a dummy user via factory.<br>2. Create a donation associated with the user.<br>3. Retrieve the user relation from the donation model. | User and Donation with `user_id` mapped. | The relation returns a `User` instance, and the user's `id` matches the donation's `user_id`. | | |
| TC004 | Verify Donation has many DonationUpdates | 1. Create a dummy user via factory.<br>2. Create a donation associated with the user.<br>3. Create multiple `DonationUpdate` records linked to the donation's `id`.<br>4. Retrieve the `updates` relation from the donation model. | User, Donation, and two `DonationUpdate` entries. | The `updates` relation returns a collection with exactly 2 items, and the items are instances of `DonationUpdate`. | | |
