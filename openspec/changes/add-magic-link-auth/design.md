## Context

The app uses Laravel Fortify for auth (login, registration, password reset). All routes are session-based via Inertia.js. The current login page has email + password. Registration collects first_name, last_name, email, password. There is no social auth or SSO.

The goal is to add magic link auth as a first-class login method alongside passwords, with auto-registration for new users.

## Goals / Non-Goals

**Goals:**
- Add passwordless login via magic link (email → click → logged in)
- Auto-create accounts for new users on first magic link click
- Prompt new users to complete their profile (name) after first login
- Keep existing password login, password reset, and profile update working
- Redirect `/register` to `/magic-link`

**Non-Goals:**
- Removing password auth entirely
- Adding social login (Google/GitHub OAuth)
- Adding 2FA or MFA
- Changing the session or cookie configuration

## Decisions

**Signed URLs instead of token table**: Use Laravel's `URL::signedRoute()` to generate magic links. The URL contains a cryptographic signature that verifies authenticity and expiry. No extra database table, no cleanup cron job. Tokens expire after 15 minutes. The tradeoff is tokens can't be revoked once sent, but this is acceptable for short-lived magic links.

**Unified login/registration flow**: When a magic link is clicked, if no user exists with that email, one is created automatically with empty `first_name` and `last_name`. The user is then redirected to `/onboarding` to complete their profile. If the user already exists, they're logged in and sent to `/dashboard`.

**Separate `/magic-link` page**: Rather than adding magic link to the existing login page, it gets its own route. This keeps the mental model clean — password users go to `/login`, magic link users go to `/magic-link`. Each page links to the other.

**Profile completion middleware**: A new `EnsureProfileComplete` middleware checks if `first_name` is empty. If so, it redirects to `/onboarding`. This middleware runs after `auth` but before `team` in the middleware stack. It applies to all routes except auth pages, onboarding, and logout.

**Rate limiting**: 3 magic link requests per email per 5 minutes, using Laravel's `RateLimiter`. This prevents abuse while allowing legitimate retries.

**Email**: A simple Mailable (`MagicLinkMail`) with the signed link. Uses Laravel's markdown mail for consistency.

## Risks / Trade-offs

- **Email dependency**: If email delivery fails, users can't log in via magic link. Password login remains as a fallback.
- **Empty profile state**: Users who skip onboarding (by typing URLs directly) will have empty names. The middleware prevents this by redirecting to onboarding.
- **No token revocation**: Signed URLs can't be revoked once sent. Acceptable given 15-minute expiry.

## Migration Plan

1. Add new routes, controllers, middleware, and Vue pages
2. Register `EnsureProfileComplete` middleware in `bootstrap/app.php`
3. Add redirect from `/register` to `/magic-link`
4. Add cross-links between login and magic link pages
5. No database migration needed
