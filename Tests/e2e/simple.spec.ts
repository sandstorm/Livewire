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

test("action with redirect", async ({ page }) => {
  await page.goto(process.env.BASE_URL + '/livewire-conformance-tests/actionWithRedirect');
  await page.getByRole('textbox').fill('foobar');
  await page.getByRole('button').click();
  // "foobar" should be found as URL argument
  await page.waitForURL(process.env.BASE_URL + '/livewire-conformance-tests/controller#foobar')
});

test("actionAttributes", async ({ page }) => {
  await page.goto(process.env.BASE_URL + '/livewire-conformance-tests/actionAttributes');

  await page.getByTestId('triggerJs').click();
  await expect(page.getByTestId('title')).toContainText('triggerJs');
  const called = await page.evaluate(function() {
    return window['__called'];
  })
  expect(called).toBeTruthy();

  await page.getByTestId('triggerParameters').click();
  await expect(page.getByTestId('title')).toContainText('triggerParameters1');
  await expect(page.getByTestId('returnValue')).toContainText('RETURN VALUE');

  await page.getByTestId('renderless').click();
  await expect(page.getByTestId('returnValue')).toContainText('RENDERLESS RETURN');
  await expect(page.getByTestId('title')).toHaveText('triggerParameters1'); // this value did not change

  await page.getByTestId('refresh').click();
  await expect(page.getByTestId('title')).toHaveText('renderless'); // now the value has changed


});
