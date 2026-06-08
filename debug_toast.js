const { chromium } = require('playwright');

(async () => {
  const browser = await chromium.launch();
  const page = await browser.newPage();
  
  page.on('console', msg => console.log('BROWSER LOG:', msg.text()));

  await page.route('**/donation', async (route) => {
    const req = route.request();
    if (req.method() === 'POST') {
      console.log('Intercepted POST');
      const realResponse = await page.request.get(req.url());
      const realHtml = await realResponse.text();
      
      const scriptHtml = `<script>
        console.log('Script injected!');
        setTimeout(() => {
          console.log('typeof showToast =', typeof showToast);
          if (typeof showToast === 'function') {
            showToast("Test Toast");
          } else {
            console.log('showToast not found');
            const container = document.createElement("div");
            container.className = "toast-container";
            document.body.appendChild(container);
            const toast = document.createElement("div");
            toast.className = "toast-message";
            toast.innerHTML = '<span>Fallback Toast</span>';
            container.appendChild(toast);
          }
        }, 100);
      </script>`;
      
      await route.fulfill({
        status: 200,
        contentType: 'text/html',
        body: realHtml + scriptHtml
      });
    } else {
      route.continue();
    }
  });

  await page.goto('https://retide-app-archaniels-projects.vercel.app/login');
  await page.fill('input[name="email"]', 'user123@gmail.com');
  await page.fill('input[name="password"]', 'user123');
  await Promise.all([
    page.waitForNavigation(),
    page.click('button[type="submit"]')
  ]);

  await page.goto('https://retide-app-archaniels-projects.vercel.app/donation');
  await page.waitForSelector('input[name="amount"]');
  await page.fill('input[name="amount"]', '50.00');
  await page.click('button[type="submit"]');

  await page.waitForTimeout(2000);
  
  const toastText = await page.evaluate(() => {
    const el = document.querySelector('.toast-message span');
    return el ? el.innerText : 'NOT FOUND';
  });
  console.log('Toast Text:', toastText);

  await browser.close();
})();
