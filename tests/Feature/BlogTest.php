<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\User;
use Cloudinary\Api\ApiResponse;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Cloudinary;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Mockery;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * Helper to mock Cloudinary upload api.
     */
    protected function mockCloudinary(): void
    {
        $mockCloudinary = Mockery::mock(Cloudinary::class);
        $mockUploadApi = Mockery::mock(UploadApi::class);
        $mockCloudinary->shouldReceive('uploadApi')->andReturn($mockUploadApi);

        $apiResponse = new ApiResponse(
            ['secure_url' => 'https://res.cloudinary.com/dummy.jpg'],
            []
        );
        $mockUploadApi->shouldReceive('upload')->andReturn($apiResponse);

        $this->app->instance(Cloudinary::class, $mockCloudinary);
        $this->app->instance('cloudinary', $mockCloudinary);
    }

    // =========================================================================
    // 1. ACCESS CONTROL TESTS
    // =========================================================================

    /**
     * Guests are redirected to login for public blog routes.
     */
    public function test_guests_are_redirected_to_login_for_public_blog_routes(): void
    {
        // View index
        $response = $this->get('/blog');
        $response->assertRedirect(route('login'));

        // View single post (requires existing or doesn't matter since middleware catches it first)
        $response = $this->get('/blog/1');
        $response->assertRedirect(route('login'));
    }

    /**
     * Admins are redirected to /admin/dashboard when attempting public blog routes.
     */
    public function test_admins_are_redirected_to_dashboard_when_attempting_public_blog_routes(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Attempt index
        $response = $this->actingAs($admin)->get('/blog');
        $response->assertRedirect(route('admin.dashboard'));

        // Attempt show
        $response = $this->actingAs($admin)->get('/blog/1');
        $response->assertRedirect(route('admin.dashboard'));
    }

    /**
     * Non-admins get a 403 response when accessing admin blog routes.
     */
    public function test_non_admins_get_403_when_accessing_admin_blog_routes(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $post = BlogPost::create([
            'title' => 'Test Post Title',
            'content' => 'Test post content that has at least ten characters.',
        ]);

        $this->actingAs($user)->get('/admin/blogs')->assertStatus(403);
        $this->actingAs($user)->get('/admin/blogs/create')->assertStatus(403);
        $this->actingAs($user)->post('/admin/blogs', [])->assertStatus(403);
        $this->actingAs($user)->get("/admin/blogs/{$post->id}/edit")->assertStatus(403);
        $this->actingAs($user)->put("/admin/blogs/{$post->id}", [])->assertStatus(403);
        $this->actingAs($user)->delete("/admin/blogs/{$post->id}")->assertStatus(403);
    }

    /**
     * Admins successfully access admin blog routes (200 OK).
     */
    public function test_admins_can_access_admin_blog_routes(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $post = BlogPost::create([
            'title' => 'Test Post Title',
            'content' => 'Test post content that has at least ten characters.',
        ]);

        $this->actingAs($admin)->get('/admin/blogs')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/blogs/create')->assertStatus(200);
        $this->actingAs($admin)->get("/admin/blogs/{$post->id}/edit")->assertStatus(200);
    }

    // =========================================================================
    // 2. HAPPY PATH CRUD TESTS
    // =========================================================================

    /**
     * Listing posts on /blog (ordered by latest).
     */
    public function test_listing_posts_on_blog_ordered_by_latest(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        // Create posts with specific order/timestamps
        $post1 = BlogPost::create([
            'title' => 'First Post',
            'content' => 'First post content that is long enough.',
        ]);
        $post1->created_at = now()->subHours(2);
        $post1->save();

        $post2 = BlogPost::create([
            'title' => 'Second Post',
            'content' => 'Second post content that is long enough.',
        ]);
        $post2->created_at = now()->subHours(1);
        $post2->save();

        $post3 = BlogPost::create([
            'title' => 'Third Post',
            'content' => 'Third post content that is long enough.',
        ]);
        $post3->created_at = now();
        $post3->save();

        $response = $this->actingAs($user)->get('/blog');
        $response->assertStatus(200);

        // Verify ordering in view variables
        $blogPosts = $response->viewData('blog');
        $this->assertCount(3, $blogPosts);
        $this->assertEquals($post3->id, $blogPosts[0]->id);
        $this->assertEquals($post2->id, $blogPosts[1]->id);
        $this->assertEquals($post1->id, $blogPosts[2]->id);
    }

    /**
     * Viewing single post on /blog/{id} (404 for invalid).
     */
    public function test_viewing_single_post_on_blog(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $post = BlogPost::create([
            'title' => 'My Single Post Title',
            'content' => 'Content of my single post, which is plenty long.',
        ]);

        $response = $this->actingAs($user)->get("/blog/{$post->id}");
        $response->assertStatus(200);
        $response->assertSee('My Single Post Title');
        $response->assertSee('Content of my single post, which is plenty long.');

        // Test 404 for invalid ID
        $response404 = $this->actingAs($user)->get('/blog/9999');
        $response404->assertStatus(404);
    }

    /**
     * Creating a post as admin (assert redirect, database entry exists, session success message, handles image uploading).
     */
    public function test_admin_can_create_blog_post_with_image(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->mockCloudinary();

        $image = UploadedFile::fake()->create('blog_image.jpg', 100, 'image/jpeg');

        $postData = [
            'title' => 'New Admin Blog Post',
            'content' => 'This is a valid blog post content that has more than 10 characters.',
            'image_path' => $image,
        ];

        $response = $this->actingAs($admin)->post('/admin/blogs', $postData);

        $response->assertRedirect(route('admin.blogs.index'));
        $response->assertSessionHas('success', 'Blog berhasil ditambahkan!');

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Admin Blog Post',
            'content' => 'This is a valid blog post content that has more than 10 characters.',
            'image_path' => 'https://res.cloudinary.com/dummy.jpg',
        ]);
    }

    /**
     * Creating a post as admin without an image.
     */
    public function test_admin_can_create_blog_post_without_image(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $postData = [
            'title' => 'New Admin Blog Post No Image',
            'content' => 'This is another valid blog post content without image.',
        ];

        $response = $this->actingAs($admin)->post('/admin/blogs', $postData);

        $response->assertRedirect(route('admin.blogs.index'));
        $response->assertSessionHas('success', 'Blog berhasil ditambahkan!');

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Admin Blog Post No Image',
            'content' => 'This is another valid blog post content without image.',
            'image_path' => null,
        ]);
    }

    /**
     * Updating a post as admin (assert DB updated, session success, handles new image).
     */
    public function test_admin_can_update_blog_post_with_new_image(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $post = BlogPost::create([
            'title' => 'Original Title',
            'content' => 'Original content which is long enough.',
            'image_path' => 'https://res.cloudinary.com/original.jpg',
        ]);

        $this->mockCloudinary();
        $newImage = UploadedFile::fake()->create('updated_image.png', 100, 'image/png');

        $updateData = [
            'title' => 'Updated Title',
            'content' => 'Updated content which is also long enough.',
            'image_path' => $newImage,
        ];

        $response = $this->actingAs($admin)->put("/admin/blogs/{$post->id}", $updateData);

        $response->assertRedirect(route('admin.blogs.index'));
        $response->assertSessionHas('success', 'Blog berhasil diperbarui!');

        $this->assertDatabaseHas('blog_posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
            'content' => 'Updated content which is also long enough.',
            'image_path' => 'https://res.cloudinary.com/dummy.jpg',
        ]);
    }

    /**
     * Updating a post as admin without a new image.
     */
    public function test_admin_can_update_blog_post_without_new_image(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $post = BlogPost::create([
            'title' => 'Original Title',
            'content' => 'Original content which is long enough.',
            'image_path' => 'https://res.cloudinary.com/original.jpg',
        ]);

        $updateData = [
            'title' => 'Updated Title Only',
            'content' => 'Updated content only, which is long enough.',
        ];

        $response = $this->actingAs($admin)->put("/admin/blogs/{$post->id}", $updateData);

        $response->assertRedirect(route('admin.blogs.index'));
        $response->assertSessionHas('success', 'Blog berhasil diperbarui!');

        $this->assertDatabaseHas('blog_posts', [
            'id' => $post->id,
            'title' => 'Updated Title Only',
            'content' => 'Updated content only, which is long enough.',
            'image_path' => 'https://res.cloudinary.com/original.jpg', // Should remain unchanged
        ]);
    }

    /**
     * Deleting a post as admin (assert DB deleted, session success).
     */
    public function test_admin_can_delete_blog_post(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $post = BlogPost::create([
            'title' => 'Post to be deleted',
            'content' => 'Content of the post to be deleted.',
        ]);

        $response = $this->actingAs($admin)->delete("/admin/blogs/{$post->id}");

        $response->assertRedirect(route('admin.blogs.index'));
        $response->assertSessionHas('success', 'Blog berhasil dihapus!');

        $this->assertDatabaseMissing('blog_posts', [
            'id' => $post->id,
        ]);
    }

    // =========================================================================
    // 3. VALIDATION FAILURE TESTS
    // =========================================================================

    /**
     * Validation Failure: Empty title/content.
     */
    public function test_create_post_validation_fails_for_empty_fields(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/admin/blogs', [
            'title' => '',
            'content' => '',
        ]);

        $response->assertSessionHasErrors(['title', 'content']);
    }

    /**
     * Validation Failure: Title length < 5 or > 100.
     */
    public function test_create_post_validation_fails_for_invalid_title_length(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Under min (4 characters)
        $response = $this->actingAs($admin)->post('/admin/blogs', [
            'title' => 'abcd',
            'content' => 'Valid content for this post.',
        ]);
        $response->assertSessionHasErrors(['title']);

        // Over max (101 characters)
        $response = $this->actingAs($admin)->post('/admin/blogs', [
            'title' => str_repeat('a', 101),
            'content' => 'Valid content for this post.',
        ]);
        $response->assertSessionHasErrors(['title']);
    }

    /**
     * Validation Failure: Content length < 10 or > 5000.
     */
    public function test_create_post_validation_fails_for_invalid_content_length(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Under min (9 characters)
        $response = $this->actingAs($admin)->post('/admin/blogs', [
            'title' => 'Valid Title',
            'content' => '123456789',
        ]);
        $response->assertSessionHasErrors(['content']);

        // Over max (5001 characters)
        $response = $this->actingAs($admin)->post('/admin/blogs', [
            'title' => 'Valid Title',
            'content' => str_repeat('a', 5001),
        ]);
        $response->assertSessionHasErrors(['content']);
    }

    /**
     * Validation Failure: Image mimetype and size validations.
     */
    public function test_create_post_validation_fails_for_invalid_image_type_and_size(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Invalid MIME type (text file renamed or text content)
        $invalidFile = UploadedFile::fake()->create('document.txt', 100, 'text/plain');
        $response = $this->actingAs($admin)->post('/admin/blogs', [
            'title' => 'Valid Title',
            'content' => 'Valid content for post.',
            'image_path' => $invalidFile,
        ]);
        $response->assertSessionHasErrors(['image_path']);

        // Invalid size (larger than 5120 KB - 6000 KB)
        $largeImage = UploadedFile::fake()->create('large_image.jpg', 6000, 'image/jpeg');
        $response = $this->actingAs($admin)->post('/admin/blogs', [
            'title' => 'Valid Title',
            'content' => 'Valid content for post.',
            'image_path' => $largeImage,
        ]);
        $response->assertSessionHasErrors(['image_path']);
    }
}
