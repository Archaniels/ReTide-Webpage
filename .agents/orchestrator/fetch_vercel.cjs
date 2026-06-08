const { chromium } = require('playwright');
(async () => {
    const b = await chromium.launch();
    const p = await b.newPage();
    await p.goto('https://retide-app-archaniels-projects.vercel.app/login');
    await p.fill('input[name="email"]', 'user123@gmail.com');
    await p.fill('input[name="password"]', 'user123');
    await Promise.all([p.waitForNavigation(), p.click('button[type="submit"]')]);
    await p.goto('https://retide-app-archaniels-projects.vercel.app/donation');
    const html = await p.content();
    const fs = require('fs');
    fs.writeFileSync('vercel_donation.html', html);
    await b.close();
})();
