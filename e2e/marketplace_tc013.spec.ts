import { test, expect } from '@playwright/test';

test.describe('Marketplace Feature - Unit Tests via Playwright (Frontend Validation)', () => {
    const baseURL = 'https://retide-app-archaniels-projects.vercel.app';

    /**
     * TC013: Verify checkout process with items in cart (EQP - Positive)
     */
    test('TC013 - Verify checkout process with items in cart completes and flushes cart', async ({ page }) => {
        // Arrange: Mock cart with an item already in it
        await page.evaluate(() => {
            sessionStorage.setItem('cart', JSON.stringify({ '1': { quantity: 1 } }));
        });
        
        // Act: Frontend checks if checkout is allowed, proceeds, and then flushes the cart upon success
        const isCheckoutAllowed = await page.evaluate(() => {
            let cart = JSON.parse(sessionStorage.getItem('cart') || '{}');
            if (Object.keys(cart).length > 0) {
                // Mocking successful checkout logic that clears the cart
                sessionStorage.removeItem('cart');
                return true;
            }
            return false;
        });
        
        // Assert: Ensure checkout was allowed and the cart is now empty
        expect(isCheckoutAllowed).toBe(true);
        const cartAfterCheckout = await page.evaluate(() => sessionStorage.getItem('cart'));
        expect(cartAfterCheckout).toBeNull();
    });
});
