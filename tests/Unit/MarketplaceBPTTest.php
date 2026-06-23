<?php

namespace Tests\Unit;

use App\Models\MarketplaceProduct;
use App\Models\User;
use App\Models\Payment;
use Cloudinary\Api\ApiResponse;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Cloudinary;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Route;
use Midtrans\Notification;
use Mockery;
use Tests\TestCase;

class MarketplaceBPTTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['midtrans.server_key' => 'test-server-key']);

        // Dynamically register the show route for public show page
        if (!Route::has('marketplace.show')) {
            Route::get('/marketplace/{id}', [\App\Http\Controllers\MarketplaceProductController::class, 'show'])
                ->name('marketplace.show')
                ->middleware(['auth', 'not_admin']);
        }
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    protected function mockCloudinary(): void
    {
        $mockCloudinary = Mockery::mock(Cloudinary::class);
        $mockUploadApi = Mockery::mock(UploadApi::class);
        $mockCloudinary->shouldReceive("uploadApi")->andReturn($mockUploadApi);
        $mockUploadApi
            ->shouldReceive("upload")
            ->andReturn(
                new ApiResponse(
                    ["secure_url" => "https://res.cloudinary.com/dummy.jpg"],
                    [],
                ),
            );
        $this->app->instance("cloudinary", $mockCloudinary);
        $this->app->instance(Cloudinary::class, $mockCloudinary);
    }

    protected function setupNotificationMock($orderId, $status, $paymentType = 'credit_card', $fraudStatus = 'accept', $transactionId = '12345678', $statusCode = '200', $grossAmount = '100000.00', $signatureKey = null): void
    {
        if ($signatureKey === null) {
            $serverKey = config('midtrans.server_key');
            $signatureKey = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);
        }

        $mock = Mockery::mock(Notification::class);
        $mock->transaction_status = $status;
        $mock->payment_type = $paymentType;
        $mock->order_id = $orderId;
        $mock->fraud_status = $fraudStatus;
        $mock->transaction_id = $transactionId;
        $mock->status_code = $statusCode;
        $mock->gross_amount = $grossAmount;
        $mock->signature_key = $signatureKey;

        $this->app->instance(Notification::class, $mock);
    }

    /**
     * TC01 - Path: 1 -> 2 (index)
     * Description: Access the public marketplace product listing page.
     */
    public function test_access_public_marketplace_product_listing(): void
    {
        $user = User::factory()->create(["role" => "user"]);
        
        MarketplaceProduct::create([
            'name' => 'Eco Bottle',
            'description' => 'A bottle made of ocean plastic.',
            'price' => 15000.00,
        ]);

        $response = $this->actingAs($user)->get("/marketplace");

        $response->assertStatus(200);
        $response->assertViewIs("marketplace.index");
        $response->assertViewHas("products");
    }

    /**
     * TC02 - Path: 1 (create)
     * Description: Access the marketplace product creation form as an admin.
     */
    public function test_access_marketplace_product_creation_form_as_admin(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);

        $response = $this->actingAs($admin)->get("/admin/marketplace/create");

        $response->assertStatus(200);
        $response->assertViewIs("marketplace.create");
    }

    /**
     * TC03 - Path: 1 -> 2 (store)
     * Description: Submit creation of a new product with invalid fields causing validation failure.
     */
    public function test_store_product_validation_fails_for_invalid_fields(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);

        $response = $this->actingAs($admin)->post("/admin/marketplace", [
            'name' => '',
            'description' => '',
            'price' => '',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name', 'description', 'price']);
    }

    /**
     * TC04 - Path: 1 -> 3 -> 4 -> 6 -> 7 (store)
     * Description: Successfully create a product with valid details and an image upload.
     */
    public function test_store_product_successfully_with_image_upload(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);
        $this->mockCloudinary();

        $image = UploadedFile::fake()->create("product.jpg", 100, "image/jpeg");

        $response = $this->actingAs($admin)->post("/admin/marketplace", [
            "name" => "Recycled Ocean Bottle",
            "description" => "High quality bottle made of ocean plastic",
            "price" => 25000.00,
            "image_path" => $image,
        ]);

        $response->assertRedirect(route("admin.marketplace.index"));
        $response->assertSessionHas("success", "Product berhasil ditambahkan!");

        $this->assertDatabaseHas("marketplace_products", [
            "name" => "Recycled Ocean Bottle",
            "description" => "High quality bottle made of ocean plastic",
            "price" => 25000.00,
            "image_path" => "https://res.cloudinary.com/dummy.jpg",
        ]);
    }

    /**
     * TC05 - Path: 1 -> 3 -> 5 -> 6 -> 7 (store)
     * Description: Successfully create a product with valid details and no image upload.
     */
    public function test_store_product_successfully_without_image_upload(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);

        $response = $this->actingAs($admin)->post("/admin/marketplace", [
            "name" => "Recycled Notebook",
            "description" => "Notebook made from waste cardboards",
            "price" => 15000.00,
            "image_path" => null,
        ]);

        $response->assertRedirect(route("admin.marketplace.index"));
        $response->assertSessionHas("success", "Product berhasil ditambahkan!");

        $this->assertDatabaseHas("marketplace_products", [
            "name" => "Recycled Notebook",
            "description" => "Notebook made from waste cardboards",
            "price" => 15000.00,
            "image_path" => null,
        ]);
    }

    /**
     * TC06 - Path: 1 -> 2 (show)
     * Description: Try to view details of a product that does not exist.
     */
    public function test_view_details_of_nonexistent_product_returns_not_found(): void
    {
        $user = User::factory()->create(["role" => "user"]);

        $response = $this->actingAs($user)->get("/marketplace/99999");

        $response->assertStatus(404);
    }

    /**
     * TC07 - Path: 1 -> 3 (show)
     * Description: Successfully view details of an existing product.
     */
    public function test_view_details_of_existing_product_successfully(): void
    {
        $user = User::factory()->create(["role" => "user"]);
        $product = MarketplaceProduct::create([
            "name" => "Recycled Ocean Bottle",
            "description" => "High quality bottle made of ocean plastic",
            "price" => 25000.00,
        ]);

        $response = $this->actingAs($user)->get("/marketplace/{$product->id}");

        $response->assertStatus(200);
        $response->assertViewIs("marketplace.show");
        $response->assertViewHas("product", function ($viewProduct) use ($product) {
            return $viewProduct->id === $product->id;
        });
    }

    /**
     * TC08 - Path: 1 -> 2 (edit)
     * Description: Access edit product form for a non-existent product ID.
     */
    public function test_edit_product_form_for_nonexistent_product_returns_not_found(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);

        $response = $this->actingAs($admin)->get("/admin/marketplace/99999/edit");

        $response->assertStatus(404);
    }

    /**
     * TC09 - Path: 1 -> 3 (edit)
     * Description: Access edit product form for an existing product ID.
     */
    public function test_edit_product_form_for_existing_product_successfully(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);
        $product = MarketplaceProduct::create([
            "name" => "Recycled Ocean Bottle",
            "description" => "High quality bottle made of ocean plastic",
            "price" => 25000.00,
        ]);

        $response = $this->actingAs($admin)->get("/admin/marketplace/{$product->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs("marketplace.edit");
        $response->assertViewHas("product", function ($viewProduct) use ($product) {
            return $viewProduct->id === $product->id;
        });
    }

    /**
     * TC10 - Path: 1 -> 2 (update)
     * Description: Try to update details of a non-existent product ID.
     */
    public function test_update_details_of_nonexistent_product_returns_not_found(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);

        $response = $this->actingAs($admin)->put("/admin/marketplace/99999", [
            "name" => "Updated Name",
            "description" => "Updated Desc",
            "price" => 30000.00,
        ]);

        $response->assertStatus(404);
    }

    /**
     * TC11 - Path: 1 -> 3 -> 4 (update)
     * Description: Try to update product with invalid inputs causing validation failure.
     */
    public function test_update_product_validation_fails_for_invalid_inputs(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);
        $product = MarketplaceProduct::create([
            "name" => "Original Product",
            "description" => "Original Description",
            "price" => 20000.00,
        ]);

        $response = $this->actingAs($admin)->put("/admin/marketplace/{$product->id}", [
            "name" => "Eco",
            "description" => "",
            "price" => -10.00,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(["name", "description", "price"]);
    }

    /**
     * TC12 - Path: 1 -> 3 -> 5 -> 6 -> 8 -> 9 (update)
     * Description: Update product details and replace the old image with a new image upload.
     */
    public function test_update_product_with_new_image_upload(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);
        $product = MarketplaceProduct::create([
            "name" => "Original Product",
            "description" => "Original Description",
            "price" => 20000.00,
            "image_path" => "https://res.cloudinary.com/old_image.png",
        ]);

        $this->mockCloudinary();
        $image = UploadedFile::fake()->create("new_product.png", 100, "image/png");

        $response = $this->actingAs($admin)->put("/admin/marketplace/{$product->id}", [
            "name" => "Eco Bottle Redux",
            "description" => "Upgraded ocean-waste bottle",
            "price" => 35000.00,
            "image_path" => $image,
        ]);

        $response->assertRedirect(route("admin.marketplace.index"));
        $response->assertSessionHas("success", "Product berhasil diperbarui!");

        $this->assertDatabaseHas("marketplace_products", [
            "id" => $product->id,
            "name" => "Eco Bottle Redux",
            "description" => "Upgraded ocean-waste bottle",
            "price" => 35000.00,
            "image_path" => "https://res.cloudinary.com/dummy.jpg",
        ]);
    }

    /**
     * TC13 - Path: 1 -> 3 -> 5 -> 7 -> 8 -> 9 (update)
     * Description: Update product details without replacing the existing image.
     */
    public function test_update_product_retaining_old_image(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);
        $product = MarketplaceProduct::create([
            "name" => "Original Product",
            "description" => "Original Description",
            "price" => 20000.00,
            "image_path" => "https://res.cloudinary.com/original.jpg",
        ]);

        $response = $this->actingAs($admin)->put("/admin/marketplace/{$product->id}", [
            "name" => "Eco Bottle Redux",
            "description" => "Upgraded ocean-waste bottle",
            "price" => 35000.00,
            "image_path" => null,
        ]);

        $response->assertRedirect(route("admin.marketplace.index"));
        $response->assertSessionHas("success", "Product berhasil diperbarui!");

        $this->assertDatabaseHas("marketplace_products", [
            "id" => $product->id,
            "name" => "Eco Bottle Redux",
            "description" => "Upgraded ocean-waste bottle",
            "price" => 35000.00,
            "image_path" => "https://res.cloudinary.com/original.jpg",
        ]);
    }

    /**
     * TC14 - Path: 1 -> 2 (destroy)
     * Description: Try to delete a non-existent product ID.
     */
    public function test_delete_nonexistent_product_returns_not_found(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);

        $response = $this->actingAs($admin)->delete("/admin/marketplace/99999");

        $response->assertStatus(404);
    }

    /**
     * TC15 - Path: 1 -> 3 -> 4 (destroy)
     * Description: Successfully delete an existing product.
     */
    public function test_delete_existing_product_successfully(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);
        $product = MarketplaceProduct::create([
            "name" => "Product to Delete",
            "description" => "Description of product to be deleted.",
            "price" => 50000.0,
        ]);

        $response = $this->actingAs($admin)->delete("/admin/marketplace/{$product->id}");

        $response->assertRedirect(route("admin.marketplace.index"));
        $response->assertSessionHas("success", "Product berhasil dihapus!");

        $this->assertDatabaseMissing("marketplace_products", [
            "id" => $product->id,
        ]);
    }

    /**
     * TC16 - Path: 1 -> 2 (add)
     * Description: Attempt to add a non-existent product ID to the cart.
     */
    public function test_add_nonexistent_product_to_cart_returns_not_found(): void
    {
        $user = User::factory()->create(["role" => "user"]);

        $response = $this->actingAs($user)->postJson(route("cart.add"), [
            "product_id" => 99999,
        ]);

        $response->assertStatus(404);
    }

    /**
     * TC17 - Path: 1 -> 3 -> 4 -> 5 -> 7 (add)
     * Description: Add a product that is already present in the cart, incrementing its quantity.
     */
    public function test_add_already_present_product_increments_cart_quantity(): void
    {
        $user = User::factory()->create(["role" => "user"]);
        $product = MarketplaceProduct::create([
            "name" => "Eco Bottle",
            "description" => "High quality bottle made of ocean plastic",
            "price" => 15000.00,
        ]);

        session()->put('cart', [
            $product->id => [
                'name' => 'Eco Bottle',
                'quantity' => 1,
                'price' => 15000.00,
                'image' => 'bottle.jpg',
            ]
        ]);

        $response = $this->actingAs($user)->postJson(route("cart.add"), [
            "product_id" => $product->id,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            "status" => "success",
            "message" => "Eco Bottle added to cart!",
        ]);

        $cart = session()->get("cart");
        $this->assertEquals(2, $cart[$product->id]['quantity']);
    }

    /**
     * TC18 - Path: 1 -> 3 -> 4 -> 6 -> 7 (add)
     * Description: Add a new product to the cart (initialize item with quantity 1).
     */
    public function test_add_new_product_initializes_cart_with_quantity_one(): void
    {
        $user = User::factory()->create(["role" => "user"]);
        $product = MarketplaceProduct::create([
            "name" => "Eco Bottle",
            "description" => "High quality bottle made of ocean plastic",
            "price" => 15000.00,
        ]);

        session()->put('cart', []);

        $response = $this->actingAs($user)->postJson(route("cart.add"), [
            "product_id" => $product->id,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            "status" => "success",
            "message" => "Eco Bottle added to cart!",
        ]);

        $cart = session()->get("cart");
        $this->assertEquals(1, $cart[$product->id]['quantity']);
    }

    /**
     * TC19 - Path: 1 -> 2 -> 6 -> 7 (sync)
     * Description: Sync an empty frontend cart to session.
     */
    public function test_sync_empty_cart_sets_empty_session(): void
    {
        $user = User::factory()->create(["role" => "user"]);
        session()->put('cart', [123 => ['name' => 'Old Product', 'quantity' => 1, 'price' => 10000.00]]);

        $response = $this->actingAs($user)->postJson(route("cart.sync"), [
            "cart" => [],
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            "status" => "success",
            "message" => "Cart synced successfully!",
        ]);

        $this->assertEquals([], session()->get("cart"));
    }

    /**
     * TC20 - Path: 1 -> 2 -> 3 -> 4 (sync)
     * Description: Attempt to sync a cart containing a non-existent product ID.
     */
    public function test_sync_cart_with_nonexistent_product_returns_not_found(): void
    {
        $user = User::factory()->create(["role" => "user"]);
        session()->put('cart', []);

        $response = $this->actingAs($user)->postJson(route("cart.sync"), [
            "cart" => [
                ["id" => 99999, "quantity" => 2]
            ],
        ]);

        $response->assertStatus(404);
        $this->assertEquals([], session()->get("cart"));
    }

    /**
     * TC21 - Path: 1 -> 2 -> 3 -> 5 -> 2 -> 6 -> 7 (sync)
     * Description: Sync a cart containing items, and verify canonical database prices are used to block price manipulation.
     */
    public function test_sync_cart_ignores_manipulated_client_prices(): void
    {
        $user = User::factory()->create(["role" => "user"]);
        $product = MarketplaceProduct::create([
            "name" => "Eco Bottle",
            "description" => "High quality bottle made of ocean plastic",
            "price" => 15000.00,
        ]);

        $response = $this->actingAs($user)->postJson(route("cart.sync"), [
            "cart" => [
                [
                    "id" => $product->id,
                    "quantity" => 3,
                    "price" => 1.00,
                    "name" => "Faked Cheap Bottle"
                ]
            ],
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            "status" => "success",
            "message" => "Cart synced successfully!",
        ]);

        $cart = session()->get("cart");
        $this->assertEquals("Eco Bottle", $cart[$product->id]['name']);
        $this->assertEquals(3, $cart[$product->id]['quantity']);
        $this->assertEquals(15000.00, $cart[$product->id]['price']);
    }

    /**
     * TC22 - Path: 1 -> 2 -> 3 (checkout)
     * Description: Try to view the checkout page with an empty cart.
     */
    public function test_view_checkout_with_empty_cart_redirects_back(): void
    {
        $user = User::factory()->create(["role" => "user"]);
        session()->put('cart', []);

        $response = $this->actingAs($user)->get(route("cart.checkout"));

        $response->assertRedirect(route("marketplace.index"));
        $response->assertSessionHas("error", "Cart is empty!");
    }

    /**
     * TC23 - Path: 1 -> 2 -> 4 -> 5 -> 6 -> 5 -> 7 -> 8 (checkout)
     * Description: View the checkout page with items, producing a Midtrans snap token and payment record.
     */
    public function test_view_checkout_with_items_generates_snap_token_and_payment(): void
    {
        $user = User::factory()->create(["role" => "user"]);
        $product = MarketplaceProduct::create([
            "name" => "Eco Bottle",
            "description" => "High quality bottle made of ocean plastic",
            "price" => 15000.00,
        ]);

        session()->put('cart', [
            $product->id => [
                'name' => 'Eco Bottle',
                'quantity' => 2,
                'price' => 15000.00,
                'image' => 'bottle.jpg',
            ]
        ]);

        $mockSnap = Mockery::mock('alias:\Midtrans\Snap');
        $mockSnap->shouldReceive('getSnapToken')->andReturn('snap-token-abc');

        $response = $this->actingAs($user)->get(route("cart.checkout"));

        $response->assertStatus(200);
        $response->assertViewIs("checkout");
        $response->assertViewHas("snapToken", "snap-token-abc");
        $response->assertViewHas("totalAmount", 30000.00);

        $this->assertDatabaseHas('payments', [
            'status' => 'pending',
            'payment_type' => 'marketplace',
            'gross_amount' => 30000.00,
            'user_id' => $user->id,
            'snap_token' => 'snap-token-abc',
        ]);
    }

    /**
     * TC24 - Path: 1 -> 2 -> 3 (process)
     * Description: Submit checkout process request with an empty cart.
     */
    public function test_process_checkout_with_empty_cart_redirects_back(): void
    {
        $user = User::factory()->create(["role" => "user"]);
        session()->put('cart', []);

        $response = $this->actingAs($user)->post(route("cart.process"));

        $response->assertRedirect(route("marketplace.index"));
        $response->assertSessionHas("error", "Cart is empty!");
    }

    /**
     * TC25 - Path: 1 -> 2 -> 4 -> 5 -> 6 -> 5 -> 7 -> 8 (process)
     * Description: Process checkout with items in cart, returning JSON snap token.
     */
    public function test_process_checkout_with_items_returns_snap_token_json(): void
    {
        $user = User::factory()->create(["role" => "user"]);
        $product = MarketplaceProduct::create([
            "name" => "Eco Bottle",
            "description" => "High quality bottle made of ocean plastic",
            "price" => 15000.00,
        ]);

        session()->put('cart', [
            $product->id => [
                'name' => 'Eco Bottle',
                'quantity' => 2,
                'price' => 15000.00,
                'image' => 'bottle.jpg',
            ]
        ]);

        $mockSnap = Mockery::mock('alias:\Midtrans\Snap');
        $mockSnap->shouldReceive('getSnapToken')->andReturn('snap-token-xyz');

        $response = $this->actingAs($user)->postJson(route("cart.process"));

        $response->assertStatus(200);
        $response->assertJson([
            "status" => "success",
            "snap_token" => "snap-token-xyz",
        ]);

        $this->assertDatabaseHas('payments', [
            'status' => 'pending',
            'payment_type' => 'marketplace',
            'gross_amount' => 30000.00,
            'user_id' => $user->id,
            'snap_token' => 'snap-token-xyz',
        ]);
    }

    /**
     * TC26 - Path: 1 -> 2 (index)
     * Description: Access admin marketplace index listing.
     */
    public function test_access_admin_marketplace_index_successfully(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);

        $response = $this->actingAs($admin)->get("/admin/marketplace");

        $response->assertStatus(200);
        $response->assertViewIs("admin.marketplace.index");
    }
}