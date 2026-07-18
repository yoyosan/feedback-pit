## Why

Users cannot update their display name from Account Settings. The `name` field exists in the database and is validated by the Fortify action, but the settings page only exposes email and the controller hardcodes the existing name. Users should be able to update their name alongside their email.

## What Changes

- Add a name input field to the Account Settings form, pre-populated with the current name
- Update the controller to pass the requested name instead of hardcoding the existing value
- Reuse the existing Fortify `UpdateUserProfileInformation` action (already validates name)

## Capabilities

### New Capabilities

- `account-name-edit`: Editable name field in account settings form, persisted via existing profile update flow

### Modified Capabilities

(none)

## Impact

- `app/Http/Controllers/AccountSettingsController.php` — read name from request instead of hardcoding
- `resources/js/Pages/Account/Settings.vue` — add name input field
- No database changes needed (`name` column already exists)
- No API changes, no breaking changes
