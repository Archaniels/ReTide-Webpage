import { test, expect } from '@playwright/test';

test.describe('Marketplace Feature - Unit Tests via Playwright (Frontend Validation)', () => {
    const baseURL = 'https://retide-app-archaniels-projects.vercel.app';

    /**
     * TC011: Verify image upload with invalid file type (EQP - Invalid)
     */
    test('TC011 - Verify image upload with invalid file type restricts non-image files', async ({ page }) => {
        // Arrange: Navigate and login as Admin to reach Add Product form
        await page.goto(`${baseURL}/login`);
        await page.fill('#email', 'admin123@gmail.com');
        await page.fill('#password', 'admin123');
        await page.click('button[type="submit"]');
        await expect(page).toHaveURL(`${baseURL}/admin/dashboard`);
        await page.goto(`${baseURL}/admin/marketplace/create`);

        // Act & Assert
        // Find the file input field and check its accept attribute
        const fileInput = page.locator('input[type="file"]').first();
        const acceptAttr = await fileInput.getAttribute('accept');
        
        // Verify that the accept attribute specifies image types (e.g., image/*, image/png, etc.)
        expect(acceptAttr).toMatch(/image\//);
    });
});
