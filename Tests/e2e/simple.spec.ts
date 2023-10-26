import { test, expect } from '@playwright/test';

test("simple action and modal", async ({ page }) => {
  await page.goto(process.env.BASE_URL + '/livewire-conformance-tests/simpleActionAndModel');
  await page.getByRole('textbox').fill('hallo');

  // the filled textbox should be refreshed
  await expect(page.getByTestId('title-output')).toContainText("hallo");

  // we click on "increase" multiple times
  await page.getByRole('button', { name: 'Increase' }).click({
    clickCount: 4
  });
  await expect(page.getByTestId('counter')).toContainText("Counter: 4");
});
