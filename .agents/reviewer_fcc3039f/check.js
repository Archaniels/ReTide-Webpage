const { chromium } = require('playwright');

(async () => {
  const browser = await chromium.launch();
  const page = await browser.newPage();
  await page.goto('https://retide-app-archaniels-projects.vercel.app/donation');
  const type = await page.evaluate(() => typeof window.showToast);
  console.log('TYPE_OF_SHOWTOAST:', type);
  await browser.close();
})();
