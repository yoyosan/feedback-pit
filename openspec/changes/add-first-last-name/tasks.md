## 1. Database

- [x] 1.1 Create migration to add `first_name` and `last_name` columns to users table
- [x] 1.2 Add backfill step to migration: split existing `name` into `first_name` and `last_name`
- [x] 1.3 Add step to drop `name` column from users table
- [x] 1.4 Update UserFactory to generate `first_name` and `last_name` instead of `name`

## 2. Model & Resources

- [x] 2.1 Update User model `$fillable` to use `first_name` and `last_name` instead of `name`
- [x] 2.2 Add `fullName()` method to User model
- [x] 2.3 Update `avatarUrl()` to use `fullName()`
- [x] 2.4 Update `UserResource` to expose `first_name`, `last_name`, and `full_name`

## 3. Fortify Actions

- [x] 3.1 Update `CreateNewUser` action to validate and persist `first_name` and `last_name`
- [x] 3.2 Update `UpdateUserProfileInformation` action to validate and persist `first_name` and `last_name`

## 4. Frontend - Registration

- [x] 4.1 Update `Register.vue` to show two name inputs (first name, last name)
- [x] 4.2 Update form payload to send `first_name` and `last_name`

## 5. Frontend - Account Settings

- [x] 5.1 Update `Settings.vue` to show two name inputs (first name, last name)
- [x] 5.2 Update form payload to send `first_name` and `last_name`

## 6. Frontend - Display Components

- [x] 6.1 Update `AppLayout.vue` to use `user.full_name` instead of `user.name`
- [x] 6.2 Update `InternalLayout.vue` to use `user.full_name` instead of `user.name`
- [x] 6.3 Update `CommentCard.vue` to use `comment.user.full_name` instead of `comment.user.name`
- [x] 6.4 Update `NoteCard.vue` to use `note.user.full_name` instead of `note.user.name`
- [x] 6.5 Update `Ideas/Show.vue` to use `idea.user.full_name` instead of `idea.user.name`
- [x] 6.6 Update `Internal/Ideas/Index.vue` to use `idea.user.full_name` instead of `idea.user.name`
- [x] 6.7 Update `Internal/Ideas/Show.vue` to use `idea.user.full_name` instead of `idea.user.name`

## 7. Verification

- [x] 7.1 Run `composer lint` and fix any issues
- [x] 7.2 Run `npm run lint:fix` and fix any issues
- [x] 7.3 Run `composer analyse` and fix any issues
- [x] 7.4 Run `composer test` and fix any issues
