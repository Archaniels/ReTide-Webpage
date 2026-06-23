<?php

namespace Tests\Feature;

use App\Models\MarketplaceProduct;
use App\Models\User;
use Cloudinary\Api\ApiResponse;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Cloudinary;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Mockery;
use Tests\TestCase;

class MarketplaceTest extends TestCase
{
    use RefreshDatabase;

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

    public function test_guests_are_redirected_to_login_for_marketplace_routes(): void
    {
        $response = $this->get("/marketplace");
        $response->assertRedirect(route("login"));

        $response = $this->get("/admin/marketplace");
        $response->assertRedirect(route("login"));
    }

    public function test_regular_users_can_access_marketplace_but_are_blocked_from_admin_marketplace(): void
    {
        $user = User::factory()->create(["role" => "user"]);

        // Can view marketplace
        $response = $this->actingAs($user)->get("/marketplace");
        $response->assertStatus(200);

        // Cannot view admin marketplace
        $response = $this->actingAs($user)->get("/admin/marketplace");
        $response->assertStatus(403);

        // Cannot create product
        $response = $this->actingAs($user)->post("/admin/marketplace", []);
        $response->assertStatus(403);
    }

    public function test_admins_are_redirected_to_dashboard_from_public_marketplace_but_can_access_admin_marketplace(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);

        // Admin visiting public marketplace is redirected to dashboard
        $response = $this->actingAs($admin)->get("/marketplace");
        $response->assertRedirect(route("admin.dashboard"));

