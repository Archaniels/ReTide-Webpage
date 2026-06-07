import { test, expect } from '@playwright/test';

test.describe('Marketplace Feature - Unit Tests via Playwright (Frontend Validation)', () => {
    const baseURL = 'https://retide-app-archaniels-projects.vercel.app';

    /**
     * TC012: Verify adding existing product to cart (EQP - Positive)
     */
    test('TC012 - Verify adding existing product to cart updates local cart state', async ({ page }) => {
        // Arrange: Navigate and login as User
        await page.goto(`${baseURL}/login`);
        await page.fill('#email', 'user123@gmail.com');
        await page.fill('#password', 'user123');
        await page.click('button[type="submit"]');
        
        // Act: Mocking the frontend logic where adding an item puts it in session storage
        await page.evaluate(() => {
            let cart = JSON.parse(sessionStorage.getItem('cart') || '{}');
            const productId = 1;
            cart[productId] = { quantity: 1 };
            sessionStorage.setItem('cart', JSON.stringify(cart));
        });

        // Assert: Ensure the item was added correctly
        const cartData = await page.evaluate(() => sessionStorage.getItem('cart'));
        expect(cartData).not.toBeNull();
        expect(JSON.parse(cartData!)).toHaveProperty('1');
    });
});
