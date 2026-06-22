# Unit Test: DonationUpdate

This document outlines the unit test cases executed for the `DonationUpdate` feature.

| Test ID | Description | Test Steps | Test Data | Expected Result | Actual Result | Pass/Fail |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| TC001 | Verify DonationUpdate model fillable attributes | 1. Instantiate `DonationUpdate` model.<br>2. Retrieve fillable attributes. | None | Fillable attributes should exactly match: `['donation_id', 'title', 'description', 'status']`. | | |
| TC002 | Verify successful creation and persistence of a DonationUpdate | 1. Create a dummy user via factory.<br>2. Create a donation associated with the user.<br>3. Provide update data linked to the donation.<br>4. Call `DonationUpdate::create()` with the data.<br>5. Verify the returned object type.<br>6. Check the database for the inserted record.<br>7. Validate the model's properties. | Valid `Donation`. Update data: `['donation_id' => $donation->id, 'title' => 'Project Started', 'description' => 'We have officially started the project.', 'status' => 'in_progress']` | A `DonationUpdate` instance is returned. The record is stored in the `donation_updates` table. The object attributes match the input data. | | |
| TC003 | Verify DonationUpdate belongs to a Donation | 1. Create a dummy user via factory.<br>2. Create a donation associated with the user.<br>3. Create a donation update linked to the donation.<br>4. Retrieve the `donation` relation from the update model. | User, Donation, and DonationUpdate with `donation_id` mapped. | The relation returns a `Donation` instance, and the donation's `id` matches the update's `donation_id`. | | |
