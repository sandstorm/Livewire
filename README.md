# Running Conformance Tests

We have built some laravel livewire components, which we test via Playwright. Then we recreate them inside Neos,
and use the **same tests** on the Neos Livewire implementation.

**Preparations**

```bash
cd Tests
npm install

cd laravel; composer install; cd ..
```

**Running Tests**

```bash

# in 1st console:
cd Tests/laravel
./artisan serve

# in 2nd console:
cd FLOW_BASE_DIR
./flow server:run

# running tests:
cd Tests
npm run test:laravel
# or:
npm run test:laravel:interactive


npm run test:flow
# or:
npm run test:flow:interactive


```
