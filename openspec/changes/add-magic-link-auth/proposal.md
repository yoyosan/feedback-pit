## Why

Password-based auth creates friction for users who just want to give feedback. Magic link authentication lets users sign in by clicking a link sent to their email — no password to remember, no registration form to fill out. This is especially valuable for a feedback platform where users may visit infrequently and forget their credentials.

## What Changes

- Add a `/magic-link` page where users enter their email to receive a login link
- Add a signed URL verification endpoint that logs users in (or creates an account if new)
- Add an `/onboarding` page for new users to complete their profile (first/last name)
- Add `EnsureProfileComplete` middleware to redirect users with incomplete profiles
- Redirect `/register` to `/magic-link`
- Add cross-links between `/login` and `/magic-link` pages
- Keep password login, password reset, and profile update working as-is

## Capabilities

### New Capabilities

- `magic-link-auth`: Passwordless login via email magic link, with auto-registration for new users and profile completion onboarding

### Modified Capabilities

(none — existing auth flows are preserved, not changed)

## Impact

- New routes: `GET/POST /magic-link`, `GET /magic-link/verify`, `GET/POST /onboarding`
- New controller: `MagicLinkController`, `OnboardingController`
- New middleware: `EnsureProfileComplete`
- New Mailable: `MagicLinkMail`
- New Vue pages: `Auth/MagicLink.vue`, `Auth/Onboarding.vue`
- Modified: `routes/web.php`, `bootstrap/app.php` (middleware registration)
- Redirect: `/register` → `/magic-link`
- No database changes (signed URLs, no token table needed)
- No Composer dependencies added
