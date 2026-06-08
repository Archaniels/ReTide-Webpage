const { chromium } = require('playwright');
(async () => {
    const b = await chromium.launch();
    const p = await b.newPage();
    await p.goto('http://127.0.0.1:8001/login');
    const html1 = await p.content();
    console.log("Login page has email input:", html1.includes('name="email"'));
    
    // We can't log in if the DB isn't seeded with user123. Let's just try to hit /donation. 
    // It might redirect us to login, but let's see.
    const res = await p.goto('http://127.0.0.1:8001/donation');
    const html2 = await p.content();
    console.log("Donation page has showToast:", html2.includes('showToast'));
    console.log("Status:", res.status());
    await b.close();
})();
