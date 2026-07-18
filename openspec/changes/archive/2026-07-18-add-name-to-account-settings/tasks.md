## 1. Backend

- [x] 1.1 Update `AccountSettingsController@update` to pass `$request->input('name')` instead of `$request->user()->name`

## 2. Frontend

- [x] 2.1 Add a name input to the profile form in `resources/js/Pages/Account/Settings.vue`, pre-populated from `auth.user.name`
- [x] 2.2 Include `name` in the form payload submitted to `PUT /account/settings`
- [x] 2.3 Display inline validation errors on the name field via the `:error` prop

## 3. Verification

- [x] 3.1 Run `composer lint` and fix any issues
- [x] 3.2 Run `npm run lint:fix` and fix any issues
- [x] 3.3 Run `composer analyse` and fix any issues
- [x] 3.4 Run `composer test` and fix any issues
