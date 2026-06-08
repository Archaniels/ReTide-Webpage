const { chromium } = require('playwright');

(async () => {
    const browser = await chromium.launch();
    const page = await browser.newPage();
    await page.goto('http://127.0.0.1:8000/login');
    await page.fill('#email', 'admin123@gmail.com');
    await page.fill('#password', 'admin123');
    await page.click('button[type="submit"]');
    await page.waitForURL('**/admin/dashboard');

    await page.goto('http://127.0.0.1:8000/admin/blogs/create');
    await page.fill('#title', 'A-B-');
    await page.fill('#content', 'Valid content block...');
    await page.click('button[type="submit"]');

    // wait for network idle or error
    await page.waitForLoadState('networkidle');

    const html = await page.content();
    console.log(html);

    await browser.close();
})();
