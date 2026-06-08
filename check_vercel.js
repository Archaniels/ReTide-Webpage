const { chromium } = require('playwright');
(async () => {
  const browser = await chromium.launch();
  const page = await browser.newPage();
  const response = await page.goto('https://retide-app-archaniels-projects.vercel.app/donation');
  const text = await response.text();
  console.log("Has showToast?", text.includes('showToast'));
  console.log("Has jQuery?", text.includes('jquery'));
  
  await browser.close();
})();
