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
     * TC008: Verify product creation rejects non-numeric string data in Price (EQP - Invalid Data Type)
     */
    test('TC008 - Verify product creation with Price = "abc" fails validation', async ({ page }) => {
        // Arrange
        const priceInput = page.locator('#price');
        await page.fill('#name', 'Test Item');
        await page.fill('#description', 'A valid description');
        
        // Act
        // Attempting to fill invalid characters might leave the input empty or retain them
        await priceInput.fill('abc');
        
        // Assert
        const isPriceValid = await priceInput.evaluate((el: HTMLInputElement) => el.checkValidity());
        expect(isPriceValid).toBe(false);
    });
});
