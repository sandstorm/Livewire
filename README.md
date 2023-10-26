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


## ToDo

- [ ] redirects as response to actions
- [ ] "making your props reactive"
- full page components
  - [ ] set page title
  - [ ] route parameters???? ( I guess irrelevant )
  - [ ] navigate: true
- [ ] custom response headers
- [ ] HMAC Security fixen / validieren
- [ ] lock property from updates (i guess irrelevant, because of explicit method)
- [ ] wire:confirm (sollte schon gehen, testen)
- [ ] action parameters (sollte schon gehen)
- [ ] action return values (sollte schon gehen)
- [ ] Livewires "hybrid" JS functions
- [ ] "Renderless" attribute above action method?! // skipRender
- [ ] form field validation // validation errors??
  - [ ] "Updated" can return a value (like Validation rules)
- [ ] events from browser to backend ?? -> not needed, actions!
- [ ] events from backend to browser ??
- [ ] nested components
- [ ] testing helpers
- [ ] wire:navigate
  - [ ] @persist / @endpersist
- [ ] lazy loading
  - [ ] placeholder
- [ ] file uploads
- [ ] file downloads
- [ ] URL query parameters ("#URL")
  - [ ] history: true
- computed properties: WONT HAVE
- [ ] redirects
- [ ] @teleport
