## 1. Backend - Magic Link

- [ ] 1.1 Create `MagicLinkController` with `show` (render form) and `send` (generate signed URL, email it) methods
- [ ] 1.2 Create `MagicLinkMail` Mailable with the signed link
- [ ] 1.3 Create `verify` method on `MagicLinkController` that validates the signed URL, creates user if new, logs in, and redirects appropriately
- [ ] 1.4 Add rate limiting to the `send` method (3 per email per 5 minutes)
- [ ] 1.5 Add routes: `GET /magic-link`, `POST /magic-link`, `GET /magic-link/verify`

## 2. Backend - Onboarding

- [ ] 2.1 Create `OnboardingController` with `show` (render form) and `update` (save name) methods
- [ ] 2.2 Add routes: `GET /onboarding`, `POST /onboarding`

## 3. Backend - Middleware

- [ ] 3.1 Create `EnsureProfileComplete` middleware that checks `first_name` is not empty
- [ ] 3.2 Register middleware in `bootstrap/app.php` after `auth`
- [ ] 3.3 Add redirect from `/register` to `/magic-link`

## 4. Frontend

- [ ] 4.1 Create `resources/js/Pages/Auth/MagicLink.vue` with email input and link to `/login`
- [ ] 4.2 Create `resources/js/Pages/Auth/Onboarding.vue` with first_name and last_name inputs
- [ ] 4.3 Add "Use magic link" link to `Login.vue`
- [ ] 4.4 Add "Prefer password?" link to `MagicLink.vue`

## 5. Verification

- [ ] 5.1 Run `composer lint` and fix any issues
- [ ] 5.2 Run `npm run lint:fix` and fix any issues
- [ ] 5.3 Run `composer analyse` and fix any issues
- [ ] 5.4 Run `composer test` and fix any issues
