import { test, expect } from '@playwright/test';

/**
 * TC001: Verify product creation fails with empty required fields (EQP - Invalid)
 * Methodology: Equivalence Class Partitioning (EQP) - Invalid Input
 */
test('TC001 - Marketplace: Verify product creation fails with empty required fields', async ({ page }) => {
    const baseURL = 'https://retide-app-archaniels-projects.vercel.app';

    // 1. Login as Admin
    await page.goto(`${baseURL}/login`);
    await page.fill('#email', 'admin123@gmail.com');
    await page.fill('#password', 'admin123');
    await page.click('button[type="submit"]');

    // Wait for navigation after login
    await expect(page).toHaveURL(`${baseURL}/admin/dashboard`);

    // 2. Navigate to Add Product form
    await page.goto(`${baseURL}/admin/marketplace/create`);

    // 3. Ensure fields are empty (they should be by default)
    // We can clear them just in case of any persistent browser state or autofill
    await page.fill('#name', '');
    await page.fill('#description', '');
    await page.fill('#price', '');

    // 4. Click Submit
    await page.click('button[type="submit"]:has-text("Create")');

    // 5. Verification
    await expect(page).toHaveURL(`${baseURL}/admin/marketplace/create`);

    const nameInput = page.locator('#name');
    const descriptionInput = page.locator('#description');
    const priceInput = page.locator('#price');

    await expect(nameInput).toHaveAttribute('required', '');
    await expect(descriptionInput).toHaveAttribute('required', '');
    await expect(priceInput).toHaveAttribute('required', '');

    const isNameValid = await nameInput.evaluate((el: HTMLInputElement) => el.checkValidity());
    const isDescriptionValid = await descriptionInput.evaluate((el: HTMLTextAreaElement) => el.checkValidity());
    const isPriceValid = await priceInput.evaluate((el: HTMLInputElement) => el.checkValidity());

    expect(isNameValid).toBe(false);
    expect(isDescriptionValid).toBe(false);
    expect(isPriceValid).toBe(false);
});