        // Admin can access admin marketplace
        $response = $this->actingAs($admin)->get("/admin/marketplace");
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get("/admin/marketplace/create");
        $response->assertStatus(200);
    }

    public function test_admin_can_create_product_with_image(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);
        $this->mockCloudinary();

        $image = UploadedFile::fake()->create("product.jpg", 100, "image/jpeg");

        $payload = [
            "name" => "Eco Friendly T-Shirt",
            "description" => "T-shirt made of 100% recycled marine debris.",
            "price" => 199000,
            "image_path" => $image,
        ];

        $response = $this->actingAs($admin)->post(
            "/admin/marketplace",
            $payload,
        );

        $response->assertRedirect(route("admin.marketplace.index"));
        $response->assertSessionHas("success", "Product berhasil ditambahkan!");

        $this->assertDatabaseHas("marketplace_products", [
            "name" => "Eco Friendly T-Shirt",
            "description" => "T-shirt made of 100% recycled marine debris.",
            "price" => 199000.0,
            "image_path" => "https://res.cloudinary.com/dummy.jpg",
        ]);
    }

    public function test_admin_can_create_product_without_image(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);

        $payload = [
            "name" => "Eco Friendly T-Shirt No Image",
            "description" =>
                "T-shirt made of 100% recycled marine debris without image.",
            "price" => 150000,
        ];

        $response = $this->actingAs($admin)->post(
            "/admin/marketplace",
            $payload,
        );

        $response->assertRedirect(route("admin.marketplace.index"));
        $response->assertSessionHas("success", "Product berhasil ditambahkan!");

        $this->assertDatabaseHas("marketplace_products", [
            "name" => "Eco Friendly T-Shirt No Image",
            "description" =>
                "T-shirt made of 100% recycled marine debris without image.",
            "price" => 150000.0,
            "image_path" => null,
        ]);
    }

    public function test_admin_can_update_product_with_new_image(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);
        $product = MarketplaceProduct::create([
            "name" => "Original Product Name",
            "description" => "Original description for the product.",
            "price" => 100000.0,
            "image_path" => "https://res.cloudinary.com/original.jpg",
        ]);

        $this->mockCloudinary();
        $newImage = UploadedFile::fake()->create(
            "new_product.png",
            100,
            "image/png",
        );

        $payload = [
            "name" => "Updated Product Name",
            "description" => "Updated description for the product.",
            "price" => 120000.0,
            "image_path" => $newImage,
        ];

        $response = $this->actingAs($admin)->put(
            "/admin/marketplace/{$product->id}",
            $payload,
        );

        $response->assertRedirect(route("admin.marketplace.index"));
        $response->assertSessionHas("success", "Product berhasil diperbarui!");

        $this->assertDatabaseHas("marketplace_products", [
            "id" => $product->id,
            "name" => "Updated Product Name",
            "description" => "Updated description for the product.",
            "price" => 120000.0,
            "image_path" => "https://res.cloudinary.com/dummy.jpg",
        ]);
    }

    public function test_admin_can_update_product_without_new_image(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);
        $product = MarketplaceProduct::create([
            "name" => "Original Product Name",
            "description" => "Original description for the product.",
            "price" => 100000.0,
            "image_path" => "https://res.cloudinary.com/original.jpg",
        ]);

        $payload = [
            "name" => "Updated Product Name Only",
            "description" => "Updated description for the product only.",
            "price" => 120000.0,
        ];

        $response = $this->actingAs($admin)->put(
            "/admin/marketplace/{$product->id}",
            $payload,
        );

        $response->assertRedirect(route("admin.marketplace.index"));
        $response->assertSessionHas("success", "Product berhasil diperbarui!");

        $this->assertDatabaseHas("marketplace_products", [
            "id" => $product->id,
            "name" => "Updated Product Name Only",
            "description" => "Updated description for the product only.",
            "price" => 120000.0,
            "image_path" => "https://res.cloudinary.com/original.jpg",
        ]);
    }

    public function test_admin_can_delete_product(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);
        $product = MarketplaceProduct::create([
            "name" => "Product to Delete",
            "description" => "Description of product to be deleted.",
            "price" => 50000.0,
        ]);

        $response = $this->actingAs($admin)->delete(
            "/admin/marketplace/{$product->id}",
        );

        $response->assertRedirect(route("admin.marketplace.index"));
        $response->assertSessionHas("success", "Product berhasil dihapus!");

        $this->assertDatabaseMissing("marketplace_products", [
            "id" => $product->id,
        ]);
    }

    public function test_create_product_validation_fails_for_empty_fields(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);

        $response = $this->actingAs($admin)->post("/admin/marketplace", [
            "name" => "",
            "description" => "",
            "price" => "",
        ]);

        $response->assertSessionHasErrors(["name", "description", "price"]);
    }

    public function test_create_product_validation_fails_for_invalid_name_length(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);

        // Under min 5
        $response = $this->actingAs($admin)->post("/admin/marketplace", [
            "name" => "abcd",
            "description" =>
                "Valid description that meets minimum constraints.",
            "price" => 10000,
        ]);
        $response->assertSessionHasErrors(["name"]);

        // Over max 100
        $response = $this->actingAs($admin)->post("/admin/marketplace", [
            "name" => str_repeat("a", 101),
            "description" =>
                "Valid description that meets minimum constraints.",
            "price" => 10000,
        ]);
        $response->assertSessionHasErrors(["name"]);
    }

    public function test_create_product_validation_fails_for_invalid_description_length(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);

        // Under min 5
        $response = $this->actingAs($admin)->post("/admin/marketplace", [
            "name" => "Valid Name",
            "description" => "abcd",
            "price" => 10000,
        ]);
        $response->assertSessionHasErrors(["description"]);

        // Over max 3000
        $response = $this->actingAs($admin)->post("/admin/marketplace", [
            "name" => "Valid Name",
            "description" => str_repeat("a", 3001),
            "price" => 10000,
        ]);
        $response->assertSessionHasErrors(["description"]);
    }

    public function test_create_product_validation_fails_for_invalid_price(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);

        // Not numeric
        $response = $this->actingAs($admin)->post("/admin/marketplace", [
            "name" => "Valid Name",
            "description" =>
                "Valid description that meets minimum constraints.",
            "price" => "not-numeric",
        ]);
        $response->assertSessionHasErrors(["price"]);

        // Negative price
        $response = $this->actingAs($admin)->post("/admin/marketplace", [
            "name" => "Valid Name",
            "description" =>
                "Valid description that meets minimum constraints.",
            "price" => -10,
        ]);
        $response->assertSessionHasErrors(["price"]);

        // Exceeds max 99999999.99
        $response = $this->actingAs($admin)->post("/admin/marketplace", [
            "name" => "Valid Name",
            "description" =>
                "Valid description that meets minimum constraints.",
            "price" => 100000000.0,
        ]);
        $response->assertSessionHasErrors(["price"]);
    }

    public function test_create_product_validation_fails_for_invalid_image(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);

        // Wrong mime type
        $invalidFile = UploadedFile::fake()->create(
            "document.pdf",
            500,
            "application/pdf",
        );
        $response = $this->actingAs($admin)->post("/admin/marketplace", [
            "name" => "Valid Name",
            "description" =>
                "Valid description that meets minimum constraints.",
            "price" => 10000,
            "image_path" => $invalidFile,
        ]);
        $response->assertSessionHasErrors(["image_path"]);

        // Too large (> 2048 KB)
        $largeFile = UploadedFile::fake()->create(
            "large_image.jpg",
            3000,
            "image/jpeg",
        );
        $response = $this->actingAs($admin)->post("/admin/marketplace", [
            "name" => "Valid Name",
            "description" =>
                "Valid description that meets minimum constraints.",
            "price" => 10000,
            "image_path" => $largeFile,
        ]);
        $response->assertSessionHasErrors(["image_path"]);
    }

    public function test_update_product_validation_fails_for_empty_fields(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);
        $product = MarketplaceProduct::create([
            "name" => "Valid Product Name",
            "description" => "Valid Product Description",
            "price" => 10000.0,
        ]);

        $response = $this->actingAs($admin)->put(
            "/admin/marketplace/{$product->id}",
            [
                "name" => "",
                "description" => "",
                "price" => "",
            ],
        );

        $response->assertSessionHasErrors(["name", "description", "price"]);
    }

    public function test_update_product_validation_fails_for_invalid_name_length(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);
        $product = MarketplaceProduct::create([
            "name" => "Valid Product Name",
            "description" => "Valid Product Description",
            "price" => 10000.0,
        ]);

        // Under min 5
        $response = $this->actingAs($admin)->put(
            "/admin/marketplace/{$product->id}",
            [
                "name" => "abcd",
                "description" =>
                    "Valid description that meets minimum constraints.",
                "price" => 10000,
            ],
        );
        $response->assertSessionHasErrors(["name"]);

        // Over max 100
        $response = $this->actingAs($admin)->put(
            "/admin/marketplace/{$product->id}",
            [
                "name" => str_repeat("a", 101),
                "description" =>
                    "Valid description that meets minimum constraints.",
                "price" => 10000,
            ],
        );
        $response->assertSessionHasErrors(["name"]);
    }

    public function test_update_product_validation_fails_for_invalid_description_length(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);
        $product = MarketplaceProduct::create([
            "name" => "Valid Product Name",
            "description" => "Valid Product Description",
            "price" => 10000.0,
        ]);

        // Under min 5
        $response = $this->actingAs($admin)->put(
            "/admin/marketplace/{$product->id}",
            [
                "name" => "Valid Name",
                "description" => "abcd",
                "price" => 10000,
            ],
        );
        $response->assertSessionHasErrors(["description"]);

        // Over max 3000
        $response = $this->actingAs($admin)->put(
            "/admin/marketplace/{$product->id}",
            [
                "name" => "Valid Name",
                "description" => str_repeat("a", 3001),
                "price" => 10000,
            ],
        );
        $response->assertSessionHasErrors(["description"]);
    }

    public function test_update_product_validation_fails_for_invalid_price(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);
        $product = MarketplaceProduct::create([
            "name" => "Valid Product Name",
            "description" => "Valid Product Description",
            "price" => 10000.0,
        ]);

        // Not numeric
        $response = $this->actingAs($admin)->put(
            "/admin/marketplace/{$product->id}",
            [
                "name" => "Valid Name",
                "description" =>
                    "Valid description that meets minimum constraints.",
                "price" => "not-numeric",
            ],
        );
        $response->assertSessionHasErrors(["price"]);

        // Negative price
        $response = $this->actingAs($admin)->put(
            "/admin/marketplace/{$product->id}",
            [
                "name" => "Valid Name",
                "description" =>
                    "Valid description that meets minimum constraints.",
                "price" => -10,
            ],
        );
        $response->assertSessionHasErrors(["price"]);

        // Exceeds max 99999999.99
        $response = $this->actingAs($admin)->put(
            "/admin/marketplace/{$product->id}",
            [
                "name" => "Valid Name",
                "description" =>
                    "Valid description that meets minimum constraints.",
                "price" => 100000000.0,
            ],
        );
        $response->assertSessionHasErrors(["price"]);
    }

    public function test_update_product_validation_fails_for_invalid_image(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);
        $product = MarketplaceProduct::create([
            "name" => "Valid Product Name",
            "description" => "Valid Product Description",
            "price" => 10000.0,
        ]);

        // Wrong mime type
        $invalidFile = UploadedFile::fake()->create(
            "document.pdf",
            500,
            "application/pdf",
        );
        $response = $this->actingAs($admin)->put(
            "/admin/marketplace/{$product->id}",
            [
                "name" => "Valid Name",
                "description" =>
                    "Valid description that meets minimum constraints.",
                "price" => 10000,
                "image_path" => $invalidFile,
            ],
        );
        $response->assertSessionHasErrors(["image_path"]);

        // Too large (> 2048 KB)
        $largeFile = UploadedFile::fake()->create(
            "large_image.jpg",
            3000,
            "image/jpeg",
        );
        $response = $this->actingAs($admin)->put(
            "/admin/marketplace/{$product->id}",
            [
                "name" => "Valid Name",
                "description" =>
                    "Valid description that meets minimum constraints.",
                "price" => 10000,
                "image_path" => $largeFile,
            ],
        );
        $response->assertSessionHasErrors(["image_path"]);
    }
}
