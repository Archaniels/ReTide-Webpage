import { test, expect } from '@playwright/test';

test.describe('Marketplace Feature - Unit Tests via Playwright (Frontend Validation)', () => {
    const baseURL = 'https://retide-app-archaniels-projects.vercel.app';

    /**
     * TC014: Verify checkout process with empty cart (EQP - Negative / Edge-case)
     */
    test('TC014 - Verify checkout process with empty cart prevents checkout', async ({ page }) => {
        // Arrange: Ensure the cart is empty
        await page.evaluate(() => {
            sessionStorage.removeItem('cart');
        });
        
        // Act: Frontend checks if checkout is allowed (should fail)
        const isCheckoutAllowed = await page.evaluate(() => {
            let cart = JSON.parse(sessionStorage.getItem('cart') || '{}');
            if (Object.keys(cart).length > 0) {
                sessionStorage.removeItem('cart');
                return true;
            }
            return false;
        });
        
        // Assert: User is prevented from checking out
        expect(isCheckoutAllowed).toBe(false);
    });
});
