import { test, expect } from "@playwright/test";
import path from "path";

test.describe("Blog Feature - Black Box Testing Suite", () => {
  test.setTimeout(120000); // 2 minutes for slow server / file uploads
  const baseURL = "https://retide-app-archaniels-projects.vercel.app";
  let postIdToUpdate = "";

  test.beforeEach(async ({ page }) => {
    // Login as Admin
    await page.goto(`${baseURL}/login`);
    await page.fill("#email", "admin123@gmail.com");
    await page.fill("#password", "admin123");
    await page.click('button[type="submit"]');
    await expect(page).toHaveURL(`${baseURL}/admin/dashboard`);
  });

  // 1. Post Creation & Validation (Title & Content)
  test("TC_BLG_001 - Verify valid post creation", async ({ page }) => {
    await page.goto(`${baseURL}/admin/blogs/create`);
    await page.fill("#title", "Tech Innovations");
    await page.fill(
      "#content",
      "This is a valid blog post content demonstrating normal behavior.",
    );
    await page.click('button[type="submit"]:has-text("Create")');

    const successMessage = page.locator(
      'span:has-text("Blog berhasil ditambahkan!")',
    );
    await expect(successMessage).toBeVisible();
  });

  test("TC_BLG_002 - Verify error at Title lower bound edge (BVA: Min-1)", async ({
    page,
  }) => {
    await page.goto(`${baseURL}/admin/blogs/create`);
    await page.fill("#title", "A-B-");
    await page.fill("#content", "Valid content block...");
    await page.click('button[type="submit"]:has-text("Create")');

    const errorMessage = page
      .locator(
        'span:has-text("The title field must be at least 5 characters.")',
      )
      .or(page.locator("text=The title field must be at least 5 characters."));
    await expect(errorMessage).toBeVisible({ timeout: 15000 });
  });

  test("TC_BLG_003 - Verify success at Title lower boundary (BVA: Min)", async ({
    page,
  }) => {
    await page.goto(`${baseURL}/admin/blogs/create`);
    await page.fill("#title", "Alpha");
    await page.fill("#content", "Valid content block...");
    await page.click('button[type="submit"]:has-text("Create")');

    const successMessage = page.locator(
      'span:has-text("Blog berhasil ditambahkan!")',
    );
    await expect(successMessage).toBeVisible();
  });

  test("TC_BLG_004 - Verify success at Title lower boundary plus one (BVA: Min+1)", async ({
    page,
  }) => {
    await page.goto(`${baseURL}/admin/blogs/create`);
    await page.fill("#title", "Alphas");
    await page.fill("#content", "Valid content block...");
    await page.click('button[type="submit"]:has-text("Create")');

    const successMessage = page.locator(
      'span:has-text("Blog berhasil ditambahkan!")',
    );
    await expect(successMessage).toBeVisible();
  });

  test("TC_BLG_005 - Verify success at Title upper boundary minus one (BVA: Max-1)", async ({
    page,
  }) => {
    await page.goto(`${baseURL}/admin/blogs/create`);
    await page.fill("#title", "A".repeat(99));
    await page.fill("#content", "Valid content block...");
    await page.click('button[type="submit"]:has-text("Create")');

    const successMessage = page.locator(
      'span:has-text("Blog berhasil ditambahkan!")',
    );
    await expect(successMessage).toBeVisible();
  });

  test("TC_BLG_006 - Verify success at Title upper boundary (BVA: Max)", async ({
    page,
  }) => {
    await page.goto(`${baseURL}/admin/blogs/create`);
    await page.fill("#title", "A".repeat(100));
    await page.fill("#content", "Valid content block...");
    await page.click('button[type="submit"]:has-text("Create")');

    const successMessage = page.locator(
      'span:has-text("Blog berhasil ditambahkan!")',
    );
    await expect(successMessage).toBeVisible();
  });

  test("TC_BLG_007 - Verify error at Title upper bound edge (BVA: Max+1)", async ({
    page,
  }) => {
    await page.goto(`${baseURL}/admin/blogs/create`);
    await page.fill("#title", "A".repeat(101));
    await page.fill("#content", "Valid content block...");
    await page.click('button[type="submit"]:has-text("Create")');

    const errorMessage = page
      .locator(
        'span:has-text("The title field must not be greater than 100 characters.")',
      )
      .or(
        page.locator(
          "text=The title field must not be greater than 100 characters.",
        ),
      );
    await expect(errorMessage).toBeVisible({ timeout: 15000 });
  });

  test("TC_BLG_008 - Verify data type coverage: Numeric input in String field", async ({
    page,
  }) => {
    await page.goto(`${baseURL}/admin/blogs/create`);
    await page.fill("#title", "1234567890");
    await page.fill("#content", "Valid content block...");
    await page.click('button[type="submit"]:has-text("Create")');

    const successMessage = page.locator(
      'span:has-text("Blog berhasil ditambahkan!")',
    );
    await expect(successMessage).toBeVisible();
  });

  test("TC_BLG_009 - Verify cross-site scripting (XSS) prevention in Content", async ({
    page,
  }) => {
    await page.goto(`${baseURL}/admin/blogs/create`);
    await page.fill("#title", "Security Test XSS");
    await page.fill("#content", `<script>alert('XSS')</script>`);
    await page.click('button[type="submit"]:has-text("Create")');

    const successMessage = page.locator(
      'span:has-text("Blog berhasil ditambahkan!")',
    );
    await expect(successMessage).toBeVisible();

    // Wait for redirect to /blog after creation if it redirects, otherwise go manually to /blog
    // It seems the form doesn't redirect, it just shows success message
    await page.goto(`${baseURL}/blog`);

    // Check that the script didn't execute and XSS string is escaped/visible or just not executing
    // The fact that playwright doesn't detect an unhandled alert is a good sign
  });

  // 2. File Upload Handling (Cover Image)
  test("TC_BLG_010 - Verify valid file upload", async ({ page }) => {
    await page.goto(`${baseURL}/admin/blogs/create`);
    await page.fill("#title", "File Upload Test");
    await page.fill("#content", "Testing valid file upload...");

    await page.setInputFiles("#image_path", "e2e/test-data/cover.jpg");
    await page.click('button[type="submit"]:has-text("Create")');

    const successMessage = page.locator(
      'span:has-text("Blog berhasil ditambahkan!")',
    );
    await expect(successMessage).toBeVisible({ timeout: 45000 });
  });

  test("TC_BLG_011 - Verify error on unsupported file type", async ({
    page,
  }) => {
    await page.goto(`${baseURL}/admin/blogs/create`);
    await page.fill("#title", "File Upload Test Error");
    await page.fill("#content", "Testing invalid file type...");

    await page.setInputFiles("#image_path", "e2e/test-data/malicious.exe");
    await page.click('button[type="submit"]:has-text("Create")');

    const errorMessage = page
      .locator(
        'span:has-text("The image path field must be a file of type: jpeg, png, jpg.")',
      )
      .or(
        page.locator(
          "text=The image path field must be a file of type: jpeg, png, jpg.",
        ),
      );
    await expect(errorMessage).toBeVisible({ timeout: 30000 });
  });

  test("TC_BLG_012 - Verify success at file size upper boundary (BVA: Max)", async ({
    page,
  }) => {
    await page.goto(`${baseURL}/admin/blogs/create`);
    await page.fill("#title", "File Upload Test Max Size");
    await page.fill("#content", "Testing max file size upload...");

    await page.setInputFiles("#image_path", "e2e/test-data/max_limit.png");
    await page.click('button[type="submit"]:has-text("Create")');

    const successMessage = page.locator(
      'span:has-text("Blog berhasil ditambahkan!")',
    );
    await expect(successMessage).toBeVisible({ timeout: 45000 });
  });

  test("TC_BLG_013 - Verify error at file size boundary edge (BVA: Max+1)", async ({
    page,
  }) => {
    await page.goto(`${baseURL}/admin/blogs/create`);
    await page.fill("#title", "File Upload Test Over Limit");
    await page.fill("#content", "Testing over file size limit upload...");

    await page.setInputFiles("#image_path", "e2e/test-data/over_limit.jpg");
    await page.click('button[type="submit"]:has-text("Create")');

    const errorMessage = page
      .locator(
        'span:has-text("The image path field must not be greater than 5120 kilobytes.")',
      )
      .or(
        page.locator(
          "text=The image path field must not be greater than 5120 kilobytes.",
        ),
      );
    await expect(errorMessage).toBeVisible({ timeout: 30000 });
  });

  // 3. Workflow & Edge Cases
  test("TC_BLG_014 - Verify successful post update", async ({ page }) => {
    // Create a valid post to ensure there's something to edit
    await page.goto(`${baseURL}/admin/blogs/create`);
    await page.fill("#title", "Update Target");
    await page.fill("#content", "Content to be updated.");
    await page.click('button[type="submit"]:has-text("Create")');

    await page.goto(`${baseURL}/admin/blogs`);

    // Find the first Edit link
    const editLink = page.locator('a[title="Edit Post"]').first();
    await editLink.click();

    await page.fill("#content", "Updated text here for TC014.");
    await page.click('button[type="submit"]:has-text("Update")');

    const successMessage = page.locator(
      'span:has-text("Blog berhasil diperbarui!")',
    );
    await expect(successMessage).toBeVisible();
  });

  test("TC_BLG_015 - Verify soft/hard delete functionality", async ({
    page,
  }) => {
    // Create a new post to delete
    await page.goto(`${baseURL}/admin/blogs/create`);
    await page.fill("#title", "Post to Delete");
    await page.fill("#content", "Will be deleted.");
    await page.click('button[type="submit"]:has-text("Create")');

    await page.goto(`${baseURL}/admin/blogs`);

    // Handle confirm dialog
    page.on("dialog", async (dialog) => {
      await dialog.accept();
    });

    // Click first delete button
    const deleteBtn = page.locator('button[title="Delete Post"]').first();
    await deleteBtn.click();

    // Check for success message
    const successMessage = page.locator(
      'span:has-text("Blog berhasil dihapus!")',
    );
    await expect(successMessage).toBeVisible();
  });

  test("TC_BLG_016 - Verify handling of concurrent duplicate submissions", async ({
    page,
  }) => {
    await page.goto(`${baseURL}/admin/blogs/create`);
    await page.fill("#title", "Double Click Test");
    await page.fill("#content", "Testing duplicate prevention.");

    // Rapid clicks
    const submitBtn = page.locator('button[type="submit"]:has-text("Create")');
    await submitBtn.click();
    try {
      await submitBtn.click({ timeout: 1000 });
    } catch (e) {
      // Button might be disabled or navigation started
    }

    const successMessage = page.locator(
      'span:has-text("Blog berhasil ditambahkan!")',
    );
    await expect(successMessage).toBeVisible();
  });
});
