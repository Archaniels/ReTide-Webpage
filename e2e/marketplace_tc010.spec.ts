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
     * TC010: Verify product creation with Name length = 256 (BVA - Invalid Edge Case)
     */
    test('TC010 - Verify product creation with Name length = 256 fails validation', async ({ page }) => {
        // Arrange
        const nameInput = page.locator('#name');
        await page.fill('#price', '10.00');
        await page.fill('#description', 'A valid description');
        
        // Act
        const name256 = 'A'.repeat(256);
        // Using evaluate to force the value directly, bypassing potential Playwright truncation on maxlength
        await nameInput.evaluate((el: HTMLInputElement, val) => el.value = val, name256);
        
        // Assert
        const isNameValid = await nameInput.evaluate((el: HTMLInputElement) => el.checkValidity());
        expect(isNameValid).toBe(false);
    });
});
