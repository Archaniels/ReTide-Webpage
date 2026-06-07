import { test, expect } from '@playwright/test';

test.describe('Marketplace Feature - Unit Tests via Playwright (Frontend Validation)', () => {
    const baseURL = 'https://retide-app-archaniels-projects.vercel.app';

    test.beforeEach(async ({ page }) => {
        // Arrange: Navigate and login to reach the Add Product form
        await page.goto(`${baseURL}/login`);
        await page.fill('#email', 'admin123@gmail.com');
        await page.fill('#password', 'admin123');
        await page.click('button[type="submit"]');
        await expect(page).toHaveURL(`${baseURL}/admin/dashboard`);
        await page.goto(`${baseURL}/admin/marketplace/create`);
    });

    /**
     * TC009: Verify product creation with Name length = 255 (BVA - Valid)
     */
    test('TC009 - Verify product creation with Name length = 255 passes validation', async ({ page }) => {
        // Arrange
        const nameInput = page.locator('#name');
        await page.fill('#price', '10.00');
        await page.fill('#description', 'A valid description');
        
        // Act
        const name255 = 'A'.repeat(255);
        await nameInput.fill(name255);
        
        // Assert
        const isNameValid = await nameInput.evaluate((el: HTMLInputElement) => el.checkValidity());
        expect(isNameValid).toBe(true);
    });
});
