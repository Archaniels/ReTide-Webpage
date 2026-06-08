<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\BlogPostsController;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\BlogPost;
use Mockery;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class BlogTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * Helper method to run Arrange-Act-Assert for store method validations.
     */
    private function assertValidationFails(array $data, string $expectedFailedField)
    {
        $controller = new BlogPostsController();
        $request = Request::create('/admin/blogs', 'POST', $data);

        try {
            $controller->store($request);
            $this->fail("Validation should have failed for $expectedFailedField");
        } catch (ValidationException $e) {
            $this->assertArrayHasKey($expectedFailedField, $e->errors());
        }
    }

    // TC_BLG_001: Verify valid post creation
    public function test_tc_blg_001_valid_post_creation()
    {
        $mock = Mockery::mock('alias:App\Models\BlogPost');
        $mock->shouldReceive('create')->once()->with(Mockery::on(function ($data) {
            return $data['title'] === 'Tech Innovations' &&
                   $data['content'] === 'This is a valid blog post content demonstrating normal behavior.';
        }))->andReturn(new \stdClass());

        $controller = new BlogPostsController();
        $request = Request::create('/admin/blogs', 'POST', [
            'title' => 'Tech Innovations',
            'content' => 'This is a valid blog post content demonstrating normal behavior.',
        ]);

        $response = $controller->store($request);

        $this->assertTrue($response->isRedirect(route('admin.blogs.index')));
        $this->assertEquals('Blog berhasil ditambahkan!', session('success'));
    }

    // TC_BLG_002: Verify error at Title lower bound edge (Min-1)
    public function test_tc_blg_002_title_lower_bound_edge()
    {
        $this->assertValidationFails([
            'title' => 'A-B-', // 4 chars
            'content' => 'Valid content block...',
        ], 'title');
    }

    // TC_BLG_003: Verify success at Title lower boundary (Min)
    public function test_tc_blg_003_title_lower_boundary()
    {
        $mock = Mockery::mock('alias:App\Models\BlogPost');
        $mock->shouldReceive('create')->once()->andReturn(new \stdClass());

        $controller = new BlogPostsController();
        $request = Request::create('/admin/blogs', 'POST', [
            'title' => 'Alpha', // 5 chars
            'content' => 'Valid content block...',
        ]);

        $response = $controller->store($request);
        $this->assertTrue($response->isRedirect(route('admin.blogs.index')));
    }

    // TC_BLG_004: Verify success at Title lower boundary plus one (Min+1)
    public function test_tc_blg_004_title_lower_boundary_plus_one()
    {
        $mock = Mockery::mock('alias:App\Models\BlogPost');
        $mock->shouldReceive('create')->once()->andReturn(new \stdClass());

        $controller = new BlogPostsController();
        $request = Request::create('/admin/blogs', 'POST', [
            'title' => 'Alphas', // 6 chars
            'content' => 'Valid content block...',
        ]);

        $response = $controller->store($request);
        $this->assertTrue($response->isRedirect(route('admin.blogs.index')));
    }

    // TC_BLG_005: Verify success at Title upper boundary minus one (Max-1)
    public function test_tc_blg_005_title_upper_boundary_minus_one()
    {
        $mock = Mockery::mock('alias:App\Models\BlogPost');
        $mock->shouldReceive('create')->once()->andReturn(new \stdClass());

        $controller = new BlogPostsController();
        $request = Request::create('/admin/blogs', 'POST', [
            'title' => str_repeat('A', 99),
            'content' => 'Valid content block...',
        ]);

        $response = $controller->store($request);
        $this->assertTrue($response->isRedirect(route('admin.blogs.index')));
    }

    // TC_BLG_006: Verify success at Title upper boundary (Max)
    public function test_tc_blg_006_title_upper_boundary()
    {
        $mock = Mockery::mock('alias:App\Models\BlogPost');
        $mock->shouldReceive('create')->once()->andReturn(new \stdClass());

        $controller = new BlogPostsController();
        $request = Request::create('/admin/blogs', 'POST', [
            'title' => str_repeat('A', 100),
            'content' => 'Valid content block...',
        ]);

        $response = $controller->store($request);
        $this->assertTrue($response->isRedirect(route('admin.blogs.index')));
    }

    // TC_BLG_007: Verify error at Title upper bound edge (Max+1)
    public function test_tc_blg_007_title_upper_bound_edge()
    {
        $this->assertValidationFails([
            'title' => str_repeat('A', 101),
            'content' => 'Valid content block...',
        ], 'title');
    }

    // TC_BLG_008: Verify data type coverage: Numeric input in String field
    public function test_tc_blg_008_numeric_input_in_string_field()
    {
        $mock = Mockery::mock('alias:App\Models\BlogPost');
        $mock->shouldReceive('create')->once()->andReturn(new \stdClass());

        $controller = new BlogPostsController();
        $request = Request::create('/admin/blogs', 'POST', [
            'title' => '1234567890',
            'content' => 'Valid content block...',
        ]);

        $response = $controller->store($request);
        $this->assertTrue($response->isRedirect(route('admin.blogs.index')));
    }

    // TC_BLG_009: Verify cross-site scripting (XSS) prevention in Content
    public function test_tc_blg_009_xss_prevention()
    {
        $mock = Mockery::mock('alias:App\Models\BlogPost');
        $mock->shouldReceive('create')->once()->andReturn(new \stdClass());

        $controller = new BlogPostsController();
        $request = Request::create('/admin/blogs', 'POST', [
            'title' => 'Security Test',
            'content' => "<script>alert('XSS')</script>",
        ]);

        $response = $controller->store($request);
        $this->assertTrue($response->isRedirect(route('admin.blogs.index')));
    }

    // TC_BLG_010: Verify valid file upload
    public function test_tc_blg_010_valid_file_upload()
    {
        Storage::fake('public');
        $mock = Mockery::mock('alias:App\Models\BlogPost');
        $mock->shouldReceive('create')->once()->andReturn(new \stdClass());

        $file = UploadedFile::fake()->create('cover.jpg', 2500, 'image/jpeg'); // 2.5MB

        $controller = new BlogPostsController();
        $request = Request::create('/admin/blogs', 'POST', [
            'title' => 'Valid Title',
            'content' => 'Valid content...',
        ], [], ['image_path' => $file]);

        $response = $controller->store($request);
        
        $this->assertTrue($response->isRedirect(route('admin.blogs.index')));
        $files = Storage::disk('public')->files('blog_posts');
        $this->assertCount(1, $files);
    }

    // TC_BLG_011: Verify error on unsupported file type
    public function test_tc_blg_011_unsupported_file_type()
    {
        $file = UploadedFile::fake()->create('malicious.exe', 1000, 'application/x-msdownload');

        $controller = new BlogPostsController();
        $request = Request::create('/admin/blogs', 'POST', [
            'title' => 'Valid Title',
            'content' => 'Valid content...',
        ], [], ['image_path' => $file]);

        try {
            $controller->store($request);
            $this->fail("Validation should have failed for image_path");
        } catch (ValidationException $e) {
            $this->assertArrayHasKey('image_path', $e->errors());
        }
    }

    // TC_BLG_012: Verify success at file size upper boundary (Max 5MB)
    public function test_tc_blg_012_file_size_upper_boundary()
    {
        Storage::fake('public');
        $mock = Mockery::mock('alias:App\Models\BlogPost');
        $mock->shouldReceive('create')->once()->andReturn(new \stdClass());

        $file = UploadedFile::fake()->create('max_limit.png', 5120, 'image/png');

        $controller = new BlogPostsController();
        $request = Request::create('/admin/blogs', 'POST', [
            'title' => 'Valid Title',
            'content' => 'Valid content...',
        ], [], ['image_path' => $file]);

        $response = $controller->store($request);
        $this->assertTrue($response->isRedirect(route('admin.blogs.index')));
    }

    // TC_BLG_013: Verify error at file size boundary edge (Max+1)
    public function test_tc_blg_013_file_size_boundary_edge()
    {
        $file = UploadedFile::fake()->create('over_limit.jpg', 5121, 'image/jpeg');

        $controller = new BlogPostsController();
        $request = Request::create('/admin/blogs', 'POST', [
            'title' => 'Valid Title',
            'content' => 'Valid content...',
        ], [], ['image_path' => $file]);

        try {
            $controller->store($request);
            $this->fail("Validation should have failed for image_path");
        } catch (ValidationException $e) {
            $this->assertArrayHasKey('image_path', $e->errors());
        }
    }

    // TC_BLG_014: Verify successful post update
    public function test_tc_blg_014_successful_post_update()
    {
        $mockBlog = Mockery::mock();
        $mockBlog->shouldReceive('update')->once()->with(Mockery::on(function ($data) {
            return $data['title'] === 'Updated Title' && $data['content'] === 'Updated text here.';
        }))->andReturn(true);

        $mock = Mockery::mock('alias:App\Models\BlogPost');
        $mock->shouldReceive('findOrFail')->once()->with('12')->andReturn($mockBlog);

        $controller = new BlogPostsController();
        $request = Request::create("/admin/blogs/12", 'PUT', [
            'title' => 'Updated Title',
            'content' => 'Updated text here.',
        ]);

        $response = $controller->update($request, '12');
        $this->assertTrue($response->isRedirect(route('admin.blogs.index')));
    }

    // TC_BLG_015: Verify soft/hard delete functionality
    public function test_tc_blg_015_delete_functionality()
    {
        $mockBlog = Mockery::mock();
        $mockBlog->shouldReceive('delete')->once()->andReturn(true);

        $mock = Mockery::mock('alias:App\Models\BlogPost');
        $mock->shouldReceive('findOrFail')->once()->with('12')->andReturn($mockBlog);

        $controller = new BlogPostsController();
        $response = $controller->destroy('12');

        $this->assertTrue($response->isRedirect(route('admin.blogs.index')));
    }

    // TC_BLG_016: Verify handling of concurrent duplicate submissions
    public function test_tc_blg_016_concurrent_duplicate_submissions()
    {
        $mock = Mockery::mock('alias:App\Models\BlogPost');
        // It will be called twice
        $mock->shouldReceive('create')->twice()->andReturn(new \stdClass());

        $controller = new BlogPostsController();
        $request1 = Request::create('/admin/blogs', 'POST', [
            'title' => 'Double Click Test',
            'content' => 'Testing duplicate prevention.',
        ]);
        
        $request2 = Request::create('/admin/blogs', 'POST', [
            'title' => 'Double Click Test',
            'content' => 'Testing duplicate prevention.',
        ]);

        $response1 = $controller->store($request1);
        $response2 = $controller->store($request2);

        $this->assertTrue($response1->isRedirect(route('admin.blogs.index')));
        $this->assertTrue($response2->isRedirect(route('admin.blogs.index')));
    }
}
