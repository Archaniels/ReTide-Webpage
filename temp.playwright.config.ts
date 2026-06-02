import { defineConfig, devices } from '@playwright/test';
export default defineConfig({
  testDir: './Documentation/AutomationTests/Playwright',
  use: {
    baseURL: 'http://127.0.0.1:8000',
  },
  projects: [
    {
      name: 'chromium',
      use: { ...devices['Desktop Chrome'] },
    },
  ],
});
