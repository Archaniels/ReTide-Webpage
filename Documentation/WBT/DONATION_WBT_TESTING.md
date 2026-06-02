# White Box Testing: Donation Feature

**Testing Methodology:** 
- **Statement Coverage:** Ensuring every line of code within the controllers (`DonationController`, `DonationUpdateController`) is executed at least once.
- **Branch Coverage:** Ensuring every possible decision path (e.g., validation pass/fail, ternary operators, conditional `if` statements) is validated according to its `true` and `false` evaluations.

## Test Cases

| Test ID | Description | Test Steps | Test Data | Expected Result | Actual Result | Pass/Fail |
|---|---|---|---|---|---|---|
| TC001 | Valid Donation with Name & Email | 1. Authenticate user<br>2. Call `DonationController@store`<br>3. Provide valid amount, name, and email | `amount=5000`<br>`name="John Doe"`<br>`email="john@test.com"` | Validation passes. **True** branches of name & email ternary operators executed. Donation created using provided data. Redirect to success page. | | |
| TC002 | Valid Donation without Optional Fields | 1. Authenticate user<br>2. Call `DonationController@store`<br>3. Provide valid amount only | `amount=5000`<br>`name=""`<br>`email=""` | Validation passes. **False** branches of name & email ternary operators executed. Donation created using Auth user's data as fallback. Redirect to success. | | |
| TC003 | Invalid Donation Amount (Validation Failure) | 1. Authenticate user<br>2. Call `DonationController@store`<br>3. Provide invalid amount | `amount=500` | Validation fails. Exception thrown. Code block for `Donation::create` is bypassed. | | |
| TC004 | View Donation Page Index | 1. Authenticate user<br>2. Call `DonationController@index` | User with existing donations | Retrieves user's donations. Calculates sum. Returns `donation` view. | | |
| TC005 | Fetch Donation Updates (Public API) | 1. Call `DonationController@updates` | Existing `Donation` ID | Returns JSON response with latest `DonationUpdate` records. | | |
| TC006 | View Donation Success Page | 1. Call `DonationController@success` | N/A | Returns `donation_success` view. | | |
| TC007 | Admin: View All Donations | 1. Call `DonationController@adminIndex` | N/A | Returns `admin.donations.index` view with all donations and user relationships. | | |
| TC008 | Admin: Delete Donation | 1. Call `DonationController@adminDestroy` | Existing `Donation` ID | Donation is deleted from DB. Redirect to admin index with success message. | | |
| TC009 | Admin: View Donation Updates (Non-AJAX) | 1. Call `DonationUpdateController@index` via standard HTTP GET | Existing `Donation` ID | `request()->ajax()` evaluates to **False**. Returns `admin.donation_updates.index` view. | | |
| TC010 | Admin: Fetch Donation Updates (AJAX) | 1. Call `DonationUpdateController@index` via XHR | Existing `Donation` ID, `X-Requested-With=XMLHttpRequest` | `request()->ajax()` evaluates to **True**. Returns `admin.donation_updates.partials.updates_list` partial view. | | |
| TC011 | Admin: View Create Update Form | 1. Call `DonationUpdateController@create` | Existing `Donation` ID | Returns `admin.donation_updates.create` view. | | |
| TC012 | Admin: Valid Donation Update Store | 1. Call `DonationUpdateController@store`<br>2. Provide valid title, description, status | `title="Update 1"`<br>`description="Content"`<br>`status="Ongoing"` | Validation passes. Update record created. Redirect to admin updates index with success message. | | |
| TC013 | Admin: Invalid Donation Update Store | 1. Call `DonationUpdateController@store`<br>2. Omit required title | `title=""`<br>`description="Content"`<br>`status="Ongoing"` | Validation fails. Exception thrown. `DonationUpdate::create` block is bypassed. | | |
