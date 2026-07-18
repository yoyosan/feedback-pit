## Why

The user model stores a single `name` field, which makes it harder to personalize greetings (e.g., "Hi Jane!" vs "Hi Jane Doe!") and to integrate with external systems that expect separate first/last name fields. Splitting into `first_name` and `last_name` provides more structured data and enables richer personalization throughout the app.

## What Changes

- Add `first_name` and `last_name` columns to the `users` table via migration
- Update User model `$fillable` to use `first_name` and `last_name` instead of `name`
- Add a `fullName()` accessor to maintain backward compatibility
- Update `avatarUrl()` to use the new fields
- Update Fortify actions (`CreateNewUser`, `UpdateUserProfileInformation`) to validate and persist the new fields
- Update `UserResource` to expose `first_name`, `last_name`, and `full_name`
- Update Vue frontend (Register, Account Settings) to use two separate name inputs
- Update all Vue components that display user names to use the new resource shape

## Capabilities

### New Capabilities

- `first-last-name`: Structured first and last name fields for users, with full name computed accessor

### Modified Capabilities

(none - this is a data model change, not a behavioral change)

## Impact

- Database: new migration to add columns and backfill data
- Model: `User.php` - fillable, accessor, avatarUrl()
- Fortify actions: `CreateNewUser.php`, `UpdateUserProfileInformation.php`
- Resources: `UserResource.php`
- Middleware: `HandleInertiaRequests.php` (shared auth.user shape)
- Frontend: Register.vue, Settings.vue, AppLayout.vue, InternalLayout.vue, CommentCard.vue, NoteCard.vue, Ideas/Show.vue, Internal/Ideas/Index.vue, Internal/Ideas/Show.vue
- Tests: UpdateEmailTest, any tests that reference user.name
