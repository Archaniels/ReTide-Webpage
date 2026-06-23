<?php

namespace Tests\Unit;

use App\Models\BlogPost;
use App\Models\User;
use Cloudinary\Api\ApiResponse;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Cloudinary;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Mockery;
use Tests\TestCase;

class BlogBPTTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
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

    /**
     * TC01 - Path: 1 (index)
     * Description: Access the admin panel blog post management listing.
     */
    public function test_tc01_access_admin_blog_listing(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        $post1 = BlogPost::create([
            'title' => 'Blog Post One',
            'content' => 'Content for blog post one.',
        ]);
        $post1->created_at = now()->subMinutes(10);
        $post1->save();

        $post2 = BlogPost::create([
            'title' => 'Blog Post Two',
            'content' => 'Content for blog post two.',
        ]);
        $post2->created_at = now();
        $post2->save();

        $response = $this->actingAs($admin)->get('/admin/blogs');

        $response->assertStatus(200);
        $response->assertViewIs('admin.blog.index');
        $response->assertViewHas('blogs');
        
        $viewBlogs = $response->viewData('blogs');
        $this->assertCount(2, $viewBlogs);
        $this->assertEquals($post2->id, $viewBlogs->first()->id); // Ordered by created_at descending
    }

    /**
     * TC02 - Path: 1 (index)
     * Description: Access the public blog posts listing.
     */
    public function test_tc02_access_public_blog_listing(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        
        $post1 = BlogPost::create([
            'title' => 'Blog Post One',
            'content' => 'Content for blog post one.',
        ]);
        $post1->created_at = now()->subMinutes(10);
        $post1->save();

        $post2 = BlogPost::create([
            'title' => 'Blog Post Two',
            'content' => 'Content for blog post two.',
        ]);
        $post2->created_at = now();
        $post2->save();

        $response = $this->actingAs($user)->get('/blog');

        $response->assertStatus(200);
        $response->assertViewIs('blog.index');
        $response->assertViewHas('blog');
        
        $viewBlog = $response->viewData('blog');
        $this->assertCount(2, $viewBlog);
        $this->assertEquals($post2->id, $viewBlog->first()->id); // Ordered by latest
    }

    /**
     * TC03 - Path: 1 (create)
     * Description: Access the admin create blog post form.
     */
    public function test_tc03_access_admin_create_blog_post_form(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/blogs/create');

        $response->assertStatus(200);
        $response->assertViewIs('blog.create');
    }

    /**
     * TC04 - Path: 1 -> 2 (store)
     * Description: Attempt to store a new blog post with invalid/missing title and content.
     */
    public function test_tc04_store_blog_post_validation_fails(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/admin/blogs', [
            'title' => 'Abc',
            'content' => 'Short',
            'image_path' => null,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['title', 'content']);
        $this->assertDatabaseCount('blog_posts', 0);
    }

    /**
     * TC05 - Path: 1 -> 3 -> 4 -> 6 (store)
     * Description: Store a new blog post with valid inputs and a blog image uploaded.
     */
    public function test_tc05_store_blog_post_with_image_upload_success(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->mockCloudinary();

        $image = UploadedFile::fake()->create('mangrove.png', 100, 'image/png');

        $response = $this->actingAs($admin)->post('/admin/blogs', [
            'title' => 'Protecting Indonesian Mangroves',
            'content' => 'Mangroves are crucial coastal ecosystems that provide buffer zones against tsunamis and erosion.',
            'image_path' => $image,
        ]);

        $response->assertRedirect(route('admin.blogs.index'));
        $response->assertSessionHas('success', 'Blog berhasil ditambahkan!');

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'Protecting Indonesian Mangroves',
            'content' => 'Mangroves are crucial coastal ecosystems that provide buffer zones against tsunamis and erosion.',
            'image_path' => 'https://res.cloudinary.com/dummy.jpg',
        ]);
    }

    /**
     * TC06 - Path: 1 -> 3 -> 5 -> 6 (store)
     * Description: Store a new blog post with valid inputs and no image.
     */
    public function test_tc06_store_blog_post_without_image_success(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/admin/blogs', [
            'title' => 'Restoring Coral Reefs',
            'content' => 'Coral reef restoration involves transplanting fragments from healthy reefs to damaged areas.',
            'image_path' => null,
        ]);

        $response->assertRedirect(route('admin.blogs.index'));
        $response->assertSessionHas('success', 'Blog berhasil ditambahkan!');

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'Restoring Coral Reefs',
            'content' => 'Coral reef restoration involves transplanting fragments from healthy reefs to damaged areas.',
            'image_path' => null,
        ]);
    }

    /**
     * TC07 - Path: 1 -> 2 (show)
     * Description: View detail of a non-existent public blog post.
     */
    public function test_tc07_view_nonexistent_public_blog_post(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get('/blog/99999');

        $response->assertStatus(404);
    }

    /**
     * TC08 - Path: 1 -> 3 (show)
     * Description: Successfully view a public blog post's detail page.
     */
    public function test_tc08_view_existent_public_blog_post_success(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $post = BlogPost::create([
            'title' => 'Existing Blog Post',
            'content' => 'This content is long enough to pass validation in general.',
        ]);

        $response = $this->actingAs($user)->get("/blog/{$post->id}");

        $response->assertStatus(200);
        $response->assertViewIs('blog.show');
        $response->assertViewHas('blogPost');
        $this->assertEquals($post->id, $response->viewData('blogPost')->id);
    }

    /**
     * TC09 - Path: 1 -> 2 (edit)
     * Description: Attempt to access the edit form of a non-existent blog post.
     */
    public function test_tc09_access_edit_form_of_nonexistent_blog_post(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/blogs/99999/edit');

        $response->assertStatus(404);
    }

    /**
     * TC10 - Path: 1 -> 3 (edit)
     * Description: Access the edit form for an existing blog post.
     */
    public function test_tc10_access_edit_form_of_existent_blog_post_success(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $post = BlogPost::create([
            'title' => 'Blog Post to Edit',
            'content' => 'Some existing content to display in the edit form.',
        ]);

        $response = $this->actingAs($admin)->get("/admin/blogs/{$post->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('blog.edit');
        $response->assertViewHas('blog');
        $this->assertEquals($post->id, $response->viewData('blog')->id);
    }

    /**
     * TC11 - Path: 1 -> 2 (update)
     * Description: Attempt to update a non-existent blog post.
     */
    public function test_tc11_update_nonexistent_blog_post(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->put('/admin/blogs/99999', [
            'title' => 'Updated Title',
            'content' => 'Updated long content to pass validation.',
            'image_path' => null,
        ]);

        $response->assertStatus(404);
    }

    /**
     * TC12 - Path: 1 -> 3 -> 4 (update)
     * Description: Submit updates with invalid inputs on an existing blog post.
     */
    public function test_tc12_update_blog_post_validation_fails(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $post = BlogPost::create([
            'title' => 'Original Title',
            'content' => 'Original content of sufficient length.',
        ]);

        $response = $this->actingAs($admin)->put("/admin/blogs/{$post->id}", [
            'title' => '',
            'content' => 'Short',
            'image_path' => null,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['title', 'content']);
        
        // Assert record remains unchanged in DB
        $post->refresh();
        $this->assertEquals('Original Title', $post->title);
    }

    /**
     * TC13 - Path: 1 -> 3 -> 5 -> 6 -> 8 (update)
     * Description: Successfully update an existing blog post with valid inputs and a new image file.
     */
    public function test_tc13_update_blog_post_with_image_success(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $post = BlogPost::create([
            'title' => 'Original Title',
            'content' => 'Original content of sufficient length.',
            'image_path' => 'https://res.cloudinary.com/original.jpg',
        ]);

        $this->mockCloudinary();
        $image = UploadedFile::fake()->create('new_mangrove.png', 100, 'image/png');

        $response = $this->actingAs($admin)->put("/admin/blogs/{$post->id}", [
            'title' => 'Updated Protecting Indonesian Mangroves',
            'content' => 'Mangroves are crucial coastal ecosystems that provide buffer zones against tsunamis and erosion (Updated).',
            'image_path' => $image,
        ]);

        $response->assertRedirect(route('admin.blogs.index'));
        $response->assertSessionHas('success', 'Blog berhasil diperbarui!');

        $this->assertDatabaseHas('blog_posts', [
            'id' => $post->id,
            'title' => 'Updated Protecting Indonesian Mangroves',
            'content' => 'Mangroves are crucial coastal ecosystems that provide buffer zones against tsunamis and erosion (Updated).',
            'image_path' => 'https://res.cloudinary.com/dummy.jpg',
        ]);
    }

    /**
     * TC14 - Path: 1 -> 3 -> 5 -> 7 -> 8 (update)
     * Description: Successfully update an existing blog post with valid inputs and without changing the image.
     */
    public function test_tc14_update_blog_post_without_image_success(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $post = BlogPost::create([
            'title' => 'Original Title',
            'content' => 'Original content of sufficient length.',
            'image_path' => 'https://res.cloudinary.com/original.jpg',
        ]);

        $response = $this->actingAs($admin)->put("/admin/blogs/{$post->id}", [
            'title' => 'Updated Protecting Indonesian Mangroves',
            'content' => 'Mangroves are crucial coastal ecosystems that provide buffer zones against tsunamis and erosion (Updated without image).',
            'image_path' => null,
        ]);

        $response->assertRedirect(route('admin.blogs.index'));
        $response->assertSessionHas('success', 'Blog berhasil diperbarui!');

        $this->assertDatabaseHas('blog_posts', [
            'id' => $post->id,
            'title' => 'Updated Protecting Indonesian Mangroves',
            'content' => 'Mangroves are crucial coastal ecosystems that provide buffer zones against tsunamis and erosion (Updated without image).',
            'image_path' => 'https://res.cloudinary.com/original.jpg', // Remains original
        ]);
    }

    /**
     * TC15 - Path: 1 -> 2 (destroy)
     * Description: Attempt to delete a non-existent blog post.
     */
    public function test_tc15_delete_nonexistent_blog_post(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->delete('/admin/blogs/99999');

        $response->assertStatus(404);
    }

    /**
     * TC16 - Path: 1 -> 3 -> 4 (destroy)
     * Description: Successfully delete a blog post record from the database.
     */
    public function test_tc16_delete_existent_blog_post_success(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $post = BlogPost::create([
            'title' => 'Blog Post to Delete',
            'content' => 'Some existing content to be deleted.',
        ]);

        $response = $this->actingAs($admin)->delete("/admin/blogs/{$post->id}");

        $response->assertRedirect(route('admin.blogs.index'));
        $response->assertSessionHas('success', 'Blog berhasil dihapus!');

        $this->assertDatabaseMissing('blog_posts', [
            'id' => $post->id,
        ]);
    }

    /**
     * TC17 - Middleware boundary test (Guest redirect)
     * Description: Guest (unauthenticated) tries to access the public blog index page and is redirected to login.
     */
    public function test_tc17_guest_redirected_to_login_for_public_blog(): void
    {
        $response = $this->get('/blog');

        $response->assertRedirect(route('login'));
    }

    /**
     * TC18 - Middleware boundary test (Non-admin 403)
     * Description: Authenticated normal (non-admin) user tries to access the admin blog listing page and is aborted with 403.
     */
    public function test_tc18_non_admin_cannot_access_admin_blog_listing(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get('/admin/blogs');

        $response->assertStatus(403);
    }
}
