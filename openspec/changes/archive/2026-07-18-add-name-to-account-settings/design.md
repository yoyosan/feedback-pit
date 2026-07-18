## Context

The Account Settings page (`resources/js/Pages/Account/Settings.vue`) exposes only an email input. The controller (`AccountSettingsController@update`) hardcodes the existing name via `$request->user()->name` when delegating to the Fortify `UpdatesUserProfileInformation` action, so the name is effectively immutable from the UI.

The Fortify action `UpdateUserProfileInformation` already validates `name` (required, string, max:255) and persists it. The `name` column already exists on the `users` table and is in the User model's `$fillable`. `UserResource` already exposes `name` to the frontend, shared via `auth.user.name`. No schema or API contract changes are required.

## Goals / Non-Goals

**Goals:**
- Allow users to view and update their name from the Account Settings page
- Reuse the existing Fortify action for validation and persistence
- Keep name and email in a single form submission

**Non-Goals:**
- Avatar upload or profile picture management
- Changing the email verification flow (out of scope; `MustVerifyEmail` is currently disabled)
- Additional name format validation beyond Fortify's existing rules

## Decisions

**Reuse the Fortify action as-is**: `UpdateUserProfileInformation` already validates and saves both `name` and `email`. The only backend change is the controller passing `$request->input('name')` instead of the hardcoded existing name. No new validation logic is introduced.

**Single form for name and email**: Add the name input to the existing profile form rather than creating a separate section. This groups related identity fields and keeps the UI simple.

**Source the initial value from `auth.user.name`**: The shared `UserResource` already exposes `name`, so the input can be pre-populated without any new props on the Inertia response.

## Risks / Trade-offs

- **Avatar URL changes with the name**: `User::avatarUrl()` is derived from `$this->name`, so updating the name will regenerate the avatar. This is expected behavior, not a bug.
- **No null names possible**: The `users.name` column is non-nullable, and Fortify enforces `required`, so there is no risk of a blank name persisting.
