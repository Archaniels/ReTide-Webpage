import { test, expect } from '@playwright/test';

test('test intercepting POST and injecting', async ({ page }) => {
  console.log('Navigating to login...');
  await page.goto('https://retide-app-archaniels-projects.vercel.app/login');
  
  await page.fill('input[name="email"]', 'user123@gmail.com');
  await page.fill('input[name="password"]', 'user123');
  await Promise.all([
    page.waitForNavigation({ timeout: 10000 }).catch(() => console.log('Navigation wait timed out!')),
    page.click('button[type="submit"]')
  ]);
  
  await page.route('**/donation', async (route) => {
    if (route.request().method() === 'POST') {
      console.log('Intercepted POST request');
      const response = await page.request.get('https://retide-app-archaniels-projects.vercel.app/donation');
      const html = await response.text();
      const modifiedHtml = html.replace('</body>', '<div class="error-msg">Minimum donation amount is $1.00.</div></body>');
      await route.fulfill({ status: 400, contentType: 'text/html', body: modifiedHtml });
    } else {
      await route.continue();
    }
  });

  await page.goto('https://retide-app-archaniels-projects.vercel.app/donation');
  
  // bypass HTML5 validation
  await page.$eval('form.donation-form', el => el.setAttribute('novalidate', 'true'));
  
  await page.fill('input[name="amount"]', '0.99');
  await Promise.all([
    page.waitForResponse(res => res.url().includes('/donation') && res.status() === 400),
    page.click('button[type="submit"]')
  ]);
  
  const errorText = await page.locator('.error-msg').textContent();
  console.log("Error text:", errorText);
});
